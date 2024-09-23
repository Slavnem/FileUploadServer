// URL
import * as URLs from "../Global/URL.js";

// Gerekli Metodlar
import * as QueryMethods from "../Global/Methods.js";

// Genel İşler İçin
import {
    Global
} from "../Global/Global.js";

// Veri Çekme
import {
    ApiService
} from "../Global/API.js";

// SVG Resimler
import {
    SvgDownload, SvgDelete, SvgCancel
} from "../Global/Svg.js";

// Durum Mesajları İçin
import {
    Status
} from "../Global/Status.js";

// MySession Sınıfı
import {
    MySession
} from "../Session/MySession.js";

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
    MyLanguage.PageFiles // dosyalar
);

// yükleme isteklerini tutmak için
const uploadRequests = [];

// MyFiles Sınıfı
export class MyFiles {
    // Dosyaları Getirtme
    static async Fetch(
        filenames = null // dosya isimleri
    )
    {
        // oturum kontrolü başarısızsa boş dönsün
        if(MySession.Fetch() === null)
            return null;

        // tek dosya olsa bile dizi yapsın
        if(!Array.isArray(filenames))
            filenames = [filenames];

        // dosyaları getirsin
        const files = await ApiService.FetchData(
            URLs.ApiFileURL,
            QueryMethods.MethodFetch,
            {filename: filenames}
        );

        // veriyi döndür
        return files;
    }

    // Dosyaları İndirme
    static async Download(
        filenames, // dosya isimleri
    )
    {
        // oturum kontrolü başarısızsa boş dönsün
        if(MySession.Fetch() === null)
            return null;

        // tek dosya olsa bile dizi yapsın
        if(!Array.isArray(filenames))
            filenames = [filenames];

        // dosya miktarı kadar yapsın
        filenames.forEach(file => {
            // dosyaları getirsin
            try {
                fetch(URLs.ApiFileURL, {
                method: QueryMethods.MethodDownload,
                body: JSON.stringify({filename: file})
                })
                .then(response => {
                    if(!response.ok)
                        throw new Error("Files Not Downloaded");
                
                    return response.blob();
                })
                .then(blob => {
                    // blob url dönüştür ve geçici element oluştur
                    const downloadUrl = URL.createObjectURL(blob);
                    const linkbtn = document.createElement('a');

                    // link butonu ayarlamaları
                    linkbtn.href = downloadUrl; // url adresi
                    linkbtn.download = file; // dosya adı
                    linkbtn.style.display = 'none'; // görünürlük
                    linkbtn.click(); // indirme işlemi için tıkla

                    // url serbest bırak
                    URL.revokeObjectURL(downloadUrl);
                })
            } catch(error) {
                throw new Error("Files Download Task Failed");
            }
        });
    }

    // Dosyaları Silme
    static async Delete(
        filenames, // dosya isimleri
    )
    {
        // oturum kontrolü başarısızsa boş dönsün
        if(MySession.Fetch() === null)
            return null;

        // tek dosya olsa bile dizi yapsın
        if(!Array.isArray(filenames))
            filenames = [filenames];

        // dosya miktarı kadar dönsün
        filenames.forEach(async file => {
            const filedelete = await ApiService.FetchData(
                URLs.ApiFileURL,
                QueryMethods.MethodDelete,
                {filename: filenames}
            );
        });
    }

