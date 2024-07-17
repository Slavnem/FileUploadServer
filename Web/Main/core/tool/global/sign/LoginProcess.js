// Import Global
import {
    urlPageSharedMain
} from '/core/tool/global/url/UrlData.js';

// Import Api Local
import {
    AuthProcess
} from '/core/tool/global/sign/AuthProcess.js';

import {
    BackgroundProcess,
    BackgroundPage,
    BackgroundStyle
} from '/core/tool/global/api/local/background/BackgroundProcess.js';

import {
    SessionKey,
    SessionProcess
} from '/core/tool/global/api/local/session/SessionProcess.js';

import {
    ThemeType,
    ThemeProcess
} from '/core/tool/global/theme/ThemeProcess.js';

// Import Api Server
import {
    UsersProcess
} from '/core/tool/global/api/server/users/UsersProcess.js';

import {
    LanguageKey,
    LanguageProcess
} from '/core/tool/global/api/local/language/LanguageProcess.js';

import {
    IconAll,
    IconProcess
} from '/core/tool/global/api/local/icon/IconProcess.js';

// Giriş İşlemleri İçin Hata Mesajları
class LoginError {
    // Hata Mesajları
    static ErrorMsg_ElementNotFound = "Element Not Found";
    static ErrorMsg_StatusCannotDetect = "Status Cannot Detect";
    static ErrorMsg_LanguageNotFound = "Language Not Found";
    static ErrorMsg_ElementStatusAreaNotFound = "Status Area Element Not Found";
    static ErrorMsg_ElementStatusIconNotFound = "Status Icon Element Not Found";
    static ErrorMsg_ElementStatusTextNotFound = "Status Text Element Not Found";
    static ErrorMsg_ElementInputUsernamePasswordNotFound = "Username and Password Input Element Not Found";
    static ErrorMsg_ElementInputUsernameNotFound = "Username Input Element Not Found";
    static ErrorMsg_ElementInputPasswordNotFound = "Password Input Element Not Found";
    static ErrorMsg_DataUsernameNotFound = "Username Data Not Found";
    static ErrorMsg_DataPasswordNotFound = "Password Data Not Found";
    static ErrorMsg_LoginFail = "Login Failed";
    static ErrorMsg_AutoTextChange = "Failed To Automatically Change The Text";
    static ErrorMsg_SessionUpdateCheck = "Auto Session Update/Check Error";
    static ErrorMsg_TextLanguageDataNotFound = "Text Language Data Didn't Fetch";
    static ErrorMsg_PageTitleUnableChange = "Unable to Change Page Title";
    static ErrorMsg_TextareaTitleUnable = "Unable to Change Textarea Title";
    static ErrorMsg_TextareaDescriptionUnable = "Unable To Change Textarea Description";
    static ErrorMsg_SubmitbtnTextUnable = "Unable To Change Submit Button Text";
    static ErrorMsg_ForgotbtnTextUnable = "Unable To Change Forgot Button Text";
    static ErrorMsg_RedirectbtnTextUnable = "Unable To Change Redirect Button Text";
    static ErrorMsg_InfoTextUnable = "Unable To Change Info Text";
    static ErrorMsg_UnableTranslateText = "Unable To Translate The Text Of The Input Status Messenger Into The Appropriate Language";
    static ErrorMsg_ElementSubmitbtnNotFound = "Submit Button Element Not Found";
    static ErrorMsg_BackgroundUnableChange = "Unable to Change Background";
    static ErrorMsg_ElementInputPasswordNotFound = "Element Input Password Not Found";
}

// Giriş İşlemleri İçin Anahtarlar
export class LoginKey {
    // Giriş durumu
    static keyLoginStatus_Status = "data-login-status";

    // Giriş sayfası için verilere erişmeyi sağlayan değişkenler
    static keyLanguage_Login = "login"
    static keyLanguage_Description = "description";
    static keyLanguage_Cannotlogin = "cannotlogin";
    static keyLanguage_Registernow = "registernow";
    static keyLanguage_Infotext = "infotext";
    static keyLanguage_Loginsuccess = "loginsuccess";
    static keyLanguage_Loginerror = "loginerror";
    static keyLanguage_Loginwarning = "loginwarning";

    // Giriş durumu
    static keyLogin_StatusError = "statuserror";
    static keyLogin_StatusWarning = "statuswarning";
    static keyLogin_StatusSuccess = "statussuccess";

    // Giriş sayfası anahtar kelimeler
    static keyLogin_Background = String(BackgroundPage.Page_Auth ||  "auth");
}

