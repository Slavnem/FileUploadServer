<?php
// Slavnem @2024-07-05
// Oturum İçin Parametreler
namespace SessionApi\v1\Includes\Param;

trait SessionParams {
    // Değişkenleri tanımlama
    protected static string $id = "id";
    protected static string $username = "username";
    protected static string $firstname = "firstname";
    protected static string $lastname = "lastname";
    protected static string $email = "email";
    protected static string $password = "password";
    protected static string $created = "created";
    protected static string $session_created = "session_created";

    protected static string $member = "member";
    protected static string $member_id = "member_id";
    protected static string $member_name = "member_name";

    protected static string $language = "language";
    protected static string $language_id = "language";
    protected static string $language_name = "language_name";
    
    protected static string $verify = "verify";
    protected static string $verify_id = "verify_id";
    protected static string $verify_name = "verify_name";

    protected static string $theme = "theme";
    protected static string $theme_id = "theme_id";
    protected static string $theme_name = "theme_name";

    // Değişkenleri Getirtme
    // Kayıt numarası parametresi
    final public static function getId(): ?string {
        return self::$id;
    }

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

    // Kullanıcı Oluşturulma parametresi
    final public static function getCreated(): ?string {
        return self::$created;
    }

    // Oturum Oluşturulma parametresi
    final public static function getSessionCreated(): ?string {
        return self::$session_created;
    }

    // Üye parametresi
    final public static function getMember(): ?string {
        return self::$member;
    }

    final public static function getMemberId(): ?string {
        return self::$member_id;
    }

    final public static function getMemberName(): ?string {
        return self::$member_name;
    }

    // Dil parametresi
    final public static function getLanguage(): ?string {
        return self::$language;
    }

    final public static function getLanguageId(): ?string {
        return self::$language_id;
    }

    final public static function getLanguageName(): ?string {
        return self::$language_name;
    }

    // Kullanıcı Doğrulama parametresi
    final public static function getVerify(): ?string {
        return self::$verify;
    }

    final public static function getVerifyId(): ?string {
        return self::$verify_id;
    }

    final public static function getVerifyName(): ?string {
        return self::$verify_name;
    }

    // Tema parametresi
    final public static function getTheme(): ?string {
        return self::$theme;
    }

    final public static function getThemeId(): ?string {
        return self::$theme_id;
    }

    final public static function getThemeName(): ?string {
        return self::$theme_name;
    }

    // Tüm hepsini çağırma
    final public static function getAll(): ?array {
        return [
            self::getId(),
            self::getUsername(),
            self::getFirstname(),
            self::getLastname(),
            self::getEmail(),
            self::getPassword(),
            self::getCreated(),
            self::getSessionCreated(),
            self::getMember(),
            self::getMemberId(),
            self::getMemberName(),
            self::getLanguage(),
            self::getLanguageId(),
            self::getLanguageName(),
            self::getVerify(),
            self::getVerifyId(),
            self::getVerifyName(),
            self::getTheme(),
            self::getThemeId(),
            self::getThemeName()
        ];
    }
}