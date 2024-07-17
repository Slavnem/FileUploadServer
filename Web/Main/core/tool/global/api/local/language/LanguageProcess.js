// Import
import {
    urlApiLanguage,
    routeApiLanguage,
    valueApiProcLanguageFetch,
    methodApiSecure, methodApiVisible,
    headerJSON,
} from '/core/tool/global/url/UrlData.js';

// Language Error
class LanguageError {
    // Hata Mesajları
    static ErrorMsg__LanguageUnableData = "Unable To Retrieve Language Data";
    static ErrorMsg__LanguageKeyNotFound = "Language Key Not Found";
    static ErrorMsg__LanguagePartKeyNotFound = "Language Part Key Not Found";
    static ErrorMsg__LanguageBaseKeyNotFound = "Language Base Key Not Found";
}

// Language Key
export class LanguageKey {
    // Veri getirme türleri
    static getBasic = "basic";
    static getDetailed = "large";

    // Desteklenen parçalar
    static partGlobal = "global";
    static partAuthLogin = "auth_login";
    static partAuthRegister = "auth_register";
    static partGlobalHomepage = "global_homepage";
    static partCryptEncrypt = "crypt_encryption";
    static partCryptDecrypt = "crypt_decryption";

    // Verilere erişmeyi sağlayan değişkenler
    static keyLanguage_Global_Changetheme = "changetheme";
    static keyLanguage_Global_Themedark = "themedark";
    static keyLanguage_Global_Themelight = "themelight";

    // AUTH/LOGIN
    static keyLanguage_AuthLogin_Login = "login";
    static keyLanguage_AuthLogin_Description = "description";
    static keyLanguage_AuthLogin_Cannotlogin = "cannotlogin";
    static keyLanguage_AuthLogin_Registernow = "registernow";
    static keyLanguage_AuthLogin_Infotext = "infotext";
    static keyLanguage_AuthLogin_Loginsuccess = "loginsuccess";
    static keyLanguage_AuthLogin_Loginerror = "loginerror";
    static keyLanguage_AuthLogin_Loginwarning = "loginwarning";

    // ADMIN/ENCRYPT
    static keyLanguage_CryptEncrypt_Title = "title";
    static keyLanguage_CryptEncrypt_Description = "description";
    static keyLanguage_CryptEncrypt_EncTextTitle = "enctexttitle";
    static keyLanguage_CryptEncrypt_EncTextDescription = "enctextdesc";
    static keyLanguage_CryptEncrypt_TitleAlgorithm = "encalgorithmtitle";
    static keyLanguage_CryptEncrypt_TitleProcess = "encprocesstitle";
    static keyLanguage_CryptEncrypt_EncSubmitbtn = "encsubmitbtn";
}

// Language Functions
class LanguageFunctions {
    // Language Get
    static async Fetch(params) {
        // parametrelerini hazırlamak
        const languageParams = {
            route: routeApiLanguage,
            process: valueApiProcLanguageFetch,
            type: String(params.type) || null,
            language: String(params.language) || null,
            part: String(params.part) || null,
            key: String(params.key) || null
        };

        // fetch bağlantısı
        const dataFetch = await fetch(urlApiLanguage, {
            method: methodApiSecure,
            headers: { headerJSON },
            body: JSON.stringify(languageParams)
        });

        // veriyi kontrol et ve sonucu döndür
        return (dataFetch.ok) ?  (dataFetch.json()) : ({});
    }
}

// Language Process
export class LanguageProcess {
    // Get Basic
    static async GetBasic(argLanguage, argPart, argKey) {
        // parametreler
        const params = {
            type: String(LanguageKey.getBasic) || "",
            language: String(argLanguage) || "",
            part: String(argPart) || "",
            key: String(argKey) || ""
        };

        // veriyi döndürmek
        return (await LanguageFunctions.Fetch(params) || {});
    }

    // Get Detailed
    static async GetDetailed(argLanguage, argPart, argKey, argSimplify = false) {
        // parametreler
        const params = {
            type: String(LanguageKey.getDetailed) || "",
            language: String(argLanguage) || "",
            part: String(argPart) || "",
            key: String(argKey) || "",
            simplify: Boolean(argSimplify) || false
        };

        // veriyi döndürmek
        return (await LanguageFunctions.Fetch(params) || {});
    }

    // Seçili Dili Alma
    static async GetBasicLanguage(argLanguage) {
        // verinin tamamını al
        const dataBasic = await this.GetBasic(argLanguage, "", "");

        // önemli bir değer tanımsız ise boş dönsün
        switch(true) {
            case (typeof dataBasic[argLanguage] === "undefined"):
                return null;
        }

        // eğer veri tanımlıysa döndür yoksa null döndür
        return (typeof dataBasic[argLanguage] !== "undefined") ?
            (dataBasic[argLanguage]) : null;
    }

    // Seçili Parçayı Alma
    static async GetBasicPart(argLanguage, argPart) {
        // verinin tamamını al
        const dataBasic = await this.GetBasic(argLanguage, argPart, "");

        // önemli bir değer tanımsız ise boş dönsün
        switch(true) {
            case (typeof dataBasic[argLanguage] === "undefined"):
            case (typeof dataBasic[argLanguage][argPart] === "undefined"):
                return null;
        }

        // eğer veri tanımlıysa döndür yoksa null döndür
        return (typeof dataBasic[argLanguage][argPart] !== "undefined") ?
            (dataBasic[argLanguage][argPart]) : null;
    }

    // Seçili Anahtarı Alma
    static async GetBasicKey(argLanguage, argPart, argKey) {
        // verinin tamamını al
        const dataBasic = await this.GetBasic(argLanguage, argPart, argKey);

        // önemli bir değer tanımsız ise boş dönsün
        switch(true) {
            case (typeof dataBasic[argLanguage] === "undefined"):
            case (typeof dataBasic[argLanguage][argPart] === "undefined"):
            case (typeof dataBasic[argLanguage][argPart][argKey] === "undefined"):
                return null;
        }

        // eğer veri tanımlıysa döndür yoksa null döndür
        return (typeof dataBasic[argLanguage][argPart][argKey] !== "undefined") ?
            (dataBasic[argLanguage][argPart][argKey]) : null;
    }
}