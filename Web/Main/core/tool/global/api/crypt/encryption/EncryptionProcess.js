// Import Global
import {
    urlApiEncrypt, urlPageLogin,
    routeApiEncryption,
    valueApiProcEncryptionCreate, valueApiProcEncryptionVerify,
    valueApiProcEncryptionFetchAlgos, valueApiProcEncryptionFetchProcs,
    methodApiSecure,
    headerJSON
} from '/core/tool/global/url/UrlData.js';

// Import Api Local
import {
    AuthProcess
} from '/core/tool/global/sign/AuthProcess.js';

import {
    BackgroundProcess,
    BackgroundPage,
    BackgroundStyle
} from '/core/tool/global/api/local/background/BackgroundProcess.js';

import {
    SessionKey,
    SessionProcess
} from '/core/tool/global/api/local/session/SessionProcess.js';

import {
    ThemeType,
    ThemeProcess
} from '/core/tool/global/theme/ThemeProcess.js';

// Import Api Server
import {
    UsersProcess
} from '/core/tool/global/api/server/users/UsersProcess.js';

import {
    LanguageKey,
    LanguageProcess
} from '/core/tool/global/api/local/language/LanguageProcess.js';

import {
    IconAll,
    IconProcess
} from '/core/tool/global/api/local/icon/IconProcess.js';

// Şifreleme İşlemleri İçin Hata Mesajları
class EncryptionError {
    // Hata Mesajları
    static ErrorMsg_LanguageKeyNotFound = "Language Key Not Found!";
    static ErrorMsg_LanguageKeyPartNotFound = "Language Key Part Not Found!";
    static ErrorMsg_TitleUnable = "Unable to Change \"Title\"";
    static ErrorMsg_EncTextTitle = "Unable to Change Encoder \"Text Area Title\"";
    static ErrorMsg_EncTextDescription = "Unable to Change \"Encoder Text Area Description\"";
    static ErrorMsg_LabelAlgorithm = "Unable to Change \"Label Algorithm\"";
    static ErrorMsg_LabelEncType = "Unable to Change \"Label Encryption Type\"";
    static ErrorMsg_EncSubmitBtn = "Unable to Change \"Encoder Submit Button\" Text";
    static ErrorMsg_EncTypeCreate = "Unable to Change \"Encoder Type Create\" Text";
    static ErrorMsg_FailedAutoText = "Failed To Automatically Change The Text On The Page";
    static ErrorMsg_EncSubmitBtnNotFound = "Encryption Submit Button Not Found";
    static ErrorMsg_EncInputBasedataNotFound = "Encryption Input \"Basedata\" Not Found";
    static ErrorMsg_EncInputEncryptedNotFound = "Encryption Input \"Encrypted\" Not Found";
    static ErrorMsg_BasedataNull = "Basedata Empty for Encryption";
    static ErrorMsg_AlgorithmNotFound = "Algorithm Not Found For Encryption";
    static ErrorMsg_SelectedEncTypeNotFound = "Selected Encryption Type None";
    static ErrorMsg_FetchEncryption = "Fetch Encryption Error";
    static ErrorMsg_IconElementNotFound = "Icon Element Not Found";
    static ErrorMsg_IconTextElementNotFound = "Icon Text Element Not Found";
    static ErrorMsg_DataNotFound = "Data Not Found";
    static ErrorMsg_ElementSubmitbtnNotFound = "Submit Button Element Not Found";
    static ErrorMsg_ElemetAlgorithmNotFound = "Algorithm Selection Element Not Found";
    static ErrorMsg_ElemetProcessNotFound = "Process Selection Element Not Found";
    static ErrorMsg_ElemetBasetextNotFound = "Basetext Input Element Not Found";
    static ErrorMsg_ElemetEncryptedNotFound = "Encrypted Input Element Not Found";
    static ErrorMsg_ElementStatusAreaNotFound = "Status Area Element Not Found";
    static ErrorMsg_ElementStatusIconNotFound = "Status Icon Element Not Found";
    static ErrorMsg_ElementStatusTextNotFound = "Status Text Element Not Found";
    static ErrorMsg_ElementNotFound = "Element Not Found";
    static ErrorMsg_StatusCannotDetect = "Status Cannot Detect";
    static ErrorMsg_NonAdminUser = "Non Admin User";
}

