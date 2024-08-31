// Browser (Web Tarayıcı) Sınıfı
export class MyBrowser {
    // Sınıf Değişkenleri
    static ThemeDark = "dark"; // koyu tema
    static ThemeLight = "light"; // açık tema

    static AttrColorTheme = "data-color-theme"; // renk teması özelliği

    // Tarayıcı İle İşletim Sistemi (Windows/Linux/Android/iOS) Tema Türünü Bulma
    static FindAutoTheme() {
        // Fallback için tarayıcıya göre manuel olarak sınıf ekle
        const userPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const userPrefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;

        // koyu tema destekleniyorsa
        if(userPrefersDark) {
            return String(this.ThemeDark);
        // açık tema destekleniyorsa
        } else if(userPrefersLight) {
            return String(this.ThemeLight);
        }

        // hiçbiri desteklenmiyorsa
        return null;
    }

    // Tarayıcı İle Tema Bulunduysa Tarayıcıya Eklesin
    static AddAutoTheme() {
        // html
        const html = document.documentElement;

        // açık tema destekleniyorsa onu eklesin
        if(this.FindAutoTheme() == this.ThemeLight) {
            html.setAttribute(String(this.AttrColorTheme), this.ThemeLight);
            return String(this.ThemeLight); // açık tema eklendi
        }

        // koyu tema destekleniyorsa veya hiçbiri yoksa koyu tema eklesin
        html.setAttribute(String(this.AttrColorTheme), this.ThemeDark);
        return String(this.ThemeDark); // koyu tema eklendi
    }
}