// Methods
import * as QueryMethods from "../Global/Methods.js";

// URL
import * as URLs from "../Global/URL.js";

// Fetch Api JS Service
import {
    ApiService
} from "../Global/API.js";

// Session
export class MySession {
    // Oturum değişkenleri
    static sessionID = "id";
    static sessionUsername = "username";
    static sessionEmail = "email";
    static sessionPassword = "password";
    static sessionMember = "member";
    static sessionVerify = "verify";
    static sessionTheme = "theme";
    static sessionLanguage = "language";

    // Oturum Getirme
    static async Fetch() {
        // oturum verilerini alsın ve döndürsün
        return await ApiService.FetchData(
            URLs.ApiSessionURL,
            QueryMethods.MethodFetch,
            null
        );
    }

    // Oturum Oluşturma
    static async Create(params) {
        // parametreleri kontrol etsin, yoksa boş dönsün
        if((!params.username && !params.email) || (!params.password))
            return null;

        // oturum oluşturmak için
        return await ApiService.FetchData(
            URLs.ApiSessionURL,
            QueryMethods.MethodCreate,
            params
        );
    }

    // Oturumu Güncelle
    static async Update() {
        // oturum güncellemek için
        return await ApiService.FetchData(
            URLs.ApiSessionURL,
            QueryMethods.MethodUpdate,
            null
        );
    }

    // Oturumu Doğrula
    static async Verify() {
        // oturum doğrulamak için
        return await ApiService.FetchData(
            URLs.ApiSessionURL,
            QueryMethods.MethodVerify,
            null
        );
    }

    // Oturumu Sil
    static async Delete() {
        // oturum silmek için
        return await ApiService.FetchData(
            URLs.ApiSessionURL,
            QueryMethods.MethodDelete,
            null
        );
    }
}