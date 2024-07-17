<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(IconData::class) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// İkon Fonksiyonları
class IconFunctions {
    public static function GetIcon(string $argIconKey = null): string|array|null {
        return (IconData::getIcon($argIconKey));
    }
}