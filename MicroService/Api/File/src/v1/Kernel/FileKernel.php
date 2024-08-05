<?php
// Slavnem @2024-07-06
namespace FileApi\v1\Kernel;

// Gerekli Sınıflar
use FileApi\v1\Core\Methods as Methods;
use FileApi\v1\Core\FileOperations as FileRequest;
use FileApi\v1\Includes\Param\FileParams as FileParams;

// Oturum Sınıflar
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Core\SessionRequest as SessionRequest;
use SessionApi\v1\Core\SessionError as SessionError;

// Geçerli saat dilimi
date_default_timezone_set('Europe/Istanbul'); // Türkiye saati

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
    header("Allow: $StrMethods"); // http bildiri mesaj
    exit;
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
    die(json_encode(SessionError::getAutoErrorSessionUserIdNotFound(), JSON_UNESCAPED_UNICODE));
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
        $ResultRequest = $FileRequest->Request(
            $RequestMethod,
            $_FILES,
            NULL
        );
    break;
    // diğer
    default:
        $ResultRequest = $FileRequest->Request(
            $RequestMethod,
            !empty($StoreData) ? (array)$StoreData : NULL,
            NULL
        );
}

// boşsa null yapsın
if(empty($ResultRequest)) $ResultRequest = null;

// Sonucu Json objesi olarak döndür
die(json_encode($ResultRequest, JSON_UNESCAPED_UNICODE));