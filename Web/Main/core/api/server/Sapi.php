<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        echo json_encode(404, JSON_UNESCAPED_UNICODE);
        exit; // sonlandır
}

// Server API sınıfı
class Sapi {
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

// SAPI ana url bağlantı türü
defined("SAPI_BASECONN") !== true ? define("SAPI_BASECONN", "sapi"): null;

// Klasörler
defined("DIR_SAPI") !== true ? define("DIR_SAPI", __DIR__): null;
defined("DIR_SAPI_DATABASE") !== true ? define("DIR_SAPI_DATABASE", DIR_SAPI . "/database/"): null;
defined("DIR_SAPI_ERROR") !== true ? define("DIR_SAPI_ERROR", DIR_SAPI . "/error/"): null;
defined("DIR_SAPI_USERS") !== true ? define("DIR_SAPI_USERS", DIR_SAPI . "/users/"): null;

// SAPI Sorgu Türleri
defined("SAPI_USERS") !== true ? define("SAPI_USERS", "users"): null;

// SAPI Genel Parametreler
defined("PARAM_ROUTE") !== true ? define("PARAM_ROUTE", "route"): null;
defined("PARAM_CODE") !== true ? define("PARAM_CODE", "code"): null;
defined("PARAM_TITLE") !== true ? define("PARAM_TITLE", "title"): null;
defined("PARAM_MSG") !== true ? define("PARAM_MSG", "message"): null;

// Method ön tanımlamaları
defined("METHOD_SECURE") !== true ? define("METHOD_SECURE", "SECURE"): null; // güvenli veri gönderme yöntemi
defined("METHOD_VISIBLE") !== true ? define("METHOD_VISIBLE", "VISIBLE"): null; // url de görünebilir veri gönderme yöntemi

// Hata Kodları, Başlıkları, Mesajları
defined("ERRORCODE_INVALIDSAPI") !== true ? define("ERRORCODE_INVALIDSAPI", 0): null;
defined("ERRORCODE_IMPORTFAIL") !== true ? define("ERRORCODE_IMPORTFAIL", 1): null;
defined("ERRORCODE_INVALIDMETHOD") !== true ? define("ERRORCODE_INVALIDMETHOD", 2): null;
defined("ERRORCODE_INVALIDROUTE") !== true ? define("ERRORCODE_INVALIDROUTE", 3): null;
defined("ERRORCODE_INVALIDDATA") !== true ? define("ERRORCODE_INVALIDDATA", 4): null;
defined("ERRORCODE_INVALIDSEND") !== true ? define("ERRORCODE_INVALIDSEND", 5): null;

defined("ERROR_INVALIDSAPI") !== true ? define("ERROR_INVALIDSAPI", "Invalid SAPI Tag"): null;
defined("ERROR_IMPORTFAIL") !== true ? define("ERROR_IMPORTFAIL", "Import Fail"): null;
defined("ERROR_INVALIDMETHOD") !== true ? define("ERROR_INVALIDMETHOD", "Invalid Method"): null;
defined("ERROR_INVALIDROUTE") !== true ? define("ERROR_INVALIDROUTE", "Invalid Route"): null;
defined("ERROR_INVALIDSEND") !== true ? define("ERROR_INVALIDSEND", "Invalid Send"): null;

defined("ERRORMSG_INVALIDSAPI") !== true ? define("ERRORMSG_INVALIDSAPI", "This SAPI Tag Is Invalid"): null;
defined("ERRORMSG_IMPORTFAIL") !== true ? define("ERRORMSG_IMPORTFAIL", "Files Couldn't Import Successfully"): null;
defined("ERRORMSG_INVALIDMETHOD") !== true ? define("ERRORMSG_INVALIDMETHOD", "Allow: " . METHOD_VISIBLE . ", " . METHOD_SECURE): null;
defined("ERRORMSG_INVALIDROUTE") !== true ? define("ERRORMSG_INVALIDROUTE", "Invalid Router Address"): null;
defined("ERRORMSG_INVALIDSEND") !== true ? define("ERRORMSG_INVALIDSEND", "Send Type Couldn't Find"): null;

// Header JSON
header("Content-Type: application/json; charset=UTF-8");

// Gönderilen veri methodunu alma
$requestMethod = (isset($_SERVER['REQUEST_METHOD']) && empty($_SERVER['REQUEST_METHOD']) !== true) ?
    ($_SERVER['REQUEST_METHOD']) : null;

// URL
$uri = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

// PHP INPUT DATAS
$inputData = json_decode(file_get_contents('php://input'), true);
$inputRoute = isset($inputData[PARAM_ROUTE]) ? $inputData[PARAM_ROUTE] : null;

// URL PARTS
$uriData = explode("/", $uri);
$ApiServer = (isset($uriData[0])) ? ($uriData[0]) : (null);

// SAPI türü başarısız ise
if($ApiServer != SAPI_BASECONN) {
    http_response_code(404);

    echo json_encode([
        PARAM_CODE => ERRORCODE_INVALIDSAPI,
        PARAM_TITLE => ERROR_INVALIDSAPI,
        PARAM_MSG => ERRORMSG_INVALIDSAPI
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

// Veri gönderilecek adres
$sendAddr = (isset($uriData[1])) ? ($uriData[1]) : (null);

// Yapılacak işlemlere göre dosyalar
$includeFile = [
    "users" => [
        DIR_SAPI_DATABASE . "Database.php",
        DIR_SAPI_USERS . "UsersStruct.php",
        DIR_SAPI_USERS . "UsersGateway.php",
        DIR_SAPI_USERS . "UsersController.php",
        DIR_SAPI_USERS . "UsersProcess.php"
    ]
];

// Method türüne göre işlem
switch($requestMethod) {
    // Güvenli Veri Gönderimi
    case (METHOD_SECURE):
        // Sorgu sonuçlarını tutacak olan değişken
        $storeData = null;

        // Sayfa yönlendirme durumu kontrolü için değişken
        $statusRoute = true;

        // İçeri aktarılan dosyaların durumunu tutacak olan değişken
        $statusImport = false;

        // Sorgu yapılmak istenen tür
        switch($inputRoute) {
            // Kullanıcılar
            case (SAPI_USERS):
                // Dosya aktarımına ait değeri tutacak
                $statusImport = boolval(Sapi::FileImporter($includeFile[SAPI_USERS]));
            break;
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
    // Görünebilir Veri Gönderimi
    default:
        // Sorgu sonuçlarını tutacak olan değişken
        $storeData = null;

        // Sayfa yönlendirme durumu kontrolü için değişken
        $statusRoute = true;

        // İçeri aktarılan dosyaların durumunu tutacak olan değişken
        $statusImport = false;

        // Sorgu yapılmak istenen tür
        switch($sendAddr) {
            // Bilinmiyor
            default:
                $statusRoute = false;
            break;
        }

        // Değişken değer kontrolü
        switch(true) {
            case ($statusRoute !== true):
                $storeData = [
                    PARAM_CODE => ERRORCODE_INVALIDROUTE,
                    PARAM_TITLE => ERROR_INVALIDROUTE,
                    PARAM_MSG => ERRORMSG_INVALIDROUTE
                ];
                break;
            case ($statusImport !== true): // başarısız
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