<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(Kernel::class) !== true):
    case ((bool)class_exists(SessionFunctions::class) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Url Adres
defined("URL_SESSION_DESTROY") !== true ? define("URL_SESSION_DESTROY", "/lapi/session/destroy"): null;

// Admin sayfaları için tanımlamalar
defined("ADMINISTRATOR_ADMIN") !== true ? define("ADMINISTRATOR_ADMIN", "administrator/admin"): null;
defined("ADMINISTRATOR_ENCRYPTOR") !== true ? define("ADMINISTRATOR_ENCRYPTOR", "administrator/encryptor"): null;
defined("ADMINISTRATOR_DECRYPTOR") !== true ? define("ADMINISTRATOR_DECRYPTOR", "administrator/decryptor"): null;

// Küresel sayfalar için tanımlamalar
defined("GLOBAL_HOMEPAGE") !== true ? define("GLOBAL_HOMEPAGE", "homepage"): null;

// Giriş Kontrol sayfası için tanımlamalar
defined("AUTH_LOGIN") !== true ? define("AUTH_LOGIN", "auth/login"): null;
defined("AUTH_REGISTER") !== true ? define("AUTH_REGISTER", "auth/register"): null;

// Hesabı Olan Kullanıcıların sayfaları için tanımlamalar
defined("ACCOUNT_LOGOUT") !== true ? define("ACCOUNT_LOGOUT", "account/logout"): null;
defined("ACCOUNT_SETTINGS") !== true ? define("ACCOUNT_SETTINGS", "account/settings"): null;

// Paylaşımlı sayfalar için tanımlamalar
defined("SHARED_MAIN") !== true ? define("SHARED_MAIN", "global/main"): null;

// Sayfa Kısaltmalar
defined("PAGES_ADMIN") !== true ? define("PAGES_ADMIN", "admin"): null;
defined("PAGES_GLOBAL") !== true ? define("PAGES_GLOBAL", "global"): null;
defined("PAGES_PRIVATE") !== true ? define("PAGES_PRIVATE", "private"): null;
defined("PAGES_SHARED") !== true ? define("PAGES_SHARED", "shared"): null;

// Sayfa İsimlendirme
defined("PAGES_ADMIN_TAG_ADMIN") !== true ? define("PAGES_ADMIN_TAG_ADMIN", "adminBase"): null;
defined("PAGES_ADMIN_TAG_ENCRYPTOR") !== true ? define("PAGES_ADMIN_TAG_ENCRYPTOR", "adminEncryptor"): null;
defined("PAGES_ADMIN_TAG_DECRYPTOR") !== true ? define("PAGES_ADMIN_TAG_DECRYPTOR", "adminDecryptor"): null;

defined("PAGES_GLOBAL_TAG_HOMEPAGE") !== true ? define("PAGES_GLOBAL_TAG_HOMEPAGE", "globalHomepage"): null;
defined("PAGES_GLOBAL_TAG_LOGIN") !== true ? define("PAGES_GLOBAL_TAG_LOGIN", "authLogin"): null;
defined("PAGES_GLOBAL_TAG_REGISTER") !== true ? define("PAGES_GLOBAL_TAG_REGISTER", "authRegister"): null;

defined("PAGES_PRIVATE_TAG_LOGOUT") !== true ? define("PAGES_PRIVATE_TAG_LOGOUT", "sessionLogout"): null;
defined("PAGES_PRIVATE_TAG_SETTINGS") !== true ? define("PAGES_PRIVATE_TAG_SETTINGS", "accountSettings"): null;

defined("PAGES_SHARED_TAG_MAIN") !== true ? define("PAGES_SHARED_TAG_MAIN", "sharedGlobal"): null;

// URL
$url = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

// URL PARTS
$urlArr = explode("/", $url);

// Yönlendirilmek istenen kısım
$redirectUrl = implode("/", array_slice($urlArr, 0, 2));

// Yönlendirilecek sayfaların dosyaları
$pages = [
    PAGES_ADMIN => [ // ADMINISTRATOR
        PAGES_ADMIN_TAG_ADMIN => FILE_PAGE_ADMINISTRATOR_ADMIN,
        PAGES_ADMIN_TAG_ENCRYPTOR => FILE_PAGE_ADMINISTRATOR_ENCRYPTOR,
        PAGES_ADMIN_TAG_DECRYPTOR => FILE_PAGE_ADMINISTRATOR_DECRYPTOR,
    ],
    PAGES_GLOBAL => [ // GLOBAL
        PAGES_GLOBAL_TAG_HOMEPAGE => FILE_PAGE_GLOBAL_HOMEPAGE,
        PAGES_GLOBAL_TAG_LOGIN => FILE_PAGE_GLOBAL_LOGIN,
        PAGES_GLOBAL_TAG_REGISTER => FILE_PAGE_GLOBAL_REGISTER
    ],
    PAGES_PRIVATE => [ // PRIVATE
        PAGES_PRIVATE_TAG_LOGOUT => FILE_PAGE_PRIVATE_LOGOUT,
        PAGES_PRIVATE_TAG_SETTINGS => FILE_PAGE_PRIVATE_SETTINGS
    ],
    PAGES_SHARED => [ // SHARED
        PAGES_SHARED_TAG_MAIN => FILE_PAGE_SHARED_MAIN
    ]
];

// Yönlendirilecek sayfaların kısaltmaları
$pages_short = [
    PAGES_ADMIN => [ // ADMINISTRATOR
        PAGES_ADMIN_TAG_ADMIN => ADMINISTRATOR_ADMIN,
        PAGES_ADMIN_TAG_ENCRYPTOR => ADMINISTRATOR_ENCRYPTOR,
        PAGES_ADMIN_TAG_DECRYPTOR => ADMINISTRATOR_DECRYPTOR
    ],
    PAGES_GLOBAL => [ // GLOBAL
        PAGES_GLOBAL_TAG_HOMEPAGE => GLOBAL_HOMEPAGE,
        PAGES_GLOBAL_TAG_LOGIN => AUTH_LOGIN,
        PAGES_GLOBAL_TAG_REGISTER => AUTH_REGISTER
    ],
    PAGES_PRIVATE => [ // PRIVATE
        PAGES_PRIVATE_TAG_LOGOUT => ACCOUNT_LOGOUT,
        PAGES_PRIVATE_TAG_SETTINGS => ACCOUNT_SETTINGS
    ],
    PAGES_SHARED => [ // SHARED
        PAGES_SHARED_TAG_MAIN => SHARED_MAIN
    ]
];

// Eğer yönlendirme tanımlı değilse
if(isset($redirectUrl) !== true || strlen($redirectUrl) < 1) {
    $redirectUrl = $pages_short[PAGES_GLOBAL][PAGES_GLOBAL_TAG_HOMEPAGE]; // otomatik ana sayfa
}

// İçe aktarma yapılacak adresleri tutan dizi
$includeFile = null;

switch($redirectUrl) {
    // ADMINISTRATOR
    case $pages_short[PAGES_ADMIN][PAGES_ADMIN_TAG_ADMIN]: // admin
    case $pages_short[PAGES_ADMIN][PAGES_ADMIN_TAG_ENCRYPTOR]: // encryptor
    case $pages_short[PAGES_ADMIN][PAGES_ADMIN_TAG_DECRYPTOR]: // decryptor
        // admin kontrolü başarısızsa sonlandırsın
        switch(true) {
            case ((bool)SessionFunctions::SessionAdmin() !== true):
                http_response_code(401);
                header("Location: /" . AUTH_LOGIN);
                exit;
        }

        // sayfayı içe aktarma
        switch($redirectUrl) {
            case $pages_short[PAGES_ADMIN][PAGES_ADMIN_TAG_ADMIN]:
                $includeFile = $pages[PAGES_ADMIN][PAGES_ADMIN_TAG_ADMIN];
                break;
            case $pages_short[PAGES_ADMIN][PAGES_ADMIN_TAG_ENCRYPTOR]:
                $includeFile = $pages[PAGES_ADMIN][PAGES_ADMIN_TAG_ENCRYPTOR];
                break;
            case $pages_short[PAGES_ADMIN][PAGES_ADMIN_TAG_DECRYPTOR]:
                $includeFile = $pages[PAGES_ADMIN][PAGES_ADMIN_TAG_DECRYPTOR];
                break;
        }
    break;
    // GLOBAL
    case $pages_short[PAGES_GLOBAL][PAGES_GLOBAL_TAG_HOMEPAGE]: // homepage
    case $pages_short[PAGES_GLOBAL][PAGES_GLOBAL_TAG_LOGIN]: // login
    case $pages_short[PAGES_GLOBAL][PAGES_GLOBAL_TAG_REGISTER]: // register
        // sayfayı içe aktarma
        switch($redirectUrl) {
            case $pages_short[PAGES_GLOBAL][PAGES_GLOBAL_TAG_HOMEPAGE]:
                $includeFile = $pages[PAGES_GLOBAL][PAGES_GLOBAL_TAG_HOMEPAGE];
                break;
            case $pages_short[PAGES_GLOBAL][PAGES_GLOBAL_TAG_LOGIN]:
                $includeFile = $pages[PAGES_GLOBAL][PAGES_GLOBAL_TAG_LOGIN];
                break;
            case $pages_short[PAGES_GLOBAL][PAGES_GLOBAL_TAG_REGISTER]:
                $includeFile = $pages[PAGES_GLOBAL][PAGES_GLOBAL_TAG_REGISTER];
                break;
            default:
                http_response_code(404);
                header("Location: /error-client");
                exit;
        }
    break;
    // PRIVATE
    case $pages_short[PAGES_PRIVATE][PAGES_PRIVATE_TAG_LOGOUT]: // logout
    case $pages_short[PAGES_PRIVATE][PAGES_PRIVATE_TAG_SETTINGS]: // settings
        // oturum kontrolü başarısızsa sonlandırsın
        switch(true) {
            case ((bool)SessionFunctions::SessionVerify() !== true):
                http_response_code(401);
                header("Location: /" . AUTH_LOGIN);
                exit;
        }

        // sayfayı içe aktarma
        switch($redirectUrl) {
            case $pages_short[PAGES_PRIVATE][PAGES_PRIVATE_TAG_LOGOUT]:
                $includeFile = $pages[PAGES_PRIVATE][PAGES_PRIVATE_TAG_LOGOUT];
                break;
            case $pages_short[PAGES_PRIVATE][PAGES_PRIVATE_TAG_SETTINGS]:
                $includeFile = $pages[PAGES_PRIVATE][PAGES_PRIVATE_TAG_SETTINGS];
                break;
            default:
                http_response_code(404);
                header("Location: /" . AUTH_LOGIN);
                exit;
        }
    break;
    // SHARED
    case $pages_short[PAGES_SHARED][PAGES_SHARED_TAG_MAIN]: // main
        // sayfayı içe aktarma
        switch($redirectUrl) {
            case $pages_short[PAGES_SHARED][PAGES_SHARED_TAG_MAIN]:
                $includeFile = $pages[PAGES_SHARED][PAGES_SHARED_TAG_MAIN];
                break;
            default:
                http_response_code(404);
                header("Location: /" . AUTH_LOGIN);
                exit;
        }
    break;
    // UNKNOWN
    default:
        // Eğer kullanıcı giriş yapmış bir kullanıcı ise
        // direk paylaşımlı sayfaya, değilse ana sayfaya yönlendirsin
        switch(true) {
            case ((bool)(SessionFunctions::SessionVerify()) !== true): // anasayfa
                $includeFile = $pages[PAGES_GLOBAL][PAGES_GLOBAL_TAG_HOMEPAGE];
                break;
            default: // paylaşımlı
                $includeFile = $pages[PAGES_SHARED][PAGES_SHARED_TAG_MAIN];
                break;
        }
    break;
}

// Veri eğer dizi değilse diziye çevir
if(is_array($includeFile) !== true) {
    $includeFile = (array)$includeFile;
}

// İçeri Aktarılması Aktif Dosyaları İçeri Aktarma
$statusInclude = Kernel::FileImporter($includeFile);

// Bulunamadıysa Hata Yönlendirmesi
switch($statusInclude) {
    case true:
        // değişkenleri yoketmek
        unset($includeFile);
        unset($statusInclude);
        unset($pages);
        unset($pages_short);
        break; // başarılı
    default: // hata
        http_response_code(404);
        header("Location: /error-client");
        exit;
}
