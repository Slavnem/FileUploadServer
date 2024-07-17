<?php
// Varlığı zorunlu olan şeyleri kontrol etme
// Eğer .php tarzı bir uzantı varsa
// dosyaya direk erişim yapılmaya çalışılıyor demektir
// bunu engellemeliyiz
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(Database::class)) !== true:
    case ((bool)class_exists(UsersStruct::class)) !== true:
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

class UsersGateway {
    private PDO $connection; // veritabanı bağalntısı için obje
    
    
    public function __construct(Database $database) {
        // Veritabanına bağalntı sağlama
        $this->connection = $database->getConnection();
    }

    // Verileri eşleşen kullanıcıyı getirtme
    public function GetPwdByUsername(string $username): ?string {
        // sorgu
        $sql = UsersStruct::$procedure0;

        // sorgu bağlantısı, parametre vermesi ve çalıştırması
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();

        // hiç veri bulunmadıysa
        if($stmt->rowCount() < 1) {
            return (null);
        }

        // veriyi tut
        $fetchdata = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // boşsa ver, null dönsün, değilse ilk dizisini alsın
        if(isset($fetchdata) !== true || empty($fetchdata)) {
            return (null);
        }

        // veriyi sadeleştir
        if(count($fetchdata) > 0) {
            $fetchdata = $fetchdata[0];
        }

        // şifreyi varsa döndürsün
        return (isset($fetchdata[UsersStruct::$column_password]) && empty($fetchdata[UsersStruct::$column_password]) !== true) ?
            (string)$fetchdata[UsersStruct::$column_password] : (null);
    }

    public function GetUser(string $username, string $password): ?array {
        // sorgu
        $sql = UsersStruct::$procedure0;

        // sorgu bağlantısı, parametre vermesi ve çalıştırması
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();

        // hiç veri bulunmadıysa
        if($stmt->rowCount() < 1) {
            return null;
        }

        // verileri al, hata oluşursa boş dön
        $stored = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

        // veri yoksa boş dönsün
        switch(true) {
            case (isset($stored) !== true):
            case (empty($stored)):
            case (isset($stored[UsersStruct::$column_password]) !== true):
            case (empty($stored[UsersStruct::$column_password])):
                return null;
        }

        // şifreyi al
        $hashpassword = $stored[UsersStruct::$column_password];
            
        // hashli şifre alınamadı, kullanıcı yok
        if(isset($hashpassword) !== true || empty($hashpassword)) {
            return null;
        }

        // kullanıcı uyuşma kontrolü
        switch(true) {
            case ($password === $hashpassword || password_verify($password, $hashpassword)):
                // kullanıcı uyuştu verileri döndür
                return (isset($stored) && empty($stored) !== true) ?
                    ((array)$stored) : (null);
        }

        // veriler uyuşmadı
        return null;
    }
}
?>