// Şifreleme İşlemleri İçin Anahtarlar
export class EncryptionKey {
    // Şifreleme işlemler durumları
    static keyEncryption_DataStatus = "data-encrypt-status";
    static keyEncryption_Title = "enctitle";
    static keyEncryption_StatusCreateSuccess = "enccreatesuccess";
    static keyEncryption_StatusCreateError = "enccreateerror";
    static keyEncryption_StatusCreateWarning = "enccreatewarning";
    static keyEncryption_StatusVerifySuccess = "encverifysuccess";
    static keyEncryption_StatusVerifyError = "encverifyerror";
    static keyEncryption_StatusVerifyWarning = "encverifywarning";
    static keyEncryption_MultiAlgorithm = "multialgorithm";
    static keyEncryption_MultiProcess = "multiprocess";
}

// Şifreleme İşlemleri İçin Fonksiyonlar
class EncryptionFunctions {
    // Şifreleme Türleri
    static EncryptProc_Create = "create";
    static EncryptProc_Verify = "verify";
 
    // Sonuç Parametreleri
    static ResultParam_Algorithm = "algorithm";
    static ResultParam_Basedata = "basedata";
    static ResultParam_Encrypted = "encrypted";
    static ResultParam_Verify = "verify";

    // Metini Şifreleme
    static async Encrypt(argUserparams) {
        // parametreleri hazırlamak
        const params = {
            route: String(routeApiEncryption) || "",
            process: String(valueApiProcEncryptionCreate) || "",
            algorithm: String(argUserparams.algorithm) || "",
            basetext: String(argUserparams.basetext) || ""
        };

        try {
            // fetch ile api ya sorgu göndermek
            const response = await fetch(urlApiEncrypt, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });
        
            // json objesine çevirilmiş veriyi döndürmek
            return (response.json());
        } catch(error) {
            console.error(EncryptionError.ErrorMsg_DataNotFound || "Data Not Found");
        }

        return null;
    }

    // Metin ve Şifreli Metini Karşılaştırıp Doğrulama
    static async Verify(argUserparams) {
        // parametreleri hazırlamak
        const params = {
            route: String(routeApiEncryption) || "",
            process: String(valueApiProcEncryptionVerify) || "",
            algorithm: String(argUserparams.algorithm) || "",
            basetext: String(argUserparams.basetext) || "",
            encrypted: String(argUserparams.encrypted) || ""
        };

        try {
            // fetch ile api ya sorgu göndermek
            const response = await fetch(urlApiEncrypt, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });
        
            // json objesine çevirilmiş veriyi döndürmek
            return response.json();
        } catch(error) {
            console.error(EncryptionError.ErrorMsg_DataNotFound || "Data Not Found");
        }

        return Boolean(false);
    }

    // Şifreleme Algoritmalarını Getirtme
    static async FetchAlgos(argAlgorithm) {
        // parametreleri hazırlamak
        const params = {
            route: String(routeApiEncryption) || "",
            process: String(valueApiProcEncryptionFetchAlgos) || "",
        };

        // Algoritma bilgisi boş değilse parametrelere eklensin
        switch(true) {
            case (typeof argAlgorithm !== "undefined" && argAlgorithm !== null && argAlgorithm.length > 0):
                params = {
                    ...params,
                    algorithm: String(argAlgorithm)
                };
        }

        try {
            // fetch ile api ya sorgu göndermek
            const response = await fetch(urlApiEncrypt, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });
        
            // json objesine çevirilmiş veriyi döndürmek
            return response.json();
        } catch(error) {
            console.error(EncryptionError.ErrorMsg_DataNotFound || "Data Not Found");
        }

        return null;
    }

    // Şifreleme İşlemlerini Getirtme
    static async FetchProcs(argAlgorithm) {
        // parametreleri hazırlamak
        const params = {
            route: String(routeApiEncryption) || "",
            process: String(valueApiProcEncryptionFetchProcs) || ""
        };

        try {
            // fetch ile api ya sorgu göndermek
            const response = await fetch(urlApiEncrypt, {
                method: methodApiSecure,
                headers: { headerJSON },
                body: JSON.stringify(params)
            });
        
            // json objesine çevirilmiş veriyi döndürmek
            return response.json();
        } catch(error) {
            console.error(EncryptionError.ErrorMsg_DataNotFound || "Data Not Found");
        }

        return null;
    }
}

