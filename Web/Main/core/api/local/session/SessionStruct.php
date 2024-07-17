<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Kullanıcı doğrulaması için bağalntı sağlayacağımız url
defined("API_USERS") !== true ? define("API_USERS", ($_SERVER['HTTP_HOST'] . "/sapi")): null;
defined("ROUTE_USERS") !== true ? define("ROUTE_USERS", "users"): null;
defined("PROCESS_USERS_FETCH") !== true ? define("PROCESS_USERS_FETCH", "fetch"): null;

class SessionStruct {
    // Veritabanı tablosu
    public static string $column_id = "usersId";
    public static string $column_username = "usersUsername";
    public static string $column_name = "usersName";
    public static string $column_lastname = "usersLastname";

    public static string $column_email = "usersEmail";
    public static string $column_password = "usersPassword";
    public static string $column_memberid = "usersMemberid";
    public static string $column_membername = "membershipName";
    public static string $column_languageid = "usersLanguageid";
    public static string $column_languageshort = "languagesShort";
    public static string $column_languagename = "languagesName";
    public static string $column_verifyid = "usersVerifyid";
    public static string $column_verifyname = "verifyName";
    public static string $column_themeid = "usersThemeid";
    public static string $column_themename = "themeName";
    public static string $column_themevalue = "themeValue";
    public static string $column_created = "usersCreated";

    // Parametreler
    public static string $param_process = "process";
    public static string $param_username = "username";
    public static string $param_password = "password";


    // Oturum verileri
    public static string $data_session_status_success = "active";
    public static string $data_session_status_fail = "fail";

    // Oturum değişkenleri
    public static int $value_session_admin = 99;
    public static int $value_session_moderator = 98;

    public static string $session_id = "session_id";
    public static string $session_username = "session_username";
    public static string $session_name = "session_name";
    public static string $session_lastname = "session_lastname";
    public static string $session_email = "session_email";
    public static string $session_password = "session_password";
    public static string $session_memberid = "session_memberid";
    public static string $session_membername = "session_membername";
    public static string $session_languageid = "session_languageid";
    public static string $session_languageshort = "session_languageshort";
    public static string $session_languagename = "session_languagename";
    public static string $session_verifyid = "session_verifyid";
    public static string $session_verifyname = "session_verifyname";
    public static string $session_themeid = "session_themeid";

    public static string $session_themename = "session_themename";
    public static string $session_themevalue = "session_themevalue";
    public static string $session_created = "session_created";
    public static string $session_login = "session_login";
    public static string $session_time = "session_time";
    public static string $session_status = "session_status";
    public static string $session_token = "session_token";
}