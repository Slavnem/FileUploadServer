<?php
// Slavnem @2024-09-20
namespace LanguageApi\v1\Core;

// Methodlar
trait LanguageMethods
{
    // Anahtarlar
    protected static string $methodFetch = "FETCH";
    protected static string $methodGet = "GET";

    // Anahtarları getiren fonksiyonlar
    final public static function getFetch(): ?string {
        return self::$methodFetch;
    }

    final public static function getGet(): ?string {
        return self::$methodGet;
    }

    final public static function getAll(): ?array {
        return [
            self::getFetch(),
            self::getGet()
        ];
    }
}