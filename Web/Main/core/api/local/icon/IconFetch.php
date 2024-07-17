<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(IconFunctions::class) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Parametreler
defined("PARAM_ICON") !== true ? define("PARAM_ICON", "icon"): null;

// JSON
header("Content-Type: application/json; charset=UTF-8");

// URL
$url = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

// URL PARTS
$uriData = explode("/", $url);

// METHOD JSON DATA
$inputData = json_decode(file_get_contents('php://input'), true);

// Yönlendirilmek istenen kısım
$redirectUrl = array_slice($uriData, 2, 1);

// Değerleri al
$valueIcon = isset($redirectUrl[0]) ?
    (string)$redirectUrl[0] : null;

// Url verisi boş
// Değerleri JSON verisi olarak al
switch(isset($valueIcon) !== true || empty($valueIcon)) {
    case true:
        $valueIcon = (isset($inputData[PARAM_ICON])) ?
            (string)$inputData[PARAM_ICON] : "";
        break;
}

// Döndürülecek veri
$storeData = null;

// ICON
switch(true) {
    case (isset($valueIcon) && empty($valueIcon) !== true):
        $storeData = (string)IconFunctions::GetIcon($valueIcon);
        break;
    default:
        $storeData = (array)IconFunctions::GetIcon();
}

// Verinin için boş ise null yap
$storeData = (isset($storeData) && empty($storeData) !== null) ?
    ($storeData) : (null);

// Veriyi json objesi olarak döndür
echo json_encode($storeData, JSON_UNESCAPED_UNICODE);
exit;