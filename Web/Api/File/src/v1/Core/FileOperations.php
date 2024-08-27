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
use AuthApi\v1\Core\AuthRequest as AuthRequest;
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
        ?array $argFileDatas = NULL
    ): ?array
    {
        // kullanıcı verisi gelmemişse eğer dosyalar getirilemez
        if(!$this->sessionRequest->isSession())
            return FileOperationsError::getAutoErrorSessionForUpload();

        // oturumdaki kullanıcıya ait ID
        $session_user_id = $this->sessionRequest->Request(
            SessionMethods::getFetch(),
            NULL,
            NULL
        )[SessionParams::getId()] ?? null;

        // oturum kullanıcısı yoksa boş dönsün
        if(!($session_user_id > 0))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // kullanıcı klasörü
        $user_dir = FileConfig::getStorageDir() . $session_user_id . "/";

        // dosyalar url
        $user_url = FileConfig::getStorageUrl() . $session_user_id . "/";

        // dizinin mevcut olup olmadığını kontrol etme
        if(!is_dir($user_dir)) return null;

        // dosyaların listeleyip getirsin
        $user_files = array_diff(scandir($user_dir), ['..', '.']);

        // Dosyaları en son değiştirilme tarihine göre sıralar
        usort($user_files, function($a, $b) use ($user_dir) {
            $a_time = filemtime(rtrim($user_dir, '/') . '/' . ltrim($a, '/'));
            $b_time = filemtime(rtrim($user_dir, '/') . '/' . ltrim($a, '/'));

            return $b_time - $a_time; // En yeni dosyalar en başta
        });

        // dosyalar bulunamadıysa boş dönsün
        if(empty($user_files)) return null;
        
        // dosya bilgilerini düzenleyip depolamak için
        $file_datas = null;

        // eğer tek dosya ise
        if(!empty($argFileDatas) && count($argFileDatas) == 1) {
            // dosya adı
            $argfile = $argFileDatas[0];

            // döngüyle teker teker alsın
            foreach($user_files as $file) {
                // normal dosya değilse sonraki tura geçsin
                if($file === "." || $file === "..") continue;

                // istenen dosyalar boşsa ya da dizin içinde varsa
                if(stripos($file, $argfile) !== false) {
                    $localfilepath = (string)($user_dir . $file); // yerel dosya yolu
                    $filepath = (string)($user_url . $file); // dosya yolu

                    $file_datas[] = [
                        "name" => (string)$file, // dosya adı
                        "size" => filesize($localfilepath), // dosya boyutu
                        "modified" => date("Y-m-d H:i:s", filemtime($localfilepath)), // dosya değiştirilme tarihi
                        "path" => (string)$filepath // dosya yolu
                    ];
                }
            }
        }
        // çoklu dosyalar için
        else {
            // döngüyle teker teker alsın
            foreach($user_files as $file) {
                // normal dosya değilse sonraki tura geçsin
                if($file === "." || $file === "..") continue;
            
                // istenen dosyalar boşsa ya da dizin içinde varsa
                if($argFileDatas === null || in_array($file, $argFileDatas)) {
                    $localfilepath = (string)($user_dir . $file); // yerel dosya yolu
                    $filepath = (string)($user_url . $file); // dosya yolu
                
                    $file_datas[] = [
                        "name" => (string)$file, // dosya adı
                        "size" => filesize($localfilepath), // dosya boyutu
                        "modified" => date("Y-m-d H:i:s", filemtime($localfilepath)), // dosya değiştirilme tarihi
                        "path" => $filepath // dosya yolu
                    ];
                }
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
        if(!$this->sessionRequest->isSession())
            return FileOperationsError::getAutoErrorSessionForUpload();

        // oturumdaki kullanıcıya ait ID
        $session_user_id = $this->sessionRequest->Request(
            SessionMethods::getFetch(),
            NULL,
            NULL
        )[SessionParams::getId()] ?? null;

        // oturum kullanıcısı yoksa boş dönsün
        if(!($session_user_id > 0))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // dosyalar boşsa boş dönsün
        if(empty($argFileDatas)) return null;

        // kullanıcı klasörü
        $user_dir = FileConfig::getStorageDir() . $session_user_id . '/';

        // dosyalar url
        $user_url = FileConfig::getStorageUrl() . $session_user_id . "/";

        // dizinin mevcut olup olmadığını kontrol etme
        if(!is_dir($user_dir) || empty(self::Fetch())) {
            // dosya yolu kullanıcı ID'si ile birlikte
            mkdir($user_dir, 0755, true);
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
            $tmp_filename = (string)$argFileDatas["tmp_name"][$key];
            
            // kaydedilecek dosya yolu
            $tmp_destination = (string)($user_dir . basename($name));

            // url dosya yolu
            $urlpath = (string)($user_url . basename($name));

            // dosyayı kaydetmek
            move_uploaded_file($tmp_filename, $tmp_destination) ?
            $response[] = [ // dosya işlemi başarılı
                "name" => $name,
                "path" => $urlpath,
                "status" => "Uploaded Successfully"
            ]
            : $response[] = [ // dosya yükleme işlemi başarısız oldu
                "name" => $name,
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
        if(!$this->sessionRequest->isSession())
            return FileOperationsError::getAutoErrorSessionForUpload();

        // oturumdaki kullanıcıya ait ID
        $session_user_id = $this->sessionRequest->Request(
            SessionMethods::getFetch(),
            NULL,
            NULL
        )[SessionParams::getId()] ?? null;

        // oturum kullanıcısı yoksa boş dönsün
        if(!($session_user_id > 0))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // kullanıcı klasörü
        $user_dir = FileConfig::getStorageDir() . $session_user_id . '/';

        // dosyalar url
        $user_url = FileConfig::getStorageUrl() . $session_user_id . "/";

        // geri dönen yanıt
        $response = [];

        // döngüyle teker teker alsın
        foreach($argFileDatas as $filename) {
            // yerel dosya yolu
            $filepath = (string)($user_dir . basename($filename));

            // url dosya yolu
            $urlpath = (string)($user_url . basename($filename));

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

    // Dosya İndirme
    final protected function Download(
        ?array $argFileDatas
    ): ?array
    {
        // kullanıcı verisi gelmemişse eğer dosyalar getirilemez
        if(!$this->sessionRequest->isSession())
            return FileOperationsError::getAutoErrorSessionForUpload();

        // oturumdaki kullanıcıya ait ID
        $session_user_id = $this->sessionRequest->Request(
            SessionMethods::getFetch(),
            NULL,
            NULL
        )[SessionParams::getId()] ?? null;

        // oturum kullanıcısı yoksa boş dönsün
        if(!($session_user_id > 0))
            return FileOperationsError::getAutoErrorSessionForUpload();

        // dosya varlığı kontrolü
        if(empty($argFileDatas[0])) return null;

        // dosya adı
        $filename = (string)$argFileDatas[0];

        // kullanıcı klasörü
        $user_dir = FileConfig::getStorageDir() . $session_user_id . "/";

        // dosya yolu
        $filepath = (string)($user_dir . $filename);

        // dosyanın olup olmadığını kontrol et
        if(!file_exists($filepath))
            return null;

        // dosya indirme başlıklarını ayarla
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);

        // dosya adını döndürsün
        return [$filename];
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
            case (strtoupper(Methods::getPost())):
                return self::Upload($argDatas);
            // Dosya Sil
            case (strtoupper(Methods::getDelete())):
                return self::Delete($argDatas);
            // Dosya İndir
            case (strtoupper(Methods::getDownload())):
                return self::Download($argDatas);
        }

        // Veri yok, boş dönsün
        return null;
    }
}