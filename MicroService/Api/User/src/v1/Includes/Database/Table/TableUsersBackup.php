<?php
// Slavnem @2024-07-05
// Kullanıcı Yedek Tablosu
namespace UserApi\v1\Includes\Database\Table;

trait TableUsersBackup {
    // Değişkenleri Tanımlama
    protected static string $id = "usersbackupId";
    protected static string $userid = "usersbackupUserid";
    protected static string $username = "usersbackupUsername";
    protected static string $firstname = "usersbackupFirstname";
    protected static string $lastname = "usersbackupLastname";
    protected static string $email = "usersbackupEmail";
    protected static string $password = "usersbackupPassword";
    protected static string $memberid = "usersbackupMemberid";
    protected static string $languageid = "usersbackupLanguageid";
    protected static string $verifyid = "usersbackupVerifyid";
    protected static string $themeid = "usersbackupThemeid";
    protected static string $process = "usersbackupProcess";
    protected static string $created = "usersbackupCreated";

    // Değişkenleri Getirtme
    // Kayıt numarası sütunu
    final public static function getId(): ?string {
        return self::$id;
    }

    // Kullanıcı numarası sütunu
    final public static function getUserId(): ?string {
        return self::$userid;
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

    // Yedekleme işlemi türü sütunu
    final public static function getProcess(): ?string {
        return self::$process;
    }

    // Yedekleme kayıtı oluşturulma tarihi sütunu
    final public static function getCreated(): ?string {
        return self::$created;
    }

    // Tüm hepsini çağırma
    final public static function getAll(): ?array {
        return array(
            self::getId(),
            self::getUserId(),
            self::getUsername(),
            self::getFirstname(),
            self::getLastname(),
            self::getEmail(),
            self::getPassword(),
            self::getMemberId(),
            self::getLanguageId(),
            self::getVerifyId(),
            self::getThemeId(),
            self::getProcess(),
            self::getCreated()
        );
    }
}