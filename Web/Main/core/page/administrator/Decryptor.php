<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case (boolval(strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php")))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

echo "Administrator -> Decryptor<br/>";
exit;