<?php
// Slavnem @2024-07-06
namespace FileApi\v1\Kernel;

// Genel Api
use FileApi\Api as ApiGlobal;

// Gerekli Sınıflar
use FileApi\v1\Core\Methods as Methods;
use FileApi\v1\Core\FileOperations as FileRequest;
use FileApi\v1\Includes\Param\FileParams as FileParams;

// Oturum Sınıflar
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Core\SessionRequest as SessionRequest;
use SessionApi\v1\Core\SessionErrors as SessionError;

// Sayfa Json objesi döndürecek
header("Content-Type: application/json; charset=UTF-8");

// Methods
$Methods = Methods::getAll();

// methodları büyük harfe çevirsin
for($countMethods = 0; $countMethods < count($Methods); $countMethods++)
{
    $Methods[$countMethods] = strtoupper($Methods[$countMethods]);
}

// Methodları birleştirsin
$StrMethods = null;

for($StrMethods = strtoupper($Methods[0]), $methodcount = 1; $methodcount < count($Methods); $methodcount++) {
    $StrMethods .= ", " . strtoupper($Methods[$methodcount]);
}

// Uri
$RequestUri = substr(strtolower($_SERVER['REQUEST_URI']), 1);

// Method
$RequestMethod = strtoupper($_SERVER['REQUEST_METHOD']);

// Geçersiz method denenmişse hata çıktısı ver
if(!in_array($RequestMethod, $Methods)) {
    http_response_code(405); // http hata kodu
    die(json_encode(ApiGlobal::ReturnForJSON(
        ApiGlobal::__JSON_TYPE_VAL_ERR__,
        ApiGlobal::__JSON_CODE_VAL_ERR__,
        $StrMethods
    ), JSON_UNESCAPED_UNICODE)); // bildiri
}

// Oturum sorgu
$SessionRequest = new SessionRequest();

// Oturum yoksa işlem yapılmasın
if(empty($SessionRequest->Request(
    SessionMethods::getFetch(),
    NULL,
    NULL))
)
{
    // kullanıcıya ait oturum yok
    die(json_encode(ApiGlobal::ReturnForJSON(
        ApiGlobal::__JSON_TYPE_VAL_ERR__,
        ApiGlobal::__JSON_CODE_VAL_ERR__,
        "Session User ID Not Found"
    ), JSON_UNESCAPED_UNICODE));
}

// Post verisi, Get verisi
$PostData = (array)json_decode(file_get_contents("php://input"), true);

// Gelen verileri depolama
$StoreData = $PostData[FileParams::getFilename()] ?? null;

// Dosya sorguları yaptıran sınıf nesnesi
$FileRequest = new FileRequest();

// Türüne göre sorgu yaptırma
switch($RequestMethod)
{
    // dosya yükleme
    case Methods::getUpload():
    case Methods::getPost():
        $StoreData = $_FILES["files"] ?? NULL;
    break;
}

// Sorgu yapsın
$ResultRequest = $FileRequest->Request(
    $RequestMethod,
    (array)$StoreData ?? NULL,
    NULL
);

// boşsa null yapsın
if(empty($ResultRequest)) $ResultRequest = null;

// Sonucu Json objesi olarak döndür
die(json_encode($ResultRequest, JSON_UNESCAPED_UNICODE));