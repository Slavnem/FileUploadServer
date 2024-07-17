<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

class LanguageData {
    public static $LanguageData = [
        "en" => [ // en us
            "global" => [
                "changetheme" => "Change theme",
                "themedark" => "Dark Theme",
                "themelight" => "Light Theme"
            ],
            "auth_login" => [ // LOGIN PAGE
                "login" => "Login",
                "description" => "Welcome To The Main Server",
                "cannotlogin" => "I cannot Login",
                "registernow" => "If you don't have an account, create one right now...",
                "infotext" => "If you click twice in succession on the password entry section, you can see the password you entered as text and if you click again in succession, you can see it again as a password",
                "loginsuccess" => "Data is correct. Have a nice day :)",
                "loginerror" => "Login failed",
                "loginwarning" => "Make sure you enter the information completely"
            ],
            "auth_register" => [ // REGISTER PAGE
                "register" => "Register"
            ],
            "global_homepage" => [ // HOMEPAGE
                "homepage" => "Homepage"
            ],
            "crypt_encryption" => [ // ENCRYPTION
                "title" => "Encryptor",
                "description" => "The main encryptor is designed for Admin users only. The encryptor has tools such as data encryption, encryption verification",
                "enctexttitle" => "Welcome To The Main Data Encryptor",
                "enctextdesc" => "The main encryptor is designed for Admin users only. The encryptor has tools such as data encryption, encryption verification",
                "algorithm" => "Algorithm",
                "encryptiontype" => "Encryption Type",
                "enctypecreate" => "Create",
                "enctypeverify" => "Verify",
                "encsubmitbtn" => "Submit",
                "enctitle" => "Encryptor",
                "enccreatesuccess" => "Encrypted text with Basic text successfully generated",
                "enccreatewarning" => "Could not successfully create Basic text and Encrypted text, make sure the values are present",
                "enccreateerror" => "Basic text and ciphertext resulted in incorrect results",
                "encverifysuccess" => "Base text and Encrypted texts are matching",
                "encverifywarning" => "There is a problem with matching Basic text and Encrypted texts, make sure the data exists",
                "encverifyerror" => "Base text and Encrypted texts are not matching",
                "encalgorithmtitle" => "Algorithm",
                "encprocesstitle" => "Process",
                "multialgorithm" => [
                    "default" => "Default",
                    "username" => "For Username",
                    "simple" => "Simple"
                ],
                "multiprocess" => [
                    "create" => "Create",
                    "verify" => "Verify"
                ]
            ]
        ],
        "uk" => [ // en uk
            "global" => [
                "changetheme" => "Change theme",
                "themedark" => "Dark Theme",
                "themelight" => "Light Theme"
            ],
            "auth_login" => [ // LOGIN PAGE
                "login" => "Login",
                "description" => "Welcome To The Main Server",
                "cannotlogin" => "I can't login",
                "registernow" => "If you don't have an account, create one right now...",
                "infotext" => "If you click twice in succession on the password entry section, you can see the password you entered as text and if you click again in succession, you can see it again as a password",
                "loginsuccess" => "Data is correct. Have a nice day :)",
                "loginerror" => "Login failed",
                "loginwarning" => "Make sure you enter the information completely"
            ],
            "auth_register" => [ // REGISTER PAGE
                "register" => "Register"
            ],
            "global_homepage" => [ // HOMEPAGE
                "homepage" => "Homepage"
            ],
            "crypt_encryption" => [ // ENCRYPTION
                "title" => "Encryptor",
                "description" => "The main encryptor is designed for Admin users only. The encryptor has tools such as data encryption, encryption verification",
                "enctexttitle" => "Welcome To The Main Data Encryptor",
                "enctextdesc" => "The main encryptor is designed for Admin users only. The encryptor has tools such as data encryption, encryption verification",
                "algorithm" => "Algorithm",
                "encryptiontype" => "Encryption Type",
                "enctypecreate" => "Create",
                "enctypeverify" => "Verify",
                "encsubmitbtn" => "Submit",
                "enctitle" => "Encryptor",
                "enccreatesuccess" => "Encrypted text with Basic text successfully generated",
                "enccreatewarning" => "Could not successfully create Basic text and Encrypted text, make sure the values are present",
                "enccreateerror" => "Basic text and ciphertext resulted in incorrect results",
                "encverifysuccess" => "Base text and Encrypted text are matching",
                "encverifywarning" => "There is a problem with matching Basic text and Encrypted texts, make sure the data exists",
                "encverifyerror" => "Base text and Encrypted text are not matching",
                "encalgorithmtitle" => "Algorithm",
                "encprocesstitle" => "Process",
                "multialgorithm" => [
                    "default" => "Default",
                    "username" => "For Username",
                    "simple" => "Simple"
                ],
                "multiprocess" => [
                    "create" => "Create",
                    "verify" => "Verify"
                ]
            ]
        ], 
        "tr" => [
            "global" => [
                "changetheme" => "Temayı Değiştir",
                "themedark" => "Koyu Tema",
                "themelight" => "Açık Tema"
            ],
            "auth_login" => [ // LOGIN PAGE
                "login" => "Giriş Yap",
                "description" => "Ana Sunucu'ya Hoşgeldiniz",
                "cannotlogin" => "Giriş yapamıyorum",
                "registernow" => "Eğer bir hesabınız yoksa, hemen şimdi bir tane oluşturun...",
                "infotext" => "Şifre giriş bölümüne iki kez üst üste tıklarsanız girdiğiniz şifreyi metin olarak, tekrar üst üste tıklarsanız şifre olarak görebilirsiniz",
                "loginsuccess" => "Veriler eşleşti. İyi günler :)",
                "loginerror" => "Giriş başarısız oldu",
                "loginwarning" => "Bilgileri eksiksiz girdiğinize emin olunuz"
            ],
            "auth_register" => [ // REGISTER PAGE
                "register" => "Kayıt Ol"
            ],
            "global_homepage" => [ // HOMEPAGE
                "homepage" => "Anasayfa"
            ],
            "crypt_encryption" => [ // ENCRYPTION
                "title" => "Şifreleyici",
                "description" => "Ana şifreleyici yalnızca Yönetici kullanıcılar için tasarlanmıştır. Şifreleyici veri şifreleme, şifreleme doğrulama gibi araçlara sahiptir",
                "enctexttitle" => "Ana Veri Şifreleyiciye Hoş Geldiniz",
                "enctextdesc" => "Ana şifreleyici yalnızca Yönetici kullanıcılar için tasarlanmıştır. Şifreleyici veri şifreleme, şifreleme doğrulama gibi araçlara sahiptir",
                "algorithm" => "Algoritma",
                "encryptiontype" => "Şifreleme Türü",
                "enctypecreate" => "Oluştur",
                "enctypeverify" => "Doğrula",
                "encsubmitbtn" => "Gönder",
                "enctitle" => "Şifreleyici",
                "enccreatesuccess" => "Temel metin ile Şifrelenmiş metin başarıyla oluşturuldu",
                "enccreatewarning" => "Temel metin ve Şifreli metin başarıyla oluşturulamadı, değerlerin mevcut olduğundan emin olun",
                "enccreateerror" => "Temel metin ile şifrelenmiş metin hatalı sonuçlandı",
                "encverifysuccess" => "Temel metin ve Şifrelenmiş metin eşleşiyor",
                "encverifywarning" => "Temel metin ve Şifrelenmiş metinler eşleştirmesinde problem var, verilerin varlığından emin olunuz",
                "encverifyerror" => "Temel metin ve Şifrelenmiş metin eşleşmiyor",
                "encalgorithmtitle" => "Algoritma",
                "encprocesstitle" => "İşlem",
                "multialgorithm" => [
                    "default" => "Varsayılan",
                    "username" => "Kullanıcı Adı İçin",
                    "simple" => "Basit"
                ],
                "multiprocess" => [
                    "create" => "Oluştur",
                    "verify" => "Doğrula"
                ]
            ]
        ],
        "ru" => [
            "global" => [
                "changetheme" => "Изменить тему",
                "themedark" => "Темная тема",
                "themelight" => "Светлая тема"
            ],
            "auth_login" => [ // LOGIN PAGE
                "login" => "Войти",
                "description" => "Добро Пожаловать На Главный Сервер",
                "cannotlogin" => "Я не могу войти в систему",
                "registernow" => "Если у вас нет аккаунта, создайте его прямо сейчас...",
                "infotext" => "Если вы дважды подряд нажмете на раздел ввода пароля, вы увидите введенный вами пароль в виде текста, а если вы нажмете еще раз подряд, то снова увидите его в виде пароля",
                "loginsuccess" => "Данные верны. Хорошего дня :)",
                "loginerror" => "Вход в систему не удался",
                "loginwarning" => "Убедитесь, что вы ввели информацию полностью"
            ],
            "auth_register" => [ // REGISTER PAGE
                "register" => "Зарегистрируйтесь"
            ],
            "global_homepage" => [ // HOMEPAGE
                "homepage" => "Домашняя Страница"
            ],
            "crypt_encryption" => [ // ENCRYPTION
                "title" => "Шифровальщик",
                "description" => "Основной шифровальщик предназначен только для пользователей-администраторов. Шифровальщик имеет такие инструменты, как шифрование данных, проверка шифрования",
                "enctexttitle" => "Добро пожаловать в главный шифровальщик данных",
                "enctextdesc" => "Основной шифровальщик предназначен только для пользователей-администраторов. Шифровальщик имеет такие инструменты, как шифрование данных, проверка шифрования",
                "algorithm" => "Алгоритм",
                "encryptiontype" => "Тип Шифрования",
                "enctypecreate" => "Создать",
                "enctypeverify" => "Проверьте",
                "enctitle" => "шифровальщик",
                "encsubmitbtn" => "Отправить",
                "enccreatesuccess" => "Зашифрованный текст с основным текстом успешно создан",
                "enccreatewarning" => "Не удалось успешно создать Основной текст и Зашифрованный текст, убедитесь, что значения присутствуют",
                "enccreateerror" => "Основной текст и зашифрованный текст не совпадают",
                "encverifysuccess" => "Совпадение основного и зашифрованного текста",
                "encverifywarning" => "Возникла проблема при сопоставлении основного и зашифрованного текстов, убедитесь, что данные существуют",
                "encverifyerror" => "Основной текст и зашифрованный текст не совпадают",
                "encalgorithmtitle" => "Алгоритм",
                "encprocesstitle" => "Процесс",
                "multialgorithm" => [
                    "default" => "По Умолчанию",
                    "username" => "Для Имени Пользователя",
                    "simple" => "Простой"
                ],
                "multiprocess" => [
                    "create" => "Создать",
                    "verify" => "Проверьте"
                ]
            ]
        ]
    ];
}