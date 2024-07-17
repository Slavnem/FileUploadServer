<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(LanguageFunctions::class) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Parametreler
defined("LANGUAGE_BASIC") !== true ? define("LANGUAGE_BASIC", "basic"): null;
defined("LANGUAGE_DETAILED") !== true ? define("LANGUAGE_DETAILED", "large"): null;

defined("PARAM_TYPE") !== true ? define("PARAM_TYPE", "type"): null;
defined("PARAM_LANGUAGE") !== true ? define("PARAM_LANGUAGE", "language"): null;
defined("PARAM_PART") !== true ? define("PARAM_PART", "part"): null;
defined("PARAM_KEY") !== true ? define("PARAM_KEY", "key"): null;
defined("PARAM_SIMPLIFY") !== true ? define("PARAM_SIMPLIFY", "simplify"): null;

// JSON
header("Content-Type: application/json; charset=UTF-8");

// URL
$url = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

// URL PARTS
$urlArr = explode("/", $url);

// METHOD JSON DATA
$inputData = json_decode(file_get_contents('php://input'), true);

// Yönlendirilmek istenen kısım
$redirectUrl = array_slice($urlArr, 2, 5);

// Değerleri url'den almak
$typeid = (isset($redirectUrl[0]) && empty($redirectUrl[0]) !== true) ?
    (string)urldecode($redirectUrl[0]) : ""; // basic - detailed

$languageid = (isset($redirectUrl[1]) && empty($redirectUrl[1]) !== true) ?
    (string)urldecode($redirectUrl[1]) : ""; // dil bilgisi (en, ru, tr)

$partid = (isset($redirectUrl[2]) && empty($redirectUrl[2]) !== true) ?
    (string)urldecode($redirectUrl[2]) : ""; // parça bilgisi (auth, global)

$keyid = (isset($redirectUrl[3]) && empty($redirectUrl[3]) !== true) ?
    (string)urldecode($redirectUrl[3]) : ""; // anahtar bilgisi (login_title, btn_text)

$simplify = (isset($redirectUrl[4]) && empty($redirectUrl[4]) !== true) ?
    (bool)urldecode($redirectUrl[4]) : false;

// veri çekme türü boş ise eğer
// method ile gönderilen verileri almak
switch(true) {
    case (isset($typeid) !== true || empty($typeid)):
        $typeid = (string)(isset($inputData[PARAM_TYPE]) && empty($inputData[PARAM_TYPE]) !== true) ?
            $inputData[PARAM_TYPE] : LANGUAGE_BASIC;

    case (isset($languageid) !== true || empty($languageid)):
        $languageid = (string)(isset($inputData[PARAM_LANGUAGE]) && empty($inputData[PARAM_LANGUAGE]) !== true) ?
            $inputData[PARAM_LANGUAGE] : "";

    case (isset($partid) !== true || empty($partid)):
        $partid = (string)(isset($inputData[PARAM_PART]) && empty($inputData[PARAM_PART]) !== true) ?
            $inputData[PARAM_PART] : "";

    case (isset($keyid) !== true || empty($keyid)):
        $keyid = (string)(isset($inputData[PARAM_KEY]) && empty($inputData[PARAM_KEY]) !== true) ?
            $inputData[PARAM_KEY] : "";

    case (isset($simplify) !== true || empty($simplify)):
        $simplify = (bool)(isset($inputData[PARAM_SIMPLIFY]) && empty($inputData[PARAM_SIMPLIFY]) !== true) ?
            (bool)$inputData[PARAM_SIMPLIFY] : false;
}

// Depolanan veri
$storeData = null;

// Sınıf fonksiyonunu kullanarak veriyi getirmek
switch($typeid) {
    case (LANGUAGE_BASIC):
        $storeData = LanguageFunctions::GetBasicLanguage($languageid, $partid, $keyid, $simplify);
        break;
    case (LANGUAGE_DETAILED):
        $storeData = LanguageFunctions::GetDetailedLanguage($languageid, $partid, $keyid, $simplify);
        break;
}

// Veriyi json objesi olarak döndür
echo json_encode($storeData, JSON_UNESCAPED_UNICODE);
exit;