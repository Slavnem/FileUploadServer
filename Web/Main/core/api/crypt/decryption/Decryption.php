<?php
// JSON
header("Content-Type: application/json; charset=UTF-8");

// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(401);
        echo json_encode(401, JSON_UNESCAPED_UNICODE);
        exit; // sonlandır
}

echo json_encode("Cryptography -> Decryption", JSON_UNESCAPED_UNICODE);
exit;

// Şifreleme Algoritmaları Uzunluğu
defined("LENGTH_DECRYPTALGO") !== true ? define("LENGTH_DECRYPTALGO", 4): null;
defined("LENGTH_EXTRA") !== true ? define("LENGTH_EXTRA", 11): null;

// year decimal(percent): 3, month: 2, day: 2, hour: 2, minute: 2, algortihm: 4
defined("LENGTH_CRYPT") !== true ? define("LENGTH_CRYPT", (LENGTH_EXTRA + LENGTH_DECRYPTALGO)): null;

// Şifreleme Algoritmaları
defined("DECRYPTALGO_DEFAULT") !== true ? define("DECRYPTALGO_DEFAULT", "default"): null;
defined("DECRYPTALGO_USERNAME") !== true ? define("DECRYPTALGO_USERNAME", "username"): null;
defined("DECRYPTALGO_BASIC") !== true ? define("DECRYPTALGO_BASIC", "basic"): null;

// Şifrelenmek istenen veri türleri
defined("CRYPT_EXTRA") !== true ? define("CRYPT_EXTRA", (str_pad(substr(date("Y"), 2, 3), 3, "0") .(date("dmHi")))): null;
defined("CRYPT_DECRYPT") !== true ? define("CRYPT_DECRYPT", "decrypt"): null;

// Hata kodları
defined("ERRORCODE_CRYPT_NOPOSTED") !== true ? define("ERRORCODE_CRYPT_NOPOSTED", 99): null;
defined("ERRORCODE_CRYPT_NOPROCESS") !== true ? define("ERRORCODE_CRYPT_NOPROCESS", 100): null;
defined("ERRORCODE_CRYPT_NODATATYPE") !== true ? define("ERRORCODE_CRYPT_NODATATYPE", 101): null;
defined("ERRORCODE_CRYPT_EMPTYPARAM") !== true ? define("ERRORCODE_CRYPT_EMPTYPARAM", 102): null;

// Hata metinleri
defined("ERRORMSG_CRYPT_NOPOSTED") !== true ? define("ERRORMSG_CRYPT_NOPOSTED", "No Posted Data"): null;
defined("ERRORMSG_CRYPT_NOPROCESS") !== true ? define("ERRORMSG_CRYPT_NOPROCESS", "No Process Type"): null;
defined("ERRORMSG_CRYPT_NODATATYPE") !== true ? define("ERRORMSG_CRYPT_NODATATYPE", "No Data Type"): null;
defined("ERRORMSG_CRYPT_EMPTYPARAM") !== true ? define("ERRORMSG_CRYPT_EMPTYPARAM", "Empty Param"): null;

// Şifreleme Çözümleme
class Decryption {
    // Parametreler
    public static $paramData = "data";
    public static $paramEncrypted = "encrypted";
    public static $paramAlgorithm = "algorithm";

    // Karakter şifrelene numaraları
    protected static $charnum = [
        1 => "q", 2 => "w", 3 => "e" , 4 => "r", 5 => "t",
        6 => "y", 7 => "u", 8 => "ı", 9 => "o", 10 => "p",
        11 => "ğ" , 12 => "ü", 13 => "a", 14 => "s", 15 => "d",
        16 => "f" , 17 => "g", 18 => "h", 19 => "j", 20 => "k",
        21 => "l" , 22 => "ş", 23 => "i", 24 => "z", 25 => "x",
        26 => "c" , 27 => "v", 28 => "b", 29 => "n", 30 => "m",
        31 => "Q" , 32 => "W", 33 => "E", 34 => "R", 35 => "T",
        36 => "Y" , 37 => "U", 38 => "I", 39 => "O", 40 => "P",
        41 => "Ğ" , 42 => "Ü", 43 => "A", 44 => "S", 45 => "D",
        46 => "F" , 47 => "G", 48 => "H", 49 => "J", 50 => "K",
        51 => "L" , 52 => "Ş", 53 => "İ", 54 => "Z", 55 => "X",
        56 => "C" , 57 => "V", 58 => "B", 59 => "N", 60 => "M",
        61 => "!" , 62 => ">", 63 => "'", 64 => "£", 65 => "^",
        66 => "#" , 67 => "+", 68 => "$", 69 => "%", 70 => "½",
        71 => "&" , 72 => "¾", 73 => "/", 74 => "{", 75 => "(",
        76 => "[" , 77 => ")", 78 => "]", 79 => "=", 80 => "}",
        81 => "?" , 82 => "\"", 83 => "*", 84 => "-", 85 => "_",
        86 => "|" , 87 => "~", 88 => "¨", 89 => "`", 90 => ",",
        91 => ";" , 92 => "´", 93 => "˙", 94 => ".", 95 => ":",
        96 => "<" , 97 => "Â", 98 => "€", 99 => 0, 100 => 1,
        101 => 2, 102 => 3, 103 => 4, 104 => 5, 105 => 6, 106 => 7,
        107 => 8, 108 => 9, 109 => "ç", 110 => "Ç"
    ];

