<?php
// Slavnem @2024-08-03
namespace FileApi\v1\Core;

// Gerekli Sınıflar
use FileApi\v1\Core\Methods as Methods;
use FileApi\v1\Includes\Config\FileConfig as FileConfig;
use FileApi\v1\Core\FileOperationsAbs as FileOperationsAbs;
use FileApi\v1\Core\FileOperationsImpl as FileOperationsImpl;
use FileApi\v1\Core\FileOperationsError as FileOperationsError;

// Oturum Sınıfları
use SessionApi\v1\Core\SessionRequest as SessionRequest;
use SessionApi\v1\Core\Methods as SessionMethods;
use SessionApi\v1\Includes\Param\SessionParams as SessionParams;

// Dosya Yükleme Sınıfı
final class FileOperations extends FileOperationsAbs implements FileOperationsImpl {
    // Sınıf Başlangıç Tanımlamaları
    protected SessionRequest $sessionRequest;

    // Sınıf Yapıcı Fonksiyonu
    public final function __construct() {
        $this->sessionRequest = new SessionRequest();
    }

    // Dosya Getirme
    final protected function Fetch(
        ?array $argFileDatas
    ): ?array
    {
        // kullanıcı verisi gelmemişse eğer dosyalar getirilemez
        if(!is_null($this->sessionRequest->isSession()))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // oturumdaki kullanıcıya ait ID
        $sesion_user_id = $this->sessionRequest->Request(
            SessionMethods::getFetch(),
            NULL,
            NULL
        )[SessionParams::getId()] ?? null;

        // oturum kullanıcısı yoksa boş dönsün
        if(!($sesion_user_id > 0))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // kullanıcı klasörü
        $user_dir = FileConfig::getStorageDir() . $sesion_user_id . '/';

        // dosyaların varlığını kontrol etsin
        // dosyalar yoksa boş dönsün
        if(!file_exists($user_dir)) return null;

        // dosyaların listeleyip getirsin
        $user_files = scandir($user_dir);
        
        // dosya bilgilerini düzenleyip depolamak için
        $file_datas = [];

        // döngüyle teker teker alsın
        foreach($user_files as $file) {
            // normal dosya değilse sonraki tura geçsin
            if($file === "." || $file === "..") continue;

            // istenen dosyalar boşsa ya da dizin içinde varsa
            if($argFileDatas === null || in_array($file, $argFileDatas)) {
                $filepath = $user_dir . $file; // dosya yolu

                $file_datas[] = [
                    "name" => $file, // dosya adı
                    "size" => filesize($filepath), // dosya boyutu
                    "modified" => date("Y-m-d H:i:s", filemtime($filepath)), // dosya değiştirilme tarihi
                    "path" => $filepath // dosya yolu
                ];
            }
        }

        // sıralanmış verileri döndür
        return $file_datas;
    }

    // Dosya Yükleme
    final protected function Upload(
        ?array $argFileDatas
    ): ?array
    {
        // kullanıcı verisi gelmemişse eğer dosyalar getirilemez
        if(!is_null($this->sessionRequest->isSession()))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // oturumdaki kullanıcıya ait ID
        $sesion_user_id = $this->sessionRequest->Request(
            SessionMethods::getFetch(),
            NULL,
            NULL
        )[SessionParams::getId()] ?? null;

        // oturum kullanıcısı yoksa boş dönsün
        if(!($sesion_user_id > 0))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // kullanıcı klasörü
        $user_dir = FileConfig::getStorageDir() . $sesion_user_id . '/';

        // klasör yoksa yeni bir klasör oluştursun
        if(!file_exists($user_dir)) {
            // dosya yolu kullanıcı ID'si ile birlikte
            mkdir($user_dir, 0777, true);
        }

        // geri dönen yanıt
        $response = [];

        // döngüyle teker teker alsın
        foreach($argFileDatas["name"] as $key => $name) {
            // dosya işleminde başarısızlık
            if($argFileDatas["error"][$key] !== UPLOAD_ERR_OK) {
                $response[] = [
                    "name" => $name,
                    "status" => "Error Occured"
                ];

                continue; // sonraki tura geç
            }

            // geçici olarak dosya adını tutsun
            $tmp_filename = $argFileDatas["tmp_name"][$key];
            
            // kaydedilecek dosya yolu
            $tmp_destination = $user_dir . basename($name);

            // dosyayı kaydetmek
            move_uploaded_file($tmp_filename, $tmp_destination) ?
            $response[] = [ // dosya işlemi başarılı
                "name" => $name,
                "status" => "Uploaded Successfully",
                "path" => $tmp_destination
            ]
            : $response[] = [ // dosya yükleme işlemi başarısız oldu
                "name" => $name,,
                "status" => "Failed To Upload"
            ];
        }

        // yanıtın sonucunu döndür
        return $response;
    }

    // Dosya Silme
    final protected function Delete(
        ?array $argFileDatas
    ): ?array
    {
        // kullanıcı verisi gelmemişse eğer dosyalar getirilemez
        if(!is_null($this->sessionRequest->isSession()))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // oturumdaki kullanıcıya ait ID
        $sesion_user_id = $this->sessionRequest->Request(
            SessionMethods::getFetch(),
            NULL,
            NULL
        )[SessionParams::getId()] ?? null;

        // oturum kullanıcısı yoksa boş dönsün
        if(!($sesion_user_id > 0))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // kullanıcı klasörü
        $user_dir = FileConfig::getStorageDir() . $sesion_user_id . '/';

        // geri dönen yanıt
        $response = [];

        // döngüyle teker teker alsın
        foreach($argFileDatas as $filename) {
            // dosya yolu
            $filepath = $user_dir . basename($filename);

            // eğer dosya bulunamadıysa kaydetsin ve sonraki tura geçsin
            if(!file_exists($filepath))
            {
                $response[] = [
                    "name" => $filename,
                    "status" => "File Not Found"
                ];

                continue; // sonraki tura geç
            }

            // dosya silme başarısız ise
            if(!unlink($filepath)) {
                $response[] = [
                    "name" => $filename,
                    "status" => "Failed To Delete"
                ];

                continue; // sonraki tura geç
            }

            // dosya silme başarılı
            $response[] = [
                "name" => $filename,
                "status" => "Deleted Successfully"
            ];
        }

        // yanıtın sonucunu döndür
        return $response;
    }

    // Kullanıcıdan Alınan Sorgu İle İşlem Yapma
    final public function Request(
        ?string $argRequestMethod,
        ?array $argDatas,
        ?array $argNewDatas
    ): ?array
    {
        // işlem metodu
        $requestMethod = strtoupper($argRequestMethod);

        // Methoda göre işlem
        switch($requestMethod) {
            // Dosya Verisini Getir
            case (strtoupper(Methods::getFetch())):
                return self::Fetch($argDatas);
            // Dosya Yükle
            case (strtoupper(Methods::getUpload())):
                return self::Upload($argDatas);
            // Dosya Sil
            case (strtoupper(Methods::getDelete())):
                return self::Delete($argDatas);
        }

        // Veri yok, boş dönsün
        return null;
    }
}