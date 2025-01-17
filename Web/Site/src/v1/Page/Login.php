<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="color-scheme" content="dark light">
        <meta name="description" content="Login Now The File Server">
        <title>Giriş Yap</title>
        <link rel="icon" href="/Asset/logo/offical-logo.ico">
        <link rel="apple-touch-icon" href="/Asset/logo/offical-logo.png">
        <!-- CSS -->
        <link rel="stylesheet" href="/Site/src/v1/Style/Login.css">
    </head>
    <body>
        <noscript>Enable JavaScript</noscript>

        <main id="id_signmain" class="signmain">
            <section id="id_signarea" class="signarea">
                <div id="id_signmainarea" class="signmainarea">
                    <div class="hidden-field">
                        <input type="hidden" name="botcheck" id="botcheck">
                    </div>

                    <div id="id_titlearea" class="titlearea">
                        <div id="id_titlearea_textarea"
                            name="textarea"
                            class="titlearea_textarea">
                            <h2 id="id_textarea_title"
                                name="main_title"
                                class="textarea_title">
                                Giriş Yap
                            </h2>
                            <p id="id_textarea_description"
                                name="main_description"
                                class="textarea_description">
                                Dosya Sunucusuna Hoşgeldiniz!
                            </p>
                        </div>
                    </div>
                    <div id="id_statusarea"
                        name="statusarea"
                        class="statusarea">
                    </div>
                    <div id="id_inputarea" class="inputarea">
                        <input type="text"
                            autocomplete="off"
                            name="username"
                            id="id_username"
                            class="input_data input_username"
                            placeholder="Abcd"
                            title="Kullanıcı Adı"
                            required
                        />
                        <input type="password"
                            autocomplete="off"
                            name="password"
                            id="id_password"
                            class="input_data input_password"
                            placeholder="****"
                            title="Şifre"
                            minlength="1"
                            required
                        />
                    </div>
                    <div id="id_submitarea" class="submitarea">
                        <button type="button"
                            id="id_submitbtn"
                            name="btnsubmit"
                            class="input_submitbtn submitbtn"
                            title="Şimdi Giriş Yap">
                            Giriş Yap
                        </button>
                    </div>
                </div>
            </section>
        </main>

        <!-- JS -->
        <script nonce type="module" src="/Site/src/v1/Tool/Page/PageLogin.js"></script>
    </body>
</html>