    // Dosyaları Yükleme
    static async Upload(
        files, // dosyalar
        progressbar, // yükleme barı
        btnarea = null // button bölgesi
    )
    {
        // oturum kontrolü başarısızsa boş dönsün
        if(MySession.Fetch() === null) {
            return false;
        }
        // dosyalar boşsa hata dönsün
        else if(!files || files.length < 1) {
            return false;
        }

        // yeni form
        const formData = new FormData();

        // form dosyalarını aktarsın
        for(const file of files) {
            formData.append("files[]", file);
        }

        // varolan yükleme isteklerini iptal etsin
        if(uploadRequests && uploadRequests.length > 0) {
            uploadRequests.forEach((xhr) => {
                // XMLHttp objesi ise silsin
                xhr instanceof XMLHttpRequest ?
                    xhr.abort() // iptal etsin
                    : null;
            });
            
            // işlemerin iptal edildiğine dair mesaj
            Status.Add(
                document.body, // <body>
                _SessionLanguage?.otherfileuploadscancel ?? "Dosya Yükleme İptali",
                _SessionLanguage?.otherfileuploadscancelinfo ??
                    "Diğer Dosya Yükleme İşlemleri İptal Edildi, Aynı Anda Sadece 1 Tane Dosya Yükleme İşlemi Yapılabilir",
                Status.Error,
                true
            );

            // yükleme barı kapalı dursun
            progressbar.style.display = "none";

            // işlemi sonlandırsın
            return false;
        }

        // zaman etiketini alsın
        const dateTime = Date.now();

        // yükleme barı stili
        progressbar.style.display = "flex";

        // sorgu objesi oluştursun
        const request = new XMLHttpRequest();

        // isteği küresel nesneye eklesin
        // zaman etiketine göre sonrasında silme işlemi rahat olur
        if(uploadRequests.length < 1) {
            uploadRequests.push({ dateTime, request });
        } else {
            return false; // sonlandırsın
        }

        // yükleme index numarasını bulsun
        const requestIndex = uploadRequests.findIndex(item => item.dateTime == dateTime);

        // çalıştır
        request.open(QueryMethods.MethodPost, URLs.ApiFileURL);

        // buton oluştur ve sınıf ata
        const elementButtonAbort = document.createElement('button');
        elementButtonAbort.setAttribute("class", "btnfileupload btnuploadfiles_abort");
        elementButtonAbort.innerHTML = SvgCancel;

        // buton bölgesi varsa
        if(btnarea) {
            // içine aktar
            btnarea.appendChild(elementButtonAbort);

            // butona tıklanırsa iptal et
            elementButtonAbort.addEventListener("click", function() {
                // işlem kaydedilmişse ve listede bulunursa silsin
                if(requestIndex !== -1) {
                    uploadRequests.splice(requestIndex, 1);
                }

                // işlem varsa
                if(request) {
                    request.abort(); // yüklemeyi iptal et
                    elementButtonAbort.remove(); // butonu sil
                }
            });
        }

        // yüzde değerini yazmak için element
        const elementUploadText = document.createElement('span');

        // elementi içe aktar
        progressbar.appendChild(elementUploadText);

        // tamamlanmış yüzde
        var percentCompleted = 0;

        // işlem sonu yapılacak
        const handleEnd = () => {
            // butonu sil
            elementButtonAbort?.remove();

            // güncelleme metinini sil
            elementUploadText?.remove();

            // işlem kaydedilmişse ve listede bulunursa silsin
            requestIndex !== -1 ? 
                uploadRequests.splice(requestIndex, 1)
                : null;

            // yüzde değerini sil ve yükleyiciyi sıfırla
            if(progressbar.style.display != "none") {
                setTimeout(function() {
                    progressbar.style.width = "0%";
                    progressbar.style.display = "none";
                }, 1000);
            }
        };

        // yükleniyor
        request.upload.addEventListener('progress', (event) => {
            percentCompleted = Math.round((event.loaded / event.total) * 100);
            progressbar.style.width = percentCompleted + '%';
            elementUploadText.textContent = percentCompleted + '%';
        });

        // gönder
        request.send(formData);

        return new Promise((resolve) => {
            // işlem sonlanması
            request.onloadend = function() {
                handleEnd(); // sonlandırıcı

                // tamamı yüklendi
                percentCompleted >= 100 ?
                    resolve(true) // yükleme başarılı
                    : resolve(false); // yükleme başarısız
            }
        });
    }

    // Ekrandaki dosyaları temizlesin
    static ClearScreen(elementFilesArea) {
        // eğer element yoksa hata dönsün
        if(!elementFilesArea) {
            console.error("Screen Files Area Element Not Found");
            return false;
        }

        // içini temizlesin
        elementFilesArea.innerHTML = null;        
    }

