<?php
// Tür dönüşümü engelleme
declare(strict_types = 1);

// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

defined("ERRORCODE_SESSIONNOTAVAILABLE") !== true ? define("ERRORCODE_SESSIONNOTAVAILABLE", 12): null;
defined("ERROR_SESSIONNOTAVAILABLE") !== true ? define("ERROR_SESSIONNOTAVAILABLE", "Session Not Available"): null;
defined("ERRORMSG_SESSIONNOTAVAILABLE") !== true ? define("ERRORMSG_SESSIONNOTAVAILABLE", "Session Not Available And Cannot Create New Session"): null;

// Kernel Sınıfı
class Kernel {
    // Doya İçe Aktarıcı
    public static function FileImporter(array $includeFile): bool {
        // Dizi boyutu kontrol
        if(empty($includeFile) || count($includeFile) < 1) {
            return false;
        }

        // tüm dosyaların varlığını kontrol etme
        foreach($includeFile as $file) {
            if(file_exists($file) !== true) {
                return false;
            }
        }

        // tüm dosyalar olduğu için içe aktarma
        foreach($includeFile as $file) {
            require $file;
        }

        return true;
    }
}

// Hata Kodları, Başlıkları, Mesajları
defined("ERRCODE_IMPORTFAIL") !== true ? define("ERRCODE_IMPORTFAIL", 1): null;
defined("ERRORCODE_SESSION_NOADMIN") !== true ? define("ERRORCODE_SESSION_NOADMIN", 1000): null;

defined("ERROR_IMPORTFAIL") !== true ? define("ERROR_IMPORTFAIL", "Import Fail"): null;
defined("ERROR_SESSION_NOADMIN") !== true ? define("ERROR_SESSION_NOADMIN", "Admin Error"): null;

defined("ERRORMSG_IMPORTFAIL") !== true ? define("ERRORMSG_IMPORTFAIL", "Files Couldn't Import Successfully"): null;
defined("ERRORMSG_SESSION_NOADMIN") !== true ? define("ERRORMSG_SESSION_NOADMIN", "Non Admin User"): null;

// Parametreler
defined("PARAM_ERRCODE") !== true ? define("PARAM_ERRCODE", "errcode"): null;
defined("PARAM_ERROR") !== true ? define("PARAM_ERROR", "error"): null;
defined("PARAM_ERRORMSG") !== true ? define("PARAM_ERRORMSG", "message"): null;

// İçe Aktarılacak Olan Dosyalar
$includeFile = [
    __DIR__ . "/RootTree.php", // Kök Ağaç Yapısı
    __DIR__ . "/KernelFunctions.php" // Çekirdek Fonksiyonları
];

// Sınıf fonksiyonu kontrolü
switch(true) {
    case ((bool)(class_exists(Kernel::class)) !== true):
        http_response_code(404); // http kodu
        header("Location: /error-client"); // http yönlendirme
        exit; // sonlandır
}

// Dosya içeri aktarma kontrolü
$importStatus = (bool)(Kernel::FileImporter($includeFile));

// Değişken yoketme
unset($includeFile);

// Sınıf fonksiyonu kontrolü
switch(true) {
    case ((bool)(class_exists(KernelFunctions::class)) !== true):
        http_response_code(404); // http kodu
        header("Location: /error-client"); // http yönlendirme
        exit; // sonlandır
}

// Kontrol durumu
switch($importStatus) {
    case true:
        unset($importStatus); // değişkeni temizlemek
        break; // başarılı
    default: // hata
        // Header JSON
        header("Content-Type: application/json; charset=UTF-8");

        echo json_encode([
            PARAM_ERRCODE => (int)defined("ERRCODE_IMPORTFAIL") ? ERRCODE_IMPORTFAIL : 1,
            PARAM_ERROR => (string)defined("ERROR_IMPORTFAIL") ? ERROR_IMPORTFAIL : "Import Fail",
            PARAM_ERRORMSG => (string)defined("ERRORMSG_IMPORTFAIL") ? ERRORMSG_IMPORTFAIL : "Files Couldn't Import Successfully"
        ], JSON_UNESCAPED_UNICODE);

        exit; // sonlandır
}

// Sayfa yönlendirme
$includeFileSession = [
    FILE_API_LOCAL_SESSION_STRUCT, // Oturum Yapısı
    FILE_API_LOCAL_SESSION_FUNCTIONS // Oturum İşlemleri
];

// Dosya içeri aktarma durumu
$statusImportSession = (bool)Kernel::FileImporter($includeFileSession);

// Başarsız dosya içe aktarımı
switch($statusImportSession) {
    case true:
        unset($includeFileSession);
        unset($statusImportSession);
        break;
    default: // hata
        http_response_code(404);
        header("Location: /error-client");
        exit;
}

// Oturum varlığı kontrolü
switch((bool)SessionFunctions::SessionAvailable() !== true) {
    case true:
        // Oturum zorla yoketsin ve yenisii oluştursun
        $preprocSessionDestroy = (bool)SessionFunctions::SessionDestroy(true);
        $preprocSessionNew = (bool)SessionFunctions::SessionNew();

        // Yeni oturum oluşturma başarısız ise eğer
        // geliştirici hata bilgilendirme sayfasına yönlendirsin
        switch(true) {
            case ($preprocSessionDestroy === true && $preprocSessionNew !== true):
            case ($preprocSessionNew !== true):
                // hata iletisi
                $sendError =
                    ("code=" . ERRORCODE_SESSIONNOTAVAILABLE) .
                    ("&title=" . ERROR_SESSIONNOTAVAILABLE) .
                    ("&message=" . ERRORMSG_SESSIONNOTAVAILABLE);

                http_response_code(900); // geliştirici kodu
                header("Location: /error/contact-to-developer?$sendError"); // geliştirici hata sayfası
                echo json_encode(null, JSON_UNESCAPED_UNICODE);
                exit; // sonlandırma
        }

        // Çekirdek oturum müdahelesi olan değişkenlerı kaldır
        unset($preprocSessionDestroy);
        unset($preprocSessionNew);
}

// Sayfa yönlendirici için
$includeFilePageRouter = [
    FILE_CORE_KERNEL_PAGEROUTER // Sayfa Yönlendirici
];

// Dosya içeri aktarma durumu
$statusImportPageRouter = (bool)Kernel::FileImporter($includeFilePageRouter);

// Değişken yoketme
unset($includeFilePageRouter);

// Başarsız dosya içe aktarımı
switch($statusImportPageRouter) {
    case true:
        unset($statusImportPageRouter);
        break;
    default: // hata
        http_response_code(404);
        header("Location: /error-client");
        exit;
}

// sonlandır
exit;