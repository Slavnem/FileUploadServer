<?php
// Slavnem @2024-07-06
namespace AuthApi\v1\Core;

trait AuthMethods
{
    // Anahtarlar
    protected static string $methodFetch = "FETCH";
    protected static string $methodCreate = "CREATE";
    protected static string $methodUpdate = "UPDATE";
    protected static string $methodDelete = "DELETE";
    protected static string $methodVerify = "VERIFY";


    // Anahtarları getiren fonksiyonlar
    final public static function getFetch(): ?string {
        return self::$methodFetch;
    }

    final public static function getCreate(): ?string {
        return self::$methodCreate;
    }

    final public static function getUpdate(): ?string {
        return self::$methodUpdate;
    }

    final public static function getDelete(): ?string {
        return self::$methodDelete;
    }

    final public static function getVerify(): ?string {
        return self::$methodVerify;
    }

    final public static function getAll(): ?array {
        return [
            self::getFetch(),
            self::getCreate(),
            self::getUpdate(),
            self::getDelete(),
            self::getVerify()
        ];
    }
}