<?php
// Slavnem @2024-08-04
namespace FileArchWeb\Src\v1\Page;

// Oturum Sınıfları
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;
use SessionApi\v1\Core\SessionRequest as SessionRequest;

// Sayfa
use const Site\Src\v1\Kernel\__PAGE_AUTH_LOGIN__;

// oturum sorgu nesnesi
$SessionRequest = new SessionRequest();

// oturum başlatma
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// oturumu kapatsın
$logout_session = $SessionRequest->Request(
    SessionMethods::getDelete(),
    NULL,
    NULL
);

// giriş sayfasına yönlendirsin
header("Location: /" . __PAGE_AUTH_LOGIN__);
exit();