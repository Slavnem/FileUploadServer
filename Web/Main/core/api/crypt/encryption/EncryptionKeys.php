<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Şifreleme Algoritmaları
defined("ENCRYPTALGO_KEY_DEFAULT") !== true ? define("ENCRYPTALGO_KEY_DEFAULT", "default"): null;
defined("ENCRYPTALGO_KEY_USERNAME") !== true ? define("ENCRYPTALGO_KEY_USERNAME", "username"): null;
defined("ENCRYPTALGO_KEY_SIMPLE") !== true ? define("ENCRYPTALGO_KEY_SIMPLE", "simple"): null;

defined("ENCRYPTALGO_NUM_DEFAULT") !== true ? define("ENCRYPTALGO_NUM_DEFAULT", 1000): null;
defined("ENCRYPTALGO_NUM_USERNAME") !== true ? define("ENCRYPTALGO_NUM_USERNAME", 1001): null;
defined("ENCRYPTALGO_NUM_SIMPLE") !== true ? define("ENCRYPTALGO_NUM_SIMPLE", 1002): null;

// Şifreleme Anahtarları
class EncryptionKeys {
    // Karakter şifrelene numaraları
    protected static array $keyListDefault = [
        "q" => 1, "w" => 2, "e" => 3, "r" => 4, "t" => 5,
        "y" => 6, "u" => 7, "ı" => 8, "o" => 9, "p" => 10,
        "ğ" => 11, "ü" => 12, "a" => 13, "s" => 14, "d" => 15,
        "f" => 16, "g" => 17, "h" => 18, "j" => 19, "k" => 20,
        "l" => 21, "ş" => 22, "i" => 23, "z" => 24, "x" => 25,
        "c" => 26, "v" => 27, "b" => 28, "n" => 29, "m" => 30,
        "Q" => 31, "W" => 32, "E" => 33, "R" => 34, "T" => 35,
        "Y" => 36, "U" => 37, "I" => 38, "O" => 39, "P" => 40,
        "Ğ" => 41, "Ü" => 42, "A" => 43, "S" => 44, "D" => 45,
        "F" => 46, "G" => 47, "H" => 48, "J" => 49, "K" => 50,
        "L" => 51, "Ş" => 52, "İ" => 53, "Z" => 54, "X" => 55,
        "C" => 56, "V" => 57, "B" => 58, "N" => 59, "M" => 60,
        "!" => 61, ">" => 62, "'" => 63, "£" => 64, "^" => 65,
        "#" => 66, "+" => 67, "$" => 68, "%" => 69, "½" => 70,
        "&" => 71, "¾" => 72, "/" => 73, "{" => 74, "(" => 75,
        "[" => 76, ")" => 77, "]" => 78, "=" => 79, "}" => 80,
        "?" => 81, "\"" => 82, "*" => 83, "-" => 84, "_" => 85,
        "|" => 86, "~" => 87, "¨" => 88, "`" => 89, "," => 90,
        ";" => 91, "´" => 92, "˙" => 93, "." => 94, ":" => 95,
        "<" => 96, "Â" => 97, "€" => 98, 0 => 99, 1 => 100,
        2 => 101, 3 => 102, 4 => 103, 5 => 104, 6 => 105, 7 => 106,
        8 => 107, 9 => 108, "ç" => 109, "Ç" => 110
    ];

    // Şifreleme türleri numaraları
    protected static $encalgorithmsNum = [
        ENCRYPTALGO_KEY_DEFAULT => ENCRYPTALGO_NUM_DEFAULT,
        ENCRYPTALGO_KEY_USERNAME => ENCRYPTALGO_NUM_USERNAME,
        ENCRYPTALGO_KEY_SIMPLE => ENCRYPTALGO_NUM_SIMPLE
    ];

    // Şifreleme türleri isimleri
    protected static $encalgorithmsKey = [
        ENCRYPTALGO_NUM_DEFAULT => ENCRYPTALGO_KEY_DEFAULT,
        ENCRYPTALGO_NUM_USERNAME => ENCRYPTALGO_KEY_USERNAME,
        ENCRYPTALGO_NUM_SIMPLE => ENCRYPTALGO_KEY_SIMPLE
    ];

    // Şifreleme anahtar bilgilerini döndür
    public static function getEncKeyList(int|string $algorithmtype): array {
        switch($algorithmtype) {
            case (ENCRYPTALGO_KEY_DEFAULT):
            case (ENCRYPTALGO_NUM_DEFAULT):
                return (array)self::$keyListDefault;
            case (ENCRYPTALGO_KEY_USERNAME):
            case (ENCRYPTALGO_NUM_USERNAME):
                return (array)self::$keyListDefault;
            case (ENCRYPTALGO_KEY_SIMPLE):
            case (ENCRYPTALGO_NUM_SIMPLE):
                return (array)self::$keyListDefault;
        }

        return [];
    }

    // Şifreleme türü numarasını döndür
    public static function getEncAlgorithmNum($algorithmkey = null, bool $multialgorithm = false): int|array {
        // algoritma anahtarı verisini string türüne çevir
        $algorithmkey = (string)$algorithmkey;

        // depolanacak veri
        $stored = 0;

        switch(true) {
            case ((bool)$multialgorithm !== true):
                $stored = (isset(self::$encalgorithmsNum[$algorithmkey]) && (int)self::$encalgorithmsNum[$algorithmkey] > 0) ?
                    (int)self::$encalgorithmsNum[$algorithmkey] : (int)0;
            case ((bool)$multialgorithm):
                $stored = (isset(self::$encalgorithmsNum[$algorithmkey]) && (int)self::$encalgorithmsNum[$algorithmkey] > 0) ?
                    (int)self::$encalgorithmsNum[$algorithmkey] : (array)self::$encalgorithmsNum;
        }

        // eğer dizi ise dizi olarak değilse metin olarak dönsün
        return (is_array($stored)) ? (array)$stored : (int)$stored;
    }

    // Şifreleme türü metinini döndür
    public static function getEncAlgorithmKey($algorithmnum = 0, bool $multialgorithm = false): string|array {
        // algoritma numarası verisini int türüne çevir
        $algorithmnum = (int)$algorithmnum;

        // depolanacak veri
        $stored = null;

        switch(true) {
            case ((bool)$multialgorithm !== true):
                $stored = (isset(self::$encalgorithmsKey[$algorithmnum]) && strlen(self::$encalgorithmsKey[$algorithmnum]) > 0) ?
                    (string)self::$encalgorithmsKey[$algorithmnum] : (string)"";
            case ((bool)$multialgorithm):
                $stored = (isset(self::$encalgorithmsKey[$algorithmnum]) && strlen(self::$encalgorithmsKey[$algorithmnum]) > 0) ?
                    (string)self::$encalgorithmsKey[$algorithmnum] : (array)self::$encalgorithmsKey;
        }

        // eğer dizi ise dizi olarak değilse metin olarak dönsün
        return (is_array($stored)) ? (array)$stored : (string)$stored;
    }
}