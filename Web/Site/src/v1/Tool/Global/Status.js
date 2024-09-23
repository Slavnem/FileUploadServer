// Durum Ekle
export class Status {
    // Bildiri Tipleri
    static Success = "success";
    static Warning = "warning";
    static Error = "error";
    static Info = "info";

    // Durum Ekle
    static Add(
        statusarea, // durumların tutulduğu yer
        title = null, // başlık metini
        msg = null, // mesaj metini
        type = null, // durum türü (hata, uyarı, başarı, bilgi)
        statusclear = true // durum temizle
    )
    {
        // element yoksa hata
        if(!statusarea) {
            console.error("[STATUS]: Status Area Element Not Found");
            return false;
        }
        // gerekli metinler yoksa
        else if(title === null && msg === null) {
            console.error("[STATUS]: Status Title Or Message Has To Be");
            return false;
        }
    
        // element oluştursun
        const elementNewStatus = document.createElement("div");
        const elementStatusTitle = document.createElement("h3");
        const elementStatusMsg = document.createElement("p");
    
        // verileri ayarla
        elementNewStatus.setAttribute("data-status-type", type);
        elementNewStatus.setAttribute("class", "status-send");
    
        // iç metini ayarla
        elementStatusTitle.textContent = String(title ?? "[NULL TITLE]");
        elementStatusMsg.textContent = String(msg ?? "[NULL MESSAGE]");
    
        // iç içe elementler
        elementNewStatus.appendChild(elementStatusTitle);
        elementNewStatus.appendChild(elementStatusMsg);
    
        // içine veriyi eklesin
        statusarea.appendChild(elementNewStatus);
    
        // belirli süre sonra silsin
        if(statusclear) {
            setTimeout(function() {
                elementNewStatus.remove();
            }, 2400);
        }
    }

    // Durum Temizle
    static Clear(
        element // durumu silinmek istenen element
    )
    {
        // element yoksa hata
        if(!element) {
            console.error("[STATUS]: Element Not Found");
            return false;
        }

        // elementi yoket
        element.remove();
    }
}