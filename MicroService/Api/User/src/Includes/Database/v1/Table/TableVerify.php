<?php
// Slavnem @2024-07-05
// Kullanıcı Doğrulama Tablosu
namespace UserApi\Includes\Database\v1\Table;

trait TableVerify {
    // Değişkenleri Tanımlama
    protected static string $id = "verifyId";
    protected static string $value = "verifyValue";
    protected static string $name = "verifyName";

    // Değişkenleri Getirtme
    // Kayıt numarası sütunu
    final public static function getId(): ?string {
        return self::$id;
    }

    // Değer sütunu
    final public static function getValue(): ?string {
        return self::$value;
    }

    // İsimlendirme sütunu
    final public static function getName(): ?string {
        return self::$name;
    }

    // Tüm hepsini çağırma
    final public static function getAll(): ?array {
        return array(
            self::getId(),
            self::getValue(),
            self::getName()
        );
    }
}