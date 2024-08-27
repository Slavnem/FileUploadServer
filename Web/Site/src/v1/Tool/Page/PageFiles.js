// Dosya İşlemleri Sınıfı
import {
    MyFiles
} from "../File/MyFiles.js";

// Dil Bilgileri
import {
    MyLanguageData
} from "../../Data/SessionData.js";

// dosya gösterme ekranı
const elementFilesArea = document.querySelector(`div[name="filesarea"]`) || null;

// dosya isim metini
const elementFileNameInput = document.querySelector(`input[name="infilename"]`) || null;

// dosya araştırma butonu
const elementFileSearchBtn = document.querySelector(`button[name="btninfilesearch"]`) || null;

// dosya seçme elementi
const elementLabelInputFileUpload = document.querySelector(`label[name="labelfileupload"]`) || null;
const elementInputFileUpload = document.querySelector(`input[type="file"]`) || null;

// dosya yükleme işlem buton bölgesi
const elementFileUploadBtnArea = document.querySelector(`div[name="fileuploadbtnarea"]`) || null;

// dosya yükleme butonu
const elementFileUploadBtn = document.querySelector(`button[name="btnfileupload"]`) || null;

// dosya yükleme durumu bölgesi elementi
const elementFileProgressBarArea = document.querySelector(`div[name="uploadprogressbararea"]`) || null;

// dosya yükleme durumu elementi
const elementFileProgressBar = document.querySelector(`div[name="uploadprogressbar"]`) || null;

// durum alanı
const elementFileStatusArea = document.querySelector(`div[name="statusarea"]`) || null;

// metin ayarlamaları
elementFileSearchBtn.textContent = String(MyLanguageData.search || "Araştır");
elementFileSearchBtn.title = String(MyLanguageData.search || "Araştır");

elementFileUploadBtn.textContent = String(MyLanguageData.upload || "Yükle");
elementFileUploadBtn.title = String(MyLanguageData.upload || "Yükle");

elementFileNameInput.title = String(MyLanguageData.searchfiles || "Dosyaları Araştır");

elementLabelInputFileUpload.innerText = String(MyLanguageData.selectfiles || "Dosyaları Seç");
elementLabelInputFileUpload.title = String(MyLanguageData.selectfiles || "Dosyaları Seç");

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

                    // dosya isimleri boşsa
                    switch(!files || files.length < 1) {
                        case true: // dosya seçilmedi
                            console.error("Not Any File Selected");
                        break;
                        default: // dosya seçildi
                            // dosyaları yükle
                            const uploadResult = await MyFiles.Upload(files, elementFileProgressBar, elementFileUploadBtnArea);

                            // dosya seçimini temizle
                            elementInputFileUpload.value = null;

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
                                    MyFiles.StatusAdd(elementFileStatusArea,
                                        String(MyLanguageData.fileuploadsuccess || "Yüklenme Tamamlandı"),
                                        String(MyLanguageData.fileuploadsuccessinfo || "Dosyalarınız sunucuya başarıyla yüklendi"),
                                        "success"
                                    );
                                break;
                                default: // hata
                                    MyFiles.StatusAdd(elementFileStatusArea,
                                        String(MyLanguageData.fileuploaderror || "Yükleme Başarısız"),
                                        String(MyLanguageData.fileuploaderrorinfo || "Dosyalarınız bir hata sonucu ya da istemli olarak yüklenmedi"),
                                        "error"
                                    );
                            }
                        break;
                    }
                }
        });
}