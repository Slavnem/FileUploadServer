<?php
// Slavnem @2024-07-17
namespace SessionApi\v1\Core;

// Gerekli Sınıflar
use SessionApi\v1\Core\Methods as Methods;
use SessionApi\v1\Core\SessionFunctionsAbs as SessionFunctionsAbs;
use SessionApi\v1\Core\SessionFunctionsImpl as SessionFunctionsImpl;
use SessionApi\v1\Core\SessionError as SessionError;
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;
use SessionApi\v1\Includes\Param\UpdateSessionParams as UpdateSessionParams;

// Kullanıcı Verileri Kontrolü İçin Sınıflar
use UserApi\v1\Core\UserRequest as UserRequest;
use UserApi\v1\Includes\Database\Param\UserParams as UserParams;
use UserApi\v1\Includes\Database\Table\TableUsers as TableUsers;
use UserApi\v1\Includes\Database\Table\TableMembership as TableMembership;
use UserApi\v1\Includes\Database\Table\TableLanguages as TableLanguages;
use UserApi\v1\Includes\Database\Table\TableVerify as TableVerify;
use UserApi\v1\Includes\Database\Table\TableThemes as TableThemes;

// Oturum Sorgu Sınıfı
final class SessionRequest extends SessionFunctionsAbs implements SessionFunctionsImpl {
    // Sınıf Başlangıç Tanımlamaları
    protected UserRequest $userRequest;

    // Sınıf Yapıcı Fonksiyonu
    public final function __construct() {
        $this->userRequest = new UserRequest();
    }

    // Oturum Başlatma
    final protected function runSession(): ?bool
    {
        // oturum açık değilse oturumu başlatsın
        if(session_status() != PHP_SESSION_ACTIVE)
        {
            session_start();
            session_regenerate_id();
        }

        // torumu açık olup olmama durumunu döndür
        return session_status() == PHP_SESSION_ACTIVE;
    }

    // Oturum Varlık Durumu
    final public function isSession(): ?array
    {
        // oturumu başlatma
        self::runSession();

        // aktif oturum verilerini kontrol etsin
        // zorunlu değerler yok ya da boş ise hata döndürsün
        if(!isset($_SESSION[SessionParams::getUsername()]) || is_null($_SESSION[SessionParams::getUsername()]))
            return SessionError::getAutoErrorSessionNotFoundUsername();
        else if(!isset($_SESSION[SessionParams::getEmail()]) || is_null($_SESSION[SessionParams::getEmail()]))
            return SessionError::getAutoErrorSessionNotFoundEmail();
        else if(!isset($_SESSION[SessionParams::getPassword()]) || is_null($_SESSION[SessionParams::getPassword()]))
            return SessionError::getAutoErrorSessionNotFoundPassword();

        // her şey tamam olduğu için boş döndürsün
        return null;
    }

    // Oturumu Getir
    final protected function Fetch(
    ) : ?array
    {
        // oturum bilgisini alsın
        $session = self::isSession();
        
        // veri boşsa oturum var demektir, aksi halde hata dönmüştür
        // alınan hatayı döndürsün
        if(!is_null($session)) return $session;

        // oturum verilerini döndürsün
        return $_SESSION;
    }

    // Oturumu Oluştur
    final protected function Create(
        ?array $argUserDatas
    ) : ?array
    {
        // oturumu başlatma
        self::runSession();

        // kullanıcı verilerini düzeltme
        $temp_userdatas = [
            UserParams::getUsername() => $argUserDatas[SessionParams::getUsername()] ?? null,
            UserParams::getEmail() => $argUserDatas[SessionParams::getEmail()] ?? null,
            UserParams::getPassword() => $argUserDatas[SessionParams::getPassword()] ?? null,
        ];

        // zorunlu verileri kontrol etsin, yoksa hata döndürsün
        if(!isset($temp_userdatas[UserParams::getUsername()]) || is_null($temp_userdatas[UserParams::getUsername()]))
            return SessionError::getAutoErrorNotFoundUsername();
        else if(!isset($temp_userdatas[UserParams::getEmail()]) || is_null($temp_userdatas[UserParams::getEmail()]))
            return SessionError::getAutoErrorNotFoundEmail();
        else if(!isset($temp_userdatas[UserParams::getPassword()]) || is_null($temp_userdatas[UserParams::getPassword()]))
            return SessionError::getAutoErrorNotFoundPassword();

        // Kullanıcı bilgilerini sorgulatmak
        $result_user = $this->userRequest->Request(
            Methods::getFetch(),
            $temp_userdatas,
            NULL
        );

        // gelen veri de kullanıcı id kısımı boş ise eğer
        // kullanıcı bulunamamıştır demek, boş veri döndürsün
        if(!isset($result_user[TableUsers::getId()]) || $result_user[TableUsers::getId()] < 1)
            return null;

        // verileri sadeleştirsin
        $session_datas = [
            SessionParams::getId() => $result_user[TableUsers::getId()] ?? null,
            SessionParams::getUsername() => $result_user[TableUsers::getUsername()] ?? null,
            SessionParams::getFirstname() => $result_user[TableUsers::getFirstname()] ?? null,
            SessionParams::getLastname() => $result_user[TableUsers::getLastname()] ?? null,
            SessionParams::getEmail() => $result_user[TableUsers::getEmail()] ?? null,
            SessionParams::getPassword() => $result_user[TableUsers::getPassword()] ?? null,
            SessionParams::getMember() => $result_user[TableMembership::getValue()] ?? null,
            SessionParams::getLanguage() => $result_user[TableLanguages::getValue()] ?? null,
            SessionParams::getVerify() => $result_user[TableVerify::getValue()] ?? null,
            SessionParams::getTheme() => $result_user[TableThemes::getValue()] ?? null,
            SessionParams::getCreated() => $result_user[TableUsers::getCreated()] ?? null,
            SessionParams::getSessionCreate() => date('Y-m-d H:i:s') ?? null,
            UpdateSessionParams::getSessionUpdate() => date('Y-m-d H:i:s') ?? null
        ];

        // oturuma veriyi yaz
        $_SESSION = $session_datas;

        // oturuma veri yazmayı kapatma
        session_write_close();

        // ayarlanan veriyi döndürsün
        return $session_datas;
    }