// Şifreleme İşlemleri
class EncryptionProcess {
    // Giriş Durumu Mesajcısı
    static async StatusMessage(argStatus, argCustomMsg = null) {
        // elementler
        const elementStatusArea = document.querySelector(`div#id_statusarea`);
        const elementStatusIcon = document.querySelector(`span#id_statusarea_icon`);
        const elementStatusText = document.querySelector(`span#id_statusarea_text`);

        // Tanımsız element
        switch(true) {
            case (elementStatusArea === null):
                throw new Error(EncryptionError.ErrorMsg_ElementStatusAreaNotFound || "Login Status Error: Status Area Element Not Found");
            case (elementStatusIcon === null):
                throw new Error(EncryptionError.ErrorMsg_ElementStatusIconNotFound || "Login Status Error: Status Icon Element Not Found");
            case (elementStatusText === null):
                throw new Error(EncryptionError.ErrorMsg_ElementStatusTextNotFound || "Login Status Error: Status Text Element Not Found");
            case (argStatus == EncryptionKey.keyEncryption_StatusCreateSuccess):
            case (argStatus == EncryptionKey.keyEncryption_StatusCreateWarning):
            case (argStatus == EncryptionKey.keyEncryption_StatusCreateError):
            case (argStatus == EncryptionKey.keyEncryption_StatusVerifySuccess):
            case (argStatus == EncryptionKey.keyEncryption_StatusVerifyWarning):
            case (argStatus == EncryptionKey.keyEncryption_StatusVerifyError):
                break;
            default:
                throw new Error(EncryptionError.ErrorMsg_StatusCannotDetect || "Status Error: Language Base Key Error!")
        }

        // anahtar kelimeler
        let keyLanguage = (await SessionProcess.SessionFetchKey(SessionKey.keySession_Languageshort)) || null;
        const keyPart = String(LanguageKey.partCryptEncrypt) || null;
        let keyBase = String(argStatus) || null;
        var keyIcon = null;

        // eğer parça ya da anahtar bilgisi boş ise hata çıktısı
        switch(null) {
            case (keyPart):
                throw new Error(LanguageSupport.ErrorMsg_LanguagePartKeyNotFound || "Language Error: Language Part Key");
            case (keyBase):
                throw new Error(LanguageSupport.ErrorMsg_LanguageBaseKeyNotFound || "Language Error: Language Base Key");
        }

        // Dil anahatar verisi düzenleme
        switch(keyBase) {
            case (EncryptionKey.keyEncryption_StatusCreateSuccess):
                keyBase = String(EncryptionKey.keyEncryption_StatusCreateSuccess);
                keyIcon = String(IconAll.ikeyCryptEncryptCreateSuccess);
                break;
            case (EncryptionKey.keyEncryption_StatusCreateWarning):
                keyBase = String(EncryptionKey.keyEncryption_StatusCreateWarning);
                keyIcon = String(IconAll.ikeyCryptEncryptCreateWarning);
                break;
            case (EncryptionKey.keyEncryption_StatusCreateError):
                keyBase = String(EncryptionKey.keyEncryption_StatusCreateError);
                keyIcon = String(IconAll.ikeyCryptEncryptCreateError);
                break;
            case (EncryptionKey.keyEncryption_StatusVerifySuccess):
                keyBase = String(EncryptionKey.keyEncryption_StatusVerifySuccess);
                keyIcon = String(IconAll.ikeyCryptEncryptVerifySuccess);
                break;
            case (EncryptionKey.keyEncryption_StatusVerifyWarning):
                keyBase = String(EncryptionKey.keyEncryption_StatusVerifyWarning);
                keyIcon = String(IconAll.ikeyCryptEncryptVerifyWarning);
                break;
            case (EncryptionKey.keyEncryption_StatusVerifyError):
                keyBase = String(EncryptionKey.keyEncryption_StatusVerifyError);
                keyIcon = String(IconAll.ikeyCryptEncryptVerifyError);
                break;
        }

        // duruma göre dil bilgisini almak
        const dataStatusTitle = (await LanguageProcess.GetBasicKey(
            String(keyLanguage) || null,
            String(keyPart) || null,
            String(keyBase) || null
        )) || null;        

        // ikonu al
        const dataIcon = (await IconProcess.Get(keyIcon)) || null;

        // Duruma göre içeriği düzenle
        switch(argStatus) {
            case (EncryptionKey.keyEncryption_StatusCreateSuccess):
            case (EncryptionKey.keyEncryption_StatusCreateWarning):
            case (EncryptionKey.keyEncryption_StatusCreateError):
            case (EncryptionKey.keyEncryption_StatusVerifySuccess):
            case (EncryptionKey.keyEncryption_StatusVerifyWarning):
            case (EncryptionKey.keyEncryption_StatusVerifyError):
                elementStatusArea.setAttribute(EncryptionKey.keyEncryption_DataStatus, argStatus);

                // İkonu elemente aktarma ve still düzenlemesi yapma
                elementStatusIcon.innerHTML = dataIcon;

                // eğer özel metin varsa özel metin olmalı
                switch(true) {
                    // özel metin
                    case (typeof argCustomMsg !== "undefined" && argCustomMsg !== null && argCustomMsg.length > 0):
                        elementStatusText.textContent = String(argCustomMsg);
                        break;
                    // normal metin
                    default:
                        elementStatusText.textContent = String(dataStatusTitle);
                }

                elementStatusArea.style.display = "flex";
                break;
        }

        return String(argStatus) || null;
    }

