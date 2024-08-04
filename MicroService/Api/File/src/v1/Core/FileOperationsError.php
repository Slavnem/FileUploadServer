<?php
// Slavnem @2024-08-03
namespace FileApi\v1\Core;

// Oturum Hataları
trait FileOperationsError {
    // Anahtar kelimeler
    protected static string $keyCode = "code";
    protected static string $keyMessage = "message";
    protected static string $keyDescription = "description";

    // Başlangıçta varolan hata çeşitleri
    protected static array $AutoErrorNonData = [
        "code" => -1,
        "message" => "No Valid Data",
        "description" => "Lack of Valid Data Causes Error",
    ];

    protected static array $AutoErrorNoFile = [
        "code" => -1,
        "message" => "Files Not Found",
        "description" => "You Must Have The Files To Be Able To Upload Them"
    ];

    protected static array $AutoErrorSessionForUpload = [
        "code" => -1,
        "message" => "Session Required",
        "description" => "Current Session Required to Upload Files"
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
    final public static function getAutoErrorNonData(): ?array {
        return self::$AutoErrorNonData;
    }

    final public static function getAutoErrorNoFile(): ?array {
        return self::$AutoErrorNoFile;
    }

    final public static function getAutoErrorSessionForUpload(): ?array {
        return self::$AutoErrorSessionForUpload;
    }

    // Özel Hata Döndürme
    final public static function ErrorReturn(
        ?int $argErrCode = -1,
        ?string $argErrMsg,
        ?string $argErrDesc
    ): ?array
    {
        return [
            "code" => $argErrCode,
            "message" => $argErrMsg,
            "description" => $argErrDesc,
        ];
    }
}
