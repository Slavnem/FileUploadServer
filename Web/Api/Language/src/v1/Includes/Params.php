<?php
// Slavnem @2024-09-20
namespace LanguageApi\v1\Includes;

// Params
trait Params {
    // Değişkenleri tanımlama
    protected static string $language = "language";
    protected static string $page = "page";

    // Değişkenleri Getirtme
    // Dil Parametresi
    final public static function getLanguage(): ?string {
        return self::$language;
    }

    // Sayfa Parametresi
    final public static function getPage(): ?string {
        return self::$page;
    }

    // Tüm hepsini çağırma
    final public static function getAll(): ?array {
        return [
            self::getLanguage(),
            self::getPage()
        ];
    }
}