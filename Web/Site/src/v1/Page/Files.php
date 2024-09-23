<?php
// Slavnem @2024-08-04
namespace FileArchWeb\Src\v1\Page;

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
if(!$SessionRequest->isSession()) {
    // giriş için yönlendirsin
    header("Location: /auth/login");
    exit;
}

$SvgUpload = '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"></path></svg>';
$SvgLogout = '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M400 54.1c63 45 104 118.6 104 201.9 0 136.8-110.8 247.7-247.5 248C120 504.3 8.2 393 8 256.4 7.9 173.1 48.9 99.3 111.8 54.2c11.7-8.3 28-4.8 35 7.7L162.6 90c5.9 10.5 3.1 23.8-6.6 31-41.5 30.8-68 79.6-68 134.9-.1 92.3 74.5 168.1 168 168.1 91.6 0 168.6-74.2 168-169.1-.3-51.8-24.7-101.8-68.1-134-9.7-7.2-12.4-20.5-6.5-30.9l15.8-28.1c7-12.4 23.2-16.1 34.8-7.8zM296 264V24c0-13.3-10.7-24-24-24h-32c-13.3 0-24 10.7-24 24v240c0 13.3 10.7 24 24 24h32c13.3 0 24-10.7 24-24z"></path></svg>';
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="color-scheme" content="dark light">
        <title>Dosyalar</title>
        <link rel="icon" href="/Asset/logo/offical-logo.ico">
        <link rel="apple-touch-icon" href="/Asset/logo/offical-logo.png">
        <link rel="stylesheet" href="/Site/src/v1/Style/Files.css">
    </head>
    <body>
        <!-- SEARCH -->
        <div id="id_searcharea"
            name="searcharea"
            class="searcharea">
                <a id="id_btnlogout"
                    name="btnlogout"
                    href="/auth/logout"
                    class="btn btnlogout">
                    <?php print($SvgLogout); ?>
                </a>

                <input type="text"
                    autocomplete="on"
                    id="id_filename"
                    name="filename"
                    class="input_data input_filename"
                    placeholder="Abcd.txt"
                    title="Dosyayı Ara" />

            <button type="button"
                id="id_btnfilesearch"
                name="btnfilesearch"
                data-dom-event-listen="true"
                class="btnsearch btnfilesearch">
                Araştır
            </button>
        </div>

        <!-- UPLOAD -->
        <div id="id_filesuploadarea"
            name="filesuploadarea"
            class="filesuploadarea">
            <div id="id_fileselectarea"
                name="fileselectarea"
                class="fileselectarea">
                <input type="file"
                    id="id_fileupload"
                    class="fileupload"
                    name="files[]"
                    multiple />

                <label for="id_fileupload"
                    id="id_labelfileupload"
                    name="labelfileupload"
                    class="labelfileupload">
                </label>

                <ul id="id_filelist"
                    name="filelist"
                    class="list filelist">
                </ul>
            </div>

            <div id="id_fileprogressbararea"
                name="fileprogressbararea"
                class="fileprogressbararea">
                <div id="id_uploadprogressbar"
                    name="uploadprogressbar"
                    class="progressbar uploadprogressbar">
                </div>
            </div>

            <div id="id_fileuploadbtnarea"
                name="fileuploadbtnarea"
                class="btnarea fileuploadbtnarea">
                <button type="button"
                    id="id_btnfileupload"
                    name="btnfileupload"
                    class="btnfileupload btnuploadfiles">
                    <?php print($SvgUpload); ?>
                    <span name="btnfileupload_text">Yükle</span>
                </button>
            </div>
        </div>

        <!-- STATUS -->
        <div id="id_statusarea"
            name="statusarea"
            class="statusarea">
        </div>

        <!-- FILES -->
        <div id="id_filesarea"
            name="filesarea"
            class="files filesarea">
        </div>

        <!-- FOOTER -->
        <footer>
            <p>&copy; Slavnem 2024. All rights reserved.</p>
        </footer>

        <!-- JS -->
        <script nonce type="module" src="/Site/src/v1/Tool/Page/PageFiles.js"></script>
    </body>
</html>