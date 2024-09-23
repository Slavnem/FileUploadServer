// Slavnem @2024-09-20
// MyLanguage

// URL
import * as URLs from "../Global/URL.js";

// METHODS
import * as Methods from "../Global/Methods.js";

// API
import {
    ApiService
} from "../Global/API.js";

// Class
export class MyLanguage {
    // Parametre
    static ParamLanguage = "language";
    static ParamPage = "page";

    // Sayfa
    static PageAuthLogin = "auth/login";
    static PageAuthLogout = "auth/logout";
    static PageFiles = "files";

    // Dil Bilgisi
    static async Fetch(arg_language, arg_page) {
        return await ApiService.FetchData(
            URLs.ApiLanguageURL,
            Methods.MethodFetch,
            {
                language: String(arg_language) || null,
                page: String(arg_page) || null
            }
        );
    }
}