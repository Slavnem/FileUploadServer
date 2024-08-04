<?php
// Slavnem @2024-08-04
namespace FileArchWeb\Src\v1\Page;

// Oturum yoksa başlatsın
if(session_status() != PHP_SESSION_ACTIVE) session_start();

// Durum Sınıfı
use FileArchWeb\Src\v1\Kernel\Status as Status;

// Oturum Sınıfları
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;
use SessionApi\v1\Core\SessionRequest as SessionRequest;

// oturum sorgu nesnesi
$SessionRequest = new SessionRequest();

// durum mesajları
$status_store = NULL;

// oturum geçersizse, giriş sayfasına yönlendirsin
if(!is_null($SessionRequest->isSession()))
{
    // giriş için yönlendirsin
    header("Location: /auth/login");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="color-scheme" content="dark light">
        <title>Ana Sayfa</title>
        <link rel="icon" href="../asset/logo/slavnem.ico">
        <link rel="apple-touch-icon" href="../asset/logo/slavnem.png">
        <link rel="stylesheet" href="../src/v1/Style/Home.css">
    </head>
    <body>
        <h1>Ana Sayfa</h1>
    </body>
</html>