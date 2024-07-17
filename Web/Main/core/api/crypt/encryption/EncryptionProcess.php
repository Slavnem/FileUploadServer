<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(EncryptionKeys::class) !== true):
    case ((bool)class_exists(EncryptionFunctions::class) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Parametreler
defined("PARAM_ALGORITHM") !== true ? define("PARAM_ALGORITHM", "algorithm"): null;
defined("PARAM_BASETEXT") !== true ? define("PARAM_BASETEXT", "basetext"): null;
defined("PARAM_ENCRYPTED") !== true ? define("PARAM_ENCRYPTED", "encrypted"): null;
defined("PARAM_PROCESS") !== true ? define("PARAM_PROCESS", "process"): null;

// İşlem Türleri
defined("PROC_CRYPT_VERIFY") !== true ? define("PROC_CRYPT_VERIFY", "verify"): null;
defined("PROC_CRYPT_CREATE") !== true ? define("PROC_CRYPT_CREATE", "create"): null;
defined("PROC_CRYPT_FETCHALGOS") !== true ? define("PROC_CRYPT_FETCHALGOS", "fetchalgos"): null;
defined("PROC_CRYPT_FETCHPROCS") !== true ? define("PROC_CRYPT_FETCHPROCS", "fetchprocs"): null;

// JSON
header("Content-Type: application/json; charset=UTF-8");

// URL
$url = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

// URL PARTS
$uriData = explode("/", $url);

// METHOD JSON DATA
$inputData = json_decode(file_get_contents('php://input'), true);

// Yönlendirilmek istenen kısım
$redirectUrl = array_slice($uriData, 2, 4);

/* 
// GÜVENLİK AMAÇLI DEVRE DIŞI
// DISABLED FOR SECURITY

// Değerleri al
$valueCryptAlgo = isset($redirectUrl[0]) ?
    (string)$redirectUrl[0] : "";

$valueBasetext = isset($redirectUrl[1]) ?
    (string)$redirectUrl[1] :"";

$valueEncrypted = isset($redirectUrl[2]) ?
    (string)$redirectUrl[2] :"";

$valueProcess = isset($redirectUrl[3]) ?
    (string)$redirectUrl[3] :"";
*/

// Değerleri JSON verisi olarak al
switch(true) {
    case (isset($valueCryptAlgo) !== true || empty($valueCryptAlgo)):
        $valueCryptAlgo = (isset($inputData[PARAM_ALGORITHM])) ?
            (string)$inputData[PARAM_ALGORITHM] : "";

    case (isset($valueBasetext) !== true || empty($valueBasetext)):
        $valueBasetext = (isset($inputData[PARAM_BASETEXT])) ?
            (string)$inputData[PARAM_BASETEXT] : "";

    case (isset($valueEncrypted) !== true || empty($valueEncrypted)):
        $valueEncrypted = (isset($inputData[PARAM_ENCRYPTED])) ?
            (string)$inputData[PARAM_ENCRYPTED] : "";

    case (isset($valueProcess) !== true || empty($valueProcess)):
        $valueProcess = (isset($inputData[PARAM_PROCESS])) ?
            (string)$inputData[PARAM_PROCESS] : "";
}

// Depolanan veri
$storeData = null;

// İşlem türüne göre işlem yapılacak
switch($valueProcess) {
    // yeni şifreleme oluşturma
    case PROC_CRYPT_CREATE:
        $storeData = EncryptionFunctions::EncryptAlgo($valueCryptAlgo, $valueBasetext);

        /*
        // DEBUG
        $storeData = [
            "process" => PROC_CRYPT_CREATE,
            "algorithm" => $valueCryptAlgo,
            "basetext" => $valueBasetext,
            "encrypted" => $storeData
        ];
        */
        
        break;
    // basit metin ile şifrelenmiş metini karşılaştırma ve doğrulama
    case PROC_CRYPT_VERIFY:
        $storeData = EncryptionFunctions::EncryptVerify($valueCryptAlgo, $valueBasetext, $valueEncrypted);

        /*
        // DEBUG
        $storeData = [
            "process" => PROC_CRYPT_VERIFY,
            "algorithm" => $valueCryptAlgo,
            "basetext" => $valueBasetext,
            "encrypted" => $valueEncrypted,
            "verify" => ($storeData)
        ];
        */
        break;
    // algoritma türlerini alma
    case PROC_CRYPT_FETCHALGOS:
        switch(true) {
            case ((int)$valueCryptAlgo > 0):
                $storeData = EncryptionFunctions::EncryptKeyFetch((int)$valueCryptAlgo);
                break;
            case (strlen((string)$valueCryptAlgo) > 0):
                $storeData = EncryptionFunctions::EncryptKeyFetch((string)$valueCryptAlgo);
                break;
            default:
                $storeData = EncryptionFunctions::EncryptKeyFetch();
        }
        break;
    // işlem türlerini alma
    case PROC_CRYPT_FETCHPROCS:
        $storeData = [
            PROC_CRYPT_CREATE,
            PROC_CRYPT_VERIFY
        ];
        break;
}

// Veriyi json objesi olarak döndür
echo json_encode($storeData, JSON_UNESCAPED_UNICODE);
exit;