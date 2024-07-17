// Import
import {
    urlApiSession,
    routeApiSession,
    valueApiProcSessionNew, valueApiProcSessionDestroy,
    valueApiProcSessionFetch, valueApiProcSessionUpdate,
    valueApiProcSessionVerify, valueApiProcSessionAdmin,
    valueApiProcSessionModerator,
    methodApiSecure, methodApiVisible,
    headerJSON
} from '/core/tool/global/url/UrlData.js';

// Session Error
class SessionError {
    // Hata mesajları
    static ErrorMsg_SessionUser = "Session User Error";
    static ErrorMsg_SessionUpdate = "Session Update Error";
    static ErrorMsg_SessionVerify = "Session Verify Error";
    static ErrorMsg_SessionFetch = "Session Fetch Error";
    static ErrorMsg_AutoSession = "Auto Session Update/Check Error";
    static ErrorMsg_SessionParameter = "Check Session Data Submission Parameters";
    static ErrorMsg_SessionSave = "Session Save Error";
}

export class SessionParam {
    // Oturum parametre kelimeleri
    static paramSession_Username = "username";
    static paramSession_Password = "password";
}

export class SessionKey {
    // Oturum anahtar kelimeleri
    static keySession_Id = "session_id";
    static keySession_Username = "session_username";
    static keySession_Name = "session_name";
    static keySession_Lastname = "session_lastname";
    static keySession_Email = "session_email";
    static keySession_Password = "session_password";
    static keySession_Languageid = "session_languageid";
    static keySession_Languageshort = "session_languageshort";
    static keySession_Languagename = "session_languagename";
    static keySession_Memberid = "session_memberid";
    static keySession_Membertype = "session_membertype";
    static keySession_Membername = "session_membername";
    static keySession_Verifyid = "session_verifyid";
    static keySession_Verifytype = "session_verifytype";
    static keySession_Verifyname = "session_verifyname";
    static keySession_Themename = "session_themename";
    static keySession_Themevalue = "session_themevalue";
    static keySession_Created = "session_created";
}

// Session Functions
class SessionFunctions {
    // Yeni Oturum Oluşturmak
    static async New() {
        const params = {
            route: String(routeApiSession) || null,
            process: String(valueApiProcSessionNew) || null
        };

        // herhangi bir veri yoksa boş dönmeli
        switch(true) {
            case (params.route === "undefined" || params.route.length < 1):
            case (params.process === "undefined" || params.process.length < 1):
                console.error(SessionError.ErrorMsg_SessionParameter || "Check Session Data Submission Parameters");
                return null;
        }

        try {
            // api sorgusu yapmak
            const response = await fetch(urlApiSession, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });

            // json objesine çevirilmiş veriyi döndürmek
            return response.json();
        } catch(error) {
            console.error(SessionError.ErrorMsg_SessionSave || "Session Save Error");
        }

