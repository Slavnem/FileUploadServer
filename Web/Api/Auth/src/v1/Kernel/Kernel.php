<?php
// Slavnem @2024-07-06
namespace AuthApi\v1\Kernel;

// Genel Sınıflar
use AuthApi\Api as ApiGlobal;

// Gerekli Sınıflar
use AuthApi\v1\Core\AuthMethods as Methods;
use AuthApi\v1\Core\AuthRequest as AuthRequest;

// Veritabanı
use AuthApi\v1\Includes\Database\Param\AuthParams as AuthParams;
use AuthApi\v1\Includes\Database\Param\UpdateAuthParams as UpdateAuthParams;

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

// Verileri Depolama
$StoreAuthData = [
    // Kullanıcı Adı
    AuthParams::getUsername() => $PostData[AuthParams::getUsername()] ?? null,
    // Ad
    AuthParams::getFirstname() => $PostData[AuthParams::getFirstname()] ?? null,
    // Soyad
    AuthParams::getLastname() => $PostData[AuthParams::getLastname()] ?? null,
    // E-posta
    AuthParams::getEmail() => $PostData[AuthParams::getEmail()] ?? null,
    // Şifre
    AuthParams::getPassword() => $PostData[AuthParams::getPassword()] ?? null,
    // Dil
    AuthParams::getLanguage() => $PostData[AuthParams::getLanguage()] ?? null,
    // Tema
    AuthParams::getTheme() => $PostData[AuthParams::getTheme()] ?? null
];

// Yeni Verileri Depolama
$StoreNewAuthData = [
    // Yeni Kullanıcı Adı
    UpdateAuthParams::getUsername() => $PostData[UpdateAuthParams::getUsername()] ?? null,
    // Yeni İsim
    UpdateAuthParams::getFirstname() => $PostData[UpdateAuthParams::getFirstname()] ?? null,
    // Yeni Soyisim
    UpdateAuthParams::getLastname() => $PostData[UpdateAuthParams::getLastname()] ?? null,
    // Yeni Email
    UpdateAuthParams::getEmail() => $PostData[UpdateAuthParams::getEmail()] ?? null,
    // Yeni Şifre
    UpdateAuthParams::getPassword() => $PostData[UpdateAuthParams::getPassword()] ?? null,
    // Yeni Üye
    UpdateAuthParams::getMember() => $PostData[UpdateAuthParams::getMember()] ?? null,
    // Yeni Dil
    UpdateAuthParams::getLanguage() => $PostData[UpdateAuthParams::getLanguage()] ?? null,
    // Yeni Doğrulama
    UpdateAuthParams::getVerify() => $PostData[UpdateAuthParams::getVerify()] ?? null,
    // Yeni Tema
    UpdateAuthParams::getTheme() => $PostData[UpdateAuthParams::getTheme()] ?? null
];

// kullanıcı sorguları yaptıran sınıf nesnesi
$AuthRequest = new AuthRequest();

// Sorgu yaptırma
$ResultRequest = $AuthRequest->Request(
    $RequestMethod,
    $StoreAuthData,
    $StoreNewAuthData
);

// Sonucu Json objesi olarak döndür
die(json_encode($ResultRequest, JSON_UNESCAPED_UNICODE));