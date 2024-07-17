// Import
import {
    IconAll,
    IconProcess
} from '/core/tool/global/api/local/icon/IconProcess.js';

import {
    LanguageKey,
    LanguageProcess
} from '/core/tool/global/api/local/language/LanguageProcess.js';

import {
    SessionKey,
    SessionProcess
} from '/core/tool/global/api/local/session/SessionProcess.js';

// Theme Type
export class ThemeType {
    // Tema Türleri
    static ThemeDark = "dark";
    static ThemeLight = "light";
    static ThemeAuto = "auto";

    // Tema Türlerini İçeren Dizi
    static ThemeArr = Array(
        this.ThemeDark,
        this.ThemeLight
    );
}

// Theme Error
class ThemeError {
    // Hata Mesajları
    static ErrorMsg_ThemeSwitcherUnavailable = "Theme Switcher Unavailable";
    static ErrorMsg_ThemeNotFound = "Theme Not Found";
    static ErrorMsg_ThemeButtonNotFound = "Theme Button Not Found";
    static ErrorMsg_ThemeElementNotFound = "Theme Element Not Found";
    static ErrorMsg_ParentElementNotFound = "Parent Element Not Found";
    static ErrorMsg_FailGetSystemTheme = "Failed to Retrieve User System Theme";
    static ErrorMsg_FailChangeBtnTitle = "Failed to Change Button Title";
    static ErrorMsg_DataNotFound = "Data Not Found";
}

// Theme Functions
class ThemeFunctions {
    static attrTheme = "data-color-theme";

    // Tema seçme
    static Select(theme) {
        // Geçerli bir tema ile uyuşuyorsa eğer
        // kullanılabilir ama onun dışında
        // otomatik temaya geçilmeli
        switch(theme) {
            case (ThemeType.ThemeDark):
            case (ThemeType.ThemeLight):
                return (window.matchMedia(`(prefers-color-scheme: ${theme})`).matches) ? (theme) : (ThemeType.ThemeAuto);
            case (ThemeType.ThemeAuto):
                for(var tcount = 0; tcount < (ThemeType.ThemeArr).length; tcount++) {
                    var tempTheme = ThemeType.ThemeArr[tcount];

                    if(window.matchMedia(`(prefers-color-scheme: ${tempTheme})`).matches) {
                        return (tempTheme);
                    }
                }
        }

        // Otomatik tema, yoksa da boş dönsün
        return (ThemeType.ThemeAuto || null);
    }

    // Tema değerini getirtme
    static Value(elementAttr) {
        // tema değeri elementi yoksa veya boş ise
        switch(true) {
            case (typeof elementAttr === "undefined" || elementAttr === null):
                return null;
        }

        // tema değerini getir, yoksa da boş dönsün
        return (elementAttr.getAttribute(ThemeFunctions.attrTheme) || null);
    }

    // Tema ikonunu getirtme
    static async Icon(theme) {
        // hangi ikonunu seçileceğini tutma
        var iconKey = null;

        // Temaya göre ikon belirleme
        switch(theme) {
            case (ThemeType.ThemeDark):
                iconKey = (IconAll.ikeyThemeDark);
                break;
            case (ThemeType.ThemeLight):
                iconKey = (IconAll.ikeyThemeLight);
                break;
            default:
                iconKey = (IconAll.ikeyThemeAuto);
                break;
        }

        // iconu tutacak
        const iconData = await IconProcess.Get(iconKey).then();

        // icon verisini döndür, yoksa da boş dönsün
        return (iconData || null);
    }

    // Temayı değiştir
    static Change(htmlElement, attrtheme, theme) {
        // geçici tema değerini tutma
        var tempValueTheme = theme;

        switch(theme) {
            case (ThemeType.ThemeAuto):
                // sistem desteğine göre tema seçtirmek
                tempValueTheme = ThemeFunctions.Select(ThemeType.ThemeAuto);

                // Eğer yine otomatik tema seçili ise, rastgele tema seç
                switch(true) {
                    case (tempValueTheme == ThemeType.ThemeAuto):
                        tempValueTheme = ThemeType.ThemeArr[Math.floor(Math.random() * ThemeType.ThemeArr.length).theme];
                }
        }

        // Bir sonraki elementi seçmek için şuanki temayı buluyoruz
        const indexTheme = ThemeType.ThemeArr.indexOf(tempValueTheme);

        // Eğer index bulunmuşsa sonrakini seçmesini sağlıyoruz
        // Eğer devamı yoksa dizinin başından seçiyor
        switch(indexTheme !== -1) {
            case true:
                tempValueTheme = (indexTheme < ((ThemeType.ThemeArr.length) - 1)) ?
                    (ThemeType.ThemeArr[indexTheme + 1]) :
                    (ThemeType.ThemeArr[0]);
                break;
            default:
                tempValueTheme = ThemeType.ThemeArr[Math.floor(Math.random() * ThemeType.ThemeArr.length).theme];
        }

        // Elementin tema değerini değiştirme
        htmlElement.setAttribute(attrtheme, tempValueTheme);

        // Eğer sıradaki tema yoksa zaten dizi başına gelicek
        // bu yüzden başlangıç değeri dizi başındaki değeridir
        var tempNextTheme = (ThemeType.ThemeArr[0]);
        
        // Sıradaki temanın değerini alıp döndürme
        const indexNowTheme = ThemeType.ThemeArr.indexOf(tempValueTheme);

        switch(indexNowTheme !== -1) {
            case true:
                tempNextTheme = (indexNowTheme < ((ThemeType.ThemeArr.length) - 1)) ?
                    (ThemeType.ThemeArr[indexNowTheme + 1]):
                    (ThemeType.ThemeArr[0]);
        }

        // Tema değerini döndürme, yoksa da başlangıç temasını döndürme
        return (tempNextTheme || ThemeType.ThemeArr[0]);
    }

