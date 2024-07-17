<?php
// Varlığı zorunlu olan şeyleri kontrol etme
// Eğer .php tarzı bir uzantı varsa
// dosyaya direk erişim yapılmaya çalışılıyor demektir
// bunu engellemeliyiz
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(UsersGateway::class)) !== true:
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

class UsersController {
    public function __construct(private UsersGateway $gateway) {}

    public function UserVerify(string $username, string $password): bool {
        $hashpassword = $this->gateway->GetPwdByUsername($username);
        
        // Kullanıcı şifresi alınamadı
        if(!$hashpassword || $hashpassword == null || strlen($hashpassword) <= 1) {
            return false;
        }

        // doğrulama sonucunu döndür
        return (bool)($password === $hashpassword || password_verify($password, $hashpassword));
    }

    public function UserData(string $username, string $password): ?array {
        return (array)($this->gateway->GetUser($username, $password));
    }
}
?>