        return null;
    }

    // Oturumu Yoketmek
    static async Destroy() {
        const params = {
            route: String(routeApiSession)|| null,
            process: String(valueApiProcSessionDestroy)|| null
        };

        // herhangi bir veri yoksa boş dönmeli
        switch(true) {
            case (params.route === "undefined" || params.route.length < 1):
            case (params.process === "undefined" || params.process.length < 1):
                console.error(SessionError.ErrorMsg_SessionParameter || "Check Session Data Submission Parameters");
                return null;
        }

        try {
            // api sorgusu yapmak
            const response = await fetch(urlApiSession, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });

            // json objesine çevirilmiş veriyi döndürmek
            return response.json();
        } catch(error) {
            console.error(SessionError.ErrorMsg_SessionFetch || "Session Fetch Error");
        }

        return null;
    }

    // Oturum Verilerini Getirtmek
    static async Fetch() {
        const params = {
            route: String(routeApiSession) || null,
            process: String(valueApiProcSessionFetch) || null
        };

        // herhangi bir veri yoksa boş dönmeli
        switch(true) {
            case (params.route === "undefined" || params.route.length < 1):
            case (params.process === "undefined" || params.process.length < 1):
                console.error(SessionError.ErrorMsg_SessionParameter || "Check Session Data Submission Parameters");
                return null;
        }

        try {
            // api sorgusu yapmak
            const response = await fetch(urlApiSession, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });

            // json objesine çevirilmiş veriyi döndürmek
            return response.json();
        } catch(error) {
            console.error(SessionError.ErrorMsg_SessionSave || "Session Save Error");
        }

        return null;
    }

    // Oturum Verilerini Güncelleme
    static async Update(userparams) {
        const params = {
            route: String(routeApiSession) || null,
            process: String(valueApiProcSessionUpdate) || null,
            username: String(userparams.username) || null,
            password: String(userparams.password) || null
        };

        // herhangi bir veri yoksa boş dönmeli
        switch(true) {
            case (params.route === "undefined" || params.route.length < 1):
            case (params.process === "undefined" || params.process.length < 1):
            case (params.username === "undefined" || params.username.length < 1):
            case (params.password === "undefined" || params.password.length < 1):
                console.error(SessionError.ErrorMsg_SessionParameter || "Check Session Data Submission Parameters");
                return null;
        }

        try {
            // api sorgusu yapmak
            const response = await fetch(urlApiSession, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });

            // json objesine çevirilmiş veriyi döndürmek
            return response.json();
        } catch(error) {
            console.error(SessionError.ErrorMsg_SessionUpdate || "Session Update Error");
        }

        return null;
    }

    // Oturum Verilerini Doğrulama
    static async Verify(userparams) {
        const params = {
            route: String(routeApiSession) || null,
            process: String(valueApiProcSessionVerify) || null,
            username: String(userparams.username) || null,
            password: String(userparams.password) || null
        };

        // herhangi bir veri yoksa boş dönmeli
        switch(true) {
            case (params.route === "undefined" || params.route.length < 1):
            case (params.process === "undefined" || params.process.length < 1):
            case (params.username === "undefined" || params.username.length < 1):
            case (params.password === "undefined" || params.password.length < 1):
                console.error(SessionError.ErrorMsg_SessionParameter || "Check Session Data Submission Parameters");
                return null;
        }

        try {
            // api sorgusu yapmak
            const response = await fetch(urlApiSession, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });

            // json objesine çevirilmiş veriyi döndürmek
            return response.json();
        } catch(error) {
            console.error(SessionError.ErrorMsg_SessionVerify || "Session Verify Error");
        }

        return null;
    }

    // Oturum Yetki Doğrulama
    static async MemberVerify(argMemberValue) {
        const params = {
            route: String(routeApiSession) || null,
            process: String(argMemberValue) || null,
        };

        // herhangi bir veri yoksa boş dönmeli
        switch(true) {
            case (params.route === "undefined" || params.route.length < 1):
            case (params.process === "undefined" || params.process.length < 1):
                console.error(SessionError.ErrorMsg_SessionParameter || "Check Session Data Submission Parameters");
                return null;
        }

        try {
            // api sorgusu yapmak
            const response = await fetch(urlApiSession, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });

            // json objesine çevirilmiş veriyi döndürmek
            return response.json();
        } catch(error) {
            console.error(SessionError.ErrorMsg_SessionVerify || "Session Verify Error");
        }

        return null;
    }
}

// SESSION PROCESS CLASS
export class SessionProcess {
    // Session New
    static async SessionNew() {
        return (await SessionFunctions.New() || null);
    }

    // Session Verify
    static async SessionVerify(argUsername, argPassword) {
        // parametreler
        const params = {
            username: String(argUsername) || null,
            password: String(argPassword) || null
        };

        // Doğrulama işlemi yaptırmak
        const statusVerify = await SessionFunctions.Verify(params);

        // Doğrulama durumna göre döndürmek
        return (statusVerify || false);
    }

    // Session Update
    static async SessionUpdate(argUsername, argPassword) {
        // parametreler
        const params = {
            username: String(argUsername) || null,
            password: String(argPassword) || null
        };

        // Güncelleme işlemi yaptırmak
        const statusUpdate = await SessionFunctions.Update(params);

        // Güncelleme durumna göre döndürmek
        return Boolean(statusUpdate) || false;
    }

    // Session Destroy
    static async SessionDestroy() {
        return (await SessionFunctions.Destroy()) || false;
    }

    // Session Fetch
    static async SessionFetch() {
        return (await SessionFunctions.Fetch()) || {};
    }

    // Session Anahtarını Getirtme
    static async SessionFetchKey(argSessionkey) {
        return (await this.SessionFetch())[argSessionkey] || null;
    }

    // Session Admin
    static async SessionAdmin() {
        return (await SessionFunctions.MemberVerify(valueApiProcSessionAdmin)) || false;
    }

    // Session Moderator
    static async SessionModerator() {
        return (await SessionFunctions.MemberVerify(valueApiProcSessionModerator)) || false;
    }
}