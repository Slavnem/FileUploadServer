<?php
// Slavnem @2024-07-17
namespace AuthApi\v1\Core;

// Varsayılan Sınıflar
use PDO;

// Gerekli Sınıflar
use AuthApi\v1\Core\AuthFunctionsAbs as AuthFunctionsAbs;
use AuthApi\v1\Core\AuthFunctionsImpl as AuthFunctionsImpl;
use AuthApi\v1\Core\AuthErrors as AuthError;
use AuthApi\v1\Core\AuthMethods as Methods;

// Veritabanı, Sorgular ve Metodlar
use AuthApi\v1\Includes\Database\AuthDatabase as AuthDatabase;
use AuthApi\v1\Includes\Database\Param\AuthParams as AuthParams;
use AuthApi\v1\Includes\Database\Param\UpdateAuthParams as UpdateAuthParams;
use AuthApi\v1\Includes\Database\AuthProcedures as AuthProcedures;

// Tablolar
use AuthApi\v1\Includes\Database\Table\TableUsers as TableUsers;
use AuthApi\v1\Includes\Database\Table\TableLanguages as TableLanguages;
use AuthApi\v1\Includes\Database\Table\TableMembership as TableMembership;
use AuthApi\v1\Includes\Database\Table\TableVerify as TableVerify;
use AuthApi\v1\Includes\Database\Table\TableThemes as TableThemes;

// AuthRequest Sınıfı
final class AuthRequest extends AuthAbsFunctions implements AuthImplFunctions {
    // Değiştirilemez Değişkenler
    protected AuthDatabase $AuthDatabase;
    protected PDO $AuthDatabaseConn;

    protected static int $minPasswdLength = 8;

    // Sınıf Başlangıç Tanımlamaları
    public final function __construct() {
        $this->AuthDatabase = new AuthDatabase();
        $this->AuthDatabaseConn = $this->AuthDatabase->getConnect();
    }

    // Getir
    final protected function Fetch (
        ?array $argDatas
    ) : ?array
    {
        // argüman verilerini depolamak
        $tempUsername = $argDatas[AuthParams::getUsername()] ?? null;
        $tempEmail = $argDatas[AuthParams::getEmail()] ?? null;
        $tempPassword = $argDatas[AuthParams::getPassword()] ?? null;

        // zorunlu verileri kontrol etsin, yoksa hata dönsün
        if(empty($tempUsername) && empty($tempEmail))
            return [AuthError::getAutoErrorNotFoundUsername(), AuthError::getAutoErrorNotFoundEmail()];
        else if(empty($tempPassword))
            return AuthError::getAutoErrorNotFoundPassword();

        // sql sorgusunu ayarlamak
        $sqlQuery = AuthProcedures::getFetch();

        // sorgu ayarlaması
        $stmt = $this->AuthDatabaseConn->prepare($sqlQuery);

        // sorgu değerleri
        $stmt->bindValue(AuthParams::getUsername(), $tempUsername, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getEmail(), $tempEmail, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getPassword(), $tempPassword, PDO::PARAM_STR);

        // sorguyu çalıştırmak
        $stmt->execute();

        $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC)[0] ?? null;
        $stmt->closeCursor();

