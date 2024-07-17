<?php
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

// Define Database Infos
defined("DB_HOST") !== true ? define("DB_HOST", "localhost"): null;
defined("DB_NAME") !== true ? define("DB_NAME", "MainDB"): null;
defined("DB_USER") !== true ? define("DB_USER", "root"): null;
defined("DB_PASSWD") !== true ? define("DB_PASSWD", "debianx64"): null;

// API V1
// DATABASE
class Database {
    // Class Function
    public function __construct(
        private string $db_host,
        private string $db_name,
        private string $db_user,
        private string $db_password)
    {}

    // Database Connection
    public function getConnection() : PDO {
        // Veritabanı Bağlantı Bilgisini Saklama
        $dbsn = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8";

        // Veritabanı İçin PDO Objesi Oluşturup Döndürme
        return (new PDO($dbsn, $this->db_user, $this->db_password, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]));
    }
}