// Import
import {
    urlApiIcon,
    routeApiIcon,
    valueApiProcIconFetch,
    methodApiSecure, methodApiVisible,
    headerJSON,
} from '/core/tool/global/url/UrlData.js';

// Icon Error
class IconError {
    // Hata Mesajları
    static ErrorMsg__IconNotFound = "Icon Not Found";
}

// Icon Data All
export class IconAll {
    // Genel
    static ikeyQuestion = "question";
    static ikeyError = "error";
    static ikeyWarning = "warning";
    static ikeySuccess = "success";
    static ikeyThemeAuto = "planet";
    static ikeyThemeDark = "moon";
    static ikeyThemeLight = "sun";
    static ikeyCryptsecure = "secure";
    static ikeyCryptinsecure = "insecure";
    static ikeyCryptsecurehalf = "securehalf";
    static ikeyCryptsecurekey = "securekey";
    static ikeyCrypterror = "secureerror";
    static ikeyCryptsuccess = "securesuccess";
    static ikeyInfo = "info";

    // Sayfalar için özel
    static ikeyAuthloginSuccess = this.ikeySuccess;
    static ikeyAuthloginWarning = this.ikeyWarning;
    static ikeyAuthloginError = this.ikeyError;

    // Sayfalar için özel
    static ikeyCryptEncryptCreateSuccess = this.ikeySuccess;
    static ikeyCryptEncryptCreateWarning = this.ikeyWarning;
    static ikeyCryptEncryptCreateError = this.ikeyError;
    static ikeyCryptEncryptVerifySuccess = this.ikeySuccess;
    static ikeyCryptEncryptVerifyWarning = this.ikeyWarning;
    static ikeyCryptEncryptVerifyError = this.ikeyError;
}

// Icon Functions
class IconFunctions {
    static async Fetch(params) {
        // zorunlu değişkenler yoksa boş dönsün
        switch(true) {
            case (typeof params.icon === "undefined" || params.icon === null):
                return {};
        }

        // parametreler
        const iconParams = {
            route: routeApiIcon,
            process: valueApiProcIconFetch,
            icon: String(params.icon)
        };

        // fetch bağlantısı
        const dataFetch = await fetch(urlApiIcon, {
            method: methodApiSecure,
            headers: { headerJSON },
            body: JSON.stringify(iconParams)
        });

        // veriyi kontrol et ve sonucu döndür
        return (dataFetch.ok) ? (dataFetch.json()) : ({});
    }
}

// Icon Process
export class IconProcess {
    static Get(iconKey) {
        // zorunlu değişkenler yoksa boş dönsün
        switch(true) {
            case (typeof iconKey === "undefined" || iconKey === null):
                return {};
        }

        // parametreler
        const params = {
            icon: String(iconKey)
        };

        // Fetch işlemi yapıp gelen değeri döndürmek
        try {
            return IconFunctions.Fetch(params);
        } catch(error) {
            console.error(IconError.ErrorMsg__IconNotFound || "Icon Not Found");
        }

        // boş veri döndür
        return {};
    }
}