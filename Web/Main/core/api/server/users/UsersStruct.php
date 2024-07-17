<?php
// Varlığı zorunlu olan şeyleri kontrol etme
// Eğer .php tarzı bir uzantı varsa
// dosyaya direk erişim yapılmaya çalışılıyor demektir
// bunu engellemeliyiz
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

class UsersStruct {
    public static string $procedure0 = "CALL ProcGetByUsername_v1(?, \"verify\")";

    // Veritabanı tablo sütunları
    public static $column_username = "usersUsername";
    public static $column_email = "usersEmail";
    public static $column_password = "usersPassword";

    // Parametreler
    public static string $param_username = "username";
    public static string $param_password = "password";
}
?>