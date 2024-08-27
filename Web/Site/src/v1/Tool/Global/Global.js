// Dil Bilgileri
import {
    MyLanguageData
} from "../../Data/SessionData.js";

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
        elementBtnOkYes.textContent = String(onlytrue ? (MyLanguageData.ok || "Tamam") : (MyLanguageData.yes || "Evet"));

        // sayfa kaydırmayı iptal et
        document.body.style.overflowY = "hidden";

        // still ayarlasın
        elementMessageBoxArea.style.width = "100vw";
        elementMessageBoxArea.style.height = "100dvh";
        elementMessageBoxArea.style.zIndex = "998";
        elementMessageBoxArea.style.display = "flex";
        elementMessageBoxArea.style.flexDirection = "column";
        elementMessageBoxArea.style.flexWrap = "wrap";
        elementMessageBoxArea.style.position = "fixed";
        elementMessageBoxArea.style.alignItems = "center";
        elementMessageBoxArea.style.justifyContent = "center";
        elementMessageBoxArea.style.left = "0";
        elementMessageBoxArea.style.top = "0";
        elementMessageBoxArea.style.background = "rgba(0,0,0,0.5)";
        elementMessageBoxArea.style.backdropFilter = "blur(1rem)";

        elementMessageBox.style.width = "auto";
        elementMessageBox.style.maxWidth = "400px";
        elementMessageBox.style.height = "auto";
        elementMessageBox.style.display = "flex";
        elementMessageBox.style.flexDirection = "column";
        elementMessageBox.style.flexWrap = "wrap";
        elementMessageBox.style.position = "relative";
        elementMessageBox.style.background = "rgba(0,0,0,0.25)";
        elementMessageBox.style.zIndex = "999";

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
                elementBtnNo.textContent = String(MyLanguageData.no || "Hayır");

                // içe aktar
                elementBtnArea.appendChild(elementBtnNo);

                // butona tıklandığında
                elementBtnNo.addEventListener("click", () => {
                    document.body.style.overflowY = "auto"; // sayfa kaydırmayı aktif et
                    elementMessageBoxArea.remove(); // mesaj kutusunu sil
                    resolve(false);
                });
            }
        });
    }
}