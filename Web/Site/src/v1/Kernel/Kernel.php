<?php
// Slavnem @2024-08-03
namespace Site\Src\v1\Kernel;

// Sabit Değerler
const __PAGE_AUTH_LOGIN__ = "auth/login";
const __PAGE_AUTH_LOGOUT__ = "auth/logout";
const __PAGE_FILES__ = "files";

// Genel İşlem Sınıfı
use Site\Public\IndexGlobal as IndexGlobal;

// Oturum Bilgileri
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Core\SessionRequest as SessionRequest;

use const Site\Public\__SRC_DIR__;

// Sayfa Url kontrolü
$UrlAddr = $_SERVER['REQUEST_URI'];
$UrlAddr = substr($UrlAddr, 1, strlen($UrlAddr) - 1);

// oturum sorgu nesnesi
$SessionRequest = new SessionRequest();

// eğer oturum yoksa giriş sayfasına yönlendirsin
// ve oturum verisi boş değilse eğer, hata mesajları var demektir
// boşsa eğer, oturum zaten var demektir

// oturum yok
if(!$SessionRequest->isSession() && // oturum yoksa
    strcmp(strtolower($UrlAddr), strtolower(__PAGE_AUTH_LOGIN__)) != 0 // url de eşleşmiyorsa
)
{
    header("Location: /" . __PAGE_AUTH_LOGIN__); // giriş sayfası
    exit();
}

// İşlem yapılmak istenen sayfaya göre
switch(strtolower($UrlAddr))
{
    // giriş yapma sayfası
    case strtolower(__PAGE_AUTH_LOGIN__):
        IndexGlobal::Importer([__SRC_DIR__ . "Page/Login.php"]);
        exit;
    // oturumu kapat
    case strtolower(__PAGE_AUTH_LOGOUT__):
        IndexGlobal::Importer([__SRC_DIR__ . "Page/Logout.php"]);
        exit;
    // ana sayfa
    case strtolower(__PAGE_FILES__):
        IndexGlobal::Importer([__SRC_DIR__ . "Page/Files.php"]);
        exit;
}

// ana sayfa
header("Location: /" . __PAGE_FILES__); // ana sayfa
exit;