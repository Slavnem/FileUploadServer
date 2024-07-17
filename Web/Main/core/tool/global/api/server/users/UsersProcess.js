// Import
import {
    urlApiUsers,
    routeApiUsers,
    valueApiProcUsersVerify, valueApiProcUsersFetch,
    methodApiSecure, methodApiVisible,
    headerJSON,
} from '/core/tool/global/url/UrlData.js';

// Kullanıcı Hatalar
class UsersError {
    // Hata Mesajları
    static ErrorMsg_DataNotFound = "Data Not Found";
}

// Kullanıcı Fonksiyonları
class UsersFunctions {
    // Kullanıcı Verilerini Getirmek
    static async Fetch(userparams) {
        // paratmetreleri almak
        const params = {
            route: String(routeApiUsers || null),
            process: String(valueApiProcUsersFetch || null),
            username: String(userparams.username || null),
            password: String(userparams.password || null)
        };

        try {
            // fetch ile api ya sorgu göndermek
            const response = await fetch(urlApiUsers, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });
        
            // json objesine çevirilmiş veriyi döndürmek
            return (response.json());
        } catch(error) {
            console.error(UsersError.ErrorMsg_DataNotFound || "Data Not Found");
        }

        return null;
    }

    // Kullanıcı Doğrulama
    static async Verify(userparams) {
        // paratmetreleri almak
        const params = {
            route: String(routeApiUsers || null),
            process: String(valueApiProcUsersVerify || null),
            username: String(userparams.username || null),
            password: String(userparams.password || null)
        };

        try {
            // fetch ile api ya sorgu göndermek
            const response = await fetch(urlApiUsers, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });
        
            // json objesine çevirilmiş veriyi döndürmek
            return (response.json());
        } catch(error) {
            console.error(UsersError.ErrorMsg_DataNotFound || "Data Not Found");
        }

        return null;
    }
}

// Kullanıcı İşlemleri
export class UsersProcess {
    // Kullanıcı Bilgileri
    static async UserData(argUsername, argPassword) {
        // parametreler
        const params = {
            username: String(argUsername) || null,
            password: String(argPassword) || null
        };

        // veriyi döndürme
        return (await UsersFunctions.Fetch(params)) || null;
    }

    // Kullanıcı Doğrulama
    static async UserVerify(argUsername, argPassword) {
        // parametreler
        const params = {
            username: String(argUsername) || null,
            password: String(argPassword) || null
        };

        // veriyi döndürme
        return (await UsersFunctions.Verify(params)) || null;
    }
}