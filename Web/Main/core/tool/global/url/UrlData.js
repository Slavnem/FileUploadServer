// TOOL
export const urlToolGlobalBackgroundSelector = "/core/tool/global/background/BackgroundSelector.js";
export const urlToolGlobalIconSelect = "/core/tool/global/icon/IconSelect.js";
export const urlToolGlobalLanguageSupport = "/core/tool/global/language/LanguageSupport.js";
export const urlToolGlobalLanguageSelector = "/core/tool/global/language/LanguageSelector.js";
export const urlToolGlobalLocalStorage = "/core/tool/global/localstorage/LocalStorage.js";
export const urlToolGlobalSessionData = "/core/tool/global/session/SessionData.js";
export const urlToolGlobalSignLoginProcess = "/core/tool/global/sign/LoginProcess.js";
export const urlToolGlobalSignRegisterProcess = "/core/tool/global/sign/RegisterProcess.js";
export const urlToolGlobalColorThemeChanger = "/core/tool/global/theme/ColorThemeChanger.js";
export const urlToolGlobalUrlData = "/core/tool/global/url/UrlData.js";

// BASE -> DEFAULT
export const urlBase = "//main.server.com/";
export const urlBaseServerApi = (urlBase + "sapi");
export const urlBaseLocalApi = (urlBase + "lapi");
export const urlBaseCryptApi = (urlBase + "crypt");

// HEADER
export const headerJSON = "'Content-Type': 'application/json; charset=UTF-8'";

// URL -> API -> SERVER
export const urlApiUsers = (urlBaseServerApi);

// URL -> API -> LOCAL
export const urlApiLanguage = (urlBaseLocalApi);
export const urlApiBackground = (urlBaseLocalApi);
export const urlApiIcon = (urlBaseLocalApi);
export const urlApiSession = (urlBaseLocalApi);
export const urlApiEncrypt = (urlBaseCryptApi);
export const urlApiDecrypt = (urlBaseCryptApi);

// METHOD
export const methodApiSecure = "SECURE";
export const methodApiVisible = "VISIBLE";

// ROUTE API -> SERVER
export const routeApiUsers = "users";

// ROUTE API -> LOCAL
export const routeApiLanguage = "language";
export const routeApiBackground = "background";
export const routeApiIcon = "icon";
export const routeApiSession = "session";

// ROUTE API -> CRYPTOGRAPHY
export const routeApiEncryption = "encrypt";
export const routeApiDecryption = "decrypt";

// VALUE API -> SERVER
export const valueApiProcUsersVerify = "verify";
export const valueApiProcUsersFetch = "fetch";

// VALUE API -> LOCAL
export const valueApiProcSessionNew = "new";
export const valueApiProcSessionDestroy = "destroy";
export const valueApiProcSessionFetch = "fetch";
export const valueApiProcSessionUpdate = "update";
export const valueApiProcSessionVerify = "verify";
export const valueApiProcSessionAdmin = "admin";
export const valueApiProcSessionModerator = "moderator";

export const valueApiProcBackgroundFetch = "fetch";
export const valueApiProcLanguageFetch = "fetch";
export const valueApiProcIconFetch = "fetch";

// VALUE API -> CRYPT
export const valueApiProcEncryptionCreate = "create";
export const valueApiProcEncryptionVerify = "verify";
export const valueApiProcEncryptionFetchAlgos = "fetchalgos";
export const valueApiProcEncryptionFetchProcs = "fetchprocs";

// PAGE -> GLOBAL
export const urlPageHomepage = (urlBase + "homepage");
export const urlPageLogin = (urlBase + "auth/login");
export const urlPageRegister = (urlBase + "auth/register");

// PAGE -> SHARED
export const urlPageSharedMain = (urlBase + "global/main");