    // Oturumu Güncelle
    final protected function Update(
        ?array $argNewSessionDatas
    ): ?array
    {
        // oturum bilgisini alsın
        $session = self::isSession();
        
        // veri boşsa oturum var demektir, aksi halde hata dönmüştür
        // alınan hatayı döndürsün
        if(!is_null($session)) return $session;

        // oturum yeni verilerini alsın ve kontrollü şekilde güncellesin
        if(isset($argNewSessionDatas[UpdateSessionParams::getUsername()]))
            $_SESSION[SessionParams::getUsername()] = $argNewSessionDatas[UpdateSessionParams::getUsername()];
        if(isset($argNewSessionDatas[UpdateSessionParams::getFirstname()]))
            $_SESSION[SessionParams::getFirstname()] = $argNewSessionDatas[UpdateSessionParams::getFirstname()];
        if(isset($argNewSessionDatas[UpdateSessionParams::getLastname()]))
            $_SESSION[SessionParams::getLastname()] = $argNewSessionDatas[UpdateSessionParams::getLastname()];
        if(isset($argNewSessionDatas[UpdateSessionParams::getEmail()]))
            $_SESSION[SessionParams::getEmail()] = $argNewSessionDatas[UpdateSessionParams::getEmail()];
        if(isset($argNewSessionDatas[UpdateSessionParams::getPassword()]))
            $_SESSION[SessionParams::getPassword()] = $argNewSessionDatas[UpdateSessionParams::getPassword()];
        if(isset($argNewSessionDatas[UpdateSessionParams::getMember()]))
            $_SESSION[SessionParams::getMember()] = $argNewSessionDatas[UpdateSessionParams::getMember()];
        if(isset($argNewSessionDatas[UpdateSessionParams::getLanguage()]))
            $_SESSION[SessionParams::getLanguage()] = $argNewSessionDatas[UpdateSessionParams::getLanguage()];
        if(isset($argNewSessionDatas[UpdateSessionParams::getVerify()]))
            $_SESSION[SessionParams::getVerify()] = $argNewSessionDatas[UpdateSessionParams::getVerify()];
        if(isset($argNewSessionDatas[UpdateSessionParams::getTheme()]))
            $_SESSION[SessionParams::getTheme()] = $argNewSessionDatas[UpdateSessionParams::getTheme()];

        // oturum güncellenme süresini yenilesin
        $_SESSION[UpdateSessionParams::getSessionUpdate()] = date('Y-m-d H:i:s');

        // oturuma veri yazmayı kapatma
        session_write_close();

        // güncellenmiş veya güncellenmemiş fark etmeksizin
        // oturum verilerini döndür çünkü aynı veriler gelmiş olabilir
        return $_SESSION;
    }

    // Oturumu Sil
    final protected function Delete(        
    ) : ?array
    {
        // oturum bilgisini alsın
        $session = self::isSession();
        
        // veri boşsa oturum var demektir, aksi halde hata dönmüştür
        // alınan hatayı döndürsün
        if(!is_null($session)) return $session;

        // oturum verilerini geçici olarak depolasın
        $temp_session = (array)$_SESSION;

        // oturumu temizlesin
        session_destroy();

        // oturum da kullanıcı ID'si yoksa veya geçersizse oturum boştur,
        // boş değer döndürsün
        if(!isset($temp_session[SessionParams::getId()]) || $temp_session[SessionParams::getId()] < 1)
            return null;

        // geçici depolanmış veriyi döndürsün
        return $temp_session;
    }

    // Kullanıcıdan Alınan Sorgu İle İşlem Yapma
    final public function Request(
        ?string $argRequestMethod,
        ?array $argDatas,
        ?array $argNewDatas
    ): ?array
    {
        // işlem metodu
        $requestMethod = strtoupper($argRequestMethod);

        // Methoda göre işlem
        switch($requestMethod) {
            // Oturum Verisini Getir
            case (strtoupper(Methods::getFetch())):
                return self::Fetch();
            // Oturum Oluştur
            case (strtoupper(Methods::getCreate())):
                return self::Create($argDatas);
            // Oturum Verisi Güncelle
            case (strtoupper(Methods::getUpdate())):
                return self::Update($argNewDatas);
            // Oturum Sil
            case (strtoupper(Methods::getDelete())):
                return self::Delete();
        }

        // Veri yok, boş dönsün
        return null;
    }
}