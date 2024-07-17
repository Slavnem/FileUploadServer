<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Kernel Fonksiyonları
class KernelFunctions {
    // Verieln domain adresini isteğe göre http veya https yapmak
    protected static function DomainHttps(string $url, bool $https = true): string {
        // istenmeyen http:// https:// kısımlarını temizleme
        $url = str_replace("http:", "", strtolower($url));
        $url = str_replace("https:", "", strtolower($url));
        $url = str_replace("/", "", strtolower($url));

        // istenmeyen kısımlar temizlendikten sonra metinin başında http: https: eklemek
        $url = (($https == true) ? ("https://") : ("http://")) . $url;

        // düzenlenen url'yi döndür
        return strval($url);
    }

    // Verilen domain adresinin https desteklemesini kontrol etmek
    public static function FilterDomainHttps(string $url): bool {
        // url için domain uygunluğu kontrolü yapıyoruz
        return boolval(self::DomainHttps($url, filter_var($url, FILTER_VALIDATE_URL)));
    }

    // Verilen domain adı kontrol sonucu döndür
    public static function GetDomainHttps(string $url): string {
        // Doğrulama sonucuna göre http ya da https döndür
        return strval(self::DomainHttps($url, boolval(self::FilterDomainHttps($url))));
    }

    // Doya İçe Aktarıcı
    public static function FileImporter(array $files): bool {
        // Dizi boyutu kontrol
        if(empty($files) || count($files) < 1) {
            return false;
        }

        // tüm dosyaların varlığını kontrol etme
        foreach($files as $file) {
            if(file_exists($file) !== true) {
                return false;
            }
        }

        // tüm dosyalar olduğu için içe aktarma
        foreach($files as $file) {
            require $file;
        }

        return true;
    }
}