        // sorgu sonucunu döndürsün
        return $fetch ?? null;
    }

    // Oluştur
    final protected function Create (
        ?array $argDatas
    ) : ?array
    {
        // argüman verilerini depolamak
        $tempUsername = $argDatas[AuthParams::getUsername()] ?? null;
        $tempFirstname = $argDatas[AuthParams::getFirstname()] ?? null;
        $tempLastname = $argDatas[AuthParams::getLastname()] ?? null;
        $tempEmail = $argDatas[AuthParams::getEmail()] ?? null;
        $tempPassword = $argDatas[AuthParams::getPassword()] ?? null;
        $tempLanguage = $argDatas[AuthParams::getLanguage()] ?? null;
        $tempTheme = $argDatas[AuthParams::getTheme()] ?? null;

        // zorunlu verileri kontrol etsin
        if($tempUsername == null)
            return AuthError::getAutoErrorNotFoundUsername();
        else if($tempEmail == null)
            return AuthError::getAutoErrorNotFoundEmail();
        else if(!filter_var($tempEmail, FILTER_VALIDATE_EMAIL))
            return AuthError::getAutoErrorNotValidEmail();
        else if($tempPassword == null)
            return AuthError::getAutoErrorNotFoundPassword();
        else if(strlen($tempPassword) < self::$minPasswdLength)
            return AuthError::getAutoErrorLessThenMinPasswordLength();

        // kullanıcı verilerini veritabanından almayı deniyoruz,
        // eğer kullanıcı yoksa yeni kullanıcı oluşturulabilir
        $fetch = self::Fetch($argDatas);
        
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;

        // boş olmayana göre hata mesajı döndürmek
        if($fetchUsername != null)
            return AuthError::getAutoErrorUsernameTaken();
        else if($fetchEmail != null)
            return AuthError::getAutoErrorEmailTaken();

        // sql sorgusunu ayarlamak
        $sqlQuery = AuthProcedures::getCreate();

        // sorgu ayarlaması
        $stmt = $this->AuthDatabaseConn->prepare($sqlQuery);

        // sorgu değerleri
        $stmt->bindValue(AuthParams::getUsername(), $tempUsername, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getFirstname(), $tempFirstname, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getLastname(), $tempLastname, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getEmail(), $tempEmail, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getPassword(), $tempPassword, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getLanguage(), $tempLanguage, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getTheme(), $tempTheme, PDO::PARAM_STR);

        // sorguyu çalıştırmak
        $stmt->execute();
        $stmt->closeCursor();

        // kullanıcı bilgisini veritabanından yine alsın
        // dönen veriye göre cevap dönsün
        $fetch = self::Fetch($argDatas);

        // zorunlu verileri alsın
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;
        
        // kullanıcı adı, email, şifre zorunlu kısımlar
        if($fetchUsername == null || $fetchEmail == null || $fetchPassword == null)
            return AuthError::getAutoErrorCreateUserFail();

        // verisi alınan kullanıcı bilgilerini döndürsün
        return $fetch ?? null;
    }

    // Güncelle
    final protected function Update (
        ?array $argStoredDatas,
        ?array $argDatas
    ) : ?array
    {
        // depolanmış argüman verilerini depolamak
        $storedUsername = $argStoredDatas[AuthParams::getUsername()] ?? null;
        $storedEmail = $argStoredDatas[AuthParams::getEmail()] ?? null;
        $storedPassword = $argStoredDatas[AuthParams::getPassword()] ?? null;

        // zorunlu verileri kontrol etsin
        if($storedUsername == null)
            return AuthError::getAutoErrorNotFoundUsername();
        else if($storedEmail == null)
            return AuthError::getAutoErrorNotFoundEmail();
        else if($storedPassword == null)
            return AuthError::getAutoErrorNotFoundPassword();

        // argüman verilerini depolamak
        $tempUsername = $argDatas[UpdateAuthParams::getUsername()] ?? null;
        $tempFirstname = $argDatas[UpdateAuthParams::getFirstname()] ?? null;
        $tempLastname = $argDatas[UpdateAuthParams::getLastname()] ?? null;
        $tempEmail = $argDatas[UpdateAuthParams::getEmail()] ?? null;
        $tempPassword = $argDatas[UpdateAuthParams::getPassword()] ?? null;
        $tempMember = $argDatas[UpdateAuthParams::getMember()] ?? null;
        $tempLanguage = $argDatas[UpdateAuthParams::getLanguage()] ?? null;
        $tempVerify = $argDatas[UpdateAuthParams::getVerify()] ?? null;
        $tempTheme = $argDatas[UpdateAuthParams::getTheme()] ?? null;

        if(strlen($tempEmail) > 0 && !filter_var($tempEmail, FILTER_VALIDATE_EMAIL))
            return AuthError::getAutoErrorNotValidEmail();
        else if(strlen($tempPassword) > 0 && strlen($tempPassword) < self::$minPasswdLength)
            return AuthError::getAutoErrorLessThenMinPasswordLength();

        // eğer tüm veriler boşsa, güncellenecek veri yoktur
        if
        (
            strlen($tempUsername) < 1 && strlen($tempFirstname) < 1 && strlen($tempLastname) < 1 &&
            strlen($tempPassword) < 1 && strlen($tempMember) < 1 && strlen($tempLanguage) < 1 &&
            strlen($tempVerify) < 1 && strlen($tempVerify) < 1
        )
            return AuthError::getAutoErrorUpdateDatasAreEmpty();

        // kullanıcı bilgisini almaya çalışsın,
        // eğer kullanıcı yoksa zaten güncellenemez
        $fetch = self::Fetch($argStoredDatas);
        
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;

        // hepsi boş ise kullanıcı yok demektir
        if($fetchUsername == null && $fetchEmail == null && $fetchPassword == null)
            return AuthError::getAutoErrorUserNotFound();

        // sql sorgusunu ayarlamak
        $sqlQuery = AuthProcedures::getUpdate();

        // sorgu ayarlaması
        $stmt = $this->AuthDatabaseConn->prepare($sqlQuery);

        // sorgu değerleri
        // depolanmış değerler
        $stmt->bindValue(AuthParams::getUsername(), $storedUsername, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getEmail(), $storedEmail, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getPassword(), $storedPassword, PDO::PARAM_STR);

        // yeni değerler
        $stmt->bindValue(UpdateAuthParams::getUsername(), $tempUsername, PDO::PARAM_STR);
        $stmt->bindValue(UpdateAuthParams::getFirstname(), $tempFirstname, PDO::PARAM_STR);
        $stmt->bindValue(UpdateAuthParams::getLastname(), $tempLastname, PDO::PARAM_STR);
        $stmt->bindValue(UpdateAuthParams::getEmail(), $tempEmail, PDO::PARAM_STR);
        $stmt->bindValue(UpdateAuthParams::getPassword(), $tempPassword, PDO::PARAM_STR);
        $stmt->bindValue(UpdateAuthParams::getMember(), $tempMember, PDO::PARAM_STR);
        $stmt->bindValue(UpdateAuthParams::getLanguage(), $tempLanguage, PDO::PARAM_STR);
        $stmt->bindValue(UpdateAuthParams::getVerify(), $tempVerify, PDO::PARAM_STR);
        $stmt->bindValue(UpdateAuthParams::getTheme(), $tempTheme, PDO::PARAM_STR);

        // sorguyu çalıştırmak
        $stmt->execute();
        $stmt->closeCursor();

        // kullancıyı veritabanından almak için küçük düzenleme
        $tempDatas = [
            AuthParams::getUsername() => ($tempUsername == null) ? $storedUsername : $tempUsername,
            AuthParams::getEmail() => ($tempEmail == null) ? $storedEmail : $tempEmail,
            AuthParams::getPassword() => ($tempPassword == null) ? $storedPassword : $tempPassword
        ];

        // verileri çeksin ve döndürsün
        return self::Fetch($tempDatas) ?? null;
    }

    // Sil
    final protected function Delete (
        ?array $argDatas
    ) : ?array
    {
        // argüman verilerini depolamak
        $tempUsername = $argDatas[AuthParams::getUsername()] ?? null;
        $tempFirstname = $argDatas[AuthParams::getFirstname()] ?? null;
        $tempLastname = $argDatas[AuthParams::getLastname()] ?? null;
        $tempEmail = $argDatas[AuthParams::getEmail()] ?? null;
        $tempPassword = $argDatas[AuthParams::getPassword()] ?? null;
        $tempLanguage = $argDatas[AuthParams::getLanguage()] ?? null;
        $tempTheme = $argDatas[AuthParams::getTheme()] ?? null;

        // zorunlu verileri kontrol etsin, yoksa hata dönsün
        if(empty($tempUsername) && empty($tempEmail))
            return [AuthError::getAutoErrorNotFoundUsername(), AuthError::getAutoErrorNotFoundEmail()];
        else if(empty($tempPassword))
            return AuthError::getAutoErrorNotFoundPassword();

        // kullanıcı verilerini veritabanından almayı deniyoruz,
        // eğer kullanıcı yoksa kullanıcı silinemez
        $fetchNonDeleted = self::Fetch($argDatas);
        
        $fetchUsername = $fetchNonDeleted[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetchNonDeleted[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetchNonDeleted[TableUsers::getPassword()] ?? null;

        // hepsi boş ise kullanıcı yok demektir
        if($fetchUsername == null || $fetchEmail == null || $fetchPassword == null)
            return AuthError::getAutoErrorUserNotFound();

        // sql sorgusunu ayarlamak
        $sqlQuery = AuthProcedures::getDelete();

        // sorgu ayarlaması
        $stmt = $this->AuthDatabaseConn->prepare($sqlQuery);

        // sorgu değerleri
        $stmt->bindValue(AuthParams::getUsername(), $tempUsername, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getEmail(), $tempEmail, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getPassword(), $tempPassword, PDO::PARAM_STR);

        // sorguyu çalıştırmak
        $stmt->execute();
        $stmt->closeCursor();

        // kullanıcı bilgisini veritabanından yine alsın
        // dönen veriye göre cevap dönsün
        $fetch = self::Fetch($argDatas);

        // zorunlu verileri alsın
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;
        
        // kullanıcı adı, email, şifre zorunlu kısımlar
        // eğer veri yoksa kullanıcı başarıyla silinmiş demektir
        // silinmeden önceki kayıtlı veriyi döndürsün
        if($fetchUsername == null && $fetchEmail == null && $fetchPassword == null)
            return $fetchNonDeleted;

        // kullanıcı silinemedi, null dönsün
        return null;
    }

    // Doğrula
    // Getir
    final protected function Verify (
        ?array $argDatas
    ) : ?array
    {
        // argüman verilerini depolamak
        $tempUsername = $argDatas[AuthParams::getUsername()] ?? null;
        $tempEmail = $argDatas[AuthParams::getEmail()] ?? null;
        $tempPassword = $argDatas[AuthParams::getPassword()] ?? null;

        // zorunlu verileri kontrol etsin, yoksa hata dönsün
        if(empty($tempUsername) && empty($tempEmail))
            return [AuthError::getAutoErrorNotFoundUsername(), AuthError::getAutoErrorNotFoundEmail()];
        else if(empty($tempPassword))
            return AuthError::getAutoErrorNotFoundPassword();

        // sql sorgusunu ayarlamak
        $sqlQuery = AuthProcedures::getVerify();

        // sorgu ayarlaması
        $stmt = $this->AuthDatabaseConn->prepare($sqlQuery);

        // sorgu değerleri
        $stmt->bindValue(AuthParams::getUsername(), $tempUsername, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getEmail(), $tempEmail, PDO::PARAM_STR);
        $stmt->bindValue(AuthParams::getPassword(), $tempPassword, PDO::PARAM_STR);

        // sorguyu çalıştırmak
        $stmt->execute();

        $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC)[0] ?? null;
        $stmt->closeCursor();

        // sorgu sonucunu döndürsün
        return $fetch ?? null;
    }

    // Kullanıcıdan Alınan Sorgu İle İşlem Yapma
    final public function Request (
        ?string $argRequestMethod,
        ?array $argAuthDatas,
        ?array $argNewAuthDatas
    ): ?array
    {
        // işlem metodu
        $requestMethod = strtoupper($argRequestMethod);

        // Methoda göre işlem
        switch($requestMethod) {
            // Kullanıcı Verisini Getir
            case (strtoupper(Methods::getFetch())):
                return self::Fetch($argAuthDatas);
            // Kullanıcı Oluştur
            case (strtoupper(Methods::getCreate())):
                return self::Create($argAuthDatas);
            // Kullanıcı Verisi Güncelle
            case (strtoupper(Methods::getUpdate())):
                return self::Update($argAuthDatas, $argNewAuthDatas);
            // Kullanıcı Sil
            case (strtoupper(Methods::getDelete())):
                return self::Delete($argAuthDatas);
            // Kullanıcı Doğrula
            case (strtoupper(Methods::getVerify())):
                return self::Verify($argAuthDatas);
        }

        // Veri yok, boş dönsün
        return null;
    }
}