    // Tema Metin İsim Anahtarı
    static TextKey(theme) {
        switch(theme) {
            case (ThemeType.ThemeAuto):
                return (LanguageKey.keyLanguage_Global_Changetheme);
            case (ThemeType.ThemeDark):
                return (LanguageKey.keyLanguage_Global_Themedark);
            case (ThemeType.ThemeLight):
                return (LanguageKey.keyLanguage_Global_Themelight);
        }

        return null;
    }
}

// Theme Process
export class ThemeProcess {
    // Tema değiştirici buttona ait özellikler
    static idThemeSwitchBtn = "id_themebtn";
    static classThemeSwitchBtn = "minibtn themebtn";

    // Tema Seçim Elementi Oluşturucu
    static async CreateSwitcher(parentElement, attributeElement) {
        // Eğer tema elementini oluşturacağımız ana element
        // ya da durumuna göre değişkilik yapmamızı sağlayacak
        // değişken anahtarı yoksa, oluşturmasın
        switch(true) {
            case (typeof parentElement === "undefined" || parentElement === null):
            case (typeof attributeElement === "undefined" || attributeElement === null):
                return false;
        }

        // Tema değerini tutan türden değeri almak
        var valueTheme = (ThemeFunctions.Value(attributeElement));

        // Butonu oluşturma
        const elementBtnThemeSwitch = document.createElement("button");

        // Id, Sınıf ver
        elementBtnThemeSwitch.setAttribute("id", ThemeProcess.idThemeSwitchBtn || null);
        elementBtnThemeSwitch.setAttribute("class", ThemeProcess.classThemeSwitchBtn || null);

        // Ana elementin içine aktar
        parentElement.appendChild(elementBtnThemeSwitch);

        // Temaya göre buton ikonu seçilecek
        ThemeFunctions.Icon(valueTheme).then(icon => {
            elementBtnThemeSwitch.innerHTML = icon;
        });

        // dil parametreleri
        let paramLanguage = null;
        const paramPart = String(LanguageKey.partGlobal);
        let paramKey = String(LanguageKey.keyLanguage_Global_Changetheme || "changetheme");
        var themeNow;

        // Oturum verisini almak
        const dataSession = await SessionProcess.SessionFetch();

        // dil bilgisini almak
        paramLanguage = dataSession[SessionKey.keySession_Languageshort] || null;

        // Dil anahtarı ile butona başlık eklesin
        const dataLanguageText = await LanguageProcess.GetBasicKey(paramLanguage, paramPart, paramKey);
        let titleThemeSwitcher = dataLanguageText || null;

        // buton başlığını değiştir
        elementBtnThemeSwitch.title = titleThemeSwitcher;

        // Butonun alabileceği 2 ikon
        const iconElementBtnThemeSwitch = ThemeType.ThemeArr;

        // Butona tıklandığında tema değişikliğini yaptırma
        elementBtnThemeSwitch.addEventListener("click", function() {
            valueTheme = ThemeFunctions.Value(attributeElement) || null;
            themeNow = ThemeFunctions.Change(attributeElement, ThemeFunctions.attrTheme, valueTheme) || null;
            paramKey = ThemeFunctions.TextKey(themeNow) || null;

            // buton başlığını değiştir
            SessionProcess.SessionFetch().then(session => {
                paramLanguage = String(session[SessionKey.keySession_Languageshort] || null);

                LanguageProcess.GetBasicKey(paramLanguage, paramPart, paramKey).then(language => {
                    // veri varsa
                    if(typeof language !== "undefined" && language !== null) {
                        titleThemeSwitcher = String(language);
                        elementBtnThemeSwitch.title = String(titleThemeSwitcher);
                    }
                });
            });

            // Butonun ikonunu değiştirme
            ThemeFunctions.Icon(themeNow).then(icon => {
                elementBtnThemeSwitch.innerHTML = icon;
            });
        });

        return true;
    }
}