<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case (boolval(strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php")))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}
?>
<!DOCTYPE html>
<html data-color-theme="auto">
<head>
    <!-- TITLE -->
    <title>Encryptor</title>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark light">
    <!-- ICON -->
    <link rel="icon" href="/asset/global/image/logo/slavnem/slavnem.ico">
    <link rel="apple-touch-icon" href="/asset/global/image/logo/slavnem/slavnem.png">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/core/style/static/cryptography/encryption/encryptor.css">
</head>
<body>
    <!-- NOSCRIPT -->
    <noscript>Enable JavaScript</noscript>
    <!-- CRYPTOGRAPHY MAIN AREA -->
    <main id="idcryptmain" class="cryptmain">
        <!-- CRYPTOGRAPHY AREA -->
        <section id="id_cryptarea" class="cryptarea">
            <!-- CRYPT AREA -->
            <div id="id_enccryptrarea" class="enccryptarea">
                <!-- CRYPT TITLE AREA -->
                <div id="id_crypttitlearea" class="crypttitlearea">
                    <!-- CRYPT TEXT AREA -->
                    <div id="id_crypttextarea" class="crypttextarea">
                        <h1 id="id_crypttextarea_title" class="crypttextarea_title">Welcome To The Main Data Encryptor</h1>
                        <p id="id_crypttextarea_description" class="crypttextarea_description">The main encryptor is designed for Admin users only. The encryptor has tools such as data encryption, encryption verification</p>
                    </div>
                </div>
                <!-- STATUS AREA -->
                <div id="id_statusarea" class="statusarea">
                    <span id="id_statusarea_icon" class="statusicon statusarea_icon"></span>
                    <span id="id_statusarea_text" class="statustext statusarea_text"></span>
                </div>
                <!-- ENCRYPTOR INPUT AREA -->
                <div id="id_encinputarea" class="encinputarea">
                    <input type="text" name="basetext" id="id_input_encbasetext" class="input_encdata input_encbasetext" placeholder="Abcdefghi"/>
                    <input type="text" name="encrypted" id="id_input_encencrypted" class="input_encdata input_encencrypted" placeholder="Bx@9Exq1*Fx?3!I#p@1"/>
                </div>
                <!-- ENCRYPTOR ALGORITHM AREA -->
                <div id="id_encalgorithmarea" class="cryptalgorithmarea encalgorithmarea">
                    <p id="id_encalgorithm_title" class="encalgorithm_title">Algorithm</p>
                    <select id="id_encalgorithms" class="encalgorithms" name="encalgos"></select>
                </div>
                <!-- ENCRYPTOR TYPE AREA -->
                <div id="id_enctypearea" class="cryptprocarea encprocarea">
                    <p id="id_encprocess_title" class="encprocess_title">Process</p>
                    <select id="id_encproc" class="encalgorithms" name="encprocs"></select>
                </div>
                <!-- CRYPT SUBMIT AREA -->
                <div id="id_cryptsubmitarea" class="cryptsubmitarea">
                    <button type="button" id="id_cryptsubmitbtn" class="cryptbtn encsubmitbtn" name="encsubmitbtn">Submit</button>
                </div>
            </div>
        </section>
    </main>
    <!-- JAVASCRIPT -->
    <script nonce type="module" src="/core/tool/global/api/crypt/encryption/EncryptionProcess.js"></script>
</body>
</html>