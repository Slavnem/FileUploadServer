<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        echo json_encode(404, JSON_UNESCAPED_UNICODE);
        exit; // sonlandır
}

// Local API sınıfı
class Lapi {
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

// LAPI ana url bağlantı türü
defined("LAPI_BASECONN") !== true ? define("LAPI_BASECONN", "lapi"): null;

// Klasörler
defined("DIR_LAPI") !== true ? define("DIR_LAPI", __DIR__): null;
defined("DIR_LAPI_LANGUAGE") !== true ? define("DIR_LAPI_LANGUAGE", DIR_LAPI . "/language/"): null;
defined("DIR_LAPI_BACKGROUND") !== true ? define("DIR_LAPI_BACKGROUND", DIR_LAPI . "/background/"): null;
defined("DIR_LAPI_SESSION") !== true ? define("DIR_LAPI_SESSION", DIR_LAPI . "/session/"): null;
defined("DIR_LAPI_ICON") !== true ? define("DIR_LAPI_ICON", DIR_LAPI . "/icon/"): null;

// LAPI Sorgu Türleri
defined("LAPI_LANGUAGE") !== true ? define("LAPI_LANGUAGE", "language"): null;
defined("LAPI_BACKGROUND") !== true ? define("LAPI_BACKGROUND", "background"): null;
defined("LAPI_SESSION") !== true ? define("LAPI_SESSION", "session"): null;
defined("LAPI_ICON") !== true ? define("LAPI_ICON", "icon"): null;

// LAPI Genel Parametreler
defined("PARAM_ROUTE") !== true ? define("PARAM_ROUTE", "route"): null;
defined("PARAM_CODE") !== true ? define("PARAM_CODE", "code"): null;
defined("PARAM_TITLE") !== true ? define("PARAM_TITLE", "title"): null;
defined("PARAM_MSG") !== true ? define("PARAM_MSG", "message"): null;

// Method ön tanımlamaları
defined("METHOD_SECURE") !== true ? define("METHOD_SECURE", "SECURE"): null; // güvenli veri gönderme yöntemi
defined("METHOD_VISIBLE") !== true ? define("METHOD_VISIBLE", "VISIBLE"): null; // url de görünebilir veri gönderme yöntemi

// Hata Kodları, Başlıkları, Mesajları
defined("ERRORCODE_INVALIDLAPI") !== true ? define("ERRORCODE_INVALIDLAPI", 0): null;
defined("ERRORCODE_IMPORTFAIL") !== true ? define("ERRORCODE_IMPORTFAIL", 1): null;
defined("ERRORCODE_INVALIDMETHOD") !== true ? define("ERRORCODE_INVALIDMETHOD", 2): null;
defined("ERRORCODE_INVALIDROUTE") !== true ? define("ERRORCODE_INVALIDROUTE", 3): null;
defined("ERRORCODE_INVALIDDATA") !== true ? define("ERRORCODE_INVALIDDATA", 4): null;
defined("ERRORCODE_INVALIDSEND") !== true ? define("ERRORCODE_INVALIDSEND", 5): null;

defined("ERROR_INVALIDLAPI") !== true ? define("ERROR_INVALIDLAPI", "Invalid LAPI Tag"): null;
defined("ERROR_IMPORTFAIL") !== true ? define("ERROR_IMPORTFAIL", "Import Fail"): null;
defined("ERROR_INVALIDROUTE") !== true ? define("ERROR_INVALIDROUTE", "Invalid Route"): null;
defined("ERROR_INVALIDSEND") !== true ? define("ERROR_INVALIDSEND", "Invalid Send"): null;
defined("ERROR_INVALIDMETHOD") !== true ? define("ERROR_INVALIDMETHOD", "Invalid Method"): null;

defined("ERRORMSG_INVALIDLAPI") !== true ? define("ERRORMSG_INVALIDLAPI", "This LAPI Tag Is Invalid"): null;
defined("ERRORMSG_IMPORTFAIL") !== true ? define("ERRORMSG_IMPORTFAIL", "Files Couldn't Import Successfully"): null;
defined("ERRORMSG_INVALIDROUTE") !== true ? define("ERRORMSG_INVALIDROUTE", "Invalid Router Address"): null;
defined("ERRORMSG_INVALIDSEND") !== true ? define("ERRORMSG_INVALIDSEND", "Send Type Couldn't Find"): null;
defined("ERRORMSG_INVALIDMETHOD") !== true ? define("ERRORMSG_INVALIDMETHOD", "Allow: " . METHOD_VISIBLE . ", " . METHOD_SECURE): null;

// Header JSON
header("Content-Type: application/json; charset=UTF-8");

// Gönderilen veri methodunu alma
$requestMethod= (isset($_SERVER['REQUEST_METHOD']) && empty($_SERVER['REQUEST_METHOD']) !== true) ?
    ($_SERVER['REQUEST_METHOD']) : null;

// URL
$uri = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

// PHP INPUT DATAS
$inputData = json_decode(file_get_contents('php://input'), true);
$inputRoute = isset($inputData[PARAM_ROUTE]) ? $inputData[PARAM_ROUTE] : null;

// URL PARTS
$uriData = explode("/", $uri);
$ApiLocal = isset($uriData[0]) ? $uriData[0] : null;

// LAPI türü başarısız ise
if($ApiLocal != LAPI_BASECONN) {
    http_response_code(404);

    echo json_encode([
        PARAM_CODE => ERRORCODE_INVALIDLAPI,
        PARAM_TITLE => ERROR_INVALIDLAPI,
        PARAM_MSG => ERRORMSG_INVALIDLAPI
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

// Veri gönderilecek adres
$sendAddr = (isset($uriData[1]) && empty($uriData[1] !== true)) ? $uriData[1] : null;

// Yapılacak işlemlere göre dosyalar
$includeFile = [
    LAPI_LANGUAGE => [
        DIR_LAPI_LANGUAGE . "LanguageData.php",
        DIR_LAPI_LANGUAGE . "LanguageFunctions.php",
        DIR_LAPI_LANGUAGE . "LanguageFetch.php"
    ],
    LAPI_BACKGROUND => [
        DIR_LAPI_BACKGROUND . "BackgroundData.php",
        DIR_LAPI_BACKGROUND . "BackgroundFunctions.php",
        DIR_LAPI_BACKGROUND . "BackgroundFetch.php"
    ],
    LAPI_SESSION => [
        DIR_LAPI_SESSION . "SessionStruct.php",
        DIR_LAPI_SESSION . "SessionFunctions.php",
        DIR_LAPI_SESSION . "SessionProcess.php"
    ],
    LAPI_ICON => [
        DIR_LAPI_ICON . "IconData.php",
        DIR_LAPI_ICON . "IconFunctions.php",
        DIR_LAPI_ICON . "IconFetch.php"
    ]
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
            case (LAPI_SESSION):
                $statusImport = (bool)Lapi::FileImporter($includeFile[LAPI_SESSION]);
                break;
            case (LAPI_LANGUAGE):
                $statusImport = (bool)Lapi::FileImporter($includeFile[LAPI_LANGUAGE]);
                break;
            case (LAPI_BACKGROUND):
                $statusImport = (bool)Lapi::FileImporter($includeFile[LAPI_BACKGROUND]);
                break;
            case (LAPI_ICON):
                $statusImport = (bool)Lapi::FileImporter($includeFile[LAPI_ICON]);
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
            case (LAPI_LANGUAGE):
                $statusImport = (bool)Lapi::FileImporter($includeFile[LAPI_LANGUAGE]);
                break;
            case (LAPI_BACKGROUND):
                $statusImport = (bool)Lapi::FileImporter($includeFile[LAPI_BACKGROUND]);
                break;
            case (LAPI_ICON):
                $statusImport = (bool)Lapi::FileImporter($includeFile[LAPI_ICON]);
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