    static EncryptCheckBtn(
        argElementBtn,
        argElementAlgorithm, 
        argElementProcess,
        argElementInputBasetext,
        argElementInputEncrypted = null,
        argAutoInsertToInput = true)
    {
        // şifrelenmiş metini tutacak olan element
        var elementEncrypted = null;

        // Eğer buton tanımsızsa direk hata mesajı dönsün
        switch(true) {
            case (typeof argElementBtn === "undefined"):
            case (argElementBtn === null):
                console.error(EncryptionError.ErrorMsg_ElementSubmitbtnNotFound || "Submit Button Element Not Found");
                return false;
            case (typeof argElementAlgorithm === "undefined"):
            case (argElementAlgorithm === null):
                console.error(EncryptionError.ErrorMsg_ElemetAlgorithmNotFound || "Algorithm Selection Element Not Found");
                return false;
            case (typeof argElementProcess === "undefined"):
            case (argElementProcess === null):
                console.error(EncryptionError.ErrorMsg_ElemetProcessNotFound || "Process Selection Element Not Found");
                return false;
            case (typeof argElementInputBasetext === "undefined"):
            case (argElementInputBasetext === null):
                console.error(EncryptionError.ErrorMsg_ElemetBasetextNotFound || "Basetext Element Not Found");
                return false;
            case (typeof argElementInputEncrypted !== "undefined" && argElementInputEncrypted !== null):
                elementEncrypted = argElementInputEncrypted;
        }

        // Buttona tıklandığında işlem yapsın
        argElementBtn.addEventListener("click", function() {
            // Oturum yoksa otomatik giriş sayfasına yönlendirsin
            SessionProcess.SessionAdmin().then(statusAdmin => {
                // admin değilse hata fırlatsın
                if(Boolean(statusAdmin) !== true) {
                    throw new Error(EncryptionError.ErrorMsg_NonAdminUser || "Non Admin User");
                }
            })
            .catch(error => {
                // Giriş Sayfasına Sayfa yönlendirme
                window.location.href = urlPageLogin;
                return;
            });

            // Şifreleme türünü seçme
            const valueAlgorithm = argElementAlgorithm.value || "";
            const valueProcess = argElementProcess.value || "";

            // giriş değerlerini alma
            const valueBasetext = argElementInputBasetext.value || "";

            // eğer şifre doğrulama isteniyorsa
            // şifrelenmiş metin girilmesi zorunlu
            switch(valueProcess) {
                case (EncryptionFunctions.EncryptProc_Verify):
                    if(typeof elementEncrypted === "undefined" || elementEncrypted === null) {
                        console.error(EncryptionError.ErrorMsg_ElemetEncryptedNotFound || "Encrypted Input Element Not Found");
                        break;
                    }
                default:
                    const valueEncrypted = argElementInputEncrypted.value || "";

                    // alınan değerler ile parametre oluşturma
                    const params = {
                        algorithm: String(valueAlgorithm) || "",
                        process: String(valueProcess) || "",
                        basetext: String(valueBasetext) || "",
                        encrypted: String(valueEncrypted) || ""
                    };

                    // sorgu işlemlerini türe göre gerçekleştirme
                    switch(valueProcess) {
                        case (EncryptionFunctions.EncryptProc_Create):
                            EncryptionFunctions.Encrypt(params).then(dataEncrypt => {
                                // veri boşsa hiç uğraşmasın
                                if(dataEncrypt === null || dataEncrypt.length < 1) {
                                    return false;
                                }

                                // verinin ekrana çıktısı için
                                switch(true) {
                                    case Boolean(argAutoInsertToInput && (typeof elementEncrypted !== "undefined" || elementEncrypted !== null)):
                                        // şifreli metin saklayan elementin içine aktar
                                        elementEncrypted.value = dataEncrypt;

                                        // durum çıktısı
                                        EncryptionProcess.StatusMessage(EncryptionKey.keyEncryption_StatusCreateSuccess);
                                        break;
                                    default: // uyarı çıktısı ver
                                        alert(`Encrypted: ${dataEncrypt}`);
                                }
                            });
                            break;
                        case (EncryptionFunctions.EncryptProc_Verify):
                            EncryptionFunctions.Verify(params).then(dataVerify => {
                                // verinin ekrana çıktısı için
                                switch(true) {
                                    case Boolean((typeof elementEncrypted === "undefined") || (elementEncrypted === null) || (elementEncrypted.value.length < 1)):
                                        // şifreli veri için metin elementi yok
                                        EncryptionProcess.StatusMessage(EncryptionKey.keyEncryption_StatusVerifyWarning);
                                        break;
                                    case Boolean(argAutoInsertToInput && (typeof elementEncrypted !== "undefined" || elementEncrypted !== null)):
                                        // veri doğruysa işlem başka, değilse başka
                                        Boolean(dataVerify) ?
                                            (EncryptionProcess.StatusMessage(EncryptionKey.keyEncryption_StatusVerifySuccess)):
                                            (EncryptionProcess.StatusMessage(EncryptionKey.keyEncryption_StatusVerifyError));
                                        break;
                                    default: // uyarı çıktısı ver
                                        alert(`Encrypted Verify: ${dataVerify}`);
                                }
                            });
                        break;
                    }
            }
        });
    }

