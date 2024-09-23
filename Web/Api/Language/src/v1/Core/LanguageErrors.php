<?php
// Slavnem @2024-09-20
namespace LanguageApi\v1\Core;

// Language Errors
trait LanguageErrors {
    // Anahtar kelimeler
    protected static string $keyCode = "code";
    protected static string $keyMessage = "message";
    protected static string $keyDescription = "description";

    // Başlangıçta varolan hata çeşitleri
    protected static array $AutoErrorLanguageNotFound = [
        "code" => -1,
        "message" => "Language Not Found",
        "description" => "Requested Language Not Found"
    ];

    protected static array $AutoErrorPageNotFound = [
        "code" => -1,
        "message" => "Page Not Found",
        "description" => "Requested Page Not Found"
    ];

    // Anahtar Kelimeleri Getirtme
    final public static function getCode(): ?string {
        return self::$keyCode;
    }

    final public static function getMessage(): ?string {
        return self::$keyMessage;
    }

    final public static function getDescription(): ?string {
        return self::$keyDescription;
    }

    // Hata Bilgilerini Getirtme
    final public static function getAutoErrorLanguageNotFound(): ?array {
        return self::$AutoErrorLanguageNotFound;
    }

    final public static function getAutoErrorPageNotFound(): ?array {
        return self::$AutoErrorPageNotFound;
    }
}