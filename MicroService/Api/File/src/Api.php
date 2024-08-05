<?php
// Slavnem @2024-08-02

// Dosyalar
$IndexFiles = array(
    dirname(__DIR__) . "/vendor/autoload.php",
    "../../Session/vendor/autoload.php",
    "../../User/vendor/autoload.php",
    dirname(__DIR__) . "/src/v1/Kernel/FileKernel.php"
);

// Dosya İşlemi
final class IndexOperations {
    public static function Importer(?array $argFiles): bool {
        // boşsa dosya hata dönsün
        if($argFiles === null || !is_array($argFiles)) {
            return false;
        }

        // Dosyaların varlığı kontrolü
        foreach($argFiles as $File) {
            if(!file_exists($File)) {
                return false;
            }
        }

        // Dosyaları İçe Aktar
        foreach($argFiles as $File) {
            require_once $File;
        }

        // Dosya içe aktarma başarılı
        return true;
    }
}

// Dosya Aktarması Durumu
switch(IndexOperations::Importer($IndexFiles)) {
    // Dosya İçe Aktarma Başarılı
    case true: break;
    // Hata yönlendirmesi
    default:
        http_response_code(404);
        header("Message: File Not Found");
        exit;
}