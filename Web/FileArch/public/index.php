<?php
// Slavnem @2024-08-03
namespace FileArchWeb\Public;

// Dosya İşlemi Sınıfı
class IndexOperations {
    public static function Importer(?array $argFiles): bool {
        // boşsa dosya hata dönsün
        if($argFiles === null || !is_array($argFiles)) {
            return false;
        }

        // Dosyaların varlığı kontrolü
        foreach($argFiles as $File) {
            if(!file_exists($File)) {
                echo $File;
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

// Dosyalar
$IndexFiles = array(
    dirname(__DIR__) . "/vendor/autoload.php",
    "../../../MicroService/Api/Session/vendor/autoload.php",
    "../../../MicroService/Api/File/vendor/autoload.php",
    dirname(__DIR__) . "/src/v1/Kernel/FileArchKernel.php"
);

// Dosya Aktarması Durumu
switch(!IndexOperations::Importer($IndexFiles)) {
    // Hata yönlendirmesi
    case true:
        http_response_code(404);
        header("Message: File Not Found");
        exit();
}