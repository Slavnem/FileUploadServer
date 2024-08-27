// URL
import {
    PageFiles
} from "../Global/URL.js";

// MyAuth Sınıfı
import {
    MyAuth
} from "./MyAuth.js";

// MySession Sınıfı
import {
    MySession
} from "../Session/MySession.js";

// Dil Bilgileri
import {
    MyLanguageData
} from "../../Data/SessionData.js";

// MyLogin Sınıfı
export class MyLogin {
    // Durum Temizle
    static StatusClear(
        statusarea // durumların tutulduğu yer
    )
    {
        // element yoksa hata
        if(!statusarea) {
            console.error("Status Area Element Not Found");
            return false;
        }

        // içini temizle
        statusarea.innerHTML = null;
    }

    // Durum Ekle
    static StatusAdd(
        statusarea, // durumların tutulduğu yer
        title = null, // başlık metini
        msg = null, // mesaj metini
        type = null, // durum türü (hata, uyarı, başarı, bilgi)
        statusclear = true // durum temizle
    )
    {
        // element yoksa hata
        if(!statusarea) {
            console.error("Status Area Element Not Found");
            return false;
        }
        // gerekli metinler yoksa
        else if(title === null && msg === null) {
            console.error("Status Title Or Message Has To Be");
            return false;
        }

        // önceki durumları temizlesin
        if(statusclear)
            this.StatusClear(statusarea);

        // element oluştursun
        const elementNewStatus = document.createElement("div");
        const elementStatusTitle = document.createElement("h3");
        const elementStatusMsg = document.createElement("p");

        // verileri ayarla
        elementNewStatus.setAttribute("data-status-type", type);
        elementNewStatus.setAttribute("class", "status-send");

        // iç metini ayarla
        elementStatusTitle.textContent = title ? String(title) : "";
        elementStatusMsg.textContent = msg ? String(msg) : "";

        // iç içe elementler
        elementNewStatus.appendChild(elementStatusTitle);
        elementNewStatus.appendChild(elementStatusMsg);

        // içine veriyi eklesin
        statusarea.appendChild(elementNewStatus);
    }

    // Giriş
    static Login(
        inputUsername = null, // kullanıcı adı girişi elementi
        inputEmail = null, // e-posta girişi elementi
        inputPassword = null, // şifre giriş elementi
        statusarea, // durum elementleri bölgesi
        btn // giriş yapma butonu elementi
    )
    {
        // buton yoksa hata dönsün
        if(!btn) {
            this.StatusAdd(statusarea,
                String(MyLanguageData.notenoughdata || "Yetersiz Veri"),
                String(MyLanguageData.hastobeusernameandpassword || "Kullanıcı Adı veya Şifre Olmak Zorunda"),
                "error"
            );

            this.StatusAdd(statusarea,
                String(MyLanguageData.missingelement || "Eksik Element"),
                String(MyLanguageData.hastobesubmitbtn || "Giriş kontrolü için buton olmak zorunda"),
                "error"
            );

            return false;
        }

        // butona tıklanma işlemi
        btn.addEventListener("click", async () => {
            // parametreler
            const dataParams = {
                username: inputUsername ? String(inputUsername.value) : null,
                email: inputEmail ? String(inputEmail.value) : null,
                password: inputPassword ? String(inputPassword.value) : null
            };

            // veri kontrolü
            if((!dataParams.username && !dataParams.email) || (!dataParams.password)) {
                // geçerli verilerin hepsi girilmemiş
                this.StatusAdd(statusarea,
                    String(MyLanguageData.notenoughdata || "Yetersiz Veri"),
                    String(MyLanguageData.hastobeusernameandpassword || "Kullanıcı Adı veya Şifre Olmak Zorunda"),
                    "warning"
                );

                return false;
            }

            // kullanıcıya ait verileri saklasın
            const authVerifyData = await MyAuth.AuthVerify(dataParams);

            // veri boşsa hata oluştursun
            if(!authVerifyData || authVerifyData === null) {
                this.StatusAdd(statusarea,
                    String(MyLanguageData.loginfailed || "Giriş Başarısız"),
                    String(MyLanguageData.loginfailedinfo || "Kullanıcı Adı veya Şifre Hatalı"),
                    "error"
                );

                return false;
            }

            // oturum verilerini alsın
            var sessionData = await MySession.Fetch();

            // oturum boşsa yenisini oluştursun
            if(!sessionData || sessionData === null) {
                sessionData = await MySession.Create(dataParams);
            }
            else {
                // her ihtimale karşı eski oturumu silip yenisini oluştursun
                sessionData = await MySession.Delete();
                sessionData = await MySession.Create(dataParams);
            }

            // oturumu doğrulasın
            // eğer doğrulama başarısız ise oturumu silsin
            const sessionVerify = await MySession.Verify();

            if(!sessionVerify || sessionVerify === null) {
                sessionData = await MySession.Delete();

                // hata durumu
                this.StatusAdd(statusarea,
                    String(MyLanguageData.sessionerror || "Oturum Hatası"),
                    String(MyLanguageData.sessionverifyerror || "Giriş yapıldı fakat oturum doğrulanamadı"),
                    "error"
                );

                return false;
            }

            // elemanları sil
            if(inputUsername) inputUsername.remove();
            if(inputEmail) inputEmail.remove();
            if(inputPassword) inputPassword.remove();
            if(btn) btn.remove();

            // oturum başarıyla doğrulandı
            this.StatusAdd(statusarea,
                String(MyLanguageData.loginsuccess || "Giriş Başarılı"),
                String(MyLanguageData.loginsuccessinfo || "Tebrikler! Bilgiler doğrulandı"),
                "success"
            );

            setTimeout(function() {
                // yönlendirme bilgisi
                MyLogin.StatusAdd(statusarea,
                    String(MyLanguageData.redirect || "Yönlendiriliyor"),
                    String(MyLanguageData.redirectinfo || "Diğer sayfaya yönlendiriliyorsunuz..."),
                    "info"
                );

                setTimeout(function() {
                    window.location.href = PageFiles;
                }, 1500);
            }, 1500);

            return true;
        });
    }
}