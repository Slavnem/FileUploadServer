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
use UserApi\v1\Core\Methods as UserMethods;
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

        // geçici olarak değerleri tutmak
        $temp_username = $_SESSION[SessionParams::getUsername()] ?? null;
        $temp_email = $_SESSION[SessionParams::getEmail()] ?? null;
        $temp_password = $_SESSION[SessionParams::getPassword()] ?? null;

        // aktif oturum verilerini kontrol etsin
        // zorunlu değerler yok ya da boş ise hata döndürsün
        if(empty($temp_username) && empty($temp_email))
            return [SessionError::getAutoErrorSessionNotFoundUsername(), SessionError::getAutoErrorSessionNotFoundEmail()];
        else if(!isset($_SESSION[SessionParams::getPassword()]) || is_null($_SESSION[SessionParams::getPassword()]))
            return SessionError::getAutoErrorSessionNotFoundPassword();

        // veritabanından kullanıcının varlığı kontrol edilsin
        $user = $this->userRequest->Request(
            UserMethods::getFetch(),
            [
                UserParams::getUsername() => $temp_username ?? null,
                UserParams::getEmail() => $temp_email ?? null,
                UserParams::getPassword() => $temp_password ?? null
            ],
            NULL
        );

        // kullanıcı hatalarını depolasın
        $user_errors = NULL;

        // id, kullanıcı adı, email veya şifre yoksa kullanıcı yoktur
        if(!isset($user[TableUsers::getId()]) || $user[TableUsers::getId()] < 1)
            $user_errors[] = [SessionError::getAutoErrorSessionUserIdNotFound()];
        if(!isset($user[TableUsers::getUsername()]) || empty($user[TableUsers::getUsername()]))
            $user_errors[] = [SessionError::getAutoErrorSessionUserUsernameNotFound()];
        if(!isset($user[TableUsers::getEmail()]) || empty($user[TableUsers::getEmail()]))
            $user_errors[] = [SessionError::getAutoErrorSessionUserEmailNotFound()];
        if(!isset($user[TableUsers::getPassword()]) || empty($user[TableUsers::getPassword()]))
            $user_errors[] = [SessionError::getAutoErrorSessionUserPasswordNotFound()];

        // kullanıcı hatası boş değilse döndürsün
        if(!empty($user_errors) && count($user_errors) > 0)
            return $user_errors;

        // her şey tamam olduğu için boş döndürsün
        return null;
    }

    // Oturumu Kaydet
    final protected function saveSession(
        ?array $argUserDatas
    ): ?array
    {
        // veri varlığığ kontrolü
        if(!isset($argUserDatas) || empty($argUserDatas)) return null;

        // oturum yoksa başlat
        self::runSession();

        // oturumu kaydet
        $_SESSION = [
            SessionParams::getId() => $argUserDatas[TableUsers::getId()] ?? null,
            SessionParams::getUsername() => $argUserDatas[TableUsers::getUsername()] ?? null,
            SessionParams::getFirstname() => $argUserDatas[TableUsers::getFirstname()] ?? null,
            SessionParams::getLastname() => $argUserDatas[TableUsers::getLastname()] ?? null,
            SessionParams::getEmail() => $argUserDatas[TableUsers::getEmail()] ?? null,
            SessionParams::getPassword() => $argUserDatas[TableUsers::getPassword()] ?? null,
            SessionParams::getCreated() => $argUserDatas[TableUsers::getCreated()] ?? null,
            SessionParams::getMemberId() => $argUserDatas[TableMembership::getId()] ?? null,
            SessionParams::getMemberName() => $argUserDatas[TableMembership::getName()] ?? null,
            SessionParams::getMember() => $argUserDatas[TableMembership::getValue()] ?? null,
            SessionParams::getLanguageId() => $argUserDatas[TableLanguages::getId()] ?? null,
            SessionParams::getLanguageName() => $argUserDatas[TableLanguages::getName()] ?? null,
            SessionParams::getLanguage() => $argUserDatas[TableLanguages::getValue()] ?? null,
            SessionParams::getVerifyId() => $argUserDatas[TableVerify::getId()] ?? null,
            SessionParams::getVerifyName() => $argUserDatas[TableVerify::getName()] ?? null,
            SessionParams::getVerify() => $argUserDatas[TableVerify::getValue()] ?? null,
            SessionParams::getThemeId() => $argUserDatas[TableThemes::getId()] ?? null,
            SessionParams::getThemeName() => $argUserDatas[TableThemes::getName()] ?? null,
            SessionParams::getTheme() => $argUserDatas[TableThemes::getValue()] ?? null
        ];

        // oturuma veri yazmayı kapatma
        session_write_close();

        // oturum verisini döndür
        return $_SESSION;
    }

    // Oturumu Getir
    final protected function Fetch() : ?array
    {
        // oturum bilgisini alsın
        $session = self::isSession();
        
        // veri boşsa oturum var demektir, aksi halde hata dönmüştür
        // alınan hatayı döndürsün
        if(!is_null(self::isSession())) return $session;

        // oturum verilerini döndürsün
        return $_SESSION;
    }

    // Oturumu Oluştur
    final protected function Create(
        ?array $argUserDatas
    ) : ?array
    {
        // oturum yoksa başlatısn
        if(session_status() != PHP_SESSION_ACTIVE) session_start();

        // kullanıcı verilerini düzeltme
        $temp_userdatas = [
            UserParams::getUsername() => $argUserDatas[SessionParams::getUsername()] ?? null,
            UserParams::getEmail() => $argUserDatas[SessionParams::getEmail()] ?? null,
            UserParams::getPassword() => $argUserDatas[SessionParams::getPassword()] ?? null,
        ];

        if(empty($temp_userdatas[UserParams::getUsername()]) && empty($temp_userdatas[UserParams::getEmail()]))
            return [SessionError::getAutoErrorNotFoundUsername(), SessionError::getAutoErrorNotFoundEmail()];
        // zorunlu verileri kontrol etsin, yoksa hata döndürsün
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

        // oturuma verileri kaydetsin
        self::saveSession($result_user);

        // oturum oluşturulma tarihi
        $_SESSION[SessionParams::getSessionCreated()] = date('Y-m-d H:i:s') ?? null;
        $_SESSION[UpdateSessionParams::getSessionUpdate()] = date('Y-m-d H:i:s') ?? null;

        // oturuma veri yazmayı kapatma
        session_write_close();

        // yeni oturum verisini döndürsün
        return $_SESSION;
    }

    // Oturumu Güncelle
    final protected function Update(): ?array
    {
        // oturumu başlatma
        self::runSession();

        // oturum bilgisini alsın
        $session = self::isSession();
        
        // veri boşsa oturum var demektir, aksi halde hata dönmüştür
        // alınan hatayı döndürsün
        if(!is_null($session)) return $session;

        // kullanıcı verilerini düzeltme
        $temp_userdatas = [
            UserParams::getUsername() => $_SESSION[SessionParams::getUsername()] ?? null,
            UserParams::getEmail() => $_SESSION[SessionParams::getEmail()] ?? null,
            UserParams::getPassword() => $_SESSION[SessionParams::getPassword()] ?? null,
        ];

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

        // oturuma verileri kaydetsin
        self::saveSession($result_user);

        // oturum güncellenme süresini yenilesin
        $_SESSION[UpdateSessionParams::getSessionUpdate()] = date('Y-m-d H:i:s');

        // oturuma veri yazmayı kapatma
        session_write_close();

        // güncellenmiş veya güncellenmemiş fark etmeksizin
        // oturum verilerini döndür çünkü aynı veriler gelmiş olabilir
        return $_SESSION;
    }

    // Oturumu Sil
    final protected function Delete() : ?array
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
                return self::Update();
            // Oturum Sil
            case (strtoupper(Methods::getDelete())):
                return self::Delete();
        }

        // Veri yok, boş dönsün
        return null;
    }
}