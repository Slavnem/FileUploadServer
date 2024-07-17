<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

//////////////////////////////
// DİZİNLER / DIRECTORIES
//////////////////////////////
// ROOT
defined("TREE") !== true ? define("TREE", $_SERVER["DOCUMENT_ROOT"] . "/") : null;

// DIRECTORY -> CORE
defined("DIR_CORE") !== true ? define("DIR_CORE", TREE . "core/") : null;

// DIRECTORY -> API
defined("DIR_API") !== true ? define("DIR_API", DIR_CORE . "api/") : null;
defined("DIR_API_LOCAL") !== true ? define("DIR_API_LOCAL", DIR_API . "local/") : null;
defined("DIR_API_LOCAL_BACKGROUND") !== true ? define("DIR_API_LOCAL_BACKGROUND", DIR_API_LOCAL . "background/") : null;
defined("DIR_API_LOCAL_ICON") !== true ? define("DIR_API_LOCAL_ICON", DIR_API_LOCAL . "icon/") : null;
defined("DIR_API_LOCAL_LANGUAGE") !== true ? define("DIR_API_LOCAL_LANGUAGE", DIR_API_LOCAL . "language/") : null;
defined("DIR_API_LOCAL_SESSION") !== true ? define("DIR_API_LOCAL_SESSION", DIR_API_LOCAL . "session/") : null;

defined("DIR_API_SERVER") !== true ? define("DIR_API_SERVER", DIR_API . "server/") : null;
defined("DIR_API_SERVER_USERS") !== true ? define("DIR_API_SERVER_USERS", DIR_API_SERVER . "users/") : null;

// DIRECTORY -> COMPONENT
defined("DIR_COMPONENT") !== true ? define("DIR_COMPONENT", DIR_CORE . "component/") : null;

// DIRECTORY -> KERNEL
defined("DIR_KERNEL") !== true ? define("DIR_KERNEL", DIR_CORE . "kernel/") : null;

// DIRECTORY -> PAGE
defined("DIR_PAGE") !== true ? define("DIR_PAGE", DIR_CORE . "page/") : null;
defined("DIR_PAGE_ROUTER") !== true ? define("DIR_PAGE_ROUTER", DIR_PAGE . "router/") : null;
defined("DIR_PAGE_ADMINISTRATOR") !== true ? define("DIR_PAGE_ADMINISTRATOR", DIR_PAGE . "administrator/") : null;
defined("DIR_PAGE_GLOBAL") !== true ? define("DIR_PAGE_GLOBAL", DIR_PAGE . "global/") : null;
defined("DIR_PAGE_PRIVATE") !== true ? define("DIR_PAGE_PRIVATE", DIR_PAGE . "private/") : null;
defined("DIR_PAGE_SHARED") !== true ? define("DIR_PAGE_SHARED", DIR_PAGE . "shared/") : null;

// DIRECTORY -> SESSION
defined("DIR_SESSION") !== true ? define("DIR_SESSION", DIR_CORE . "session/") : null;

// DIRECTORY -> CRYPTOGRAPHY
defined("DIR_CRYPTOGRAPHY") !== true ? define("DIR_CRYPTOGRAPHY", DIR_CORE . "crypt/") : null;
defined("DIR_CRYPT_ENCRYPTION") !== true ? define("DIR_CRYPT_ENCRYPTION", DIR_CRYPTOGRAPHY . "encryption/") : null;
defined("DIR_CRYPT_DECRYPTION") !== true ? define("DIR_CRYPT_DECRYPTION", DIR_CRYPTOGRAPHY . "decryption/") : null;

// DIRECTORY -> SHARED
defined("DIR_SHARED") !== true ? define("DIR_SHARED", DIR_CORE . "shared/") : null;

// DIRECTORY -> STYLE
defined("DIR_STYLE") !== true ? define("DIR_STYLE", DIR_CORE . "style/") : null;

// DIRECTORY STYLE -> DYNAMIC
defined("DIR_STYLE_DYNAMIC") !== true ? define("DIR_STYLE_DYNAMIC", DIR_STYLE . "dynamic/") : null;

// DIRECTORY STYLE -> STATIC
defined("DIR_STYLE_STATIC") !== true ? define("DIR_STYLE_STATIC", DIR_STYLE . "static/") : null;
defined("DIR_STYLE_STATIC_ROOT") !== true ? define("DIR_STYLE_STATIC_ROOT", DIR_STYLE_STATIC . "root/") : null;
defined("DIR_STYLE_STATIC_SERVER") !== true ? define("DIR_STYLE_STATIC_SERVER", DIR_STYLE_STATIC . "server/") : null;

