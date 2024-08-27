<?php
// Slavnem @2024-08-03
namespace SessionApi\v1\Kernel;

// Genel Api
use SessionApi\Api as ApiGlobal;

// Gerekli Sınıflar
use SessionApi\v1\Core\Methods as Methods;
use SessionApi\v1\Core\SessionRequest as SessionRequest;

// Parametreler
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;
use SessionApi\v1\Includes\Param\UpdateSessionParams as UpdateSessionParams;

// Oturum yoksa eğer, başlatsın
if(session_status() != PHP_SESSION_ACTIVE) {
    session_start();
    session_regenerate_id();
}

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

// Post verisi, Get verisi
$PostData = (array)json_decode(file_get_contents("php://input"), true);

// Verileri Depolama
$StoreSessionData = [
    // Kullanıcı Adı
    SessionParams::getUsername() => $PostData[SessionParams::getUsername()] ?? null,
    // Ad
    SessionParams::getFirstname() => $PostData[SessionParams::getFirstname()] ?? null,
    // Soyad
    SessionParams::getLastname() => $PostData[SessionParams::getLastname()] ?? null,
    // E-posta
    SessionParams::getEmail() => $PostData[SessionParams::getEmail()] ?? null,
    // Şifre
    SessionParams::getPassword() => $PostData[SessionParams::getPassword()] ?? null,
    // Dil
    SessionParams::getLanguage() => $PostData[SessionParams::getLanguage()] ?? null,
    // Tema
    SessionParams::getTheme() => $PostData[SessionParams::getTheme()] ?? null
];

// Yeni Verileri Depolama
$StoreNewSessionData = [
    // Yeni Kullanıcı Adı
    UpdateSessionParams::getUsername() => $PostData[UpdateSessionParams::getUsername()] ?? null,
    // Yeni İsim
    UpdateSessionParams::getFirstname() => $PostData[UpdateSessionParams::getFirstname()] ?? null,
    // Yeni Soyisim
    UpdateSessionParams::getLastname() => $PostData[UpdateSessionParams::getLastname()] ?? null,
    // Yeni Email
    UpdateSessionParams::getEmail() => $PostData[UpdateSessionParams::getEmail()] ?? null,
    // Yeni Şifre
    UpdateSessionParams::getPassword() => $PostData[UpdateSessionParams::getPassword()] ?? null,
    // Yeni Üye
    UpdateSessionParams::getMember() => $PostData[UpdateSessionParams::getMember()] ?? null,
    // Yeni Dil
    UpdateSessionParams::getLanguage() => $PostData[UpdateSessionParams::getLanguage()] ?? null,
    // Yeni Doğrulama
    UpdateSessionParams::getVerify() => $PostData[UpdateSessionParams::getVerify()] ?? null,
    // Yeni Tema
    UpdateSessionParams::getTheme() => $PostData[UpdateSessionParams::getTheme()] ?? null
];

// Oturum sorguları yaptıran sınıf nesnesi
$SessionRequest = new SessionRequest();

// Sorgu yaptırma
$ResultRequest = $SessionRequest->Request(
    $RequestMethod,
    $StoreSessionData,
    $StoreNewSessionData
);

// Sonucu Json objesi olarak döndür
die(json_encode($ResultRequest, JSON_UNESCAPED_UNICODE));