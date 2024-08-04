<?php
// Slavnem @2024-08-04
namespace FileArchWeb\Src\v1\Page;

// Oturum yoksa başlatsın
if(session_status() != PHP_SESSION_ACTIVE) session_start();

// Oturum Sınıfları
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;
use SessionApi\v1\Core\SessionRequest as SessionRequest;

// oturum sorgu nesnesi
$SessionRequest = new SessionRequest();

// oturumu kapatsın
$logout_session = $SessionRequest->Request(
    SessionMethods::getDelete(),
    NULL,
    NULL
);

// giriş sayfasına yönlendirsin
header("Location: /auth/login");
exit();