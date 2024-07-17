<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Enum
defined("EFORGOT") !== true ? define("EFORGOT", 0) : null;
defined("EREGISTERNOW") !== true ? define("EREGISTERNOW", 1) : null;
defined("EURLADDR") !== true ? define("EURLADDR", 0) : null;
defined("ETEXT") !== true ? define("ETEXT", 1) : null;

// Svg
defined("SVG_INFO") !== true ? define("SVG_INFO", '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0112 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 01-3.476.383.39.39 0 00-.297.17l-2.755 4.133a.75.75 0 01-1.248 0l-2.755-4.133a.39.39 0 00-.297-.17 48.9 48.9 0 01-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97zM6.75 8.25a.75.75 0 01.75-.75h9a.75.75 0 010 1.5h-9a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H7.5z" clip-rule="evenodd"></path></svg>'): null;
?>
<!DOCTYPE html>
<html data-color-theme="auto">
<head>
    <!-- TITLE -->
    <title>Login</title>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark light">
    <!-- ICON -->
    <link rel="icon" href="/asset/global/image/logo/slavnem/slavnem.ico">
    <link rel="apple-touch-icon" href="/asset/global/image/logo/slavnem/slavnem.png">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/core/style/static/sign/login/login.css">
</head>
<body>
    <!-- NOSCRIPT -->
    <noscript>Enable JavaScript</noscript>
    <!-- SIGN MAIN AREA -->
    <main id="id_signmain" class="signmain">
        <!-- SIGN AREA -->
        <section id="id_signarea" class="signarea">
            <!-- LOGIN AREA -->
            <div id="id_loginarea" class="loginarea">
                <!-- MINI BTN AREA -->
                <div id="id_minibtnarea" class="minibtnarea">
                    <button id="id_infobtn_info" class="minibtn infobtn_info"><?php echo SVG_INFO; ?></button>
                </div>
                <!-- INFO TEXT AREA -->
                <div id="id_infotextarea" class="infotextarea">
                    <p id="id_info_text" class="info_text">
                        If you click twice in succession on the password entry section,
                        you can see the password you entered as text and if you click again in succession,
                        you can see it again as a password
                    </p>
                </div>
                <!-- TITLE AREA -->
                <div id="id_titlearea" class="titlearea">
                    <div id="id_titlearea_textarea" class="titlearea_textarea">
                        <h1 id="id_textarea_title" class="textarea_title">Login Now...</h1>
                        <p id="id_textarea_description" class="textarea_description">Welcome to the Main Server</p>
                    </div>
                </div>
                <!-- STATUS AREA -->
                <div id="id_statusarea" class="statusarea">
                    <span id="id_statusarea_icon" class="statusicon statusarea_icon"></span>
                    <span id="id_statusarea_text" class="statustext statusarea_text"></span>
                </div>
                <!-- INPUT AREA -->
                <div id="id_inputarea" class="inputarea">
                    <input type="text" autocomplete="off" name="username" id="id_username" class="input_data input_username" placeholder="Abcd" />
                    <input type="password" autocomplete="off" name="password" id="id_password" class="input_data input_password" placeholder="****" />
                </div>
                <!-- FORGOT AREA -->
                <div id="id_forgotarea" class="forgotarea">
                    <a id="id_forgotbtn" class="forgotbtn" href="/route/forgot">I Can't Login</a>
                </div>
                <!-- SUBMIT AREA -->
                <div id="id_submitarea" class="submitarea">
                    <button type="button" id="id_submitbtn" class="input_submitbtn submitbtn" name="submitbtn">Login</button>
                </div>
                <!-- REDIRECT AREA -->
                <div id="id_redirectarea" class="redirectarea">
                    <a id="id_redirect_signup" class="redirect_btn redirect_signup" href="/auth/register">If you don't have an account, create one right now...</a>
                </div>
            </div>
        </section>
    </main>
    <!-- JAVASCRIPT -->
    <script nonce type="module" src="/core/tool/global/sign/LoginProcess.js"></script>
</body>
</html>