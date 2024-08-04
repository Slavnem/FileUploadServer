<?php
// Slavnem @2024-08-03
namespace FileApi\v1\Core;

trait Methods
{
    // Anahtarlar
    protected static string $methodFetch = "FETCH";
    protected static string $methodUpload = "UPLOAD";
    protected static string $methodDelete = "DELETE";


    // Anahtarları getiren fonksiyonlar
    final public static function getFetch(): ?string {
        return self::$methodFetch;
    }

    final public static function getUpload(): ?string {
        return self::$methodUpload;
    }

    final public static function getDelete(): ?string {
        return self::$methodDelete;
    }

    final public static function getAll(): ?array {
        return array(
            self::getFetch(),
            self::getUpload(),
            self::getDelete()
        );
    }
}