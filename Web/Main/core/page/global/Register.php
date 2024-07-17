<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

echo "Global -> Register <br/>";

// test
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

print_r($_SESSION);
exit;