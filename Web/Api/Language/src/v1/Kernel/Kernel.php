<?php
// Slavnem @2024-09-20
namespace LanguageApi\v1\Kernel;

// Genel Api
use LanguageApi\Api as ApiGlobal;

// Gerekli Sınıflar
use LanguageApi\v1\Core\LanguageMethods as Methods;
use LanguageApi\v1\Core\LanguageRequest;
use LanguageApi\v1\Includes\Params as LanguageParams;

// Methods
$AllMethods = Methods::getAll();

// methodları büyük harfe çevirsin
for($countMethods = 0; $countMethods < count($AllMethods); $countMethods++)
    $AllMethods[$countMethods] = strtoupper($AllMethods[$countMethods]);

// Methodları birleştirsin
$StrMethods = null;

for($StrMethods = strtoupper($AllMethods[0]), $methodcount = 1; $methodcount < count($AllMethods); $methodcount++)
    $StrMethods .= ", " . strtoupper($AllMethods[$methodcount]);

// Uri
$RequestUri = substr(strtolower($_SERVER['REQUEST_URI']), 1);

// Method
$RequestMethod = strtoupper($_SERVER['REQUEST_METHOD']);

// Geçersiz method denenmişse hata çıktısı ver
if(!in_array($RequestMethod, $AllMethods)) {
    http_response_code(405); // http hata kodu
    die(json_encode(ApiGlobal::ReturnForJSON(
        ApiGlobal::__JSON_TYPE_VAL_ERR__,
        ApiGlobal::__JSON_CODE_VAL_ERR__,
        $StrMethods
    ), JSON_UNESCAPED_UNICODE)); // bildiri
}

// Post verisi, Get verisi
$PostData = (array)json_decode(file_get_contents("php://input"), true);

// Metoda göre
switch(strtoupper($RequestMethod))
{
    // GET
    case strtoupper(Methods::getGet()):
        // Verileri Depolama
        $StoreLanguageData = [
            // Dil
            LanguageParams::getLanguage() => $_GET[LanguageParams::getLanguage()] ?? null,
            // Sayfa
            LanguageParams::getPage() => $_GET[LanguageParams::getPage()] ?? null
        ];
    break;
    // FETCH
    case strtoupper(Methods::getFetch()):
        // Verileri Depolama
        $StoreLanguageData = [
            // Dil
            LanguageParams::getLanguage() => $PostData[LanguageParams::getLanguage()] ?? null,
            // Sayfa
            LanguageParams::getPage() => $PostData[LanguageParams::getPage()] ?? null
        ];
}

// kullanıcı sorguları yaptıran sınıf nesnesi
$LanguageRequest = new LanguageRequest();

// Sorgu yaptırma
$ResultRequest = $LanguageRequest->Request(
    $RequestMethod,
    $StoreLanguageData
);

// Sonucu Json objesi olarak döndür
die(json_encode($ResultRequest, JSON_UNESCAPED_UNICODE));