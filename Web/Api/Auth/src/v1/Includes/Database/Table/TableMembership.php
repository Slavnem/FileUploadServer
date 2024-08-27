<?php
// Slavnem @2024-07-05
// Üyelik Tablosu
namespace AuthApi\v1\Includes\Database\Table;

trait TableMembership {
    // Değişkenleri Tanımlama
    protected static string $id = "membershipId";
    protected static string $value = "membershipValue";
    protected static string $name = "membershipName";

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