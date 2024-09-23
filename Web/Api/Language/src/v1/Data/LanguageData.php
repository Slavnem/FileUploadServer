<?php
// Slavnem @2024-09-20
namespace LanguageApi\v1\Data;

// Language Data
trait LanguageData {
    // Veriler
    protected static array $dataLanguage = [
        // İNGİLİZCE
        "en" => [
            "auth/login" => [
                "welcometoserver" => "Welcome To The File Server!",
                "username" => "Username",
                "email" => "Email",
                "password" => "Password",
                "login" => "Login",
                "notenoughdata" => "Not Enough Data",
                "hastobeusernameandpassword" => "Has To Be Username and Password",
                "missignelement" => "Missing Element",
                "hastobesubmitbtn" => "There Has To Be a Data Submission Button",
                "loginfailed" => "Login Failed",
                "loginfailedinfo" => "Username or Password is Incorrect",
                "loginsuccess" => "Login Successful",
                "loginsuccessinfo" => "Congratulations, Datas Verified",
                "redirect" => "Redirecting",
                "redirectinfo" => "You Are Being Redirected To The Required Page...",
                "sessionerror" => "Session Error",
                "sessionverifyerror" => "Login was made but session could not be verified"
            ],
            "files" => [
                "logout" => "Logout",
                "download" => "Download",
                "upload" => "Upload",
                "delete" => "Delete",
                "percentcompleted" => "Completed",
                "deletefilequestion" => "Do you want to delete the file?",
                "downloadfilequestion" => "Do you want to download the file",
                "yes" => "Yes",
                "ok" => "Ok",
                "no" => "No",
                "search" => "Search",
                "searchfiles" => "Search The Files",
                "selectfiles" => "Select Files",
                "files" => "Files",
                "fileuploadsuccess" => "Upload Completed",
                "fileuploadsuccessinfo" => "Your files have been successfully uploaded to the server",
                "fileuploaderror" => "Upload Failed",
                "fileuploaderrorinfo" => "Your files were not uploaded due to an error or on purpose",
                "filenotselected" => "File Not Selected",
                "filenotselectedinfo" => "File Selection Required for File Operations",
                "otherfileuploadscancel" => "File Upload Cancellation",
                "otherfileuploadscancelinfo" => "Other File Upload Operations Canceled, Only 1 File Upload Operation Can Be Performed At The Same Time"
            ]
        ],
        // TÜRKÇE
        "tr" => [
            "auth/login" => [
                "welcometoserver" => "Dosya Sunucusuna Hoşgeldiniz!",
                "username" => "Kullanıcı Adı",
                "email" => "E-Posta",
                "password" => "Şifre",
                "login" => "Giriş Yap",
                "notenoughdata" => "Eksik Veri",
                "hastobeusernameandpassword" => "Kullanıcı Adı ve Şifre Olmak Zorunda",
                "missignelement" => "Eksik Element",
                "hastobesubmitbtn" => "Veri Gönderme Butonu Olmak Zorunda",
                "loginfailed" => "Giriş Başarısız",
                "loginfailedinfo" => "Kullanıcı Adı veya Şifre Hatalı",
                "loginsuccess" => "Giriş Başarılı",
                "loginsuccessinfo" => "Tebrikler, Bilgiler Doğrulandı",
                "redirect" => "Yönlendiriliyor",
                "redirectinfo" => "Gerekli Sayfaya Yönlendiriliyorsunuz...",
                "sessionerror" => "Oturum Hatası",
                "sessionverifyerror" => "Giriş yapıldı fakat oturum doğrulanamadı"
            ],
            "files" => [
                "logout" => "Çıkış Yap",
                "download" => "İndir",
                "upload" => "Yükle",
                "delete" => "Sil",
                "percentcompleted" => "Tamamlandı",
                "deletefilequestion" => "Dosyayı silmek istiyor musunuz?",
                "downloadfilequestion" => "Dosyayı İndirmek İstiyor musunuz?",
                "yes" => "Evet",
                "ok" => "Tamam",
                "no" => "Hayır",
                "search" => "Araştır",
                "searchfiles" => "Dosyaları Araştır",
                "selectfiles" => "Dosyaları Seç",
                "files" => "Dosyalar",
                "fileuploadsuccess" => "Yükleme Tamamlandı",
                "fileuploadsuccessinfo" => "Dosyalarınız sunucuya başarıyla yüklendi",
                "fileuploaderror" => "Yükleme Başarısız",
                "fileuploaderrorinfo" => "Dosyalarınız bir hata sonucu ya da istemli olarak yüklenmedi",
                "filenotselected" => "Dosya Seçilmedi",
                "filenotselectedinfo" => "Dosya İşlemleri İçin Dosya Seçmeniz Şart",
                "otherfileuploadscancel" => "Dosya Yükleme İptali",
                "otherfileuploadscancelinfo" => "Diğer Dosya Yükleme İşlemleri İptal Edildi, Aynı Anda Sadece 1 Tane Dosya Yükleme İşlemi Yapılabilir",
            ]
        ],
        // RUSÇA
        "ru" => [
            "auth/login" => [
                "welcometoserver" => "Добро Пожаловать На Файловый Сервер!",
                "username" => "Имя пользователя",
                "email" => "Электронная почта",
                "password" => "Пароль",
                "login" => "Авторизоваться",
                "notenoughdata" => "Недостаточно данных",
                "hastobeusernameandpassword" => "Должно быть имя пользователя и пароль",
                "missignelement" => "Недостающий элемент",
                "hastobesubmitbtn" => "Там должна быть Кнопка отправки данных",
                "loginfailed" => "Не удалось выполнить вход в систему",
                "loginfailedinfo" => "Неверное имя пользователя или пароль",
                "loginsuccess" => "Вход в систему прошел успешно",
                "loginsuccessinfo" => "Поздравляем, данные подтверждены",
                "redirect" => "Перенаправление",
                "redirectinfo" => "Вы Будете Перенаправлены На Нужную Страницу...",
                "sessionerror" => "Ошибка сеанса",
                "sessionverifyerror" => "Вход в систему был выполнен, но сеанс не удалось подтвердить"
            ],
            "files" => [
                "logout" => "Выход",
                "download" => "Скачать",
                "upload" => "Загружать",
                "delete" => "Удалить",
                "percentcompleted" => "Завершенный",
                "deletefilequestion" => "Вы хотите удалить этот файл?",
                "downloadfilequestion" => "Вы хотите загрузить этот файл",
                "yes" => "Да",
                "ok" => "Ок",
                "no" => "Нет",
                "search" => "Поиск",
                "searchfiles" => "Поиск По Файлам",
                "selectfiles" => "Выберите файлы",
                "files" => "Файлы",
                "fileuploadsuccess" => "Загрузка завершена",
                "fileuploadsuccessinfo" => "Ваши файлы были успешно загружены на сервер",
                "fileuploaderror" => "Ошибка загрузки",
                "fileuploaderrorinfo" => "Ваши файлы не были загружены из-за ошибки или намеренно",
                "filenotselected" => "Файл не выбран",
                "filenotselectedinfo" => "Выбор файла, необходимого для файловых операций",
                "otherfileuploadscancel" => "Отмена загрузки файлов",
                "otherfileuploadscancelinfo" => "Другие операции по загрузке файлов отменены, одновременно может выполняться только 1 операция по загрузке файлов"
            ]
        ],
        // ALMANCA
        "de" => [
            "auth/login" => [
                "welcometoserver" => "Willkommen auf dem File Server!",
                "username" => "Benutzername",
                "email" => "E-Mail",
                "password" => "Passwort",
                "login" => "Anmeldung",
                "notenoughdata" => "Nicht genügend Daten",
                "hastobeusernameandpassword" => "Muss Benutzername und Passwort sein",
                "missignelement" => "Fehlendes Element",
                "hastobesubmitbtn" => "Es muss eine Schaltfläche für die Datenübermittlung geben",
                "loginfailed" => "Anmeldung fehlgeschlagen",
                "loginfailedinfo" => "Benutzername oder Passwort ist falsch",
                "loginsuccess" => "Anmeldung erfolgreich",
                "loginsuccessinfo" => "Glückwunsch, Datas Verified",
                "redirect" => "Umleitung",
                "redirectinfo" => "Sie werden zur gewünschten Seite weitergeleitet...",
                "sessionerror" => "Sitzungsfehler",
                "sessionverifyerror" => "Anmeldung wurde durchgeführt, aber Sitzung konnte nicht verifiziert werden"
            ],
            "files" => [
                "logout" => "Abmeldung",
                "download" => "Herunterladen",
                "upload" => "Hochladen",
                "delete" => "Löschen",
                "percentcompleted" => "Abgeschlossen",
                "deletefilequestion" => "Möchten Sie die Datei löschen?",
                "downloadfilequestion" => "Möchten Sie die Datei herunterladen",
                "yes" => "Ja",
                "ok" => "Ok",
                "no" => "Nein",
                "search" => "Suche",
                "searchfiles" => "Suche in den Dateien",
                "selectfiles" => "Dateien auswählen",
                "files" => "Dateien",
                "fileuploadsuccess" => "Upload abgeschlossen",
                "fileuploadsuccessinfo" => "Ihre Dateien wurden erfolgreich auf den Server hochgeladen",
                "fileuploaderror" => "Upload fehlgeschlagen",
                "fileuploaderrorinfo" => "Ihre Dateien wurden aufgrund eines Fehlers oder absichtlich nicht hochgeladen",
                "filenotselected" => "Datei nicht ausgewählt",
                "filenotselectedinfo" => "Dateiauswahl für Dateioperationen erforderlich",
                "otherfileuploadscancel" => "Abbruch des Dateiuploads",
                "otherfileuploadscancelinfo" => "Andere Datei-Upload-Vorgänge werden abgebrochen, es kann nur 1 Datei-Upload-Vorgang gleichzeitig durchgeführt werden"
            ]
        ]
    ];

    // Getir
    public static function getData(?string $argLanguage, ?string $argPage): ?array {
        // verileri tutacak
        $storeData = null;

        switch(true) {
            case !empty($argLanguage) && !empty($argPage):
                if(isset(self::$dataLanguage[$argLanguage][$argPage])) {
                    $storeData = self::$dataLanguage[$argLanguage][$argPage];
                }
            break;
            case !empty($argLanguage) && empty($argPage):
                if(isset(self::$dataLanguage[$argLanguage])) {
                    $storeData = self::$dataLanguage[$argLanguage];
                }
            break;
            case empty($argLanguage) && !empty($argPage):
                foreach(self::$dataLanguage as $language) {
                    if(!isset($language[$argPage])) {
                        continue;
                    }

                    $storeData = $language[$argPage];
                }
            break;
            default:
                $storeData = self::$dataLanguage;
        }

        // hepsini al
        return !empty($storeData) ? (array)$storeData : null;
    }
}