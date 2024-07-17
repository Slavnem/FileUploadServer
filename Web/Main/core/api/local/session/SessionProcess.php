<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)(strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php")))):
    case ((bool)(class_exists(SessionStruct::class)) !== true):
    case ((bool)(class_exists(SessionFunctions::class)) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Hata Kodları, Başlıkları, Mesajları
defined("ERRCODE_SESSIONCANNOTCREATE") !== true ? define("ERRCODE_SESSIONCANNOTCREATE", -1) : null;
defined("ERRCODE_INVALIDSESSIONPROCESS") !== true ? define("ERRCODE_INVALIDSESSIONPROCESS", 10) : null;
defined("ERRCODE_PARAMUSERNOTFOUND") !== true ? define("ERRCODE_PARAMUSERNOTFOUND", 11): null;
defined("ERRORCODE_SESSIONNOTAVAILABLE") !== true ? define("ERRORCODE_SESSIONNOTAVAILABLE", 12): null;
defined("ERRORCODE_SESSIONNOTUPDATEABLE") !== true ? define("ERRORCODE_SESSIONNOTUPDATEABLE", 13): null;

defined("ERROR_SESSIONCANNOTCREATE") !== true ? define("ERROR_SESSIONCANNOTCREATE", "Session Error") : null;
defined("ERROR_INVALIDSESSIONPROCESS") !== true ? define("ERROR_INVALIDSESSIONPROCESS", "Invalid Session Process"): null;
defined("ERROR_PARAMUSERNOTFOUND") !== true ? define("ERROR_PARAMUSERNOTFOUND", "Param User Not Found"): null;
defined("ERROR_SESSIONNOTAVAILABLE") !== true ? define("ERROR_SESSIONNOTAVAILABLE", "Session Not Available"): null;
defined("ERROR_SESSIONNOTUPDATEABLE") !== true ? define("ERROR_SESSIONNOTUPDATEABLE", "Session Auto Update Error"): null;

defined("ERRORMSG_SESSIONCANNOTCREATE") !== true ? define("ERRORMSG_SESSIONCANNOTCREATE", "Cannot Create Session") : null;
defined("ERRORMSG_INVALIDSESSIONPROCESS") !== true ?define("ERRORMSG_INVALIDSESSIONPROCESS", "Allow: Verify, Update, New, Data, Admin"): null;
defined("ERRORMSG_PARAMUSERNOTFOUND") !== true ? define("ERRORMSG_PARAMUSERNOTFOUND", "Param User Not Found [process, username, password]"): null;
defined("ERRORMSG_SESSIONNOTAVAILABLE") !== true ? define("ERRORMSG_SESSIONNOTAVAILABLE", "Session Not Available And Cannot Create New Session"): null;
defined("ERRORMSG_SESSIONNOTUPDATEABLE") !== true ? define("ERRORMSG_SESSIONNOTUPDATEABLE", "Session Not Updateable"): null;

// Veri işlemek için parametreler
defined("PARAM_ROUTE") !== true ? define("PARAM_ROUTE", "route"): null;
defined("PARAM_PROCESS") !== true ? define("PARAM_PROCESS", "process"): null;
defined("PARAM_USERNAME") !== true ? define("PARAM_USERNAME", "username"): null;
defined("PARAM_PASSWORD") !== true ? define("PARAM_PASSWORD", "password"): null;

// Parametre isimlerine ait değerler
defined("ROUTE_SESSION") !== true ? define("ROUTE_SESSION", "session"): null;

// Veri işlem ön tanımlamaları
defined("SESSION_VERIFY") !== true ? define("SESSION_VERIFY", "verify"): null;
defined("SESSION_UPDATE") !== true ? define("SESSION_UPDATE", "update"): null;
defined("SESSION_NEW") !== true ? define("SESSION_NEW", "new"): null;
defined("SESSION_DESTROY") !== true ? define("SESSION_DESTROY", "destroy"): null;
defined("SESSION_GET") !== true ? define("SESSION_GET", "fetch"): null;
defined("SESSION_ADMIN") !== true ? define("SESSION_ADMIN", "admin"): null;
defined("SESSION_MODERATOR") !== true ? define("SESSION_MODERATOR", "moderator"): null;

// URL
$url = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

// URL PARTS
$uriData = explode("/", $url);

// Yönlendirilmek istenen kısım
$redirectUrl = array_slice($uriData, 2, 2);

// post verileri alma
$inputData = json_decode(file_get_contents('php://input'), true);

// İşlem türünü al
switch($_SERVER['REQUEST_METHOD']) {
    case (METHOD_SECURE):
        $process = isset($inputData[PARAM_PROCESS]) ?
            (string)$inputData[PARAM_PROCESS] : null;
        break;
    default:
        $process = isset($redirectUrl[0]) ?
            (string)$redirectUrl[0] : null;
}

// Oturum varlığı kontrolü
switch((bool)SessionFunctions::SessionAvailable() !== true) {
    case true:
        // Oturum zorla yoketsin ve yenisii oluştursun
        $preprocSessionDestroy = (bool)SessionFunctions::SessionDestroy(true);
        $preprocSessionNew = (bool)SessionFunctions::SessionNew();

        // Yeni oturum oluşturma başarısız ise eğer
        // geliştirici hata bilgilendirme sayfasına yönlendirsin
        switch(true) {
            case ($preprocSessionDestroy === true && $preprocSessionNew !== true):
            case ($preprocSessionNew !== true):
                // hata iletisi
                $sendError =
                    ("code=" . ERRORCODE_SESSIONNOTAVAILABLE) .
                    ("&title=" . ERROR_SESSIONNOTAVAILABLE) .
                    ("&message=" . ERRORMSG_SESSIONNOTAVAILABLE);

                http_response_code(900); // geliştirici kodu
                header("Location: /error/contact-to-developer?$sendError"); // geliştirici hata sayfası
                echo json_encode(null, JSON_UNESCAPED_UNICODE);
                exit; // sonlandırma
        }

        // Çekirdek oturum müdahelesi olan değişkenlerı kaldır
        unset($preprocSessionDestroy);
        unset($preprocSessionNew);
}

// İşlem türüne göre
switch($process) {
    case (SESSION_VERIFY):
        // parametre varlık kontrol
        switch(true) {
            case (isset($inputData[SessionStruct::$param_process]) !== true && empty($inputData[SessionStruct::$param_process])):
            case (isset($inputData[SessionStruct::$param_username]) !== true && empty($inputData[SessionStruct::$param_username])):
            case (isset($inputData[SessionStruct::$param_password]) !== true && empty($inputData[SessionStruct::$param_password])):
                echo json_encode([
                    PARAM_CODE => (int)(defined(ERRCODE_PARAMUSERNOTFOUND) ? ERRCODE_PARAMUSERNOTFOUND : 11),
                    PARAM_TITLE => (string)(defined(ERROR_PARAMUSERNOTFOUND) ? ERROR_PARAMUSERNOTFOUND : "Param User Not Found"),
                    PARAM_MSG => (string)(defined(ERRORMSG_PARAMUSERNOTFOUND) ? ERRORMSG_PARAMUSERNOTFOUND : "Param User Not Found [process, username, password]")
                ], JSON_UNESCAPED_UNICODE);
                exit;
        }

        // parametreler
        $verifyParams = [
            SessionStruct::$session_username => (string)$inputData[SessionStruct::$param_username],
            SessionStruct::$session_password => (string)$inputData[SessionStruct::$param_password]
        ];

        // alınan veriler ile sonuç döndürme
        echo json_encode(SessionFunctions::SessionVerify($verifyParams), JSON_UNESCAPED_UNICODE);
        exit;
    case (SESSION_UPDATE):
        // parametre varlık kontrol
        switch(true) {
            case (isset($inputData[SessionStruct::$param_process]) !== true && empty($inputData[SessionStruct::$param_process])):
            case (isset($inputData[SessionStruct::$param_username]) !== true && empty($inputData[SessionStruct::$param_username])):
            case (isset($inputData[SessionStruct::$param_password]) !== true && empty($inputData[SessionStruct::$param_password])):
                echo json_encode([
                    PARAM_CODE => (int)(defined(ERRCODE_PARAMUSERNOTFOUND) ? ERRCODE_PARAMUSERNOTFOUND : 11),
                    PARAM_TITLE => (string)(defined(ERROR_PARAMUSERNOTFOUND) ? ERROR_PARAMUSERNOTFOUND : "Param User Not Found"),
                    PARAM_MSG => (string)(defined(ERRORMSG_PARAMUSERNOTFOUND) ? ERRORMSG_PARAMUSERNOTFOUND : "Param User Not Found [process, username, password]")
                ], JSON_UNESCAPED_UNICODE);
                exit;
        }

        // parametreler
        $updateParams = [
            SessionStruct::$session_username => (string)$inputData[SessionStruct::$param_username],
            SessionStruct::$session_password => (string)$inputData[SessionStruct::$param_password]
        ];

        // Oturum güncellemesine ait veriyi döndürme
        echo json_encode(SessionFunctions::SessionUpdate($updateParams), JSON_UNESCAPED_UNICODE);
        exit;
    case (SESSION_DESTROY):
        echo json_encode(SessionFunctions::SessionDestroy(true), JSON_UNESCAPED_UNICODE);
    case (SESSION_NEW):
        // alınan veriler ile sonuç döndürme
        echo json_encode(SessionFunctions::SessionNew(), JSON_UNESCAPED_UNICODE);
        exit;
    case (SESSION_GET):
        // alınan veriler ile sonuç döndürme
        echo json_encode(SessionFunctions::SessionFetch(), JSON_UNESCAPED_UNICODE);
        exit;
    case (SESSION_ADMIN):
        echo json_encode(SessionFunctions::SessionAdmin(), JSON_UNESCAPED_UNICODE);
        exit;
    case (SESSION_MODERATOR):
        echo json_encode(SessionFunctions::SessionModerator(), JSON_UNESCAPED_UNICODE);
        exit;
}

// İşlem türü yok ya da geçersiz
http_response_code(412);

echo json_encode([
    PARAM_CODE => (int)(defined("ERRCODE_INVALIDSESSIONPROCESS") ? ERRCODE_INVALIDSESSIONPROCESS : 10),
    PARAM_TITLE => (string)(defined("ERROR_INVALIDSESSIONPROCESS") ? ERROR_INVALIDSESSIONPROCESS : "Invalid Session Process"),
    PARAM_MSG => (string)(defined("ERRORMSG_INVALIDSESSIONPROCESS") ? ERRORMSG_INVALIDSESSIONPROCESS : "Allow: Verify, Update, New, Fetch, Admin")
], JSON_UNESCAPED_UNICODE);

exit;