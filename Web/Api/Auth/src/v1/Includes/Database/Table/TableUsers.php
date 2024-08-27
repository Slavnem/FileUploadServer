<?php
// Slavnem @2024-07-05
// Kullanıcı Tablosu
namespace AuthApi\v1\Includes\Database\Table;

trait TableUsers {
    // Değişkenleri Tanımlama
    protected static string $id = "usersId";
    protected static string $username = "usersUsername";
    protected static string $firstname = "usersFirstname";
    protected static string $lastname = "usersLastname";
    protected static string $email = "usersEmail";
    protected static string $password = "usersPassword";
    protected static string $memberid = "usersMemberid";
    protected static string $languageid = "usersLanguageid";
    protected static string $verifyid = "usersVerifyid";
    protected static string $themeid = "usersThemeid";
    protected static string $created = "usersCreated";

    // Değişkenleri Getirtme
    // Kayıt numarası sütunu
    final public static function getId(): ?string {
        return self::$id;
    }

    // Kullanıcı Adı sütunu
    final public static function getUsername(): ?string {
        return self::$username;
    }

    // İsim sütunu
    final public static function getFirstname(): ?string {
        return self::$firstname;
    }

    // Soyisim sütunu
    final public static function getLastname(): ?string {
        return self::$lastname;
    }

    final public static function getEmail(): ?string {
        return self::$email;
    }

    // Şifre sütunu
    final public static function getPassword(): ?string {
        return self::$password;
    }

    // Üye numarası sütunu
    final public static function getMemberId(): ?string {
        return self::$memberid;
    }

    // Dil numarası sütunu
    final public static function getLanguageId(): ?string {
        return self::$languageid;
    }

    // Hesap doğrulama numarası sütunu
    final public static function getVerifyId(): ?string {
        return self::$verifyid;
    }

    // Kullanıcı tema numarası sütunu
    final public static function getThemeId(): ?string {
        return self::$themeid;
    }

    // Kullanıcı oluşturulma tarihi sütunu
    final public static function getCreated(): ?string {
        return self::$created;
    }

    // Tüm hepsini çağırma
    final public static function getAll(): ?array {
        return array(
            self::getId(),
            self::getUsername(),
            self::getFirstname(),
            self::getLastname(),
            self::getEmail(),
            self::getPassword(),
            self::getMemberId(),
            self::getLanguageId(),
            self::getVerifyId(),
            self::getThemeId(),
            self::getCreated()
        );
    }
}