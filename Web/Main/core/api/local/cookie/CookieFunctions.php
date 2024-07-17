<?php
// Cookie Ön Tanımlamaları
defined("ERRCODE_COOKIE_NOTFOUND") !== true ? define("ERRCODE_COOKIE_NOTFOUND", 900): null;
defined("ERRCODE_COOKIE_DIFFVALUE") !== true ? define("ERRCODE_COOKIE_DIFFVALUE", 901): null;

defined("PARAM_COOKIE_EXPIRE_DAY") !== true ? define("PARAM_COOKIE_EXPIRE_DAY", 86400): null;
defined("PARAM_COOKIE_EXPIRE_HOUR") !== true ? define("PARAM_COOKIE_EXPIRE_HOUR", 3600): null;
defined("PARAM_COOKIE_EXPIRE_MIN") !== true ? define("PARAM_COOKIE_EXPIRE_MIN", 60): null;
defined("PARAM_COOKIE_EXPIRE_NOLIMIT") !== true ? define("PARAM_COOKIE_EXPIRE_NOLIMIT", 0): null;

// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)(strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php")))):
    case ((bool)defined("ERRCODE_COOKIE_NOTFOUND") !== true):
    case ((bool)defined("ERRCODE_COOKIE_DIFFVALUE") !== true):
    case ((bool)defined("PARAM_COOKIE_EXPIRE_DAY") !== true):
    case ((bool)defined("PARAM_COOKIE_EXPIRE_HOUR") !== true):
    case ((bool)defined("PARAM_COOKIE_EXPIRE_MIN") !== true):
    case ((bool)defined("PARAM_COOKIE_EXPIRE_NOLIMIT") !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Çerez İşlemlerini İçeren Sınıf
class CookieFunctions {
    // Cookie Oluşturucu
    protected static function procCookieCreate(string $cookieName, string|int|bool|float|null $cookieValue, int $cookieExpire): bool|int {
        // cookie oluştur
        setcookie(
            $cookieName,
            $cookieValue,
            [
                'expires' => (($cookieExpire !== PARAM_COOKIE_EXPIRE_NOLIMIT) ? (time() + ($cookieExpire)) : (PARAM_COOKIE_EXPIRE_NOLIMIT)),
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'],
                'httponly' => true,
                'samesite' => 'Strict'
            ]
        );

        // Cookie varlığını kontrol et
        switch(true) {
            case (isset($_COOKIE[$cookieName]) !== true):
                return (int)ERRCODE_COOKIE_NOTFOUND;
            // Cookie var fakat değerler uyuşmuyorsa sil
            case ($_COOKIE[$cookieName] != $cookieValue):
                return (int)ERRCODE_COOKIE_DIFFVALUE;
        }
        
        // Cookie var ve değer eşit ise
        return (bool)(isset($_COOKIE[$cookieName]) && $_COOKIE[$cookieName] == $cookieValue);
    }

    // Cookie Yokedici
    protected static function procCookieDestroy(string $cookieName): bool|int {
        // Cookie yoksa yok hatası, varsa da silme işlemi
        switch(true) {
            case (isset($_COOKIE[$cookieName]) !== true):
                return (int)ERRCODE_COOKIE_NOTFOUND;
            case (isset($_COOKIE[$cookieName])):
                unset($_COOKIE[$cookieName]);
                break;
        }

        // Eğer cookie yok olmuşsa işlem başarılıdır
        // Fakat hala duruyorsa cookie, işlem başarısızdır
        return (bool)(isset($_COOKIE[$cookieName]) !== true);
    }

    // Cookie Getirici
    protected static function procCookieFetch(string $cookieName): string|int|bool|float|null {
        return (isset($_COOKIE[$cookieName]) ? ($_COOKIE[$cookieName]) : null);
    }
}