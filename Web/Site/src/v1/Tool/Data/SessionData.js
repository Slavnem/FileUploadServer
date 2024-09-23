// Slavnem @2024-09-20
// Oturum Bilgileri

// MySession
import {
    MySession
} from "../Session/MySession.js";

// Oturum güncelle
export const _SessionData = await MySession.Verify();
export const _SessionLanguage = _SessionData?.languagesValue ?? null;

// Sayfa dilini ayarla
document.documentElement.setAttribute("lang", _SessionLanguage ?? "undefined");