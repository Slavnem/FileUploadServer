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
if(!$SessionRequest->isSession())
{
    // giriş için yönlendirsin
    header("Location: /auth/login");
    exit();
}

$SvgUpload = '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"></path></svg>';
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="color-scheme" content="dark light">
        <title>Dosyalar</title>
        <link rel="icon" href="Asset/logo/slavnem.ico">
        <link rel="apple-touch-icon" href="Asset/logo/slavnem.png">
        <link rel="stylesheet" href="/Site/src/v1/Style/Files.css">
    </head>
    <body>
        <h1>Dosya İşlemleri</h1>

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

                <div id="id_filelist"
                    name="filelist"
                    class="list filelist">
                </div>
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
                    class="btnupload btnfilesupload">
                    <span><?php print($SvgUpload); ?></span>Yükle
                </button>
            </div>
        </div>

        <!-- STATUS -->
        <div id="id_statusarea"
            name="statusarea"
            class="statusarea">
        </div>

        <!-- SEARCH -->
        <input type="text"
            autocomplete="on"
            id="id_filename"
            name="infilename"
            class="input_data input_filename"
            placeholder="Abcd.txt"
            title="Dosyayı Ara"
        />

        <button type="button"
        id="id_btnfilesearch"
        name="btninfilesearch"
        data-dom-event-listen="true"
        class="btnsearch btnfilesearch">
            Araştır
        </button>

        <div id="id_filesarea"
            name="filesarea"
            class="files filesarea">
        </div>

        <!-- JS -->
        <script nonce type="module" src="/Site/src/v1/Tool/Page/PageFiles.js"></script>
    </body>
</html>