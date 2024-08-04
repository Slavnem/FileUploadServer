<?php
// Slavnem @2024-07-06
namespace UserApi\v1\Includes\Database;

// Veritabanı PDO
use PDO;
use PDOException;

// Veritabanı bağlantısı bilgileri
const __USER_DATBASE_HOST__ = "localhost";
const __USER_DATABASE_NAME__ = "MainMicroServiceApiAuth";
const __USER_DATABASE_USER__ = "MainMicroServiceApi.v1.Admin";
const __USER_DATABASE_PASSWORD__ = "MainMicroServiceApi.v1.Admin@DebianGNU@MySQL";
const __USER_DATABASE_CHARSET__ = "utf8mb4";

// Veritabanı bağlantı özellikleri
const __USER_DATABASE_OPTIONS__ = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

const __USER_DATABASE_DSN__ = (
    "mysql:host=" . __USER_DATBASE_HOST__ .
    ";dbname=" . __USER_DATABASE_NAME__ .
    ";charset=" . __USER_DATABASE_CHARSET__
);

// Değiştirilemez veritabanı sınıfı
final class UserDatabase {
    // Veritabanı Bağlantı
    final public static function getConnect(): ?PDO {
        try {
            return new PDO(
                __USER_DATABASE_DSN__,
                __USER_DATABASE_USER__,
                __USER_DATABASE_PASSWORD__,
                __USER_DATABASE_OPTIONS__
            );
        } catch(PDOException $pdoexcept) {
            return null;
        }
    }
}