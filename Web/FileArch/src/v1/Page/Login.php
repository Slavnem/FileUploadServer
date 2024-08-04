<?php
// Slavnem @2024-08-03
namespace FileArchWeb\Src\v1\Page;

// Oturum yoksa başlatsın
if(session_status() != PHP_SESSION_ACTIVE) session_start();

// Oturum Sınıfları
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;
use SessionApi\v1\Core\SessionRequest as SessionRequest;

// Sayfa içindeki yazılar
$page_strs = [
    "tr" => [
        "title_login" => "Giriş Yap",
        "desc_login" => "Dosya Sunucusuna Hoşgeldiniz!",
        "btn_submit" => "Şimdi Giriş Yap",
        "input_title_username" => "Kullanıcı Adı",
        "input_title_password" => "Şifre"
    ],
    "en" => [
        "title_login" => "Login",
        "desc_login" => "Welcome To The File Server!",
        "btn_submit" => "Login Now",
        "input_title_username" => "Username",
        "input_title_password" => "Password"
    ]
];

// oturum sorgu nesnesi
$SessionRequest = new SessionRequest();

// sayfa dilini ayarlamak
$page_lang = $SessionRequest->Request(
    SessionMethods::getFetch(),
    NULL,
    NULL
)[SessionParams::getLanguage()] ?? "tr";

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
                "status" => "error",
                "message" => "Bot Saldırı Kontrolü Başarısız"
            ];

            break; // işlemi bitir
        }

        // kullanıcı verilerini al
        $username = trim($_POST["username"]) ?? null;
        $password = trim($_POST["password"]) ?? null;

        // giriş bilgileri boş olup olmama durumunu kontrol et
        if(empty($username)) { // kullanıcı adı boş olamaz
            $status_store[] = [
                "status" => "error",
                "message" => "Kullanıcı Adı Boş Olamaz"
            ];
        }
        if(empty($password)) { // şifre boş olamaz
            $status_store[] = [
                "status" => "error",
                "message" => "Şifre Boş Olamaz"
            ];
        }

        // hata kutusu boş değilse işlemi bitirsin
        if(!empty($status_store)) break;

        // verileri düzenle
        $user_datas = [
            SessionParams::getUsername() => $username,
            SessionParams::getPassword() => $password
        ];

        // yeni oturum oluştursun
        $user_session = $SessionRequest->Request(
            SessionMethods::getCreate(),
            $user_datas,
            NULL
        );

        // oturum bilgisi boşsa bunu bildirsin
        if(empty($user_session)) {
            // geçersiz email
            $status_store[] = [
                "status" => "error",
                "message" => "Kullanıcı Bulunamadı"
            ];

            break; // işlemi bitir
        }

        // dosya sayfasına yönlendir
        header("Location: /files");
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
        <title>
            <?php echo $page_strs[$page_lang]["title_login"] ?? $page_strs["tr"]["title_login"]; ?>
        </title>
        <link rel="icon" href="/asset/logo/slavnem.ico">
        <link rel="apple-touch-icon" href="/asset/logo/slavnem.png">
        <link rel="stylesheet" href="/src/v1/Style/Login.css">
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
                            <h1 id="id_textarea_title" class="textarea_title">
                                <?php echo $page_strs[$page_lang]["title_login"] ?? $page_strs["tr"]["title_login"]; ?>
                            </h1>
                            <p id="id_textarea_description" class="textarea_description">
                                <?php echo $page_strs[$page_lang]["desc_login"] ?? $page_strs[$page_lang]["desc_login"]; ?>
                            </p>
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
                        <input type="text"
                            autocomplete="off"
                            name="username"
                            id="id_username"
                            class="input_data input_username"
                            placeholder="Abcd"
                            title="<?php echo $page_strs[$page_lang]["input_title_username"] ?? $page_strs["tr"]["input_title_username"]; ?>"
                        />
                        <input type="password"
                            autocomplete="off"
                            name="password"
                            id="id_password"
                            class="input_data input_password"
                            placeholder="****"
                            title="<?php echo $page_strs[$page_lang]["input_title_password"] ?? $page_strs["tr"]["input_title_password"]; ?>"
                        />
                    </div>
                    <div id="id_submitarea" class="submitarea">
                        <button type="submit"
                            id="id_submitbtn"
                            class="input_submitbtn submitbtn"
                            name="submitbtn"
                            title="<?php echo $page_strs[$page_lang]["btn_submit"] ?? $page_strs["tr"]["btn_submit"]; ?>">
                            <?php echo $page_strs[$page_lang]["title_login"] ?? $page_strs["tr"]["title_login"]; ?>
                        </button>
                    </div>
                </form>
            </section>
        </main>

        <script nonce type="module" src="/src/v1/Tool/Auth/LoginProc.js"></script>
    </body>
</html>