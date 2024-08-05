<?php
// Slavnem @2024-08-05
namespace FileApi\v1\Includes\Param;

// Parametre
final class FileParams {
    protected static string $filename = "filename";

    // Dosya adı
    final public static function getFilename(): ?string {
        return self::$filename;
    }
}