    // Şifreleme türleri
    protected static $algorithms = [
        DECRYPTALGO_DEFAULT => 1000,
        DECRYPTALGO_USERNAME => 1001,
        DECRYPTALGO_BASIC => 1002
    ];

    // Sürüme göre işlem
    public static function DecryptAlgo(string $encrypted, string $algorithm): string {
        // Eğer metin boş ise boş dönsün
        if(empty($algorithm) || empty($encrypted) || strlen($encrypted) < (LENGTH_CRYPT + 1)) {
            return null;
        }

        // Algoritma türü seçimi
        switch($algorithm) {
            case DECRYPTALGO_USERNAME: // kullanıcı adı (username)
                $algorithm = intval(self::$algorithms[DECRYPTALGO_USERNAME]);
            break;
            case DECRYPTALGO_BASIC: // basit şifreleme
                $algorithm = intval(self::$algorithms[DECRYPTALGO_BASIC]);
            break;
            default: // otomatik
                $algorithm = intval(self::$algorithms[DECRYPTALGO_DEFAULT]);
            break;
        }

        // Metinin şifreli veri kısımını almak
        $encrypted = substr($encrypted, LENGTH_CRYPT);

        // Şifreli metin uzunluğu
        $lengthEncryptedData = strlen($encrypted);

        // Algoritmaya göre çözüm yöntemi
        switch($algorithm) {
            // Basic için çözümleme
            case (self::$algorithms[DECRYPTALGO_BASIC]):
                // metinin uzunluğunu tutan kısımı tutacak
                $lengthDecrypt = 0;

                // döngü ile şifreli metinin şifrelenmeden önceki halininin
                // uzunluğunu tutan kısımını döngü ile almak
                for($lencount = 0; isset($encrypted[$lencount]); $lencount++) {
                    // değer al ve ekle
                    $lengthDecrypt = ($lengthDecrypt * 10) + intval($encrypted[$lencount]);   

                    // kontrol
                    if(isset($encrypted[$lencount + 1]) && isset($encrypted[$lencount + 2])) {
                        // sonraki tur 0 yani uzunluk sonu belirteci ve ondan sonraki değer
                        // 0'dan büyük yani bir şifreleme var, bu yüzden döngüyü kırıyoruz
                        if(intval($encrypted[$lencount + 1] == 0) && intval($encrypted[$lencount + 2]) > 0) {
                            break;
                        }
                    }                 
                }

                // şifrelenmiş kısımı kelimenin şifresiz halininin uzunluğu hesaplandıktan sonra
                // 0 ile sonlandırması olduğundan uzunluğuna 2 ekleyerek olan kısımdan sonraki ksımı al
                $encrypted = mb_substr($encrypted, ($lencount + 2));

                // çözülmüş şifre başlangıç olarak boş
                $testDecrypt = "";

                // ilk 3 basamağa kadar karakter desteği
                for($lettcount = 1; $lettcount < 3; $lettcount++) {
                    // çözülmüş şifre başlangıç olarak boş
                    $testDecrypt = "";

                    // sayı kısımını almak
                    $testNum = intval(mb_substr($encrypted, 0, $lettcount));

                    // eğer ilk karakter tek ise, bu bir 2 basamaklı sayıdır net olarak
                    if($testNum % 2 != 0) {
                        continue; // sonraki tura geçsin
                    }

                    // numaranın 2'ye bölümü ilk sayı için geçerli bir durum
                    $subNum = ($testNum / 2);

                    // sayının karşılık geldiği karakteri ekle
                    $testDecrypt .= strval(self::$charnum[$subNum]);

                    // kalan şifreli kısım
                    $nextCrypted = strval(mb_substr($encrypted, $lettcount));

                    // kalan şifreli kısımın uzunluğu
                    $lengthNext = intval(strlen($nextCrypted));

                    // kalan kısımdaki sayıları bulmak için ek sayaç
                    for($nextcount = 0, $notenough = 1; $nextcount < $lengthNext; $nextcount++) {
                        // eğer alınan sayı sonraki sayıdan çıkarıldığında
                        // nört ya da pozitif değilse bir sonraki sayı ile birlikte alsın
                        $checkNum = intval(mb_substr($nextCrypted, ($nextcount - ($notenough - 1)), $notenough));

                        // sayı geçici sayıdan küçük sonraki tura geç
                        if($checkNum < $subNum) {
                            $notenough++; // yetersiz basamak, bir basamak arttır
                            continue;
                        } else {
                            // basamak sayısını almayı başa sar
                            $notenough = 1;

                            // alt sayıyı ayarla
                            $subNum = $checkNum - $subNum;
                        }

                        // diziye alınan değeri ekle
                        // sayının karşılık geldiği karakteri ekle
                        $testDecrypt .= strval(self::$charnum[$subNum]);
                    }

                    // eğer şifresi çözülmüş metin ile metinin şifresiz halinin uzunluğu eşleşmiyorsa
                    // sonraki tura geçsin ama eşleşiyorsa döngüyü kırsın
                    if(strlen($testDecrypt) != $lengthDecrypt)
                        continue;
                    break;
                }

                // başarılı test sonucu olan değeri atamak
                $newDecrypt = $testDecrypt;
            break;
            // Algoritma geçersiz veya yok
            default:
                $newDecrypt = NULL;
            break;
        }

        // Çözülmüş veriyi döndürme
        return strval($newDecrypt);
    }
}

