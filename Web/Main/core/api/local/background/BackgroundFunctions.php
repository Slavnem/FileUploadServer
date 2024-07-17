<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(BackgroundData::class) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Arkaplan Fonksiyonları
class BackgroundFunctions {
    // Genel arkaplan erişimi
    public static function getBackground(string $page = null, int $backgroundid = 0): array|null {
        // Arkaplanı getirtme
        return (BackgroundData::getBackgroundSelected(strval($page), intval($backgroundid)));
    }
}