// Giriş İşlemleri İçin Fonksiyonlar
class LoginFunctions {
    // Giriş Kontrolü
    static async Check(params) {
        // parametrelerini hazırlamak
        const checkParams = {
            username: String(params.username) || null,
            password: String(params.password) || null
        };

        // Kullanıcı doğrulaması yaptır ve doğrulama sonucunu döndür
        return (await UsersProcess.UserVerify(
            String(checkParams.username) || null,
            String(checkParams.password) || null
        )) || false;
    }
}

// GİRİŞ İŞLEMLERİ SINIFI
class LoginProcess {
    // Giriş Durumu Mesajcısı
    static async StatusMessage(argStatus) {
        // elementler
        const elementStatusArea = document.querySelector(`div#id_statusarea`);
        const elementStatusIcon = document.querySelector(`span#id_statusarea_icon`);
        const elementStatusText = document.querySelector(`span#id_statusarea_text`);

        // Tanımsız element
        switch(true) {
            case (elementStatusArea === null):
                throw new Error(LoginError.ErrorMsg_ElementStatusAreaNotFound || "Login Status Error: Status Area Element Not Found");
            case (elementStatusIcon === null):
                throw new Error(LoginError.ErrorMsg_ElementStatusIconNotFound || "Login Status Error: Status Icon Element Not Found");
            case (elementStatusText === null):
                throw new Error(LoginError.ErrorMsg_ElementStatusTextNotFound || "Login Status Error: Status Text Element Not Found");
            case (argStatus != LoginKey.keyLogin_StatusSuccess && argStatus != LoginKey.keyLogin_StatusWarning && argStatus != LoginKey.keyLogin_StatusError):
                throw new Error(LoginError.ErrorMsg_StatusCannotDetect || "Status Error: Language Base Key Error!")
        }

        // anahtar kelimeler
        let keyLanguage = (await SessionProcess.SessionFetchKey(SessionKey.keySession_Languageshort)) || null;
        const keyPart = String(LanguageKey.partAuthLogin) || null;
        let keyBase = String(argStatus) || null;
        var keyIcon = null;

        // eğer parça ya da anahtar bilgisi boş ise hata çıktısı
        switch(null) {
            case (keyPart):
                throw new Error(LanguageSupport.ErrorMsg_LanguagePartKeyNotFound || "Language Error: Language Part Key");
            case (keyBase):
                throw new Error(LanguageSupport.ErrorMsg_LanguageBaseKeyNotFound || "Language Error: Language Base Key");
        }

        // Dil anahatar verisi düzenleme
        switch(keyBase) {
            case (LoginKey.keyLogin_StatusSuccess):
                keyBase = String(LoginKey.keyLanguage_Loginsuccess);
                keyIcon = String(IconAll.ikeyAuthloginSuccess);
                break;
            case (LoginKey.keyLogin_StatusWarning):
                keyBase = String(LoginKey.keyLanguage_Loginwarning);
                keyIcon = String(IconAll.ikeyAuthloginWarning);
                break;
            case (LoginKey.keyLogin_StatusError):
                keyBase = String(LoginKey.keyLanguage_Loginerror);
                keyIcon = String(IconAll.ikeyAuthloginError);
                break;
        }

        // duruma göre dil bilgisini almak
        const dataStatusTitle = (await LanguageProcess.GetBasicKey(
            String(keyLanguage) || null,
            String(keyPart) || null,
            String(keyBase) || null
        )) || null;

        // ikonu al
        const dataIcon = (await IconProcess.Get(keyIcon)) || null;

        // Duruma göre içeriği düzenle
        switch(argStatus) {
            case (LoginKey.keyLogin_StatusSuccess):
            case (LoginKey.keyLogin_StatusWarning):
            case (LoginKey.keyLogin_StatusError):
                elementStatusArea.setAttribute(LoginKey.keyLoginStatus_Status, argStatus);

                // İkonu elemente aktarma ve still düzenlemesi yapma
                elementStatusIcon.innerHTML = dataIcon;
                elementStatusText.textContent = dataStatusTitle;
                elementStatusArea.style.display = "flex";
                break;
        }

        return String(argStatus) || null;
    }

