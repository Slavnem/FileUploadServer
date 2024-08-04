<?php
// Slavnem @2024-07-06
namespace FileApi\v1\Kernel;

// Gerekli Sınıflar
use FileApi\v1\Core\Methods as Methods;
use FileApi\v1\Core\FileOperations as FileOperations;

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

// Post verisi, Get verisi
$PostData = (array)json_decode(file_get_contents("php://input"), true);

// Dosya sorguları yaptıran sınıf nesnesi
$FileOperations = new FileOperations();

// Sorgu yaptırma
$ResultRequest = $FileRequest->Request(
    $RequestMethod,
    $_FILES,
    NULL
);

// Sonucu Json objesi olarak döndür
die(json_encode($ResultRequest, JSON_UNESCAPED_UNICODE));