// DIRECTORY -> TOOL
defined("DIR_TOOL") !== true ? define("DIR_TOOL", DIR_CORE . "tool/") : null;
defined("DIR_TOOL_GLOBAL") !== true ? define("DIR_TOOL_GLOBAL", DIR_TOOL . "global/") : null;
defined("DIR_TOOL_GLOBAL_BACKGROUND") !== true ? define("DIR_TOOL_GLOBAL_BACKGROUND", DIR_TOOL_GLOBAL . "background/") : null;
defined("DIR_TOOL_GLOBAL_ENCRYPTION") !== true ? define("DIR_TOOL_GLOBAL_ENCRYPTION", DIR_TOOL_GLOBAL . "encryption/") : null;
defined("DIR_TOOL_GLOBAL_ICON") !== true ? define("DIR_TOOL_GLOBAL_ICON", DIR_TOOL_GLOBAL . "icon/") : null;
defined("DIR_TOOL_GLOBAL_LANGUAGE") !== true ? define("DIR_TOOL_GLOBAL_LANGUAGE", DIR_TOOL_GLOBAL . "language/") : null;
defined("DIR_TOOL_GLOBAL_LOCALSTORAGE") !== true ? define("DIR_TOOL_GLOBAL_LOCALSTORAGE", DIR_TOOL_GLOBAL . "localstorage/") : null;
defined("DIR_TOOL_GLOBAL_ROUTE") !== true ? define("DIR_TOOL_GLOBAL_ROUTE", DIR_TOOL_GLOBAL . "route/") : null;
defined("DIR_TOOL_GLOBAL_ROUTE_FORGOT") !== true ? define("DIR_TOOL_GLOBAL_ROUTE_FORGOT", DIR_TOOL_GLOBAL_ROUTE . "forgot/") : null;
defined("DIR_TOOL_GLOBAL_SESSION") !== true ? define("DIR_TOOL_GLOBAL_SESSION", DIR_TOOL_GLOBAL . "session/") : null;
defined("DIR_TOOL_GLOBAL_SIGN") !== true ? define("DIR_TOOL_GLOBAL_SIGN", DIR_TOOL_GLOBAL . "sign/") : null;
defined("DIR_TOOL_GLOBAL_THEME") !== true ? define("DIR_TOOL_GLOBAL_THEME", DIR_TOOL_GLOBAL . "theme/") : null;
defined("DIR_TOOL_GLOBAL_URL") !== true ? define("DIR_TOOL_GLOBAL_URL", DIR_TOOL_GLOBAL . "url/") : null;

//////////////////////////////
// DOSYALAR / FILES
//////////////////////////////
// KERNEL
defined("FILE_CORE_KERNEL") !== true ? define("FILE_CORE_KERNEL", DIR_KERNEL . "Kernel.php") : null;
defined("FILE_CORE_KERNEL_PAGEROUTER") !== true ? define("FILE_CORE_KERNEL_PAGEROUTER", DIR_KERNEL . "KernelPageRouter.php") : null;
defined("FILE_CORE_KERNEL_FUNCTIONS") !== true ? define("FILE_CORE_KERNEL_FUNCTIONS", DIR_KERNEL . "KernelFunctions.php") : null;

// SESSION
defined("FILE_API_LOCAL_SESSION_STRUCT") !== true ? define("FILE_API_LOCAL_SESSION_STRUCT", DIR_API_LOCAL_SESSION . "SessionStruct.php") : null;
defined("FILE_API_LOCAL_SESSION_FUNCTIONS") !== true ? define("FILE_API_LOCAL_SESSION_FUNCTIONS", DIR_API_LOCAL_SESSION . "SessionFunctions.php") : null;
defined("FILE_API_LOCAL_SESSION_PROCESS") !== true ? define("FILE_API_LOCAL_SESSION_PROCESS", DIR_API_LOCAL_SESSION . "SessionProcess.php") : null;

// PAGE ADMINISTRATOR
defined("FILE_PAGE_ADMINISTRATOR_ADMIN") !== true ? define("FILE_PAGE_ADMINISTRATOR_ADMIN", DIR_PAGE_ADMINISTRATOR . "Admin.php") : null;
defined("FILE_PAGE_ADMINISTRATOR_ENCRYPTOR") !== true ? define("FILE_PAGE_ADMINISTRATOR_ENCRYPTOR", DIR_PAGE_ADMINISTRATOR . "Encryptor.php") : null;
defined("FILE_PAGE_ADMINISTRATOR_DECRYPTOR") !== true ? define("FILE_PAGE_ADMINISTRATOR_DECRYPTOR", DIR_PAGE_ADMINISTRATOR . "Decryptor.php") : null;

// PAGE GLOBAL
defined("FILE_PAGE_GLOBAL_HOMEPAGE") !== true ? define("FILE_PAGE_GLOBAL_HOMEPAGE", DIR_PAGE_GLOBAL . "Homepage.php") : null;
defined("FILE_PAGE_GLOBAL_LOGIN") !== true ? define("FILE_PAGE_GLOBAL_LOGIN", DIR_PAGE_GLOBAL . "Login.php") : null;
defined("FILE_PAGE_GLOBAL_REGISTER") !== true ? define("FILE_PAGE_GLOBAL_REGISTER", DIR_PAGE_GLOBAL . "Register.php") : null;

// PAGE PRIVATE
defined("FILE_PAGE_PRIVATE_LOGOUT") !== true ? define("FILE_PAGE_PRIVATE_LOGOUT", DIR_PAGE_PRIVATE . "Logout.php") : null;
defined("FILE_PAGE_PRIVATE_SETTINGS") !== true ? define("FILE_PAGE_PRIVATE_SETTINGS", DIR_PAGE_PRIVATE . "Settings.php") : null;

// PAGE SHARED
defined("FILE_PAGE_SHARED_MAIN") !== true ? define("FILE_PAGE_SHARED_MAIN", DIR_PAGE_SHARED . "Main.php") : null;