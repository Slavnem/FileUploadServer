<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(BackgroundFunctions::class) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Parametreler
defined("PARAM_PAGE") !== true ? define("PARAM_PAGE", "page"): null;
defined("PARAM_NUM") !== true ? define("PARAM_NUM", "num"): null;

// JSON
header("Content-Type: application/json; charset=UTF-8");

// URL
$url = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

// URL PARTS
$uriData = explode("/", $url);

// METHOD JSON DATA
$inputData = json_decode(file_get_contents('php://input'), true);

// Yönlendirilmek istenen kısım
$redirectUrl = array_slice($uriData, 2, 2);

// Değerleri al
$valuePage = isset($redirectUrl[0]) ?
    (string)$redirectUrl[0] : "";

$valueNum = isset($redirectUrl[1]) ?
    (int)$redirectUrl[1] : 0;

// Url verisi boş
// Değerleri JSON verisi olarak al
switch(true) {
    case (isset($valuePage) !== true || empty($valuePage)):
        $valuePage = (isset($inputData[PARAM_PAGE])) ?
            (string)$inputData[PARAM_PAGE] : "";

    case (isset($valueNum) !== true || empty($valueNum)):
        $valueNum = (isset($inputData[PARAM_NUM])) ?
            (int)$inputData[PARAM_NUM] : 0;
}

// Depolanan veri
$storeData = null;

// Duruma göre
switch(true) {
    case (isset($valuePage) && isset($valueNum)):
        $storeData = BackgroundFunctions::getBackground((string)$valuePage, (string)$valueNum);
    break;
    default:
        $storeData = BackgroundFunctions::getBackground();
    break;
}

// Veriyi json objesi olarak döndür
echo json_encode($storeData, JSON_UNESCAPED_UNICODE);
exit;