    // Dosyaları Ekrana Ekleme
    static AddScreen(
        files, // dosyalar
        elementFilesArea, // dosya ekleme alanı
        downloadbtn = true, // dosya indirme butonu
        deletebtn = true, // dosya silme butonu
        clearscreen = true, // dosya listeleme ekranını temizle
    )
    {
        // eğer element yoksa hata dönsün
        if(!elementFilesArea) {
            console.error("Screen Files Area Element Not Found");
            return false;
        }

        // eğer dosyalar boşsa hata dönsün
        else if(!files) {
            console.error("There's No Any File");
            return false;
        }

        // ekranı temizleme aktifse eğer temizlesin
        if(clearscreen)
            MyFiles.ClearScreen(elementFilesArea);

        // döngüyle dosyalar bitene kadar eklesin
        files.forEach(element => {
            // elementler
            const elementFile = document.createElement('div');
            const elementFileInfoArea = document.createElement('div');
            const elementFileTextArea = document.createElement('div');
            const elementFileBtnArea = document.createElement('div');

            const elementFileName = document.createElement('p');
            const elementFileModified = document.createElement('span');
            const elementFileSize = document.createElement('span');
            
            // elementlere sınıf ata
            elementFile.setAttribute("class", "files_file");
            elementFileName.setAttribute("class", "files_filename");
            elementFileModified.setAttribute("class", "files_filemodified");
            elementFileSize.setAttribute("class", "files_filesize");

            // dosya yolu
            elementFile.setAttribute("data-file-path", String(element.path ?? ""));

            // bölümler
            elementFileInfoArea.setAttribute("class", "file_infoarea");
            elementFileTextArea.setAttribute("class", "file_textarea");
            elementFileBtnArea.setAttribute("class", "file_btnarea");

            // elementlere değer ata
            elementFileName.textContent = String(element.name) || null;
            elementFileModified.textContent = String(element.modified) || null;
            elementFileSize.textContent = String(Global.getFileSize(element.size)) || null;

            // bölümleri ana elementin içine aktar
            elementFile.appendChild(elementFileInfoArea);
            elementFile.appendChild(elementFileTextArea);
            elementFile.appendChild(elementFileBtnArea);

            // dosya zamanı ve boyutu
            elementFileInfoArea.appendChild(elementFileModified);
            elementFileInfoArea.appendChild(elementFileSize);

            // dosya adı
            elementFileTextArea.appendChild(elementFileName);

            // elemanı ana objenin içine ekle
            elementFilesArea.appendChild(elementFile);

            // indirme butonu istenip istenmeme durumu
            switch(downloadbtn) {
                case true: // evet, isteniyor
                    // element adı boşsa oluşturmasın
                    if(!element.name || element.name.length < 1)
                        break;

                    // butonu oluştur
                    const elementFileDownloadBtn = document.createElement('button');

                    elementFileDownloadBtn.innerHTML = SvgDownload; // indirme metini
                    elementFileDownloadBtn.title = String(_LanguageData?.download ?? "İndir"); // indirme metini
                    elementFileDownloadBtn.setAttribute("class", "filesbtn files_filedownloadbtn"); // sınıf ata
                    elementFileBtnArea.appendChild(elementFileDownloadBtn); // ana elementin içine aktar

                    // butona tıklama
                    elementFileDownloadBtn.addEventListener("click", async () => {
                        try {
                            /*
                                // mesaj kutusu versin
                                const resultChoice = await Global.getMessageBox(
                                String(_LanguageData?.download ?? "İndir"),
                                String(_LanguageData?.downloadfilequestion ?? "Dosyayı İndirmek İstiyor musunuz?")
                            );

                            // eğer evet seçilmişse dosyayı indirsin
                            if(resultChoice) {
                                // dosyayı indir
                                await MyFiles.Download(element.name);
                            }
                            */

                            // direk dosyayı indirsin
                            await MyFiles.Download(element.name);
                        } catch(error) {
                            throw new Error("File Download Task Failed");
                        }
                    });
                break;
            }

            // silme butonu istenip istenmeme durumu
            switch(deletebtn) {
                case true: // evet, isteniyor
                    // element adı boşsa oluşturmasın
                    if(!element.name || element.name.length < 1)
                        break;

                    // butonu oluştur
                    const elementFileDeleteBtn = document.createElement('button');

                    elementFileDeleteBtn.innerHTML = SvgDelete; // indirme metini
                    elementFileDeleteBtn.title = String(_LanguageData?.delete ?? "Sil"); // indirme metini
                    elementFileDeleteBtn.setAttribute("class", "filesbtn files_filedeletebtn"); // sınıf ata
                    elementFileBtnArea.appendChild(elementFileDeleteBtn); // ana elementin içine aktar

                    // butona tıklama
                    elementFileDeleteBtn.addEventListener("click", async () => {
                        try {
                            // mesaj kutusu versin
                            const resultChoice = await Global.getMessageBox(
                                String(_LanguageData?.delete ?? "Sil"),
                                String(_LanguageData?.deletefilequestion ?? "Dosyayı silmek istiyor musunuz?")
                            );

                            // eğer evet seçilmişse dosyayı silsin
                            if(resultChoice) {
                                await MyFiles.Delete(element.name); // dosyayı sil
                                
                                // nesneyi kaldırsın
                                elementFile.remove();
                            }
                        } catch(error) {
                            throw new Error("File Delete Task Failed");
                        }
                    });
                break;
            }
        });
    }
}