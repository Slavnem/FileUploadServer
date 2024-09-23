// Giriş İşlemleri Sınıfı
import {
    MyLogin
} from "../Auth/MyLogin.js";

// Dil Bilgisi İçin
import {
    MyLanguage
} from "../Language/MyLanguage.js";

// Oturum Bilgileri
import {
    _SessionLanguage
} from "../Data/SessionData.js";

// Dil
const _LanguageData = await MyLanguage.Fetch(
    _SessionLanguage ?? "en",
    MyLanguage.PageAuthLogin // giriş yap
);

// Başlık ve Karşılama metini
const elementTitle = document.querySelector(`[name="main_title"]`) || null;
const elementDescription = document.querySelector(`[name="main_description"]`) || null;

// Giriş yapma butonu
const elementSubmitBtn = document.querySelector(`[name="btnsubmit"]`) || null;

// Kullanıcı adı giriş elementi
const elementInputUsername = document.querySelector(`[name="username"]`) || null;

// E-posta giriş elementi
const elementInputEmail = null;

// Şifre giriş elementi
const elementInputPassword = document.querySelector(`[name="password"]`) || null;

// Durum bilgileri elementi
const elementStatusArea = document.querySelector(`[name="statusarea"]`) || null;

// metin ayarlamaları
document.title = String(_LanguageData?.login ?? "Giriş Yap");

if(elementTitle) elementTitle.textContent = String(_LanguageData?.login ?? "Giriş Yap");
if(elementDescription) elementDescription.textContent = String(_LanguageData?.welcometoserver ?? "Dosya Sunucusuna Hoşgeldiniz!");

if(elementInputUsername) elementInputUsername.title = String(_LanguageData?.username ?? "Kullanıcı Adı");
if(elementInputPassword) elementInputPassword.title = String(_LanguageData?.password ?? "Kullanıcı Adı");

if(elementSubmitBtn) elementSubmitBtn.textContent = String(_LanguageData?.login ?? "Giriş Yap");
if(elementSubmitBtn) elementSubmitBtn.title = String(_LanguageData?.login ?? "Giriş Yap");

// Şifre giriş elementi için şifre metini gösterme ve gizleme
switch(!elementInputPassword) {
    case true: // element yok
        console.error("Password Input Element Not Found");
    break;
    default: // element var
        elementInputPassword.addEventListener("dblclick", function() {
            elementInputPassword.type = (elementInputPassword.type !== ("password") ? ("password") : ("text"));
        });
}

// Veri gönderme elementi için kontrol ve diğer işlemler
switch(!elementSubmitBtn) {
    case true: // element yok
        console.error("Data Submit Button Element Not Found");
    break;
    default: // element var
        MyLogin.Login(
            elementInputUsername,
            elementInputEmail,
            elementInputPassword,
            elementStatusArea,
            elementSubmitBtn
        );
}