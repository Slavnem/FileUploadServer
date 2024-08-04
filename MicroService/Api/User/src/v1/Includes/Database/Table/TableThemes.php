<?php
// Slavnem @2024-07-05
// Temalar Tablosu
namespace UserApi\v1\Includes\Database\Table;

trait TableThemes {
    // Değişkenleri Tanımlama
    protected static string $id = "themesId";
    protected static string $value = "themesValue";
    protected static string $name = "themesName";

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