    // Giriş Kontrolü
    static async CheckLogin(argInputdisable = true) {
        // Veri girme elementlerini alma va varlarsa verilerini alma
        const elementInputUsername = document.querySelector(`input[name="username"]`);
        const elementInputPassword = document.querySelector(`input[name="password"]`);

        // Element yoksa
        try {
            switch(true) {
                // kullanıcı adı ve şifre alanı yok
                case(elementInputUsername === null && elementInputPassword === null):
                    throw new Error(LoginProcess.ErrorMsg_ElementInputUsernamePasswordNotFound || "Username and Password Input Element Not Found");
                // sadece kullanıcı adı alanı yok
                case (elementInputUsername === null):
                    throw new Error(LoginProcess.ErrorMsg_ElementInputUsernameNotFound || "Username Input Element Not Found");
                // sadece şifre alanı yok
                case (elementInputPassword === null):
                    throw new Error(LoginProcess.ErrorMsg_ElementInputPasswordNotFound || "Password Input Element Not Found");
            }
        } catch(error) {
            console.error(error.message);
            return false;
        }

        // durum çıktısı
        var statusMessage = null;

        // parametreler
        const inputDataUsername = String(elementInputUsername.value) || null;
        const inputDataPassword = String(elementInputPassword.value) || null;

        // Kullanıcı adı ya da şifre yoksa
        try {
            switch(true) {
                case (inputDataUsername.length < 1):
                    throw new Error(LoginProcess.ErrorMsg_DataUsernameNotFound);
                case (inputDataPassword.length < 1):
                    throw new Error(LoginProcess.ErrorMsg_DataPasswordNotFound);
            }
        } catch(error) {
            // LoginProcess.StatusMessage(LoginProcess.loginStatusWarning, languageShort).then();
            statusMessage = (await LoginProcess.StatusMessage(
                String(LoginKey.keyLogin_StatusWarning) || null
            ));
            return false;
        }

        // kontrol işlemi durumunu almak
        const verifyUser = await (UsersProcess.UserVerify(
            (String(inputDataUsername) || null),
            (String(inputDataPassword) || null)
        ));

        // Kontrol sonucuna göre işlem
        switch(Boolean(verifyUser)) {
            case true:
                // Oturum güncelleme
                const statusSessionUpdate = (await SessionProcess.SessionUpdate(
                    String(inputDataUsername) || null,
                    String(inputDataPassword) || null
                ));

                // Otomatik Verileri Güncelle
                const statusAutoUpdate = (await LoginProcess.AutoUpdate());

                // Durum çıktısı
                statusMessage = (await LoginProcess.StatusMessage(
                    String(LoginKey.keyLogin_StatusSuccess) || null
                ));

                // İşlem başarılı ve giriş devre dışı bırakılmış ise
                // metin girişi devre dışı bırakıyoruz
                switch(true) {
                    case (typeof argInputdisable !== "undefined" && Boolean(argInputdisable) === true):
                        // Giriş balarılı olduğu için girişi durduruyoruz
                        elementInputUsername.disabled = true;
                        elementInputPassword.disabled = true;
                        break;
                }
                return true;
            default:
                // Durum çıktısı
                statusMessage = (await LoginProcess.StatusMessage(
                    String(LoginKey.keyLogin_StatusError) || null
                ));
                return false;
        }
    }

