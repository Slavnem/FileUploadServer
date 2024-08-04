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
    protected static string $member = "member";
    protected static string $language = "language";
    protected static string $verify = "verify";
    protected static string $theme = "theme";
    protected static string $created = "created";
    protected static string $sessioncreate = "sessioncreate";

    // Değişkenleri Getirtme
    // Kayıt Numarası parametresi
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

    // Oluşturulma Tarihi parametresi
    final public static function getCreated(): ?string {
        return self::$created;
    }

    // Oturum Oluşturulma Tarihi parametresi
    final public static function getSessionCreate(): ?string {
        return self::$sessioncreate;
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
            self::getMember(),
            self::getLanguage(),
            self::getVerify(),
            self::getTheme(),
            self::getCreated(),
            self::getSession()
        ];
    }
}