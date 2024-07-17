<?php
// JSON
header("Content-Type: application/json; charset=UTF-8");

// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        echo json_encode(404, JSON_UNESCAPED_UNICODE);
        exit; // sonlandır
}

// Crypt API sınıfı
class CryptApi {
    public static function FileImporter(array $includeFile): bool {
        // tüm dosyaların varlığını kontrol etme
        foreach($includeFile as $file) {
            if(file_exists($file) !== true) {
                return false;
            }
        }

        // tüm dosyalar olduğu için içe aktarma
        foreach($includeFile as $file) {
            require $file;
        }

        return true;
    }
}

// CRYPTAPI ana url bağlantı türü
defined("CRYPTAPI_BASECONN") !== true ? define("CRYPTAPI_BASECONN", "crypt"): null;

// CRYPTAPI Genel Parametreler
defined("PARAM_ROUTE") !== true ? define("PARAM_ROUTE", "route"): null;
defined("PARAM_CODE") !== true ? define("PARAM_CODE", "code"): null;
defined("PARAM_TITLE") !== true ? define("PARAM_TITLE", "title"): null;
defined("PARAM_MSG") !== true ? define("PARAM_MSG", "message"): null;

// Method ön tanımlamaları
defined("METHOD_SECURE") !== true ? define("METHOD_SECURE", "SECURE"): null; // güvenli veri gönderme yöntemi
defined("METHOD_VISIBLE") !== true ? define("METHOD_VISIBLE", "VISIBLE"): null; // url de görünebilir veri gönderme yöntemi

// Klasörler
defined("DIR_CRYPT") !== true ? define("DIR_CRYPT", __DIR__): null;
defined("DIR_SESSION") !== true ? define("DIR_SESSION", $_SERVER['DOCUMENT_ROOT'] . "/core/api/local/session/"): null;
defined("DIR_CRYPT_ENCRYPTION") !== true ? define("DIR_CRYPT_ENCRYPTION", DIR_CRYPT . "/encryption/"): null;
defined("DIR_CRYPT_DECRYPTION") !== true ? define("DIR_CRYPT_DECRYPTION", DIR_CRYPT . "/decryption/"): null;

// CRYPTAPI Sorgu Türleri
defined("CRYPTAPI_ENCRYPTION") !== true ? define("CRYPTAPI_ENCRYPTION", "encrypt"): null;
defined("CRYPTAPI_DECRYPTION") !== true ? define("CRYPTAPI_DECRYPTION", "decrypt"): null;

// Hata Kodları, Başlıkları, Mesajları
defined("ERRORCODE_INVALIDCRYPTAPI") !== true ? define("ERRORCODE_INVALIDCRYPTAPI", 0): null;
defined("ERRORCODE_IMPORTFAIL") !== true ? define("ERRORCODE_IMPORTFAIL", 1): null;
defined("ERRORCODE_INVALIDMETHOD") !== true ? define("ERRORCODE_INVALIDMETHOD", 2): null;
defined("ERRORCODE_INVALIDROUTE") !== true ? define("ERRORCODE_INVALIDROUTE", 3): null;
defined("ERRORCODE_INVALIDDATA") !== true ? define("ERRORCODE_INVALIDDATA", 4): null;
defined("ERRORCODE_INVALIDSEND") !== true ? define("ERRORCODE_INVALIDSEND", 5): null;

defined("ERROR_INVALIDCRYPTAPI") !== true ? define("ERROR_INVALIDCRYPTAPI", "Invalid CRPYT Tag"): null;
defined("ERROR_IMPORTFAIL") !== true ? define("ERROR_IMPORTFAIL", "Import Fail"): null;
defined("ERROR_INVALIDROUTE") !== true ? define("ERROR_INVALIDROUTE", "Invalid Route"): null;
defined("ERROR_INVALIDSEND") !== true ? define("ERROR_INVALIDSEND", "Invalid Send"): null;
defined("ERROR_INVALIDMETHOD") !== true ? define("ERROR_INVALIDMETHOD", "Invalid Method"): null;

defined("ERRORMSG_INVALIDCRYPTAPI") !== true ? define("ERRORMSG_INVALIDCRYPTAPI", "This CRYPT Tag Is Invalid"): null;
defined("ERRORMSG_IMPORTFAIL") !== true ? define("ERRORMSG_IMPORTFAIL", "Files Couldn't Import Successfully"): null;
defined("ERRORMSG_INVALIDROUTE") !== true ? define("ERRORMSG_INVALIDROUTE", "Invalid Router Address"): null;
defined("ERRORMSG_INVALIDSEND") !== true ? define("ERRORMSG_INVALIDSEND", "Send Type Couldn't Find"): null;
defined("ERRORMSG_INVALIDMETHOD") !== true ? define("ERRORMSG_INVALIDMETHOD", "Allow: " . METHOD_VISIBLE . ", " . METHOD_SECURE): null;

// Oturum dosyaları
$includeSessionFile = [
    DIR_SESSION . "SessionStruct.php",
    DIR_SESSION . "SessionFunctions.php"
];

// Oturum kontrolü için oturum dosyalarını içe aktarma
switch(true) {
    case ((bool)CryptApi::FileImporter($includeSessionFile)):
        // admin kullanıcı kontrolü
        if((bool)SessionFunctions::SessionAdmin() === true) {
            // değişken temizleme
            unset($includeSessionFile);

            // admin kullanıcı girişi başarılı
            break;
        }
    default:
        http_response_code(401);
        echo json_encode(401, JSON_UNESCAPED_UNICODE);
        exit; // sonlandır
}