    // Sayfa metinlerini çevirme
    static async TextLanguage() {
        // Dil bilgileri
        const keyLanguage = (await SessionProcess.SessionFetchKey(SessionKey.keySession_Languageshort)) || "";
        const keyPart = String(LanguageKey.partCryptEncrypt) || "";
        const keyBase = "";
 
        // dil veriyi yoksa boş dönsün
        switch(null) {
            case (keyLanguage):
            case (keyPart):
                return false;
        }
 
        // elementleri al
        const elementTitle = document.querySelector(`h1#id_crypttextarea_title`);
        const elementDescription = document.querySelector(`p#id_crypttextarea_description`);
        const elementAlgorithmTitle = document.querySelector(`p#id_encalgorithm_title`);
        const elementProcessTitle = document.querySelector(`p#id_encprocess_title`);
        const elementSelectAlgo = document.querySelector(`select[name="encalgos"]`);
        const elementSelectProc = document.querySelector(`select[name="encprocs"]`);
        const elementEncryptSubmit = document.querySelector(`button[type="button"][name="encsubmitbtn"]`);

        var elementEncryptAlgoTypes = null;
        var elementEncryptProcTypes = null;

        // Eğer çoklu seçime sahip elementler varsa alsın
        switch(true) {
            case (typeof elementSelectAlgo !== "undefined" && elementSelectAlgo !== null):
                elementEncryptAlgoTypes = elementSelectAlgo.querySelectorAll(`option`);
            case (typeof elementSelectProc !== "undefined" && elementSelectProc !== null):
                elementEncryptProcTypes = elementSelectProc.querySelectorAll(`option`);
        }
 
        // Dil Metinlerini Almak
        const dataLanguage = (await LanguageProcess.GetBasicPart(
            String(keyLanguage),
            String(keyPart)
        )) || {};
 
        // veri yoksa hata dönsün
        if(typeof dataLanguage === "undefined" || dataLanguage.length < 1) {
            return false;
        }

        // Dil verisi olanları yenilesin
        (typeof dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_Title] !== "undefined" &&
        (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_Title].length > 0)) ?
            (document.title = (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_Title])): null;

        (elementTitle !== null &&
        (typeof dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_Title] !== "undefined") &&
        (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_Title].length > 0)) ?
            (elementTitle.textContent = (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_Title])): null;
        
        (elementDescription !== null &&
        (typeof dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_Description] !== "undefined") &&
        (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_Description].length > 0)) ?
            (elementDescription.textContent = (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_Description])): null;

        (elementAlgorithmTitle !== null &&
        (typeof dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_TitleAlgorithm] !== "undefined") &&
        (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_TitleAlgorithm].length > 0)) ?
            (elementAlgorithmTitle.textContent = (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_TitleAlgorithm])): null;

        (elementProcessTitle !== null &&
        (typeof dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_TitleProcess] !== "undefined") &&
        (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_TitleProcess].length > 0)) ?
            (elementProcessTitle.textContent = (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_TitleProcess])): null;

        (elementEncryptSubmit !== null &&
        (typeof dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_EncSubmitbtn] !== "undefined") &&
        (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_EncSubmitbtn].length > 0)) ?
            (elementEncryptSubmit.textContent = (dataLanguage[LanguageKey.keyLanguage_CryptEncrypt_EncSubmitbtn])): null;

        // seçim opsiyonlarını yenilesin
        switch(true) {
            // algoritma seçenekleri
            case (typeof elementEncryptAlgoTypes !== "undefined" && elementEncryptAlgoTypes !== null && elementEncryptAlgoTypes.length > 0):
                // algoritma metinlerini almak
                let dataAlgos = null;

                switch(true) {
                    case (typeof dataLanguage[EncryptionKey.keyEncryption_MultiAlgorithm] === "undefined"):
                    case (dataLanguage[EncryptionKey.keyEncryption_MultiAlgorithm].length < 1):
                        dataAlgos = null;
                        break;
                    default:
                        dataAlgos = dataLanguage[EncryptionKey.keyEncryption_MultiAlgorithm];
                }

                for(var count = 0; count < elementEncryptAlgoTypes.length; count++) {
                    // elementi alsın
                    var elementAlgo = elementEncryptAlgoTypes[count];

                    // eğer dil değeri yoksa sonraki tura geçsin
                    try {
                        // elementin içeriğini değiştir
                        elementAlgo.textContent = (dataAlgos[elementAlgo.value]);
                    } catch(error) { continue; }
                }

            // işlem seçenekleri
            case (typeof elementEncryptProcTypes !== "undefined" && elementEncryptProcTypes.length > 0):
                // işlem metinlerini almak
                let dataProc = null;

                switch(true) {
                    case (typeof dataLanguage[EncryptionKey.keyEncryption_MultiProcess] === "undefined"):
                    case (dataLanguage[EncryptionKey.keyEncryption_MultiProcess].length < 1):
                        dataProc = null;
                        break;
                    default:
                        dataProc = dataLanguage[EncryptionKey.keyEncryption_MultiProcess];
                }

                for(var count = 0; count < elementEncryptProcTypes.length; count++) {
                    // elementi alsın
                    var elementProc = elementEncryptProcTypes[count];

                    // eğer dil değeri yoksa sonraki tura geçsin
                    try {
                        // elementin içeriğini değiştir
                        elementProc.textContent = (dataProc[elementProc.value]);
                    } catch(error) { continue; }
                }
        }
    }

    // Otomatik güncelleyici
    static async AutoUpdate() {
        // alınan oturum verileri ile dil bilgilerini değiştirtmek
        return Boolean(await EncryptionProcess.TextLanguage()) || false;
    }

    // Element oluşturucu
    static async AddElements(argParentElement, argOptionType) {
        // ana element yoksa ya da için boşsa boş dönsün
        switch(true) {
            case (typeof argParentElement === "undefined"):
            case (argParentElement === null):
                return false;
        }

        // opsiyona göre anahtarları alma
        var dataOptionKeys = null;

        // seçim türü
        switch(argOptionType) {
            // algoritma
            case (EncryptionKey.keyEncryption_MultiAlgorithm):
                dataOptionKeys = (await EncryptionFunctions.FetchAlgos());
                break;
            // işlemler
            case (EncryptionKey.keyEncryption_MultiProcess):
                dataOptionKeys = (await EncryptionFunctions.FetchProcs());
                break;
            // bilinmeyen
            default:
                return false;
        }

        // alınan verilerin sadece değerlerini tutma
        dataOptionKeys = Object.values(dataOptionKeys);

        // geçici yeni elementlere ait bilgileri tutacak
        var elementTemp = null;
        let elementTextTemp = null;

        // ana elementin içine ekleme
        for(var countTemp = 0; countTemp < dataOptionKeys.length; countTemp++) {
            // eğer elemente uygun değer varsa işlem yapsın yoksa sonraki tura geçsin
            switch(true) {
                case (typeof dataOptionKeys[countTemp] === "undefined"):
                case (dataOptionKeys[countTemp] === null):
                case (dataOptionKeys[countTemp].length < 1):
                    continue;
            }

            // yeni elementi oluşturma
            elementTemp = document.createElement(`option`);

            // metin
            elementTextTemp = dataOptionKeys[countTemp];

            // elementin değerini ve iç metinini ayarlama
            elementTemp.value = String(elementTextTemp);

            // içine yazılacak metinin ilk harfi büyük olacak
            elementTemp.textContent = String(
                elementTextTemp.substr(0,1).toUpperCase() +
                elementTextTemp.substr(1));

            // Ana elementin içine aktarma
            argParentElement.appendChild(elementTemp);
        }

        // başarılı
        return true;
    }
}

