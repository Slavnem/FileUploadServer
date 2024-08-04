// Genel İşler
export class GlobalProc {
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
}