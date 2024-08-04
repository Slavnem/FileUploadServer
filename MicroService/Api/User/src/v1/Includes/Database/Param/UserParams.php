<?php
// Slavnem @2024-07-05
// Kullanıcı İçin Parametreler
namespace UserApi\v1\Includes\Database\Param;

trait UserParams {
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
            self::getTheme()
        ];
    }
}