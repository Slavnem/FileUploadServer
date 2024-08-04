<?php
// Slavnem @2024-08-03
namespace FileArchWeb\Src\v1\Page;

// Oturum yoksa başlatsın
if(session_status() != PHP_SESSION_ACTIVE) session_start();

// Durum Sınıfı
use FileArchWeb\Src\v1\Kernel\Status as Status;

// Kullanıcı Sınıfları
use UserApi\v1\Core\Methods as UserMethods;
use UserApi\v1\Core\UserRequest as UserRequest;
use UserApi\v1\Includes\Database\Param\UserParams as UserParams;

// Oturum Sınıfları
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;
use SessionApi\v1\Core\SessionRequest as SessionRequest;

// kullanıcı sorgusu nesnesi
$UserRequest = new UserRequest();

// oturum sorgu nesnesi
$SessionRequest = new SessionRequest();

// durum mesajları
$status_store = NULL;

// işlem metodu
$LoginMethod = $_SERVER["REQUEST_METHOD"];

// Veri girişi türüne göre
switch($LoginMethod) {
    case "POST":
        // bot kontrolü
        if(isset($_POST["botcheck"]) && !empty($_POST["botcheck"]))
        {
            // bot kontrol hatası
            $status_store[] = [
                Status::$tag_status => Status::$status_error,
                Status::$tag_msg => "Bot Saldırı Kontrolü Başarısız"
            ];

            break; // işlemi bitir
        }

        // kullanıcı verilerini al
        $username = trim($_POST["username"]) ?? null;
        $email = trim($_POST["email"]) ?? null;
        $password = trim($_POST["password"]) ?? null;

        // giriş bilgileri boş olup olmama durumunu kontrol et
        if(empty($username)) { // kullanıcı adı boş olamaz
            $status_store[] = [
                Status::$tag_status => Status::$status_error,
                Status::$tag_msg => "Kullanıcı Adı Boş Olamaz"
            ];
        }
        if(empty($email)) { // email boş olamaz
            $status_store[] = [
                Status::$tag_status => Status::$status_error,
                Status::$tag_msg => "E-posta Adresi Boş Olamaz"
            ];
        }
        if(empty($password)) { // şifre boş olamaz
            $status_store[] = [
                Status::$tag_status => Status::$status_error,
                Status::$tag_msg => "Şifre Boş Olamaz"
            ];
        }

        // hata kutusu boş değilse işlemi bitirsin
        if(!empty($status_store)) break;

        // email kontrolü
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            // geçersiz email
            $status_store[] = [
                Status::$tag_status => Status::$status_error,
                Status::$tag_msg => "Geçersiz E-posta Adresi"
            ];

            break; // işlemi bitir
        }

        // verileri düzenle
        $user_datas = [
            SessionParams::getUsername() => $username,
            SessionParams::getEmail() => $email,
            SessionParams::getPassword() => $password
        ];

        // oturuma bilgileri kaydetsin
        $user_session = $SessionRequest->Request(
            SessionMethods::getCreate(),
            $user_datas,
            NULL
        );

        // oturum bilgisi boşsa bunu bildirsin
        if(empty($user_session) || is_null($user_session)) {
            // geçersiz email
            $status_store[] = [
                Status::$tag_status => Status::$status_error,
                Status::$tag_msg => "Kullanıcı Bulunamadı"
            ];

            break; // işlemi bitir
        }

        // ana sayfaya yönlendir
        header("Location: /home");
        exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="color-scheme" content="dark light">
        <title>Giriş Yap</title>
        <link rel="icon" href="../asset/logo/slavnem.ico">
        <link rel="apple-touch-icon" href="../asset/logo/slavnem.png">
        <link rel="stylesheet" href="../src/v1/Style/Login.css">
    </head>
    <body>
        <noscript>Enable JavaScript</noscript>

        <main id="id_signmain" class="signmain">
            <section id="id_signarea" class="signarea">
                <form id="id_loginarea" class="loginarea" method="post" action="/auth/login">
                    <div class="hidden-field">
                        <input type="hidden" name="botcheck" id="botcheck">
                    </div>

                    <div id="id_titlearea" class="titlearea">
                        <div id="id_titlearea_textarea" class="titlearea_textarea">
                            <h1 id="id_textarea_title" class="textarea_title">Giriş Yap...</h1>
                            <p id="id_textarea_description" class="textarea_description">Dosya Sunucusuna Hoşgeldiniz!</p>
                        </div>
                    </div>
                    <div id="id_statusarea" class="statusarea">
                        <?php
                            // durum deposu tanımlı ve boş değilse
                            if(isset($status_store) && !empty($status_store))
                            {
                                foreach($status_store as $msg) {
                                    print("<p class=\"status_msg ". $msg["status"] ."\">". $msg["message"] ."</p>");
                                }
                            }
                        ?>
                    </div>
                    <div id="id_inputarea" class="inputarea">
                        <input type="text" autocomplete="off" name="username" id="id_username" class="input_data input_username" placeholder="Abcd" title="Kullanıcı Adı"/>
                        <input type="text" autocomplete="off" name="email" id="id_email" class="input_data input_email" placeholder="Abcd@email.com" title="E-posta"/>
                        <input type="password" autocomplete="off" name="password" id="id_password" class="input_data input_password" placeholder="****" title="Şifre"/>
                    </div>
                    <div id="id_submitarea" class="submitarea">
                        <button type="submit" id="id_submitbtn" class="input_submitbtn submitbtn" name="submitbtn" title="Şimdi Giriş Yap">Giriş Yap</button>
                    </div>
                </form>
            </section>
        </main>

        <script nonce type="module" src="../src/v1/Tool/Auth/LoginProc.js"></script>
    </body>
</html>