// Şifreli veri alma ve çözme
try {
    // URL
    $URL = substr(strtolower($_SERVER["REQUEST_URI"]), 1);

    // URL PARTS
    $ARR_URL = explode("/", $URL);

    // İşlem türü
    $PROCESSTYPE = isset($ARR_URL[2]) ? $ARR_URL[2] : (throw new Exception(ERRORMSG_CRYPT_NOPROCESS, ERRORCODE_CRYPT_EMPTYPARAM));

    // Otomatik olarak veri boş
    $DECRYPTED = NULL;

    // Post verileri alma
    $POSTDATA = json_decode(file_get_contents('php://input'), true);

    // Post verisi yoksa veri boş olsun ve try bloğunu atlasın
    if($POSTDATA == NULL) {
        throw new Exception(ERRORMSG_CRYPT_NOPOSTED, ERRORCODE_CRYPT_NOPOSTED);
    }

    // Parametreler
    $PARAMS = array(
        Decryption::$paramEncrypted => isset($POSTDATA[Decryption::$paramEncrypted]) ? $POSTDATA[Decryption::$paramEncrypted] : NULL,
        Decryption::$paramAlgorithm => isset($POSTDATA[Decryption::$paramAlgorithm]) ? $POSTDATA[Decryption::$paramAlgorithm] : NULL
    );

    // Yapılmak istenen işlem türüne göre
    switch($PROCESSTYPE) {
        case CRYPT_DECRYPT: // Şifreleme çözümleme
            // Şifre çözümleme için şifrelenmiş veri ve algoritma zorunlu
            if(empty($PARAMS[Decryption::$paramEncrypted]) || empty($PARAMS[Decryption::$paramAlgorithm])) {
                throw new Exception(ERRORMSG_CRYPT_EMPTYPARAM, ERRORCODE_CRYPT_EMPTYPARAM);
            }

            // Şifrelemek istenen veriyi türe göre algoritması ile şifreletme
            $DECRYPTED = [
                "algorithm" => strval($PARAMS[Decryption::$paramAlgorithm]),
                "encrypted" => strval($PARAMS[Decryption::$paramEncrypted]),
                "decrypted" => strval(Decryption::DecryptAlgo($PARAMS[Decryption::$paramEncrypted], $PARAMS[Decryption::$paramAlgorithm]))
            ];
        break;
    }
} catch(Exception $e) {
    $DECRYPTED = NULL;
} finally {
    // şifresi çözülmüş veriyi çıktı verme
    echo json_encode($DECRYPTED, JSON_UNESCAPED_UNICODE);
}

// Sayfa sonu
exit;