// Slavnem @2024-09-21
// PageFiles.JS

// Genel
import {
    Global
} from "../Global/Global.js";

// Durum Mesajları İçin
import {
    Status
} from "../Global/Status.js";

// Dosya İşlemleri Sınıfı
import {
    MyFiles
} from "../File/MyFiles.js";

// Dil Bilgisi İçin
import {
    MyLanguage
} from "../Language/MyLanguage.js";

// Oturum Bilgileri
import {
    _SessionLanguage
} from "../Data/SessionData.js";

// Dil
const _LanguageData = await MyLanguage.Fetch(
    _SessionLanguage ?? "en",
    MyLanguage.PageFiles // dosyalar
);

// dosya gösterme ekranı
const elementFilesArea = document.querySelector(`div[name="filesarea"]`) || null;

// dosya isim metini
const elementFileNameInput = document.querySelector(`input[name="filename"]`) || null;

// kullanıcı çıkış butonu
const elementLogoutBtn = document.querySelector(`[name="btnlogout"]`) || null;

// dosya araştırma butonu
const elementFileSearchBtn = document.querySelector(`button[name="btnfilesearch"]`) || null;

// dosya seçme elementi
const elementFileUploadArea = document.querySelector(`div[name="filesuploadarea"]`) || null;
const elementLabelInputFileUpload = document.querySelector(`label[name="labelfileupload"]`) || null;
const elementInputFileUpload = document.querySelector(`input[type="file"]`) || null;

// dosya listeleme elementi
const elementFileList = document.querySelector(`ul[name="filelist"]`) || null;

// dosya yükleme işlem buton bölgesi
const elementFileUploadBtnArea = document.querySelector(`div[name="fileuploadbtnarea"]`) || null;

// dosya yükleme butonu
const elementFileUploadBtn = document.querySelector(`button[name="btnfileupload"]`) || null;
const elementFileUploadBtnText = document.querySelector(`button[name="btnfileupload"] span[name="btnfileupload_text"]`) || null;

// dosya yükleme durumu bölgesi elementi
const elementFileProgressBarArea = document.querySelector(`div[name="uploadprogressbararea"]`) || null;

// dosya yükleme durumu elementi
const elementFileProgressBar = document.querySelector(`div[name="uploadprogressbar"]`) || null;

// durum alanı
const elementFileStatusArea = document.querySelector(`div[name="statusarea"]`) || null;

// metin ayarlamaları
document.title = String(_LanguageData?.files ?? "Dosyalar");

elementLogoutBtn.title = String(_LanguageData?.logout ?? "Çıkış Yap");

elementFileSearchBtn.textContent = String(_LanguageData?.search ?? "Araştır");
elementFileSearchBtn.title = String(_LanguageData?.search ?? "Araştır");

elementFileUploadBtn.title = String(_LanguageData?.upload ?? "Yükle");
elementFileUploadBtnText.textContent = String(_LanguageData?.upload ?? "Yükle");

elementFileNameInput.title = String(_LanguageData?.searchfiles ?? "Dosyaları Araştır");

elementLabelInputFileUpload.innerText = String(_LanguageData?.selectfiles ?? "Dosyaları Seç");
elementLabelInputFileUpload.title = String(_LanguageData?.selectfiles ?? "Dosyaları Seç");

// seçilen dosyaları al
if(elementInputFileUpload && elementFileList) {
    elementInputFileUpload.addEventListener("change", () => {
        // önceki listeyi temizle
        elementFileList.innerHTML = null;

        // seçilen dosyaları al
        const selectedfiles = elementInputFileUpload.files;

        for(let fcount = 0; fcount < selectedfiles.length; fcount++) {
            // elementi oluştur
            const element_selectfile = document.createElement('li');

            // dosya
            const file = selectedfiles[fcount];

            // elementin içini düzenle
            element_selectfile.textContent =
                String((fcount + 1) + ") ")
                + String(Global.getFileSize(file.size) + " | " ?? "")
                + String(file.name ?? "");

            // içe aktar
            elementFileList.appendChild(element_selectfile);
        }
    });
}

// kullanıcıya ait dosyalar
var userFiles = null;

// kullanıcıya ait tüm dosyalar
userFiles = await MyFiles.Fetch(null);

// dosyaları getir
MyFiles.AddScreen(userFiles, elementFilesArea);

