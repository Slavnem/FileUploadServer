// Slavnem @2024-09-21
// Global.JS

// Dil Bilgisi İçin
import {
    MyLanguage
} from "../Language/MyLanguage.js";

// Oturum Bilgileri
import {
    _SessionData,
    _SessionLanguage
} from "../Data/SessionData.js";

// Dil
const _LanguageData = await MyLanguage.Fetch(
    _SessionLanguage ?? "en",
    MyLanguage.PageFiles // giriş yap
);

// Genel İşler
export class Global {
    // Rastgele Sayı Getirtme
    static getRandomNumber(min, max) {
        // büyük küçük sırası farklı ise
        if(min > max) {
            var temp = min;
            min = max;
            max = temp;
        }
        // iki sayı da aynıysa hesaplamaya gerek yok
        else if(min == max) {
            return max;
        }

        // rastgele hesapla
        return Math.round(Math.random() * (max - min) + min);
    }

    // Dosya Boyutu
    static getFileSize(filesize) {
        // dosya boyut türleri
        const units = ['Byte', 'KB', 'MB', 'GB', 'TB', 'PB'];

        // dosya boyutu ve boyut index numarası (byte)
        let size = filesize;
        let unitIndex = 0;
        
        // 1024'ten büyükse, daha büyük birimlere geç
        while (size >= 1024 && unitIndex < units.length - 1) {
            size /= 1024;
            unitIndex++;
        }
        
        // Sonucu formatla ve geri döndür
        return `${size.toFixed(2)} ${units[unitIndex]}`;
    }

    // Ekran İşlem Sorusu
    static getMessageBox(
        title = null, // başlık
        msg = null, // mesaj
        onlytrue = false // sadece tamam butonu
    )
    {
        // mesaj alanı elementleri
        const elementMessageBoxArea = document.createElement('div');
        const elementMessageBox = document.createElement('div');
        const elementTextArea = document.createElement('div');
        const elementBtnArea = document.createElement('div');
        const elementTitle = document.createElement('h2');
        const elementMsg = document.createElement('p');

        // tamam, evet butonu
        const elementBtnOkYes = document.createElement('button');
        
        // ayarlamalar
        elementMessageBox.setAttribute("class", "messagebox");
        elementTextArea.setAttribute("class", "messagebox_textarea");
        elementBtnArea.setAttribute("class", "messagebox_btnarea");
        elementTitle.setAttribute("class", "messagebox_title");
        elementMsg.setAttribute("class", "messagebox_msg");
        elementBtnOkYes.setAttribute("class", "btn messagebox_btn messagebox_btn_okyes");

        // metinleri ayarla
        elementTitle.textContent = String(title ? title : "");
        elementMsg.textContent = String(msg ? msg : "");
        elementBtnOkYes.textContent = String(onlytrue ? (_LanguageData?.ok ?? "Tamam") : (_LanguageData?.yes ?? "Evet"));

        // stiller
        const styleBody = `overflow-y: hidden;`;

        const styleMessageBoxArea = `width: 100vw;
            height: 100dvh;
            z-index: 998;
            display: flex;
            position: fixed;
            flex-direction: column;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            background: rgba(0,0,0, 0.5);
            backdrop-filter: blur(1rem);
            left: 0%;
            top: 0%;
            transform: translate(0%, 0%);
            z-index: 998;`;

        const styleMessageBox = `width: clamp(auto, auto, 400px);
            height: auto;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            position: relative;
            color: #ffffff;
            background: rgba(0,0,0, 0.25);
            border: 0;
            border-radius: 1rem;
            padding: clamp(0.25rem, 5dvh, 1.5rem) clamp(0.25rem, 5vw, 2.5rem);
            margin: 0;
            z-index: 999;`;

        const styleMessageBoxTextArea = `
            width: 100%;
            height: auto;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            align-items: center;
            text-align: center;
            gap: 0.25rem;`;

        const styleMessageBoxBtnArea = `
            width: 100%;
            height: auto;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 0.5rem;
            padding: clamp(0.125rem, 5dvh, 0.5rem);
            margin: clamp(0.125rem, 5dvh, 0.75rem) 0 0 0`;

        const styleMessageBoxBtn = `
            width: auto;
            height: auto;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: center;
            text-align: center;
            border: 0;
            border-radius: 0.75rem;
            outline: 0;
            font-size: clamp(0.8rem, 5vw, 0.9rem);
            color: #ffffff;
            background: #111111;
            padding: clamp(0.125rem, 5dvh, 0.5rem) clamp(0.125rem, 5vw, 1.5rem);
            margin: 0;
        `;

        // sayfa kaydırmayı iptal et
        document.body.style.cssText = styleBody;

        // still ayarlasın
        elementMessageBoxArea.style.cssText = styleMessageBoxArea;
        elementMessageBox.style.cssText = styleMessageBox;
        elementTextArea.style.cssText = styleMessageBoxTextArea;
        elementBtnArea.style.cssText = styleMessageBoxBtnArea;

        elementBtnOkYes.style.cssText = styleMessageBoxBtn;
        elementBtnOkYes.style.background = "rgba(0,230,15, 1)";

        // elementleri içe aktar
        document.body.appendChild(elementMessageBoxArea);
        elementMessageBoxArea.appendChild(elementMessageBox);
        elementMessageBox.appendChild(elementTextArea);
        elementMessageBox.appendChild(elementBtnArea);
        elementTextArea.appendChild(elementTitle);
        elementTextArea.appendChild(elementMsg);
        elementBtnArea.appendChild(elementBtnOkYes);   

        // sonuç bekleme
        return new Promise((resolve) => {
            // evet, tamam butonuna tıklanmışsa eğer
            elementBtnOkYes.addEventListener("click", () => {
                document.body.style.overflowY = "auto"; // sayfa kaydırmayı aktif et
                elementMessageBoxArea.remove(); // mesaj kutusunu sil
                resolve(true);
            });

            // hayır butonu varsa
            if(!onlytrue) {
                // hayır, iptal et butonu
                const elementBtnNo = document.createElement('button');

                // ayarlamalar
                elementBtnNo.setAttribute("class", "btn messagebox_btn messagebox_btn_no");

                // metinleri ayarla
                elementBtnNo.textContent = String(_LanguageData?.no ?? "Hayır");

                // still
                elementBtnNo.style.cssText = styleMessageBoxBtn;
                elementBtnNo.style.background = "rgba(238,14,37, 1)";

                // içe aktar
                elementBtnArea.appendChild(elementBtnNo);

                // butona tıklandığında
                elementBtnNo.addEventListener("click", () => {
                    document.body.style.overflowY = "auto"; // sayfa kaydırmayı aktif et
                    elementMessageBoxArea.remove(); // mesaj kutusunu sil
                    resolve(false);
                });
            } else {
                elementBtnOkYes.style.background = "rgba(0,189,255, 1)";
            }
        });
    }
}