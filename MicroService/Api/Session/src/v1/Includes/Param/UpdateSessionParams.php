<?php
// Slavnem @2024-07-05
// Oturum Güncelleme İçin Parametreler
namespace SessionApi\v1\Includes\Param;

trait UpdateSessionParams {
    // Değişkenleri tanımlama
    protected static string $username = "update_username";
    protected static string $firstname = "update_firstname";
    protected static string $lastname = "update_lastname";
    protected static string $email = "update_email";
    protected static string $password = "update_password";
    protected static string $member = "update_member";
    protected static string $language = "update_language";
    protected static string $verify = "update_verify";
    protected static string $theme = "update_theme";
    protected static string $sessionupdate = "update_sessionupdate";

    // Değişkenleri Getirtme
    // Kullanıcı Adı parametresi
    final public static function getUsername(): ?string {
        return self::$username;
    }

    // İsim parametresi
    final public static function getFirstname(): ?string {
        return self::$firstname;
    }

    // Soyisim parametresi
    final public static function getLastname(): ?string {
        return self::$lastname;
    }

    // E-posta parametresi
    final public static function getEmail(): ?string {
        return self::$email;
    }

    // Şifre parametresi
    final public static function getPassword(): ?string {
        return self::$password;
    }

    // Üye parametresi
    final public static function getMember(): ?string {
        return self::$member;
    }

    // Dil parametresi
    final public static function getLanguage(): ?string {
        return self::$language;
    }

    // Kullanıcı Doğrulama parametresi
    final public static function getVerify(): ?string {
        return self::$verify;
    }

    // Tema parametresi
    final public static function getTheme(): ?string {
        return self::$theme;
    }

    // Oturum Güncellenme Tarihi parametresi
    final public static function getSessionUpdate(): ?string {
        return self::$sessionupdate;
    }

    // Tüm hepsini çağırma
    final public static function getAll(): ?array {
        return [
            self::getUsername(),
            self::getFirstname(),
            self::getLastname(),
            self::getEmail(),
            self::getPassword(),
            self::getMember(),
            self::getLanguage(),
            self::getVerify(),
            self::getTheme(),
            self::getSessionUpdate()
        ];
    }
}