    static async TextLanguage() {
        // Dil bilgileri
        const keyLanguage = (await SessionProcess.SessionFetchKey(SessionKey.keySession_Languageshort)) || "";
        const keyPart = String(LanguageKey.partAuthLogin) || "";
        const keyBase = "";

        // dil veriyi yoksa boş dönsün
        switch(null) {
            case (keyLanguage):
            case (keyPart):
                return false;
        }

        // elementleri al
        const elementTitle = document.querySelector(`h1#id_textarea_title`);
        const elementDescription = document.querySelector(`p#id_textarea_description`);
        const elementLoginBtn = document.querySelector(`button#id_submitbtn[name="submitbtn"]`);
        const elementForgotBtn = document.querySelector(`a#id_forgotbtn`);
        const elementRedirectBtn = document.querySelector(`a#id_redirect_signup`);
        const elementInfoText = document.querySelector(`p#id_info_text`);

        // Dil Metinlerini Almak
        const dataLanguage = (await LanguageProcess.GetBasicPart(
            String(keyLanguage),
            String(keyPart)
        )) || {};

        // veri yoksa hata dönsün
        if(typeof dataLanguage === "undefined" || dataLanguage.length < 1) {
            return false;
        }

        // Dil verisi olanları yenilesin
        (typeof dataLanguage[LoginKey.keyLanguage_Login] !== "undefined" && (dataLanguage[LoginKey.keyLanguage_Login].length > 0)) ?
            (document.title = (dataLanguage[LoginKey.keyLanguage_Login])): null;

        (elementTitle !== null && typeof dataLanguage[LanguageKey.keyLanguage_AuthLogin_Login] !== "undefined" && (dataLanguage[LanguageKey.keyLanguage_AuthLogin_Login].length > 0)) ?
            (elementTitle.textContent = (dataLanguage[LanguageKey.keyLanguage_AuthLogin_Login])): null;

        (elementDescription !== null && typeof dataLanguage[LoginKey.keyLanguage_Description] !== "undefined" && (dataLanguage[LoginKey.keyLanguage_Description].length > 0)) ?
            (elementDescription.textContent = (dataLanguage[LoginKey.keyLanguage_Description])): null;
            
        (elementLoginBtn !== null && typeof dataLanguage[LoginKey.keyLanguage_Login] !== "undefined" && (dataLanguage[LoginKey.keyLanguage_Login].length > 0)) ?
            (
                (elementLoginBtn.textContent = (dataLanguage[LoginKey.keyLanguage_Login])) &&
                (elementLoginBtn.title = (dataLanguage[LoginKey.keyLanguage_Login]))
            ): null;

        (elementForgotBtn !== null && typeof dataLanguage[LoginKey.keyLanguage_Cannotlogin] !== "undefined" && (dataLanguage[LoginKey.keyLanguage_Cannotlogin].length > 0)) ?
            (
                (elementForgotBtn.textContent = (dataLanguage[LoginKey.keyLanguage_Cannotlogin])) &&
                (elementForgotBtn.title = (dataLanguage[LoginKey.keyLanguage_Cannotlogin]))
            ): null;

        (elementRedirectBtn !== null && typeof dataLanguage[LoginKey.keyLanguage_Cannotlogin] !== "undefined" && (dataLanguage[LoginKey.keyLanguage_Cannotlogin].length > 0)) ?
            (
                (elementRedirectBtn.textContent = (dataLanguage[LoginKey.keyLanguage_Registernow])) &&
                (elementRedirectBtn.title = (dataLanguage[LoginKey.keyLanguage_Registernow]))
            ): null;

        (elementInfoText !== null && typeof dataLanguage[LoginKey.keyLanguage_Infotext] !== "undefined" && (dataLanguage[LoginKey.keyLanguage_Infotext].length > 0)) ?
            (elementInfoText.textContent = (dataLanguage[LoginKey.keyLanguage_Infotext])): null;

        return true;
    }

    // Otomatik güncelleyici
    static async AutoUpdate() {
        // alınan oturum verileri ile dil bilgilerini değiştirtmek
        return Boolean(await LoginProcess.TextLanguage()) || false;
    }

    static LoginCheckBtn(argElementBtn, argSubmitdisable = true) {
        // Eğer buton tanımsızsa direk hata mesajı dönsün
        switch(true) {
            case (typeof argElementBtn === "undefined"):
            case (argElementBtn === null):
                console.error(LoginError.ErrorMsg_ElementSubmitbtnNotFound || "Submit Button Element Not Found");
                return false;
        }

        // Değişkenler
        var statusAutoUpdate;

        // Butona tıklandıkça oturum kontrolü
        argElementBtn.addEventListener("click", function() {
            LoginProcess.CheckLogin().then(check => {
                // Oturum başarısız ise eğer, güncelleme yapılmasın
                if(Boolean(check) !== true) {
                    return false;
                }

                // Otomatik güncelleme
                statusAutoUpdate = Boolean(LoginProcess.AutoUpdate().then());

                // Giriş doğrulandığı için veri gönderme butonunu devre dışı bırakıyoruz
                switch(true) {
                    case (typeof argSubmitdisable !== "undefined" && Boolean(argSubmitdisable) === true):
                        argElementBtn.disabled = true;
                        break;
                }

                // Sayfa yönlendirme
                setTimeout(function() {
                    window.location.href = urlPageSharedMain;
                }, 2888);
            });
        });
    }
}

// Otomatik veri güncellemesi
var statusAutoUpdate = Boolean(await LoginProcess.AutoUpdate()) || false;

// arkaplan değişimi durumu
var statusBackgroundChange = (await BackgroundProcess.BackgroundChange(
    document.body, // html element
    BackgroundPage.Page_Auth, // page
    null, // page num
    BackgroundStyle.Style__DarkLinear // background style
));

// Tema Değiştirici
var statusCreateThemeChanger = (await ThemeProcess.CreateSwitcher(
    document.querySelector("div#id_minibtnarea"),
    document.getElementsByTagName("html")[0]
));

// Şifre Gösterme/Gizleme
var statusPasswordShow = Boolean(AuthProcess.ShowHidePassword()) || false;

// Giriş Yapma İşlemi
var statusLogin = Boolean(LoginProcess.LoginCheckBtn(document.querySelector(`button[type="button"][name="submitbtn"]`))) || false;

// Bilgilendirme Alanı Gösterme/Gizleme
var statusInfoShow = Boolean(AuthProcess.ShowHideInfo()) || false;