// Methods
import * as QueryMethods from "../Global/Methods.js";

// URL
import * as URLs from "../Global/URL.js";

// Fetch Api JS Service
import {
    ApiService
} from "../Global/API.js";

// Auth
export class MyAuth {
    // Yetiklendirme Doğrula
    static async AuthVerify(argParams) {
        // bazıları boş olmamak zorunda
        if((argParams.username === null && argParams.email === null) || (argParams.password === null))
            return -1;

        // veriyi al
        const verify = await ApiService.FetchData(
            URLs.ApiAuthURL,
            QueryMethods.MethodFetch,
            argParams
        );

        // veri boşsa, boş dönsün
        if(!verify || verify === null) return null;

        // veriyi döndürsün
        return verify;
    }
}