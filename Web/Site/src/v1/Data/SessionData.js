// Oturum İçin Gerekli Sınıf
import {
    MySession
} from "../Tool/Session/MySession.js";

// Dil Bilgisi
import LanguageData from "./Language.json" with { type: 'json' };

// Oturum
export const SessionData = (await MySession.Fetch()) || null;

// Oturum dili
export const SessionLanguage = (SessionData) ? SessionData["language"] : "en";

// Dil bilgileri
export const MyLanguageData = LanguageData[SessionLanguage] || null;