<?php
// Slavnem @2024-08-04
namespace FileArchWeb\Src\v1\Page;

// Oturum yoksa başlatsın
if(session_status() != PHP_SESSION_ACTIVE) session_start();

// Oturum Sınıfları
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;
use SessionApi\v1\Core\SessionRequest as SessionRequest;

// Dosya Sınıfları
use FileApi\v1\Core\Methods as FileMethods;
use FileApi\v1\Core\FileOperations as FileOperations;
use FileApi\v1\Includes\Config\FileConfig;

// oturum sorgu nesnesi
$SessionRequest = new SessionRequest();

// oturum geçersizse, giriş sayfasına yönlendirsin
if(!empty($SessionRequest->isSession()))
{
    // giriş için yönlendirsin
    header("Location: /auth/login");
    exit();
}

// dosya sorgu nesnesi
$FileRequest = new FileOperations();

// kullanıcı dosyalarını alsın
$user_files = $FileRequest->Request(
    FileMethods::getFetch(), // veri getirtme
    NULL, // sadece belirli dosyalar
    NULL // yeni dosyalar (gereksiz)
);
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="color-scheme" content="dark light">
        <title>Dosyalar</title>
        <link rel="icon" href="/asset/logo/slavnem.ico">
        <link rel="apple-touch-icon" href="/asset/logo/slavnem.png">
        <link rel="stylesheet" href="/src/v1/Style/Home.css">
    </head>
    <body>
        <h1>Dosyalar</h1>
        <?php
            // kullanıcıya ait dosyalar varsa
            if(isset($user_files) && !empty($user_files)) {
                foreach($user_files as $file) {
                    $temp_name = $file["name"];
                    $temp_size = FileConfig::calcFileSize($file["size"]);
                    $temp_modified = $file["modified"];
                    $temp_path = $file["path"];
                    $temp_url = (FileConfig::getStorageUrl() . $_SESSION[SessionParams::getId()] . "/" . $temp_name);

                    // ekrana çıktı ver
                    echo "<div class=\"file_listed\" name=\"$temp_name\">
                        <p>Dosya Adı: $temp_name</p>
                        <p>Boyut: $temp_size</p>
                        <p>Son Değiştirilme: $temp_modified</p>
                        <!-- <a href=\"$temp_url\" download>İndir</a> -->
                    </div>";
                }
            }
        ?>
    </body>
</html>