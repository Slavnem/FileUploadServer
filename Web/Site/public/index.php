<?php
// Slavnem @2024-08-03
namespace Site\Public;

// Sabit değerler
const __JSON_PARAM_TYPE__ = "type";
const __JSON_PARAM_CODE__ = "code";
const __JSON_PARAM_MSG__ = "msg";

// Paramterlere Ait Değerler
const __JSON_TYPE_VAL_ERR__ = "error";
const __JSON_TYPE_VAL_WARN__ = "warning";
const __JSON_TYPE_VAL_SUCC__ = "success";
const __JSON_TYPE_VAL_REQ__ = "request";
const __JSON_TYPE_VAL_RES__ = "result"; 

// Durum kodları
const __JSON_CODE_VAL_ERR__ = -1;
const __JSON_CODE_VAL_WARN__ = 0;
const __JSON_CODE_VAL_SUCC__ = 1;
const __JSON_CODE_VAL_REQ__ = 10;
const __JSON_CODE_VAL_RES__ = 20;

// Ana Dosya Yolu
const __SRC_DIR__ = "../src/v1/";

// INDEX GLOBAL
final class IndexGlobal {
    public static final function Importer(?array $argFiles): bool {
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

    // JSON için durum döndürücü
    public static final function ReturnForJSON(
        ?string $type_str,
        ?int $code_val,
        ?string $msg_str
    ): ?array {
        return [
            __JSON_PARAM_TYPE__ => (string)$type_str ?? null,
            __JSON_PARAM_CODE__ => (int)$code_val ?? null,
            __JSON_PARAM_MSG__ => (string)$msg_str ?? null
        ];
    }
}

// Dosyalar
$IndexFiles = [
    "../vendor/autoload.php",
    "../../Api/Auth/vendor/autoload.php",
    "../../Api/Session/vendor/autoload.php",
    "../../Api/File/vendor/autoload.php",
    "../src/v1/Kernel/Kernel.php"
];

// Dosya Aktarması Durumu
switch(!IndexGlobal::Importer($IndexFiles)) {
    // Hata yönlendirmesi
    case true:
        http_response_code(404);
        die(json_encode(IndexGlobal::ReturnForJSON(
            __JSON_TYPE_VAL_ERR__,
            __JSON_CODE_VAL_ERR__,
            "Process files could not be imported successfully and therefore cannot be processed"
        )));
}