// Algoritma türleri seçenek elementlerini oluşturma
var statusAddAlgorithmOptions = (await EncryptionProcess.AddElements(
    document.querySelector(`select[name="encalgos"]`),
    EncryptionKey.keyEncryption_MultiAlgorithm
)) || false;

// İşlem türleri seçenek elementlerini oluşturma
var statusAddProcessOptions = (await EncryptionProcess.AddElements(
    document.querySelector(`select[name="encprocs"]`),
    EncryptionKey.keyEncryption_MultiProcess
)) || false;

// Otomatik veri güncellemesi
var statusAutoUpdate = Boolean(await EncryptionProcess.AutoUpdate()) || false;

// Arkaplan değişimi durumu
var statusBackgroundChange = (await BackgroundProcess.BackgroundChange(
    document.body, // html element
    BackgroundPage.Page_Crypt, // page
    null, // page num
    BackgroundStyle.Style__DarkLinear // background style
)) || false;

// Tema Değiştirici
var statusCreateThemeChanger = (await ThemeProcess.CreateSwitcher(
    document.querySelector("div#id_minibtnarea"),
    document.getElementsByTagName("html")[0]
)) || false;

// Şifreleme İşlemleri
var statusEncrypt = Boolean(EncryptionProcess.EncryptCheckBtn(
    document.querySelector(`button[type="button"][name="encsubmitbtn"]`),
    document.querySelector(`select[name="encalgos"]`),
    document.querySelector(`select[name="encprocs"]`),
    document.querySelector(`input[type="text"][name="basetext"]`),
    document.querySelector(`input[type="text"][name="encrypted"]`)
)) || false;