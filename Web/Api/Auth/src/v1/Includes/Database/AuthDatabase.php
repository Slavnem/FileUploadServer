<?php
// Slavnem @2024-07-06
namespace AuthApi\v1\Includes\Database;

// Veritabanı PDO
use PDO;
use PDOException;

// Veritabanı bağlantısı bilgileri
const __AUTH_DATABASE_HOST__ = "localhost";
const __AUTH_DATABASE_NAME__ = "MainMicroServiceApiAuth";
const __AUTH_DATABASE_USER__ = "MainMicroServiceApi.v1.Admin";
const __AUTH_DATABASE_PASSWORD__ = "MainMicroServiceApi.v1.Admin@DebianGNU@MySQL";
const __AUTH_DATABASE_CHARSET__ = "utf8mb4";

// Veritabanı bağlantı özellikleri
const __AUTH_DATABASE_OPTIONS__ = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

const __AUTH_DATABASE_DSN__ = (
    "mysql:host=" . __AUTH_DATABASE_HOST__ .
    ";dbname=" . __AUTH_DATABASE_NAME__ .
    ";charset=" . __AUTH_DATABASE_CHARSET__
);

// Değiştirilemez veritabanı sınıfı
final class AuthDatabase {
    // Veritabanı Bağlantı
    final public static function getConnect(): ?PDO {
        try {
            return new PDO(
                __AUTH_DATABASE_DSN__,
                __AUTH_DATABASE_USER__,
                __AUTH_DATABASE_PASSWORD__,
                __AUTH_DATABASE_OPTIONS__
            );
        } catch(PDOException $pdoexcept) {
            return null;
        }
    }
}