// butona tıklandığında dosyaları araştır
switch(!elementFileSearchBtn) {
    case true: // element yok
        console.error("File Search Button Not Found");
    break;
    default: // element var
        // butona tıklandığı zaman
        elementFileSearchBtn.addEventListener("click", async () => {
            switch(!elementFileNameInput) {
                case true: // dosya isim girme elementi yoksa hata
                    console.error("File Name Input Element Not Found");
                break;
                default:
                    // dosya adını veya adlarını
                    const fileName = String(elementFileNameInput.value);

                    // dosyaları araştır
                    userFiles = await MyFiles.Fetch(fileName);

                    // dosyalar boş veya dolu fark etmeksizin ekranı temizle
                    MyFiles.ClearScreen(elementFilesArea);

                    // dosyalar bulunduysa ya da boşsa ona göre çıktı değişecek
                    switch(!userFiles) {
                        case true:
                            // eğer metin boş değilse
                            if(fileName.length > 0)
                                console.error("Files Not Found");
                            break;
                        default: // dosyalar bulundu
                            // bulunan dosyaları ekrana eklesin
                            MyFiles.AddScreen(userFiles, elementFilesArea);
                    }
                }
        });
}

// butona tıkladığında dosya yükle
switch(!elementFileUploadBtn) {
    case true: // element yok
        console.error("File Upload Button Not Found");
    break;
    default: // element var
        // butona tıklandığı zaman
        elementFileUploadBtn.addEventListener("click", async () => {
            switch(!elementInputFileUpload) {
                case true: // dosya seçme elementi yoksa
                    console.error("File Upload Input Not Found");
                break;
                default:
                    // dosyaları alsın
                    const files = elementInputFileUpload.files;

                    // eski listeyi temizle
                    elementFileList ? elementFileList.innerHTML = null : null;

                    // dosya isimleri boşsa
                    switch(!files || files.length < 1) {
                        case true: // dosya seçilmedi
                            Status.Add(elementFileStatusArea,
                                String(_LanguageData?.filenotselected),
                                String(_LanguageData?.filenotselectedinfo),
                                Status?.Warning ?? "warning"
                            );
                        break;
                        default: // dosya seçildi
                            // dosyaları yüklemeden önce butonun kullanımını iptal etsin
                            elementFileUploadBtn.style.display = "none";
                            elementFileUploadBtn.disabled = true;

                            // önceki işlemden kalma şeyleri temizlesin
                            elementFileProgressBar.innerHTML = null;

                            // dosya seçimini durdursun
                            elementInputFileUpload.disabled = true;
                            elementInputFileUpload.display = "none";

                            // dosyaları yükle
                            const uploadResult = await MyFiles.Upload(
                                files,
                                elementFileProgressBar,
                                elementFileUploadBtnArea,
                                elementFileList
                            );

                            // dosya seçimini temizle
                            elementInputFileUpload.value = null;

                            // dosya seçimini aktifleştirsin
                            elementInputFileUpload.disabled = false;
                            elementInputFileUpload.display = null;

                            // dosyaları yükleme butonunu göstersin
                            elementFileUploadBtn.style.display = "flex";
                            elementFileUploadBtn.disabled = false;

                            // yüklenme sonucuna göre
                            switch(uploadResult) {
                                case true: // başarı
                                    // dosyaları araştır
                                    userFiles = await MyFiles.Fetch(null);

                                    // dosyalar boş veya dolu fark etmeksizin ekranı temizle
                                    MyFiles.ClearScreen(elementFilesArea);

                                    // bulunan dosyaları ekrana eklesin
                                    MyFiles.AddScreen(userFiles, elementFilesArea);

                                    // durum çıktısı
                                    Status.Add(elementFileStatusArea,
                                        String(_LanguageData?.fileuploadsuccess ?? "Yüklenme Tamamlandı"),
                                        String(_LanguageData?.fileuploadsuccessinfo ?? "Dosyalarınız sunucuya başarıyla yüklendi"),
                                        Status?.Success ?? "success"
                                    );
                                break;
                                default: // hata
                                    Status.Add(elementFileStatusArea,
                                        String(_LanguageData?.fileuploaderror ?? "Yükleme Başarısız"),
                                        String(_LanguageData?.fileuploaderrorinfo ?? "Dosyalarınız bir hata sonucu ya da istemli olarak yüklenmedi"),
                                        Status?.Error ?? "error"
                                    );
                            }
                        break;
                    }
                }
        });
}