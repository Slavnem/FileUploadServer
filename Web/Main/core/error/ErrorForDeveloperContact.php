<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}
?>
<!DOCTYPE html>
<html data-color-theme="auto">
<head>
    <!-- TITLE -->
    <title>Error For Developer Contact</title>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark light">
    <!-- ICON -->
    <link rel="icon" href="/asset/global/image/logo/slavnem/slavnem.ico">
    <link rel="apple-touch-icon" href="/asset/global/image/logo/slavnem/slavnem.png">
</head>
<body>
    <h1>Send Error To This Email Adress: kafkasrevan@gmail.com</h1>
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        body {
            width: 100%;
            height: 100dvh;
            display: flex;
            overflow: hidden;
            justify-content: center;
        }
        h1 {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: clamp(0.9rem, 5vw, 1.5rem);
        }
    </style>
</body>
</html>