<?php
// Slavnem @2024-08-03
namespace FileApi\v1\Includes\Config;

// Değiştirilemez Erişme Sınıfı
final class FileConfig {
    // Dosya Yolunu Getirtme
    final public static function getStorageDir(): ?string
    {
        // dosya yükleme konumunu getirsin
        return (dirname(__DIR__) . "/../../../../../../Storage/");
    }

    // Dosya URL Yolunu Getirtme
    final public static function getStorageUrl(): ?string {
        return ($_SERVER['HTTP_HOST'] . "/Storage/");
    }

    // Dosya Boyutu
    final public static function calcFileSize(int $bytes): ?string {
        if ($bytes < 1024) return $bytes . ' Bayt'; // Bayt
        elseif ($bytes < 1048576) return round($bytes / 1024, 2) . ' KB'; // Kilo Bayt
        elseif ($bytes < 1073741824) return round($bytes / 1048576, 2) . ' MB'; // Megabayt
        elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2) . ' GB'; // Gigabayt
        return round($bytes / 1099511627776, 2) . ' TB'; // Terabayt
    }
}