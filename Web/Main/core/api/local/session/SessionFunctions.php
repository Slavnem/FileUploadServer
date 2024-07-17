<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(SessionStruct::class) !== true):
    case ((bool)defined("API_USERS") !== true):
    case ((bool)defined("ROUTE_USERS") !== true):
    case ((bool)defined("PROCESS_USERS_FETCH") !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Hata Kodları, Başlıkları, Mesajları
defined("ERRCODE_NOTDEFINED_ID") !== true ? define("ERRCODE_NOTDEFINED_ID", 100): null;
defined("ERRCODE_NOTDEFINED_USERNAME") !== true ? define("ERRCODE_NOTDEFINED_USERNAME", 101): null;
defined("ERRCODE_NOTDEFINED_NAME") !== true ? define("ERRCODE_NOTDEFINED_NAME", 102): null;
defined("ERRCODE_NOTDEFINED_LASTNAME") !== true ? define("ERRCODE_NOTDEFINED_LASTNAME", 103): null;
defined("ERRCODE_NOTDEFINED_EMAIL") !== true ? define("ERRCODE_NOTDEFINED_EMAIL", 104): null;
defined("ERRCODE_NOTDEFINED_PASSWORD") !== true ? define("ERRCODE_NOTDEFINED_PASSWORD", 105): null;
defined("ERRCODE_NOTDEFINED_MEMBERID") !== true ? define("ERRCODE_NOTDEFINED_MEMBERID", 106): null;
defined("ERRCODE_NOTDEFINED_MEMBERNAME") !== true ? define("ERRCODE_NOTDEFINED_MEMBERNAME", 107): null;
defined("ERRCODE_NOTDEFINED_LANGUAGEID") !== true ? define("ERRCODE_NOTDEFINED_LANGUAGEID", 108): null;
defined("ERRCODE_NOTDEFINED_LANGUAGESHORT") !== true ? define("ERRCODE_NOTDEFINED_LANGUAGESHORT", 109): null;
defined("ERRCODE_NOTDEFINED_LANGUAGENAME") !== true ? define("ERRCODE_NOTDEFINED_LANGUAGENAME", 110): null;
defined("ERRCODE_NOTDEFINED_VERIFYID") !== true ? define("ERRCODE_NOTDEFINED_VERIFYID", 111): null;
defined("ERRCODE_NOTDEFINED_VERIFYNAME") !== true ? define("ERRCODE_NOTDEFINED_VERIFYNAME", 112): null;
defined("ERRCODE_NOTDEFINED_THEMEID") !== true ? define("ERRCODE_NOTDEFINED_THEMEID", 113): null;
defined("ERRCODE_NOTDEFINED_THEMENAME") !== true ? define("ERRCODE_NOTDEFINED_THEMENAME", 114): null;
defined("ERRCODE_NOTDEFINED_THEMEVALUE") !== true ? define("ERRCODE_NOTDEFINED_THEMEVALUE", 115): null;
defined("ERRCODE_NOTDEFINED_CREATED") !== true ? define("ERRCODE_NOTDEFINED_CREATED", 116): null;
defined("ERRCODE_NOTDEFINED_LOGIN") !== true ? define("ERRCODE_NOTDEFINED_LOGIN", 117): null;
defined("ERRCODE_NOTDEFINED_TIME") !== true ? define("ERRCODE_NOTDEFINED_TIME", 118): null;
defined("ERRCODE_NOTDEFINED_STATUS") !== true ? define("ERRCODE_NOTDEFINED_STATUS", 119): null;
defined("ERRCODE_NOTDEFINED_TOKEN") !== true ? define("ERRCODE_NOTDEFINED_TOKEN", 120): null;
defined("ERRCODE_NOTDEFINED_DATASTATUS_SUCCESS") !== true ? define("ERRCODE_NOTDEFINED_DATASTATUS_SUCCESS", 121): null;

defined("ERROR_NOTDEFINED_ID") !== true ? define("ERROR_NOTDEFINED_ID", "Id Not Defined"): null;
defined("ERROR_NOTDEFINED_USERNAME") !== true ? define("ERROR_NOTDEFINED_USERNAME", "Username Not Defined"): null;
defined("ERROR_NOTDEFINED_NAME") !== true ? define("ERROR_NOTDEFINED_NAME", "Name Not Defined"): null;
defined("ERROR_NOTDEFINED_LASTNAME") !== true ? define("ERROR_NOTDEFINED_LASTNAME", "Lastname Not Defined"): null;
defined("ERROR_NOTDEFINED_EMAIL") !== true ? define("ERROR_NOTDEFINED_EMAIL", "Email Not Defined"): null;
defined("ERROR_NOTDEFINED_PASSWORD") !== true ? define("ERROR_NOTDEFINED_PASSWORD", "Password Not Defined"): null;
defined("ERROR_NOTDEFINED_MEMBERID") !== true ? define("ERROR_NOTDEFINED_MEMBERID", "Member Id Not Defined"): null;
defined("ERROR_NOTDEFINED_MEMBERNAME") !== true ? define("ERROR_NOTDEFINED_MEMBERNAME", "Member Name Not Defined"): null;
defined("ERROR_NOTDEFINED_LANGUAGEID") !== true ? define("ERROR_NOTDEFINED_LANGUAGEID", "Language Id Not Defined"): null;
defined("ERROR_NOTDEFINED_LANGUAGESHORT") !== true ? define("ERROR_NOTDEFINED_LANGUAGESHORT", "Language Short Not Defined"): null;
defined("ERROR_NOTDEFINED_LANGUAGENAME") !== true ? define("ERROR_NOTDEFINED_LANGUAGENAME", "Language Name Not Defined"): null;
defined("ERROR_NOTDEFINED_VERIFYID") !== true ? define("ERROR_NOTDEFINED_VERIFYID", "Verify Id Not Defined"): null;
defined("ERROR_NOTDEFINED_VERIFYNAME") !== true ? define("ERROR_NOTDEFINED_VERIFYNAME", "Verify Name Not Defined"): null;
defined("ERROR_NOTDEFINED_THEMEID") !== true ? define("ERROR_NOTDEFINED_THEMEID", "Theme Id Not Defined"): null;
defined("ERROR_NOTDEFINED_THEMENAME") !== true ? define("ERROR_NOTDEFINED_THEMENAME", "Theme Name Not Defined"): null;
defined("ERROR_NOTDEFINED_THEMEVALUE") !== true ? define("ERROR_NOTDEFINED_THEMEVALUE", "Theme Value Not Defined"): null;
defined("ERROR_NOTDEFINED_CREATED") !== true ? define("ERROR_NOTDEFINED_CREATED", "Created Not Defined"): null;
defined("ERROR_NOTDEFINED_LOGIN") !== true ? define("ERROR_NOTDEFINED_LOGIN", "Login Not Defined"): null;
defined("ERROR_NOTDEFINED_TIME") !== true ? define("ERROR_NOTDEFINED_TIME", "Time Not Defined"): null;
defined("ERROR_NOTDEFINED_STATUS") !== true ? define("ERROR_NOTDEFINED_STATUS", "Status Not Defined"): null;
defined("ERROR_NOTDEFINED_TOKEN") !== true ? define("ERROR_NOTDEFINED_TOKEN", "Token Not Defined"): null;
defined("ERROR_NOTDEFINED_DATASTATUS_SUCCESS") !== true ? define("ERROR_NOTDEFINED_DATASTATUS_SUCCESS", "Status Not Defined"): null;

defined("ERRORMSG_NOTDEFINED_ID") !== true ? define("ERRORMSG_NOTDEFINED_ID", "Session Id Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_USERNAME") !== true ? define("ERRORMSG_NOTDEFINED_USERNAME", "Session Username Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_NAME") !== true ? define("ERRORMSG_NOTDEFINED_NAME", "Session Name Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_LASTNAME") !== true ? define("ERRORMSG_NOTDEFINED_LASTNAME", "Session Lastname Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_EMAIL") !== true ? define("ERRORMSG_NOTDEFINED_EMAIL", "Session Email Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_PASSWORD") !== true ? define("ERRORMSG_NOTDEFINED_PASSWORD", "Session Password Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_MEMBERID") !== true ? define("ERRORMSG_NOTDEFINED_MEMBERID", "Session Member Id Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_MEMBERNAME") !== true ? define("ERRORMSG_NOTDEFINED_MEMBERNAME", "Session Member Name Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_LANGUAGEID") !== true ? define("ERRORMSG_NOTDEFINED_LANGUAGEID", "Session Language Id Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_LANGUAGESHORT") !== true ? define("ERRORMSG_NOTDEFINED_LANGUAGESHORT", "Session Language Short Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_LANGUAGENAME") !== true ? define("ERRORMSG_NOTDEFINED_LANGUAGENAME", "Session Language Name Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_VERIFYID") !== true ? define("ERRORMSG_NOTDEFINED_VERIFYID", "Session Verify Id Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_VERIFYNAME") !== true ? define("ERRORMSG_NOTDEFINED_VERIFYNAME", "Session Verify Name Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_THEMEID") !== true ? define("ERRORMSG_NOTDEFINED_THEMEID", "Session Theme Id Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_THEMENAME") !== true ? define("ERRORMSG_NOTDEFINED_THEMENAME", "Session Theme Name Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_THEMEVALUE") !== true ? define("ERRORMSG_NOTDEFINED_THEMEVALUE", "Session Theme Value Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_CREATED") !== true ? define("ERRORMSG_NOTDEFINED_CREATED", "Session Created Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_LOGIN") !== true ? define("ERRORMSG_NOTDEFINED_LOGIN", "Session Login Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_TIME") !== true ? define("ERRORMSG_NOTDEFINED_TIME", "Session Time Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_STATUS") !== true ? define("ERRORMSG_NOTDEFINED_STATUS", "Session Status Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_TOKEN") !== true ? define("ERRORMSG_NOTDEFINED_TOKEN", "Session Token Not Defined"): null;
defined("ERRORMSG_NOTDEFINED_DATASTATUS_SUCCESS") !== true ? define("ERRORMSG_NOTDEFINED_DATASTATUS_SUCCESS", "Data Status Success Not Defined"): null;

// Methodlar
defined("METHOD_SECURE") !== true ? define("METHOD_SECURE", "SECURE"): null;
defined("METHOD_VISIBLE") !== true ? define("METHOD_VISIBLE", "VISIBLE"): null;

// Veri Doğrulama Numaralandırmaları
defined("ENUM_SESSION") !== true ? define("ENUM_SESSION", 1): null;
defined("ENUM_DATABASE") !== true ? define("ENUM_DATABASE", 2): null;

// Veri işlemek için parametreler
defined("PARAM_ROUTE") !== true ? define("PARAM_ROUTE", "route"): null;
defined("PARAM_PROCESS") !== true ? define("PARAM_PROCESS", "process"): null;
defined("PARAM_USERNAME") !== true ? define("PARAM_USERNAME", "username"): null;
defined("PARAM_PASSWORD") !== true ? define("PARAM_PASSWORD", "password"): null;

// Eğer hata dizisi boş değilse hataları göster ve sonlandır
switch(true) {
    case (defined("PARAM_ROUTE") !== true):
    case (defined("PARAM_PROCESS") !== true):
    case (defined("PARAM_USERNAME") !== true):
    case (defined("PARAM_PASSWORD") !== true):
        http_response_code(404); // http hata kodu
        header("Location: /error-client"); // hata sayfası
        exit; // sonlandırma
}

// Oturum İşlemlerini İçeren Sınıf
class SessionFunctions {
    // Oturum başlatıcı
    protected static function procSessionStarter(): bool {
        // Oturumu başlatma
        if(session_status() !== PHP_SESSION_ACTIVE && isset($_SESSION) !== true) {
            session_start();
        }

        return (bool)(session_status() === PHP_SESSION_ACTIVE);
    }

    // Oturum sonlandırıcı
    protected static function procSessionDestroyer(): bool {
        // Oturumu sonlandırma
        if(session_status() === PHP_SESSION_ACTIVE && isset($_SESSION) === true) {
            return session_destroy();
        }

        // Oturum zaten yok, yok edilemiyor
        return (false);
    }

    // Oturum durum kontrol edici
    protected static function procSessionStatusActive(): bool {
        // oturum aktifse true, değilse false döner
        return (session_status() === PHP_SESSION_ACTIVE);
    }

    // Oturum verisi dönüştürücü
    protected static function procSessionConverter(bool $convertToSession = true, array $dataList): ?array {
        // Döndürülecek olan verileri depolama için değişken
        $storeConverted = $dataList;

        switch($convertToSession) {
            case true: // Oturuma uyumlu hale döndür verileri
                // verileri kontrol et, zaten oturum verisi ise direk döndür
                switch(true) {
                    case (isset($dataList[SessionStruct::$session_id]) !== true):
                    case (isset($dataList[SessionStruct::$session_username]) !== true):
                    case (isset($dataList[SessionStruct::$session_name]) !== true):
                    case (isset($dataList[SessionStruct::$session_lastname]) !== true):
                    case (isset($dataList[SessionStruct::$session_email]) !== true):
                    case (isset($dataList[SessionStruct::$session_password]) !== true):
                    case (isset($dataList[SessionStruct::$session_memberid]) !== true):
                    case (isset($dataList[SessionStruct::$session_membername]) !== true):
                    case (isset($dataList[SessionStruct::$session_languageid]) !== true):
                    case (isset($dataList[SessionStruct::$session_languageshort]) !== true):
                    case (isset($dataList[SessionStruct::$session_languagename]) !== true):
                    case (isset($dataList[SessionStruct::$session_verifyid]) !== true):
                    case (isset($dataList[SessionStruct::$session_verifyname]) !== true):
                    case (isset($dataList[SessionStruct::$session_themeid]) !== true):
                    case (isset($dataList[SessionStruct::$session_themename]) !== true):
                    case (isset($dataList[SessionStruct::$session_themevalue]) !== true):
                    case (isset($dataList[SessionStruct::$session_created]) !== true):
                        $storeConverted = [
                            SessionStruct::$session_id => (int)isset($dataList[SessionStruct::$column_id]) ? $dataList[SessionStruct::$column_id] : -99,
                            SessionStruct::$session_username => (string)isset($dataList[SessionStruct::$column_username]) ? $dataList[SessionStruct::$column_username] : "",
                            SessionStruct::$session_name => (string)isset($dataList[SessionStruct::$column_name]) ? $dataList[SessionStruct::$column_name] : "",
                            SessionStruct::$session_lastname => (string)isset($dataList[SessionStruct::$column_lastname]) ? $dataList[SessionStruct::$column_lastname] : "",
                            SessionStruct::$session_email => (string)isset($dataList[SessionStruct::$column_email]) ? $dataList[SessionStruct::$column_email] : "",
                            SessionStruct::$session_password => (string)isset($dataList[SessionStruct::$column_password]) ? $dataList[SessionStruct::$column_password]: "",
                            SessionStruct::$session_memberid => (int)isset($dataList[SessionStruct::$column_memberid]) ? $dataList[SessionStruct::$column_memberid]: "",
                            SessionStruct::$session_membername => (string)isset($dataList[SessionStruct::$column_membername]) ? $dataList[SessionStruct::$column_membername]: "",
                            SessionStruct::$session_languageid => (int)isset($dataList[SessionStruct::$column_languageid]) ? $dataList[SessionStruct::$column_languageid]: -99,
                            SessionStruct::$session_languageshort => (string)isset($dataList[SessionStruct::$column_languageshort]) ? $dataList[SessionStruct::$column_languageshort]: "",
                            SessionStruct::$session_languagename => (string)isset($dataList[SessionStruct::$column_languagename]) ? $dataList[SessionStruct::$column_languagename]: "",
                            SessionStruct::$session_verifyid => (int)isset($dataList[SessionStruct::$column_verifyid]) ? $dataList[SessionStruct::$column_verifyid]: -99,
                            SessionStruct::$session_verifyname => (string)isset($dataList[SessionStruct::$column_verifyname]) ? $dataList[SessionStruct::$column_verifyname]: "",
                            SessionStruct::$session_themeid => (int)isset($dataList[SessionStruct::$column_themeid]) ? $dataList[SessionStruct::$column_themeid]: -99,
                            SessionStruct::$session_themename => (string)isset($dataList[SessionStruct::$column_themename]) ? $dataList[SessionStruct::$column_themename]: "",
                            SessionStruct::$session_themevalue => (string)isset($dataList[SessionStruct::$column_themevalue]) ? $dataList[SessionStruct::$column_themevalue]: "",
                            SessionStruct::$session_created => (string)isset($dataList[SessionStruct::$column_created]) ? $dataList[SessionStruct::$column_created]: ""
                        ];
                        break;
                    default:
                        $storeConverted = $dataList;
                }
                break;
            default: // Veritabanına uyumlu hale döndür verileri
                $storeConverted = [
                    SessionStruct::$column_id => (int)isset($dataList[SessionStruct::$session_id]) ? $dataList[SessionStruct::$session_id] : -99,
                    SessionStruct::$column_username => (string)isset($dataList[SessionStruct::$session_username]) ? $dataList[SessionStruct::$session_username] : "",
                    SessionStruct::$column_name => (string)isset($dataList[SessionStruct::$session_name]) ? $dataList[SessionStruct::$session_name] : "",
                    SessionStruct::$column_lastname => (string)isset($dataList[SessionStruct::$session_lastname]) ? $dataList[SessionStruct::$session_lastname] : "",
                    SessionStruct::$column_email => (string)isset($dataList[SessionStruct::$session_email]) ? $dataList[SessionStruct::$session_email] : "",
                    SessionStruct::$column_password => (string)isset($dataList[SessionStruct::$session_password]) ? $dataList[SessionStruct::$session_password]: "",
                    SessionStruct::$column_memberid => (int)isset($dataList[SessionStruct::$session_memberid]) ? $dataList[SessionStruct::$session_memberid]: "",
                    SessionStruct::$column_membername => (string)isset($dataList[SessionStruct::$session_membername]) ? $dataList[SessionStruct::$session_membername]: "",
                    SessionStruct::$column_languageid => (int)isset($dataList[SessionStruct::$session_languageid]) ? $dataList[SessionStruct::$session_languageid]: -99,
                    SessionStruct::$column_languageshort => (string)isset($dataList[SessionStruct::$session_languageshort]) ? $dataList[SessionStruct::$session_languageshort]: "",
                    SessionStruct::$column_languagename => (string)isset($dataList[SessionStruct::$session_languagename]) ? $dataList[SessionStruct::$session_languagename]: "",
                    SessionStruct::$column_verifyid => (int)isset($dataList[SessionStruct::$session_verifyid]) ? $dataList[SessionStruct::$session_verifyid]: -99,
                    SessionStruct::$column_verifyname => (string)isset($dataList[SessionStruct::$session_verifyname]) ? $dataList[SessionStruct::$session_verifyname]: "",
                    SessionStruct::$column_themeid => (int)isset($dataList[SessionStruct::$session_themeid]) ? $dataList[SessionStruct::$session_themeid]: -99,
                    SessionStruct::$column_themename => (string)isset($dataList[SessionStruct::$session_themename]) ? $dataList[SessionStruct::$session_themename]: "",
                    SessionStruct::$column_themevalue => (string)isset($dataList[SessionStruct::$session_themevalue]) ? $dataList[SessionStruct::$session_themevalue]: "",
                    SessionStruct::$column_created => (string)isset($dataList[SessionStruct::$session_created]) ? $dataList[SessionStruct::$session_created]: ""
                ];
        }

        // Döndürülmüş veriyi döndür
        return (array)(isset($storeConverted) && is_array($storeConverted) && count($storeConverted) > 0) ?
            ($storeConverted) : null;
    }

    // Temiz ve otomatik oturum verileri
    protected static function procSessionFreeData(): ?array {
        // Oluşturulan yeni oturum verilerini içeren diziye ait değerleri döndür
        return [
            SessionStruct::$session_id => (int)0,
            SessionStruct::$session_username => (string)null,
            SessionStruct::$session_name => (string)null,
            SessionStruct::$session_lastname => (string)null,
            SessionStruct::$session_email => (string)null,
            SessionStruct::$session_password => (string)null,
            SessionStruct::$session_memberid => (int)null,
            SessionStruct::$session_membername => (string)null,
            SessionStruct::$session_languageid => (int)1, // EN
            SessionStruct::$session_languageshort => (string)"en",// US
            SessionStruct::$session_languagename => (string)"English",// US
            SessionStruct::$session_verifyid => (int)null,
            SessionStruct::$session_verifyname => (string)null,
            SessionStruct::$session_themeid => (int)3, // auto
            SessionStruct::$session_themename => (string)"Auto", // auto
            SessionStruct::$session_themevalue => (string)"auto", // auto
            SessionStruct::$session_created => (string)null,
            SessionStruct::$session_login => (bool)false,
            SessionStruct::$session_time => (string)time(),
            SessionStruct::$session_status => (string)SessionStruct::$data_session_status_success,
            SessionStruct::$session_token => (string)"token-nan"
        ];
    }

    // Kullanıcı Bilgilerini Çevrimdışı Kontrol Etme
    protected static function procSessionOfflineVerify(array $sessiondatas = []): bool {
        // Oturumu başlatma
        if((bool)self::procSessionStarter() !== true) {
            return false;
        }

        // Varlığı zorunlu verilerden herhangi birisi yoksa
        // Direk oturumudan veri almayı denesin
        // Ama eğer veriler tamsa, işleme direk devam etsin
        switch(true) {
            case (bool)isset($sessiondatas[SessionStruct::$session_id]) !== true:
            case (bool)isset($sessiondatas[SessionStruct::$session_username]) !== true:
            case (bool)isset($sessiondatas[SessionStruct::$session_email])  !== true:
            case (bool)isset($sessiondatas[SessionStruct::$session_password]) !== true:
            case (bool)isset($sessiondatas[SessionStruct::$session_created]) !== true:
            case (bool)isset($sessiondatas[SessionStruct::$session_languageshort]) !== true:
            case (bool)isset($sessiondatas[SessionStruct::$session_memberid]) !== true:
            case (bool)isset($sessiondatas[SessionStruct::$session_languageid]) !== true:
            case (bool)isset($sessiondatas[SessionStruct::$session_verifyid]) !== true:
                // Oturum başlatıldı, oturum verilerini al
                $sessiondatas = $_SESSION;
        }

        // veriyi oturum verisi türüne çevir
        $converted = SessionFunctions::procSessionConverter(true, $sessiondatas);

        // verilerden herhangi birisi uygun değilse başarısız
        switch(true) {
            case (bool)isset($converted[SessionStruct::$session_id]) !== true || (int)$converted[SessionStruct::$session_id] < 1:
            case (bool)isset($converted[SessionStruct::$session_username]) !== true || empty($converted[SessionStruct::$session_username]):
            case (bool)isset($converted[SessionStruct::$session_email])  !== true || empty($converted[SessionStruct::$session_email]):
            case (bool)isset($converted[SessionStruct::$session_password]) !== true || empty($converted[SessionStruct::$session_password]):
            case (bool)isset($converted[SessionStruct::$session_created]) !== true || empty($converted[SessionStruct::$session_created]):
            case (bool)isset($converted[SessionStruct::$session_languageshort]) !== true || empty($converted[SessionStruct::$session_languageshort]):
            case (bool)isset($converted[SessionStruct::$session_memberid]) !== true || (int)$converted[SessionStruct::$session_memberid] < 0:
            case (bool)isset($converted[SessionStruct::$session_languageid]) !== true ||(int)$converted[SessionStruct::$session_languageid] < 1:
            case (bool)isset($converted[SessionStruct::$session_verifyid]) !== true || ((int)$converted[SessionStruct::$session_verifyid]) < 0:
                return false;
        }

        // veriler doğru
        return true;
    }

    // Oturum Değişkenleri Varlığı Kontrolü
    protected static function procSessionAvailable(): bool {
        // Oturumu başlatma
        if((bool)self::procSessionStarter() !== true) {
            return false;
        }

        // değişkenlerden herhangi birisi yoksa hatalıdır
        switch(true) {
            case (bool)isset($_SESSION[SessionStruct::$session_id]) !== true:
            case (bool)isset($_SESSION[SessionStruct::$session_username]) !== true:
            case (bool)isset($_SESSION[SessionStruct::$session_email])  !== true:
            case (bool)isset($_SESSION[SessionStruct::$session_password]) !== true:
            case (bool)isset($_SESSION[SessionStruct::$session_created]) !== true:
            case (bool)isset($_SESSION[SessionStruct::$session_languageshort]) !== true:
            case (bool)isset($_SESSION[SessionStruct::$session_memberid]) !== true:
            case (bool)isset($_SESSION[SessionStruct::$session_languageid]) !== true:
            case (bool)isset($_SESSION[SessionStruct::$session_verifyid]) !== true:
                return false;
        }

        // Oturum var
        return true;
    }

    // Kullanıcı veritabanı bilgilerini alma
    protected static function procSessionUserData(array $sessiondatas = []): ?array {
        // Oturumu başlatma
        if((bool)self::procSessionStarter() !== true) {
            return null;
        }

        // Gönderilecek veri
        $sendParam = [
            SessionStruct::$session_username => null,
            SessionStruct::$session_password => null
        ];

        // parametreler için kontrol
        // basit şekilde kullanıcı bilgilerini kontrol etmek
        switch(true) {
            case (isset($sessiondatas[SessionStruct::$session_username])|| empty($sessiondatas[SessionStruct::$session_username]) !== true):
            case (isset($sessiondatas[SessionStruct::$session_password])|| empty($sessiondatas[SessionStruct::$session_password]) !== true):
                $sendParam[SessionStruct::$session_username] = (string)$sessiondatas[SessionStruct::$session_username];
                $sendParam[SessionStruct::$session_password] = (string)$sessiondatas[SessionStruct::$session_password];
                break;
            default:
                // Kullanıcı adı ve şifreyi oturumdan almak
                $tempUsername = (isset($_SESSION[SessionStruct::$session_username]) && empty(SessionStruct::$session_username) !== true) ? ($_SESSION[SessionStruct::$session_username]) : null;
                $tempPassword = (isset($_SESSION[SessionStruct::$session_password]) && empty(SessionStruct::$session_password) !== true) ? ($_SESSION[SessionStruct::$session_password]) : null;

                $sendParam[SessionStruct::$session_username] = (isset($tempUsername) ? (string)$tempUsername : null);
                $sendParam[SessionStruct::$session_password] = (isset($tempPassword) ? (string)$tempPassword : null);

                // Geçici değişkenleri yoket
                unset($tempUsername);
                unset($tempPassword);
        }

        // sorgu bilgilerini parametre de saklama
        $queryParams = [
            PARAM_ROUTE => ROUTE_USERS,
            PARAM_PROCESS => PROCESS_USERS_FETCH,
            PARAM_USERNAME => (string)isset($sendParam[SessionStruct::$session_username]) ? ($sendParam[SessionStruct::$session_username]) : null,
            PARAM_PASSWORD => (string)isset($sendParam[SessionStruct::$session_password]) ? ($sendParam[SessionStruct::$session_password]) : null
        ];

        // Bağlantı adresi
        $queryUrl = API_USERS;

        // Bağlantı oluşturma
        $curl = curl_init();

        // bağlantı ayarları
        curl_setopt_array($curl, [
            CURLOPT_SSL_VERIFYPEER => false, // ssl doğrulaması kapatma
            CURLOPT_SSL_VERIFYHOST => false, // ssl doğrulaması kapatma
            CURLOPT_URL => $queryUrl, // url adresini tanımlatma
            CURLOPT_CUSTOMREQUEST => METHOD_SECURE, // post sorgusu için
            CURLOPT_POSTFIELDS => json_encode($queryParams, JSON_UNESCAPED_UNICODE), // post veri parametreleri
            CURLOPT_RETURNTRANSFER => 1, // veri dönüşü sağlama
            CURLOPT_HTTPHEADER => array('Content-Type: application/json; charset=UTF-8')
        ]);
    
        // işlemi gerçekleştir
        $response = curl_exec($curl);

        // Bağlantıyı kapat
        curl_close($curl);

        // Gelen json objesini çözüyoruz
        $data = (array)json_decode($response);

        // dizi değilse ya da boşsa işleme devam edilmesin
        if(is_array($data) !== true || count($data) < 1) {
            return null;
        }

        // Verileri çevirmeye ihtiyaç yok, verileri döndürsün
        if((bool)SessionFunctions::procSessionOfflineVerify($data) !== true) {
            return (array)$data;
        }

        // Alınan verileri oturum verisine çevir
        $converted = SessionFunctions::procSessionConverter(true, $data);

        // Dönüştürülmüş oturum verilerinin doğruluğunu kontrol et
        $verifydata = (bool)SessionFunctions::procSessionOfflineVerify($converted);

        // Veriler ve işlemler doğru, oturuma kaydedilmesi gereken şekilde getir
        return ($verifydata !== true) ? [] : [
            SessionStruct::$session_id => (int)$converted[SessionStruct::$session_id],
            SessionStruct::$session_username => (string)$converted[SessionStruct::$session_username],
            SessionStruct::$session_name => (string)$converted[SessionStruct::$session_name],
            SessionStruct::$session_lastname => (string)$converted[SessionStruct::$session_lastname],
            SessionStruct::$session_email => (string)$converted[SessionStruct::$session_email],
            SessionStruct::$session_password => (string)$converted[SessionStruct::$session_password],
            SessionStruct::$session_memberid => (int)$converted[SessionStruct::$session_memberid],
            SessionStruct::$session_membername => (string)$converted[SessionStruct::$session_membername],
            SessionStruct::$session_languageid => (int)$converted[SessionStruct::$session_languageid],
            SessionStruct::$session_languageshort => (string)$converted[SessionStruct::$session_languageshort],
            SessionStruct::$session_languagename => (string)$converted[SessionStruct::$session_languagename],
            SessionStruct::$session_verifyid => (int)$converted[SessionStruct::$session_verifyid],
            SessionStruct::$session_verifyname => (string)$converted[SessionStruct::$session_verifyname],
            SessionStruct::$session_themeid => (int)$converted[SessionStruct::$session_themeid],
            SessionStruct::$session_themename => (string)$converted[SessionStruct::$session_themename],
            SessionStruct::$session_themevalue => (string)$converted[SessionStruct::$session_themevalue],
            SessionStruct::$session_created => (string)$converted[SessionStruct::$session_created],
            SessionStruct::$session_login => (bool)true,
            SessionStruct::$session_time => (string)date('Y-m-d-H-i-s'),
            SessionStruct::$session_status => (string)SessionStruct::$data_session_status_success,
            SessionStruct::$session_token => (string)"token-enabled"
        ];
    }

    // Oturum Rütbe Durum Kontrolcüsü
    protected static function procSessionRank(int $ranknum = 0): bool {
        // Oturuma ait kullanıcı verilerini alma
        $sessionData = (array)self::procSessionUserData();

        // Oturum bilgilerini ve rütbe değerini tutan bölümü
        // yerel şekilde kontrol etmek
        switch(true) {
            case ((bool)self::procSessionOfflineVerify($sessionData) !== true):
            case ((bool)isset($sessionData[SessionStruct::$session_memberid]) !== true):
                return false;
        }

        // istenilen rütbe ile uyuşuyorsa sorun yok
        return (
            isset($sessionData[SessionStruct::$session_memberid]) &&
            (int)$sessionData[SessionStruct::$session_memberid] === (int)$ranknum
        );
    }

    // Yeni Oturum Oluşturma
    public static function SessionNew(array $sessiondatas = [], int $lifeTime = 86400): bool {
        // Oturum başlatma başarısız ise, yeni oturum oluşturma yapılamaz
        if((bool)self::procSessionStarter() !== true) {
            // Oturum çerezini oluştururken SameSite özelliğini belirleme
            session_set_cookie_params([
                'lifetime' => ((int)$lifeTime),
                'path' => ('/'),
                'domain' => ('.' . $_SERVER['HTTP_HOST']), // sunucunun tüm alt sayfalarında geçerli
                'secure' => (true), // https
                'httponly' => (true),
                'samesite' => ('Strict') // Strict, 3.parti erişim engeli
            ]);

            // oturumu başlat
            session_start();

            // yeni oturum kimliği
            session_regenerate_id(true);
        }

        // Eğer oturum bilgileri yoksa kendisi oturum bilgisi oluştursun
        switch(true) {
            case (is_array($sessiondatas) !== true):
            case (count($sessiondatas) < 1):
            case ((bool)SessionFunctions::procSessionOfflineVerify($sessiondatas) !== true):
                $_SESSION = (array)self::procSessionFreeData();
                break;
            default: // olan veriler ile oturumu yeni oluştur
                // Verileri dönüştür
                $converted = (self::procSessionConverter(true, $sessiondatas));

                // eğer veri verilmişse ve uygun değilse oturum oluşturma başarısız
                if(is_array($converted) !== true || count($converted) < 1) {
                    return false;
                }

                $_SESSION = (array)$converted;
        }

        // Oturuma veri yazmayı kapatma
        session_write_close();
        return true;
    }

    // Oturum Doğrulama
    public static function SessionVerify(array $sessiondatas = []): bool {
        // Oturumu başlatma
        if((bool)self::procSessionStarter() !== true) {
            return false;
        }

        // Gönderilecek veri
        $sendParam = [
            SessionStruct::$session_username => null,
            SessionStruct::$session_password => null
        ];

        // parametreler için kontrol
        // basit şekilde kullanıcı bilgilerini kontrol etmek
        switch(true) {
            case (isset($sessiondatas[SessionStruct::$session_password])|| empty($sessiondatas[SessionStruct::$session_password]) !== true):
                $sendParam[SessionStruct::$session_username] = (string)$sessiondatas[SessionStruct::$session_username];
                $sendParam[SessionStruct::$session_password] = (string)$sessiondatas[SessionStruct::$session_password];    
            break;
            default:
                // Kullanıcı adı ve şifreyi oturumdan almak
                $tempUsername = (isset($_SESSION[SessionStruct::$session_username]) && empty(SessionStruct::$session_username) !== true) ? ($_SESSION[SessionStruct::$session_username]) : null;
                $tempPassword = (isset($_SESSION[SessionStruct::$session_password]) && empty(SessionStruct::$session_password) !== true) ? ($_SESSION[SessionStruct::$session_password]) : null;

                $sendParam[SessionStruct::$session_username] = (isset($tempUsername) ? (string)$tempUsername : null);
                $sendParam[SessionStruct::$session_password] = (isset($tempPassword) ? (string)$tempPassword : null);

                // Geçici değişkenleri yoket
                unset($tempUsername);
                unset($tempPassword);
        }

        // Kullanıcı verisini al
        $getUserdata = (array)self::procSessionUserData($sendParam);

        // Alınan veriyi oturum verisine dönüştür
        $convertedUserdata = (array)self::procSessionConverter(true, $getUserdata);

        // Dönüştürülmüş verinin doğruluğunu kontrol etmek
        if(isset($convertedUserdata) !== true || (bool)self::procSessionOfflineVerify($convertedUserdata) !== true) {
            // dönüştürülmüş veri uyumsuz
            return false;
        }

        // Oturum doğrulaması başarılı
        return true;
    }

    // Oturum Güncelle
    public static function SessionUpdate(array $sessiondatas = []): bool {
        // Oturumu başlatma
        if((bool)self::procSessionStarter() !== true) {
            return false;
        }

        // Gönderilecek veri
        $sendParam = [
            SessionStruct::$session_username => null,
            SessionStruct::$session_password => null
        ];

        // parametreler için kontrol
        // basit şekilde kullanıcı bilgilerini kontrol etmek
        switch(true) {
            case (isset($sessiondatas[SessionStruct::$session_password])|| empty($sessiondatas[SessionStruct::$session_password]) !== true):
                $sendParam[SessionStruct::$session_username] = (string)$sessiondatas[SessionStruct::$session_username];
                $sendParam[SessionStruct::$session_password] = (string)$sessiondatas[SessionStruct::$session_password];    
            break;
            default:
                // Kullanıcı adı ve şifreyi oturumdan almak
                $tempUsername = (isset($_SESSION[SessionStruct::$session_username]) && empty(SessionStruct::$session_username) !== true) ?
                    ($_SESSION[SessionStruct::$session_username]) : null;

                $tempPassword = (isset($_SESSION[SessionStruct::$session_password]) && empty(SessionStruct::$session_password) !== true) ?
                    ($_SESSION[SessionStruct::$session_password]) : null;

                $sendParam[SessionStruct::$session_username] = (isset($tempUsername) ? (string)$tempUsername : null);
                $sendParam[SessionStruct::$session_password] = (isset($tempPassword) ? (string)$tempPassword : null);

                // Geçici değişkenleri yoket
                unset($tempUsername);
                unset($tempPassword);
        }

        // Kullanıcı verisini al
        $getUserdata = (array)self::procSessionUserData($sendParam);

        // Alınan veriyi oturum verisine dönüştür
        $convertedUserdata = (array)self::procSessionConverter(true, $getUserdata);

        // Dönüştürülmüş verinin doğruluğunu kontrol etmek
        if(isset($convertedUserdata) !== true || (bool)self::procSessionOfflineVerify($convertedUserdata) !== true) {
            // dönüştürülmüş veri uyumsuz
            return false;
        }

        // Dönüştürülmüş verileri oturuma işlemek
        $_SESSION = (isset($convertedUserdata) && count($convertedUserdata) > 0) ? (array)$convertedUserdata : [];

        // Oturum güncelleme başarılı
        session_write_close(); // oturuma veri yazmayı kapatma
        return true;
    }

    // Oturum Yokedici
    public static function SessionDestroy(bool $forceDestroy = false): bool {
        return ((bool)self::procSessionDestroyer());
    }

    // Oturum verilerini getir
    public static function SessionFetch(): ?array {
        // Oturumu başlatma
        if((bool)self::procSessionStarter() !== true) {
            return null;
        }

        // Oturum verisini döndür
        return (isset($_SESSION) && count($_SESSION) > 0) ?
            ((array)$_SESSION) : (null);
    }

    // Admin Kontrol
    public static function SessionAdmin(): bool {
        // rütbe numarası
        if(isset(SessionStruct::$value_session_admin) !== true) {
            return false;
        }

        // admin numarası ile kontrol
        return ((bool)self::procSessionRank((int)SessionStruct::$value_session_admin));
    }

    // Moderator Kontrol
    public static function SessionModerator(): bool {
        // rütbe numarası
        if(isset(SessionStruct::$value_session_moderator) !== true) {
            return false;
        }

        // admin numarası ile kontrol
        return ((bool)self::procSessionRank((int)SessionStruct::$value_session_moderator));
    }

    // Oturumun Olup Olmadığını Çevrim Dışı Kontrol Edicek
    public static function SessionAvailable(): bool {
        return ((bool)self::procSessionAvailable());
    }
}