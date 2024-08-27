<?php
// Slavnem @2024-07-17
namespace SessionApi\v1\Core;

// Gerekli Sınıflar
use SessionApi\v1\Core\Methods as Methods;
use SessionApi\v1\Core\SessionFunctionsAbs as SessionFunctionsAbs;
use SessionApi\v1\Core\SessionFunctionsImpl as SessionFunctionsImpl;
use SessionApi\v1\Core\SessionErrors as SessionError;
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;
use SessionApi\v1\Includes\Param\UpdateSessionParams as UpdateSessionParams;

// Kullanıcı Verileri Kontrolü İçin Sınıflar
use AuthApi\v1\Core\AuthRequest as AuthRequest;
use AuthApi\v1\Core\AuthMethods as AuthMethods;
use AuthApi\v1\Includes\Database\Param\AuthParams as AuthParams;
use AuthApi\v1\Includes\Database\Table\TableUsers as TableUsers;
use AuthApi\v1\Includes\Database\Table\TableMembership as TableMembership;
use AuthApi\v1\Includes\Database\Table\TableLanguages as TableLanguages;
use AuthApi\v1\Includes\Database\Table\TableVerify as TableVerify;
use AuthApi\v1\Includes\Database\Table\TableThemes as TableThemes;

// Oturum Sorgu Sınıfı
final class SessionRequest extends SessionFunctionsAbs implements SessionFunctionsImpl {
    // Sınıf Başlangıç Tanımlamaları
    protected AuthRequest $AuthRequest;

