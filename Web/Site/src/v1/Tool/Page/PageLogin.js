// Giriş İşlemleri Sınıfı
import {
    MyLogin
} from "../Auth/MyLogin.js";

// Dil Bilgileri
import {
    MyLanguageData
} from "../../Data/SessionData.js";

// Başlık ve Karşılama metini
const elementTitle = document.querySelector(`[name="title"]`) || null;
const elementDescription = document.querySelector(`[name="description"]`) || null;

// Giriş yapma butonu
const elementSubmitBtn = document.querySelector(`button[name="btnsubmit"]`) || null;

// Kullanıcı adı giriş elementi
const elementInputUsername = document.querySelector(`input[name="inusername"]`) || null;

// E-posta giriş elementi
const elementInputEmail = null;

// Şifre giriş elementi
const elementInputPassword = document.querySelector(`input[name="inpassword"]`) || null;

// Durum bilgileri elementi
const elementStatusArea = document.querySelector(`div[name="statusarea"]`) || null;

// metin ayarlamaları
if(elementTitle) elementTitle.textContent = String(MyLanguageData.login || "Giriş Yap");
if(elementDescription) elementDescription.textContent = String(MyLanguageData.welcometoserver || "Dosya Sunucusuna Hoşgeldiniz!");

if(elementInputUsername) elementInputUsername.title = String(MyLanguageData.username || "Kullanıcı Adı");
if(elementInputPassword) elementInputPassword.title = String(MyLanguageData.password || "Kullanıcı Adı");

if(elementSubmitBtn) elementSubmitBtn.textContent = String(MyLanguageData.login || "Giriş Yap");
if(elementSubmitBtn) elementSubmitBtn.title = String(MyLanguageData.login || "Giriş Yap");

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