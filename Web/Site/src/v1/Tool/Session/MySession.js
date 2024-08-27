// Methods
import * as QueryMethods from "/Site/src/v1/Tool/Global/Methods.js";

// URL
import * as URLs from "/Site/src/v1/Tool/Global/URL.js";

// Fetch Api JS Service
import {
    ApiService
} from "/Site/src/v1/Tool/Global/API.js";

// Session
export class MySession {
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