    // Sınıf Yapıcı Fonksiyonu
    public final function __construct() {
        $this->AuthRequest = new AuthRequest();
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
    final public function isSession(): ?bool
    {
        // oturumu başlatma
        self::runSession();

        // geçici olarak değerleri tutmak
        $temp_username = $_SESSION[SessionParams::getUsername()] ?? null;
        $temp_email = $_SESSION[SessionParams::getEmail()] ?? null;
        $temp_password = $_SESSION[SessionParams::getPassword()] ?? null;

        // aktif oturum verilerini kontrol etsin
        // zorunlu değerler yok ya da boş ise hata döndürsün
        switch(true) {
            case (empty($temp_username) && empty($temp_email)):
            case (!isset($_SESSION[SessionParams::getPassword()]) || empty($_SESSION[SessionParams::getPassword()])):
                return false;
        }

        // veritabanından kullanıcının varlığı kontrol edilsin
        $Auth = $this->AuthRequest->Request(
            AuthMethods::getVerify(),
            [
                AuthParams::getUsername() => $temp_username ?? null,
                AuthParams::getEmail() => $temp_email ?? null,
                AuthParams::getPassword() => $temp_password ?? null
            ],
            NULL
        );

        // id, kullanıcı adı, email veya şifre yoksa kullanıcı yoktur
        switch(true) {
            case (!isset($Auth[TableUsers::getId()]) || $Auth[TableUsers::getId()] < 1):
            case (!isset($Auth[TableUsers::getUsername()]) || empty($Auth[TableUsers::getUsername()])):
            case (!isset($Auth[TableUsers::getEmail()]) || empty($Auth[TableUsers::getEmail()])):
            case (!isset($Auth[TableUsers::getPassword()]) || empty($Auth[TableUsers::getPassword()])):
                return false;
        }

        // her şey tamam olduğu için doğru döndürsün
        return true;
    }

    // Oturumu Kaydet
    final protected function saveSession(
        ?array $argAuthDatas
    ): ?array
    {
        // veri varlığığ kontrolü
        if(!isset($argAuthDatas) || empty($argAuthDatas)) return null;

        // oturum yoksa başlat
        self::runSession();

        // oturumu kaydet
        $_SESSION = [
            SessionParams::getId() => $argAuthDatas[TableUsers::getId()] ?? null,
            SessionParams::getUsername() => $argAuthDatas[TableUsers::getUsername()] ?? null,
            SessionParams::getFirstname() => $argAuthDatas[TableUsers::getFirstname()] ?? null,
            SessionParams::getLastname() => $argAuthDatas[TableUsers::getLastname()] ?? null,
            SessionParams::getEmail() => $argAuthDatas[TableUsers::getEmail()] ?? null,
            SessionParams::getPassword() => $argAuthDatas[TableUsers::getPassword()] ?? null,
            SessionParams::getCreated() => $argAuthDatas[TableUsers::getCreated()] ?? null,
            SessionParams::getMemberId() => $argAuthDatas[TableMembership::getId()] ?? null,
            SessionParams::getMemberName() => $argAuthDatas[TableMembership::getName()] ?? null,
            SessionParams::getMember() => $argAuthDatas[TableMembership::getValue()] ?? null,
            SessionParams::getLanguageId() => $argAuthDatas[TableLanguages::getId()] ?? null,
            SessionParams::getLanguageName() => $argAuthDatas[TableLanguages::getName()] ?? null,
            SessionParams::getLanguage() => $argAuthDatas[TableLanguages::getValue()] ?? null,
            SessionParams::getVerifyId() => $argAuthDatas[TableVerify::getId()] ?? null,
            SessionParams::getVerifyName() => $argAuthDatas[TableVerify::getName()] ?? null,
            SessionParams::getVerify() => $argAuthDatas[TableVerify::getValue()] ?? null,
            SessionParams::getThemeId() => $argAuthDatas[TableThemes::getId()] ?? null,
            SessionParams::getThemeName() => $argAuthDatas[TableThemes::getName()] ?? null,
            SessionParams::getTheme() => $argAuthDatas[TableThemes::getValue()] ?? null,
            SessionParams::getSessionCreated() => $_SESSION[SessionParams::getSessionCreated()] ?? date('Y-m-d H:i:s'),
            UpdateSessionParams::getSessionUpdate() => date('Y-m-d H:i:s')
        ];

        // oturuma veri yazmayı kapatma
        session_write_close();

        // oturum verisini döndür
        return $_SESSION;
    }

    // Oturumu Getir
    final protected function Fetch() : ?array
    {   
        // oturum yoksa boş dönsün
        if(self::isSession() != true) return null;

        // oturum verilerini döndürsün
        return $_SESSION;
    }

    // Oturumu Oluştur
    final protected function Create(
        ?array $argAuthDatas
    ) : ?array
    {
        // oturum yoksa başlatısn
        self::runSession();

        // kullanıcı verilerini düzeltme
        $temp_authdatas = [
            AuthParams::getUsername() => $argAuthDatas[SessionParams::getUsername()] ?? null,
            AuthParams::getEmail() => $argAuthDatas[SessionParams::getEmail()] ?? null,
            AuthParams::getPassword() => $argAuthDatas[SessionParams::getPassword()] ?? null,
        ];

        if(empty($temp_authdatas[AuthParams::getUsername()]) && empty($temp_authdatas[AuthParams::getEmail()]))
            return [SessionError::getAutoErrorNotFoundUsername(), SessionError::getAutoErrorNotFoundEmail()];
        // zorunlu verileri kontrol etsin, yoksa hata döndürsün
        else if(!isset($temp_authdatas[AuthParams::getPassword()]) || is_null($temp_authdatas[AuthParams::getPassword()]))
            return SessionError::getAutoErrorNotFoundPassword();

        // Kullanıcı bilgilerini sorgulatmak
        $result_auth = $this->AuthRequest->Request(
            Methods::getFetch(),
            $temp_authdatas,
            NULL
        );

        // gelen veri de kullanıcı id kısımı boş ise eğer
        // kullanıcı bulunamamıştır demek, boş veri döndürsün
        if(!isset($result_auth[TableUsers::getId()]) || $result_auth[TableUsers::getId()] < 1)
            return null;

        // eski oturum yok etsin
        self::Delete();

        // oturumu başlatsın
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // yeni oturum kimliği
        session_regenerate_id(true);

        // oturuma verileri kaydetsin
        self::saveSession($result_auth);

        // yeni oturum verisini döndürsün
        return $_SESSION;
    }

    // Oturumu Güncelle
    final protected function Update(): ?array
    {
        // oturum yoksa hata dönsün
        if(self::isSession() !== true) return SessionError::getAutoErrorSessionNotFound();

        // kullanıcı verilerini düzeltme
        $temp_Authdatas = [
            AuthParams::getUsername() => $_SESSION[SessionParams::getUsername()] ?? null,
            AuthParams::getEmail() => $_SESSION[SessionParams::getEmail()] ?? null,
            AuthParams::getPassword() => $_SESSION[SessionParams::getPassword()] ?? null,
        ];

        // Kullanıcı bilgilerini sorgulatmak
        $result_Auth = $this->AuthRequest->Request(
            Methods::getFetch(),
            $temp_Authdatas,
            NULL
        );

        // gelen veri de kullanıcı id kısımı boş ise eğer
        // kullanıcı bulunamamıştır demek, boş veri döndürsün
        if(!isset($result_Auth[TableUsers::getId()]) || $result_Auth[TableUsers::getId()] < 1)
            return null;

        // oturuma verileri kaydetsin
        self::saveSession($result_Auth);

        // güncellenmiş veya güncellenmemiş fark etmeksizin
        // oturum verilerini döndür çünkü aynı veriler gelmiş olabilir
        return $_SESSION;
    }

    // Oturumu Sil
    final protected function Delete() : ?array
    {
        // oturum yoksa hata dönsün
        if(self::isSession() !== true) return SessionError::getAutoErrorSessionNotFound();

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

    // Oturumu Doğrula
    final protected function Verify(): ?array
    {
        // oturum yoksa hata dönsün
        if(self::isSession() !== true) return SessionError::getAutoErrorSessionNotFound();

        // oturum bilgilerini geçici olarak depolasın
        $temp_session = (array)$_SESSION;

        // doğrulama için parametreler
        $params = [
            AuthParams::getUsername() => $temp_session[SessionParams::getUsername()] ?? null,
            AuthParams::getEmail() => $temp_session[SessionParams::getEmail()] ?? null,
            AuthParams::getPassword() => $temp_session[SessionParams::getPassword()] ?? null
        ];

        // doğrulama sonucu doğruysa kullanıcı verileri gelir
        // aksi halde doğrulama başarısızdır
        return $this->AuthRequest->Request(
            AuthMethods::getVerify(),
            $params,
            NULL            
        );
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
            // Oturumu Doğrula
            case (strtoupper(Methods::getVerify())):
                return self::Verify();
        }

        // Veri yok, boş dönsün
        return null;
    }
}