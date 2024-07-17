<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(EncryptionKeys::class) !== true):
    case ((bool)defined("ENCRYPTALGO_KEY_DEFAULT") !== true):
    case ((bool)defined("ENCRYPTALGO_KEY_USERNAME") !== true):
    case ((bool)defined("ENCRYPTALGO_KEY_SIMPLE") !== true):
    case ((bool)defined("ENCRYPTALGO_NUM_DEFAULT") !== true):
    case ((bool)defined("ENCRYPTALGO_NUM_USERNAME") !== true):
    case ((bool)defined("ENCRYPTALGO_NUM_SIMPLE") !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Şuanki zaman
defined("TIMENOW") !== true ? define("TIMENOW", (str_pad(substr(date("Y"), 2, 3), 3, "0") . (date("dmHi")))): null;

// Şifreleme Fonksiyonlarını İçeren Sınıf
class EncryptionFunctions {
    // Şifrelemeye dair bilgiler
    protected static int $default_algo_length_encryptalgo = 4;
    protected static int $default_algo_length_extra = 11;
    protected static int $default_algo_length_crypt = (11 + 4);

    // Veri Şifreleme
    public static function EncryptAlgo(string|int $algorithm = null|0, string $basetext): string|null {
        // Eğer metin boş ise boş dönsün
        if(strlen($basetext) < 1) {
            return null;
        }

        // Şifreleme türüne göre işlem
        switch($algorithm) {
            case ENCRYPTALGO_KEY_USERNAME: // kullanıcı adı (username)
            case ENCRYPTALGO_NUM_USERNAME:
                // Şifreleme anahtarları
                $cryptKeys = EncryptionKeys::getEncKeyList(ENCRYPTALGO_KEY_USERNAME);

                // Yeni şifreleme
                $newEncrypt = (string)((int)$algorithm . TIMENOW);

                // Metin uzunluğu
                $lengthData = strlen($basetext);

                // kendisiyle toplayarak başla
                $newEncrypt .= (string)((int)$cryptKeys[mb_substr($basetext, 0, 1)] + (int)$cryptKeys[mb_substr($basetext, 0, 1)]);
                    
                // Döngü ile veri bitene kadar şifreleme
                for($count = 1; $count < $lengthData; $count++) {
                    $newEncrypt .= (string)((int)$cryptKeys[mb_substr($basetext, ($count - 1), 1)] + (int)$cryptKeys[mb_substr($basetext, $count, 1)]);
                }
            break;
            case ENCRYPTALGO_KEY_SIMPLE: // basit şifreleme
            case ENCRYPTALGO_NUM_SIMPLE:
            default:
                // Şifreleme anahtarları
                $cryptKeys = EncryptionKeys::getEncKeyList(ENCRYPTALGO_KEY_USERNAME);

                // Yeni şifreleme
                $newEncrypt = (string)((int)$algorithm . TIMENOW);

                // Metin uzunluğu
                $lengthData = strlen($basetext);

                // metini şifrelemeye başlamadan önceki sayı metinin uzunluğunu temsil eder
                $newEncrypt .= (int)$lengthData;

                // 0 ise bu uzunluğun sonunu temsil eder
                $newEncrypt .= 0;

                // kendisiyle toplayarak başla
                $newEncrypt .= (string)((int)$cryptKeys[mb_substr($basetext, 0, 1)] + (int)$cryptKeys[mb_substr($basetext, 0, 1)]);
                    
                // Döngü ile veri bitene kadar şifreleme
                for($count = 1; $count < $lengthData; $count++) {
                    $newEncrypt .= (string)((int)$cryptKeys[mb_substr($basetext, ($count - 1), 1)] + (int)$cryptKeys[mb_substr($basetext, $count, 1)]);
                }
            break;
        }

       // şifrelenmiş veriyi döndürmek
       return (string)$newEncrypt;
    }

    // Veri ve Şifreleme Doğrulama
    public static function EncryptVerify(string|int $algorithm = null|0, string $basetext, string $encrypted): bool {
        // Veri boş ise geçersiz dönmeli
        if(empty($basetext) || empty($encrypted)) {
            return false;
        }

        // Şifreleme algoritması uyuşuyorsa devam, uyuşmuyosa başarısız
        // bir algoritma türü zorunlu, otomatik(default) bile olsa
        switch(true) {
            case (count((array)EncryptionKeys::getEncAlgorithmKey($algorithm)) > 0):
            case ((int)EncryptionKeys::getEncAlgorithmNum($algorithm) > 0):
                break; // sorun yok
            default: return false; // hatalı
        }
        
        // Veriyi şifreleyip almak
        $basetextEncrypted = (string)EncryptionFunctions::EncryptAlgo($algorithm, $basetext);
        
        // Algoritmaya göre işlem
        switch($algorithm) {
            case ENCRYPTALGO_KEY_USERNAME: // kullanıcı adı (username)
            case ENCRYPTALGO_NUM_USERNAME:
            case ENCRYPTALGO_KEY_SIMPLE: // basit şifreleme
            case ENCRYPTALGO_NUM_SIMPLE:
            default:
                // Verinin algoritma kısımı ile şifreli kısımını ayırmak
                $basetextAlgorithm = mb_substr($basetextEncrypted, 0, (int)self::$default_algo_length_encryptalgo);
                $basetextEncrypted = mb_substr($basetextEncrypted, (int)self::$default_algo_length_crypt);

                // Şifreli verinin algoritma kısımı ile şifreli kısımını ayırmak
                $encryptedAlgorithm = mb_substr($encrypted, 0, (int)self::$default_algo_length_encryptalgo);
                $encryptedEncrypted = mb_substr($encrypted, (int)self::$default_algo_length_crypt);

                // Algoritma türlerini ve değerlerini değişken türleri
                // dahil olacak şekilde karşılaştırıp sonucu döndürüyoruz
                return (bool)(($basetextAlgorithm === $encryptedAlgorithm) && ($basetextEncrypted === $encryptedEncrypted));
        }
    }

    // İstenileni Verileri Almak
    public static function EncryptKeyFetch(string|int $encryptkey = null): int|string|array|null {
        // türüne göre işlem yapılmalı
        switch(true) {
            case (is_string($encryptkey)):
                return (strlen($encryptkey) < 1) ?
                    (EncryptionKeys::getEncAlgorithmNum(0, true)):
                    (EncryptionKeys::getEncAlgorithmNum($encryptkey, false));
            case (is_int($encryptkey)):
                return ((int)$encryptkey > 0) ?
                    (EncryptionKeys::getEncAlgorithmKey($encryptkey, false)):
                    (EncryptionKeys::getEncAlgorithmKey(0, true));
        }

        // belirli bir türde değil
        // anahtar verilerini döndürsün
        return (EncryptionKeys::getEncAlgorithmKey(null, true));
    }
}