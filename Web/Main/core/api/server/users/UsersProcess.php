<?php
// Varlığı zorunlu olan şeyleri kontrol etme
// Eğer .php tarzı bir uzantı varsa
// dosyaya direk erişim yapılmaya çalışılıyor demektir
// bunu engellemeliyiz
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(Database::class) !== true):
    case ((bool)class_exists(UsersGateway::class) !== true):
    case ((bool)class_exists(UsersController::class) !== true):
    case ((bool)class_exists(UsersStruct::class) !== true):
    case ((bool)isset(UsersStruct::$param_username) !== true):
    case ((bool)isset(UsersStruct::$param_password) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Hata Kodları, Başlıkları, Mesajları
defined("ERRCODE_INVALIDUSERPROCESS") !== true ? define("ERRCODE_INVALIDUSERPROCESS", 10): null;
defined("ERRCODE_PARAMUSERNOTFOUND") !== true ? define("ERRCODE_PARAMUSERNOTFOUND", 11): null;

defined("ERROR_INVALIDUSERPROCESS") !== true ? define("ERROR_INVALIDUSERPROCESS", "Invalid User Process"): null;
defined("ERROR_PARAMUSERNOTFOUND") !== true ? define("ERROR_PARAMUSERNOTFOUND", "Param User Not Found"): null;

defined("ERRORMSG_INVALIDUSERPROCESS") !== true ? define("ERRORMSG_INVALIDUSERPROCESS", "Allow: Verify, New, Fetch"): null;
defined("ERRORMSG_PARAMUSERNOTFOUND") !== true ? define("ERRORMSG_PARAMUSERNOTFOUND", "Param User Not Found [username, password]"): null;

// Veri işlemek için parametreler
defined("PARAM_PROCESS") !== true ? define("PARAM_PROCESS", "process"): null;
defined("PARAM_USERNAME") !== true ? define("PARAM_USERNAME", "username"): null;
defined("PARAM_PASSWORD") !== true ? define("PARAM_PASSWORD", "password"): null;

// Veri işlem ön tanımlamaları
defined("USER_VERIFY") !== true ? define("USER_VERIFY", "verify"): null;
defined("USER_NEW") !== true ? define("USER_NEW", "new"): null;
defined("USER_GET") !== true ? define("USER_GET", "fetch"): null;
defined("USER_DELETE") !== true ? define("USER_DELETE", "delete"): null;

// Gönderilen verileri alma
$inputData= json_decode(file_get_contents('php://input'), true) ?? NULL;

// İşlem türü parametresi
$paramProcess = (isset($inputData[PARAM_PROCESS]) && !empty($inputData[PARAM_PROCESS])) ? ($inputData[PARAM_PROCESS]) : NULL;

// Gerekli araç bağlantıları
$databaseConnection = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWD);
$usersGateway = new UsersGateway($databaseConnection);
$usersController = new UsersController($usersGateway);

// Veri Dönüşü json Olacağı İçin Sayfa İçeriği json
header("Content-Type: application/json; charset=UTF-8");

// parametre varlık kontrol
switch(true) {
    case ((bool)isset($inputData[UsersStruct::$param_username]) !== true):
    case ((bool)isset($inputData[UsersStruct::$param_password]) !== true):
        http_response_code(412);

        echo json_encode([
            PARAM_CODE => (int)(defined(ERRCODE_PARAMUSERNOTFOUND) ? ERRCODE_PARAMUSERNOTFOUND : 11),
            PARAM_TITLE => (string)(defined(ERROR_PARAMUSERNOTFOUND) ? ERROR_PARAMUSERNOTFOUND : "Param User Not Found"),
            PARAM_MSG => (string)(defined(ERRORMSG_PARAMUSERNOTFOUND) ? ERRORMSG_PARAMUSERNOTFOUND : "Param User Not Found [username, password]")
        ], JSON_UNESCAPED_UNICODE);
        exit;
}

// İşlem türüne göre
switch($paramProcess) {
    // Kullanıcı Verilerini Doğrula
    case (USER_VERIFY):
        // alınan verilerle kullanıcı durumu kontrolü
        $userVerify = $usersController->userVerify(strval($inputData[PARAM_USERNAME]), strval($inputData[PARAM_PASSWORD]));

        // Veri doğrulama kontrol
        if((bool)isset($userVerify) !== true || (bool)$userVerify !== true) {
            $userVerify = false;
        }

        // alınan veriler ile sonuç döndürme
        echo json_encode($userVerify, JSON_UNESCAPED_UNICODE);
        exit;
    // Kullanıcı Verilerini Getir
    case (USER_GET):
        // verileri alma
        $userData = $usersController->userData(strval($inputData[PARAM_USERNAME]), strval($inputData[PARAM_PASSWORD]));

        // Veri boşluk kontrol
        if(isset($userData) !== true || empty($userData)) {
            $userData = NULL;
        }
    
        // alınan veriler ile sonuç döndürme
        echo json_encode($userData, JSON_UNESCAPED_UNICODE);
        exit;
    // Yeni Kullanıcı Oluştur
    case (USER_NEW):
        echo json_encode(["test" => "create new user"], JSON_UNESCAPED_UNICODE);
        exit;
    // Kullanıcıyı Verileri ile Birlikte Sil
    case (USER_DELETE):
        echo json_encode(["test" => "delete the user"], JSON_UNESCAPED_UNICODE);
        exit;
}

// İşlem türü yok ya da geçersiz
http_response_code(412);

echo json_encode([
    PARAM_CODE => (int)(defined("ERRCODE_INVALIDUSERPROCESS") ? ERRCODE_INVALIDUSERPROCESS : 10),
    PARAM_TITLE => (string)(defined("ERROR_INVALIDUSERPROCESS") ? ERROR_INVALIDUSERPROCESS : "Invalid User Process"),
    PARAM_MSG => (string)(defined("ERRORMSG_INVALIDUSERPROCESS") ? ERRORMSG_INVALIDUSERPROCESS : "Allow: Verify, New, Fetch")
], JSON_UNESCAPED_UNICODE);

exit;