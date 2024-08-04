<?php
// Slavnem @2024-08-03
namespace FileApi\v1\Includes\Config;

// Dosya İşlemleri Bilgisi
const __FILE_UPLOAD_LOCATION__ = "../../../../../../../Storage/";

// Değiştirilemez Erişme Sınıfı
final class FileConfig {
    // Dosya Yolunu Getirtme
    final public static function getStorageDir(): ?string
    {
        // dosya yükleme konumunu getirsin
        return __FILE_UPLOAD_LOCATION__;
    }
}