// Import
import {
    urlApiBackground,
    routeApiBackground,
    valueApiProcBackgroundFetch,
    methodApiSecure, methodApiVisible,
    headerJSON,
} from '/core/tool/global/url/UrlData.js';

// Class Background Page
export class BackgroundPage {
    static Page_Auth = "auth";
    static Page_Crypt = "crypt";
}

// Class Background Style
export class BackgroundStyle {
    static Style_DarkLinear = "dark-linear";
    static Style_DarkRadial = "dark-radial";
}

// Class Background Error
class BackgroundError {
    // Error Msg
    static ErrorMsg_GetBackgroundError = "Unable to Retrieve Background Data";
    static ErrorMsg_BackgroundNotFound = "Background Not Found";
    static ErrorMsg_ElementNotFound = "Element Not Found";
    static ErrorMsg_BackgroundSelectorError = "Background Selector Error";
    static ErrorMsg_BackgroundUnableChange = "Background Unable The To Change";
}

// Class Background Functions
class BackgroundFunctions {
    // params
    static paramBackgroundUrl = "url";
    static paramBackgroundName = "name";
    static paramBackgroundWidth = "width";
    static paramBackgroundHeight = "height";
    static paramBackgroundWidthPx = "widthpx";
    static paramBackgroundHeightPx = "heightpx";
    static paramBackgroundAlign = "align";

    // params values
    static valueParamBackgroundAlignHorz = "horizontal";
    static valueParamBackgroundAlignVert = "vertical";

    // Background Get
    static async Fetch(params) {
        // parametrelerini hazırlamak
        const backgroundParams = {
            route: routeApiBackground,
            process: valueApiProcBackgroundFetch,
            page: String(params.page) || null,
            num: parseInt(params.num) || 0
        };

        // fetch bağlantısı
        const dataFetch = await fetch(urlApiBackground, {
            method: methodApiSecure,
            headers: { headerJSON },
            body: JSON.stringify(backgroundParams)
        });

        // veriyi kontrol et ve sonucu döndür
        return (dataFetch.ok) ?  (dataFetch.json()) : ({});
    }
}

// Class Background Process
export class BackgroundProcess {
    // Functions
    static async BackgroundChange(htmlElement, paramPage, paramNum, styleColor) {
        // Eğer html elementi yoksa, zaten uygulanamaz
        if(typeof htmlElement === "undefined" || htmlElement === null)
            return false;

        // değerleri düzenlemek
        paramPage = (String(paramPage).length > 0) ? String(paramPage) : "";
        paramNum = (parseInt(paramNum) > 0) ? parseInt(paramNum) : 0;

        // parametreleri ayarlamak
        const params = {
            page: paramPage,
            num: paramNum
        };

        // Arkaplan verisini almak
        const dataBackground = (await BackgroundFunctions.Fetch(params));

        // arkaplan url adresini almak
        const dataBackgroundUrl = String(dataBackground[BackgroundFunctions.paramBackgroundUrl]) || null;

        // still ve arkplan ekleme
        switch(styleColor) {
            case (BackgroundStyle.Style_DarkRadial):
                htmlElement.style.background = `radial-gradient(circle, rgba(0,0,0,60%), rgba(0,0,0,0) 60%), url('${valueBackgroundUrl}')`;
                break;
            case (BackgroundStyle.Style_DarkLinear):
                htmlElement.style.background = `linear-gradient(145deg, rgba(0,0,0,30%), rgba(0,0,0,60%)), url('${valueBackgroundUrl}')`;
                break;
            default:
                htmlElement.style.background = `url('${dataBackgroundUrl}')`;
        }

        // Ek Özellik
        htmlElement.style.backgroundRepeat = "no-repeat";
        htmlElement.style.backgroundPosition = "center";
        htmlElement.style.backgroundSize = "cover";
        htmlElement.style.backgroundAttachment = "fixed";

        return false;
    }
}