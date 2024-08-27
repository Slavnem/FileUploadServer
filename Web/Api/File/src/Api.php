<?php
// Slavnem @2024-08-02
namespace FileApi;

// Geçerli saat dilimi
date_default_timezone_set('Europe/Istanbul'); // Türkiye saati

// API
final class Api {
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

    // Dosya İçe Aktarıcı
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
            self::__JSON_PARAM_TYPE__ => (string)$type_str ?? null,
            self::__JSON_PARAM_CODE__ => (int)$code_val ?? null,
            self::__JSON_PARAM_MSG__ => (string)$msg_str ?? null
        ];
    }
}

// Sayfa Json objesi döndürecek
header("Content-Type: application/json; charset=UTF-8");

// Ana Dosyalar
$MainFiles = [
    "../vendor/autoload.php", // composer autoload
    "../../Auth/vendor/autoload.php", // auth
    "../../Session/vendor/autoload.php", // session
    "./v1/Kernel/Kernel.php" // kernel
];

// Dosya Aktarması Durumu
switch(!Api::Importer($MainFiles)) {
    // Hata yönlendirmesi
    case true:
        http_response_code(404);
        die(json_encode(Api::ReturnForJSON(
            Api::__JSON_TYPE_VAL_ERR__,
            Api::__JSON_CODE_VAL_ERR__,
            "Process files could not be imported successfully and therefore cannot be processed"
        ), JSON_UNESCAPED_UNICODE));
}

// Dosyalar başarıyla aktarılmasına rağmen eğer işlem yapılmadıysa
die(json_encode(Api::ReturnForJSON(
    Api::__JSON_TYPE_VAL_WARN__,
    Api::__JSON_CODE_VAL_WARN__,
    "No action was taken"
), JSON_UNESCAPED_UNICODE));