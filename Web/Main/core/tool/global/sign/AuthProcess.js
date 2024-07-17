// Auth Process
export class AuthProcess {
    // Şifre Metini Gösterme/Gizleme
    static ShowHidePassword() {
        // Input Password elementi
        const elementInputPassword = document.querySelector(`input[name="password"]`);

        // Eğer elment varsa
        switch(true) {
            case (typeof elementInputPassword !== "undefined" && elementInputPassword !== null):
                elementInputPassword.addEventListener("dblclick", function() {
                    elementInputPassword.type = (elementInputPassword.type !== ("password") ? ("password") : ("text"));
                });
                
                return true;
        }

        return false;
    }

    // Bilgilendrime Alanı Gösterme/Gizleme
    static ShowHideInfo() {
        const elementInfoArea = document.querySelector(`div#id_infotextarea`);
        const elementInfoBtn = document.querySelector(`button#id_infobtn_info`);
        const elementInfoTextArea = document.querySelector(`div#id_infotextarea`);

        // element kontrolü
        switch(true) {
            case (typeof elementInfoArea === "undefined" || elementInfoArea === null):
            case (typeof elementInfoBtn === "undefined" || elementInfoBtn === null):
            case (typeof elementInfoTextArea === "undefined" || elementInfoTextArea === null):
                return false;
            case (elementInfoBtn !== null):
            case (elementInfoTextArea !== null):
                elementInfoBtn.addEventListener("click", function() {
                    elementInfoTextArea.style.display = (elementInfoTextArea.style.display === "flex") ? ("none") : ("flex");
                });
            break;
        }
    }
}