// Gönderilen veri methodunu alma
$requestMethod= (isset($_SERVER['REQUEST_METHOD']) && empty($_SERVER['REQUEST_METHOD']) !== true) ?
    ($_SERVER['REQUEST_METHOD']) : null;

// URL
$url = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

// URL PARTS
$uriData = explode("/", $url);
$ApiCrypt = isset($uriData[0]) ? $uriData[0] : null;

// METHOD JSON DATA
$inputData = json_decode(file_get_contents('php://input'), true);
$inputRoute = isset($inputData[PARAM_ROUTE]) ? $inputData[PARAM_ROUTE] : null;

// Yönlendirilmek istenen kısım
$redirectUrl = array_slice($uriData, 2, 4);

// CRYPT türü başarısız ise
if($ApiCrypt != CRYPTAPI_BASECONN) {
    http_response_code(404);

    echo json_encode([
        PARAM_CODE => ERRORCODE_INVALIDCRYPTAPI,
        PARAM_TITLE => ERROR_INVALIDCRYPTAPI,
        PARAM_MSG => ERRORMSG_INVALIDCRYPTAPI
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

// Veri gönderilecek adres
$sendAddr = (isset($uriData[1]) && empty($uriData[1] !== true)) ? $uriData[1] : null;

// Yapılacak işlemlere göre dosyalar
$includeFile = [
    CRYPTAPI_ENCRYPTION => [
        DIR_CRYPT_ENCRYPTION . "EncryptionKeys.php",
        DIR_CRYPT_ENCRYPTION . "EncryptionFunctions.php",
        DIR_CRYPT_ENCRYPTION . "EncryptionProcess.php"
    ]/*,
    CRYPTAPI_DECRYPTION => [
        DIR_CRYPT_DECRYPTION . "DecryptionKeys.php",
        DIR_CRYPT_DECRYPTION . "DecryptionFunctions.php",
        DIR_CRYPT_DECRYPTION . "DecryptionProcess.php"
    ]*/
];

// Method türüne göre işlem
switch($requestMethod) {
    // güvenli veri gönderimi metodu
    // görünebilir veri gönderimi metodu
    case (METHOD_SECURE):
        // Sorgu sonuçlarını tutacak olan değişken
        $storeData = null;

        // Sayfa yönlendirme durumu kontrolü için değişken
        $statusRoute = true;

        // İçeri aktarılan dosyaların durumunu tutacak olan değişken
        $statusImport = false;

        // Sorgu yapılmak istenen tür
        switch($inputRoute) {
            case (CRYPTAPI_ENCRYPTION):
                $statusImport = (bool)CryptApi::FileImporter($includeFile[CRYPTAPI_ENCRYPTION]);
                break;
            /*case (CRYPTAPI_DECRYPTION):
                $statusImport = (bool)CryptApi::FileImporter($includeFile[CRYPTAPI_DECRYPTION]);
                break;*/
            // Bilinmiyor
            default:
                $statusRoute = false;
                break;
        }

        // Değişken değer kontrolü
        switch(!true) {
            case ($statusRoute):
                $storeData = [
                    PARAM_CODE => ERRORCODE_INVALIDROUTE,
                    PARAM_TITLE => ERROR_INVALIDROUTE,
                    PARAM_MSG => ERRORMSG_INVALIDROUTE
                ];
                break;
            case ($statusImport): // başarısız
                $storeData = [
                    PARAM_CODE => ERRORCODE_IMPORTFAIL,
                    PARAM_TITLE => ERROR_IMPORTFAIL,
                    PARAM_MSG => ERRORMSG_IMPORTFAIL
                ];
            break;
        }

        // json objesi olarak depolanan veriyi çıktı ver
        echo json_encode($storeData, JSON_UNESCAPED_UNICODE);
    exit;
    // görünebilir veri gönderimi metodu
    default:
        // Sorgu sonuçlarını tutacak olan değişken
        $storeData = null;

        // Sayfa yönlendirme durumu kontrolü için değişken
        $statusRoute = true;

        // İçeri aktarılan dosyaların durumunu tutacak olan değişken
        $statusImport = false;

        // Sorgu yapılmak istenen tür
        switch($sendAddr) {
            default: // Bilinmiyor
                $statusRoute = false;
                break;
        }

        // Değişken değer kontrolü
        switch(!true) {
            case ($statusRoute):
                $storeData = [
                    PARAM_CODE => ERRORCODE_INVALIDROUTE,
                    PARAM_TITLE => ERROR_INVALIDROUTE,
                    PARAM_MSG => ERRORMSG_INVALIDROUTE
                ];
                break;
            case ($statusImport): // başarısız
                $storeData = [
                    PARAM_CODE => ERRORCODE_IMPORTFAIL,
                    PARAM_TITLE => ERROR_IMPORTFAIL,
                    PARAM_MSG => ERRORMSG_IMPORTFAIL
                ];
            break;
        }

        // json objesi olarak depolanan veriyi çıktı ver
        echo json_encode($storeData, JSON_UNESCAPED_UNICODE);
    exit;
}

/*
// Method yok ya da geçersiz
http_response_code(501);
header(ERRORMSG_INVALIDMETHOD);

echo json_encode([
    PARAM_CODE => ERRORCODE_INVALIDMETHOD,
    PARAM_TITLE => ERROR_INVALIDMETHOD,
    PARAM_MSG => ERRORMSG_INVALIDMETHOD
], JSON_UNESCAPED_UNICODE);

exit;
*/