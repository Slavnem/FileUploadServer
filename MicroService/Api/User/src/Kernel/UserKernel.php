<?php
// Slavnem @2024-07-06
namespace AuthApi\Kernel;

// Gerekli Sınıflar
use UserApi\Core\User\v1\Methods as Methods;
use UserApi\Core\User\v1\UserRequest as UserRequest;
use UserApi\Includes\Database\v1\Param\UserParams as UserParams;
use UserApi\Includes\Database\v1\Param\UpdateUserParams as UpdateUserParams;

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

// Verileri Depolama
$StoreUserData = [
    // Kullanıcı Adı
    UserParams::getUsername() => $PostData[UserParams::getUsername()] ?? null,
    // Ad
    UserParams::getFirstname() => $PostData[UserParams::getFirstname()] ?? null,
    // Soyad
    UserParams::getLastname() => $PostData[UserParams::getLastname()] ?? null,
    // E-posta
    UserParams::getEmail() => $PostData[UserParams::getEmail()] ?? null,
    // Şifre
    UserParams::getPassword() => $PostData[UserParams::getPassword()] ?? null,
    // Dil
    UserParams::getLanguage() => $PostData[UserParams::getLanguage()] ?? null,
    // Tema
    UserParams::getTheme() => $PostData[UserParams::getTheme()] ?? null
];

// Yeni Verileri Depolama
$StoreNewUserData = [
    // Yeni Kullanıcı Adı
    UpdateUserParams::getUsername() => $PostData[UpdateUserParams::getUsername()] ?? null,
    // Yeni İsim
    UpdateUserParams::getFirstname() => $PostData[UpdateUserParams::getFirstname()] ?? null,
    // Yeni Soyisim
    UpdateUserParams::getLastname() => $PostData[UpdateUserParams::getLastname()] ?? null,
    // Yeni Email
    UpdateUserParams::getEmail() => $PostData[UpdateUserParams::getEmail()] ?? null,
    // Yeni Şifre
    UpdateUserParams::getPassword() => $PostData[UpdateUserParams::getPassword()] ?? null,
    // Yeni Üye
    UpdateUserParams::getMember() => $PostData[UpdateUserParams::getMember()] ?? null,
    // Yeni Dil
    UserParams::getLanguage() => $PostData[UserParams::getLanguage()] ?? null,
    // Yeni Doğrulama
    UserParams::getVerify() => $PostData[UserParams::getVerify()] ?? null,
    // Yeni Tema
    UpdateUserParams::getTheme() => $PostData[UpdateUserParams::getTheme()] ?? null
];

// kullanıcı sorguları yaptıran sınıf nesnesi
$UserRequest = new UserRequest();

// Sorgu yaptırma
$ResultRequest = $UserRequest->Request(
    $RequestMethod,
    $StoreUserData,
    $StoreNewUserData
);

// Sonucu Json objesi olarak döndür
die(json_encode($ResultRequest, JSON_UNESCAPED_UNICODE));