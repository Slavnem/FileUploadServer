<?php
// Slavnem @2024-07-17
namespace UserApi\Core\User\v1;

// Gerekli Sınıflar
use PDO;
use UserApi\Core\User\v1\UserError as UserError;
use UserApi\Includes\Database\v1\Table\TableThemes;
use UserApi\Includes\Database\v1\UserDatabase as UserDatabase;
use UserApi\Core\User\v1\Methods as Methods;
use UserApi\Includes\Database\v1\Param\UserParams as UserParams;
use UserApi\Includes\Database\v1\Param\UpdateUserParams as UpdateUserParams;
use UserApi\Includes\Database\v1\UserProcedures as UserProcedures;

// Tablolar
use UserApi\Includes\Database\v1\Table\TableUsers as TableUsers;
use UserApi\Includes\Database\v1\Table\TableLanguages as TableLanguages;
use UserApi\Includes\Database\v1\Table\TableMembership as TableMembership;
use UserApi\Includes\Database\v1\Table\TableVerify as TableVerify;

// UserRequest Sınıfı
final class UserRequest {
    // Değiştirilemez Değişkenler
    protected UserDatabase $userDatabase;
    protected PDO $userDatabaseConn;

    // Sınıf Başlangıç Tanımlamaları
    public final function __construct() {
        $this->userDatabase = new UserDatabase();
        $this->userDatabaseConn = $this->userDatabase->getConnect();
    }

    // Getir
    final protected function Fetch(?array $argDatas) : ?array
    {
        // argüman verilerini depolamak
        $tempUsername = $argDatas[UserParams::getUsername()] ?? null;
        $tempEmail = $argDatas[UserParams::getEmail()] ?? null;
        $tempPassword = $argDatas[UserParams::getPassword()] ?? null;

        // zorunlu verileri kontrol etsin, yoksa null dönsün
        if($tempUsername == null)
            return UserError::getAutoErrorNotFoundUsername();
        else if($tempEmail == null)
            return UserError::getAutoErrorNotFoundEmail();
        else if($tempPassword == null)
            return UserError::getAutoErrorNotFoundPassword();
        
        // sql sorgusunu ayarlamak
        $sqlQuery = UserProcedures::getFetch();

        // sorgu ayarlaması
        $stmt = $this->userDatabaseConn->prepare($sqlQuery);

        // sorgu değerleri
        $stmt->bindValue(UserParams::getUsername(), $tempUsername, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getEmail(), $tempEmail, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getPassword(), $tempPassword, PDO::PARAM_STR);

        // sorguyu çalıştırmak
        $stmt->execute();

        // sorgu sonucunu döndürsün
        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0] ?? null;
    }

    // Oluştur
    final protected function Create(?array $argDatas) : ?array
    {
        // argüman verilerini depolamak
        $tempUsername = $argDatas[UserParams::getUsername()] ?? null;
        $tempFirstname = $argDatas[UserParams::getFirstname()] ?? null;
        $tempLastname = $argDatas[UserParams::getLastname()] ?? null;
        $tempEmail = $argDatas[UserParams::getEmail()] ?? null;
        $tempPassword = $argDatas[UserParams::getPassword()] ?? null;
        $tempLanguage = $argDatas[UserParams::getLanguage()] ?? null;
        $tempTheme = $argDatas[UserParams::getTheme()] ?? null;

        // zorunlu verileri kontrol etsin
        if($tempUsername == null)
            return UserError::getAutoErrorNotFoundUsername();
        else if($tempEmail == null)
            return UserError::getAutoErrorNotFoundEmail();
        else if($tempPassword == null)
            return UserError::getAutoErrorNotFoundPassword();

        // kullanıcı verilerini veritabanından almayı deniyoruz,
        // eğer kullanıcı yoksa yeni kullanıcı oluşturulabilir
        $fetch = self::Fetch($argDatas);
        
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;

        // boş olmayana göre hata mesajı döndürmek
        if($fetchUsername != null)
            return UserError::getAutoErrorUsernameTaken();
        else if($fetchEmail != null)
            return UserError::getAutoErrorEmailTaken();

        // sql sorgusunu ayarlamak
        $sqlQuery = UserProcedures::getCreate();

        // sorgu ayarlaması
        $stmt = $this->userDatabaseConn->prepare($sqlQuery);

        // sorgu değerleri
        $stmt->bindValue(UserParams::getUsername(), $tempUsername, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getFirstname(), $tempFirstname, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getLastname(), $tempLastname, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getEmail(), $tempEmail, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getPassword(), $tempPassword, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getLanguage(), $tempLanguage, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getTheme(), $tempTheme, PDO::PARAM_STR);

        // sorguyu çalıştırmak
        $stmt->execute();

        // kullanıcı bilgisini veritabanından yine alsın
        // dönen veriye göre cevap dönsün
        $fetch = self::Fetch($argDatas);

        // zorunlu verileri alsın
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;
        
        // kullanıcı adı, email, şifre zorunlu kısımlar
        if($fetchUsername == null || $fetchEmail == null || $fetchPassword == null)
            return UserError::getAutoErrorCreateUserFail();

        // verisi alınan kullanıcı bilgilerini döndürsün
        return $fetch ?? null;
    }

    // Güncelle
    final protected function Update(?array $argStoredDatas, ?array $argDatas) : ?array
    {
        // depolanmış argüman verilerini depolamak
        $storedUsername = $argStoredDatas[UserParams::getUsername()] ?? null;
        $storedEmail = $argStoredDatas[UserParams::getEmail()] ?? null;
        $storedPassword = $argStoredDatas[UserParams::getPassword()] ?? null;

        // zorunlu verileri kontrol etsin
        if($storedUsername == null)
            return UserError::getAutoErrorNotFoundUsername();
        else if($storedEmail == null)
            return UserError::getAutoErrorNotFoundEmail();
        else if($storedPassword == null)
            return UserError::getAutoErrorNotFoundPassword();

        // kullanıcı bilgisini almaya çalışsın,
        // eğer kullanıcı yoksa zaten güncellenemez
        $fetch = self::Fetch($argStoredDatas);
        
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;

        // hepsi boş ise kullanıcı yok demektir
        if($fetchUsername == null && $fetchEmail == null && $fetchPassword == null)
            return UserError::getAutoErrorUserNotFound();

        // argüman verilerini depolamak
        $tempUsername = $argDatas[UpdateUserParams::getUsername()] ?? null;
        $tempFirstname = $argDatas[UpdateUserParams::getFirstname()] ?? null;
        $tempLastname = $argDatas[UpdateUserParams::getLastname()] ?? null;
        $tempEmail = $argDatas[UpdateUserParams::getEmail()] ?? null;
        $tempPassword = $argDatas[UpdateUserParams::getPassword()] ?? null;
        $tempMember = $argDatas[UpdateUserParams::getMember()] ?? null;
        $tempLanguage = $argDatas[UpdateUserParams::getLanguage()] ?? null;
        $tempVerify = $argDatas[UpdateUserParams::getVerify()] ?? null;
        $tempTheme = $argDatas[UpdateUserParams::getTheme()] ?? null;

        // sql sorgusunu ayarlamak
        $sqlQuery = UserProcedures::getCreate();

        // sorgu ayarlaması
        $stmt = $this->userDatabaseConn->prepare($sqlQuery);

        // sorgu değerleri
        // depolanmış değerler
        $stmt->bindValue(UserParams::getUsername(), $storedUsername, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getEmail(), $storedEmail, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getPassword(), $storedPassword, PDO::PARAM_STR);

        // yeni değerler
        $stmt->bindValue(UpdateUserParams::getUsername(), $tempUsername, PDO::PARAM_STR);
        $stmt->bindValue(UpdateUserParams::getFirstname(), $tempFirstname, PDO::PARAM_STR);
        $stmt->bindValue(UpdateUserParams::getLastname(), $tempLastname, PDO::PARAM_STR);
        $stmt->bindValue(UpdateUserParams::getEmail(), $tempEmail, PDO::PARAM_STR);
        $stmt->bindValue(UpdateUserParams::getPassword(), $tempPassword, PDO::PARAM_STR);
        $stmt->bindValue(UpdateUserParams::getMember(), $tempMember, PDO::PARAM_STR);
        $stmt->bindValue(UpdateUserParams::getLanguage(), $tempLanguage, PDO::PARAM_STR);
        $stmt->bindValue(UpdateUserParams::getVerify(), $tempVerify, PDO::PARAM_STR);
        $stmt->bindValue(UpdateUserParams::getTheme(), $tempTheme, PDO::PARAM_STR);

        // sorguyu çalıştırmak
        $stmt->execute();

        // kullancıyı veritabanından almak için küçük düzenleme
        $tempDatas = [
            UserParams::getUsername() => ($tempUsername == null) ? $storedUsername : $tempUsername,
            UserParams::getEmail() => ($tempEmail == null) ? $storedEmail : $tempEmail,
            UserParams::getPassword() => ($tempPassword == null) ? $storedPassword : $tempPassword
        ];

        // verileri çeksin
        $fetch = self::Fetch($tempDatas);

        // alınmış veriler
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchFirstname = $fetch[TableUsers::getFirstname()] ?? null;
        $fetchLastname = $fetch[TableUsers::getLastname()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;
        $fetchMember = $fetch[TableMembership::getValue()] ?? null;
        $fetchLanguage = $fetch[TableLanguages::getValue()] ?? null;
        $fetchVerify = $fetch[TableVerify::getValue()] ?? null;
        $fetchTheme = $fetch[TableThemes::getValue()] ?? null;

        // doğrulama yapsın
        switch(true)
        {
            // veriler eşleşti
            // hiçbir veri güncellenmese bile
            // şirenin saklanan hali otomatik yeni bir şifreleme
            // ile tekrar şifrelenip saklanacak
            // güncellenmiş veriyi döndür
            case $fetchUsername == ($tempUsername == null ? $storedUsername : $tempUsername):
            case $tempFirstname == null || ($tempFirstname != null && $fetchFirstname == $tempFirstname):
            case $tempLastname == null || ($tempLastname != null && $fetchLastname == $tempLastname):
            case $fetchEmail == ($tempEmail == null ? $storedEmail : $tempEmail):
            case $fetchPassword == ($tempPassword == null ? $storedPassword : $tempPassword):
            case $tempMember == null || ($tempMember != null && $fetchMember == $tempMember):
            case $tempLanguage == null || ($tempLanguage != null && $fetchLanguage == $tempLanguage):
            case $tempVerify == null || ($tempVerify != null && $fetchVerify == $tempVerify):
            case $tempTheme == null || ($tempTheme != null && $fetchTheme == $tempTheme):
                return $fetch ?? null;
        }

        // bilinmeyen durum
        return null;
    }

    // Sil
    final protected function Delete(?array $argDatas) : ?array
    {
        // argüman verilerini depolamak
        $tempUsername = $argDatas[UserParams::getUsername()] ?? null;
        $tempFirstname = $argDatas[UserParams::getFirstname()] ?? null;
        $tempLastname = $argDatas[UserParams::getLastname()] ?? null;
        $tempEmail = $argDatas[UserParams::getEmail()] ?? null;
        $tempPassword = $argDatas[UserParams::getPassword()] ?? null;
        $tempLanguage = $argDatas[UserParams::getLanguage()] ?? null;
        $tempTheme = $argDatas[UserParams::getTheme()] ?? null;

        // zorunlu verileri kontrol etsin
        if($tempUsername == null)
            return UserError::getAutoErrorNotFoundUsername();
        else if($tempEmail == null)
            return UserError::getAutoErrorNotFoundEmail();
        else if($tempPassword == null)
            return UserError::getAutoErrorNotFoundPassword();

        // kullanıcı verilerini veritabanından almayı deniyoruz,
        // eğer kullanıcı yoksa kullanıcı silinemez
        $fetch = self::Fetch($argDatas);
        
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;

        // hepsi boş ise kullanıcı yok demektir
        if($fetchUsername == null || $fetchEmail == null || $fetchPassword == null)
            return UserError::getAutoErrorUserNotFound();

        // sql sorgusunu ayarlamak
        $sqlQuery = UserProcedures::getDelete();

        // sorgu ayarlaması
        $stmt = $this->userDatabaseConn->prepare($sqlQuery);

        // sorgu değerleri
        $stmt->bindValue(UserParams::getUsername(), $tempUsername, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getEmail(), $tempEmail, PDO::PARAM_STR);
        $stmt->bindValue(UserParams::getPassword(), $tempPassword, PDO::PARAM_STR);

        // sorguyu çalıştırmak
        $stmt->execute();

        // kullanıcı bilgisini veritabanından yine alsın
        // dönen veriye göre cevap dönsün
        $fetch = self::Fetch($argDatas);

        // zorunlu verileri alsın
        $fetchUsername = $fetch[TableUsers::getUsername()] ?? null;
        $fetchEmail = $fetch[TableUsers::getEmail()] ?? null;
        $fetchPassword = $fetch[TableUsers::getPassword()] ?? null;
        
        // kullanıcı adı, email, şifre zorunlu kısımlar
        // eğer veri yoksa kullanıcı başarıyla silinmiş demektir
        // silinen kullanıcı için gelen argüman verisi döndürülsün
        if($fetchUsername == null && $fetchEmail == null && $fetchPassword == null)
            return $argDatas;

        // kullanıcı silinemedi, null dönsün
        return null;
    }

    // Kullanıcıdan Alınan Sorgu İle İşlem Yapma
    final public function Request(?string $argRequestMethod, ?array $argUserDatas, ?array $argNewUserDatas): ?array
    {
        // işlem metodu
        $requestMethod = strtoupper($argRequestMethod);

        // Methoda göre işlem
        switch($requestMethod) {
            // Kullanıcı Verisini Getir
            case (strtoupper(Methods::getFetch())):
                return self::Fetch($argUserDatas);
            // Kullanıcı Oluştur
            case (strtoupper(Methods::getCreate())):
                return self::Create($argUserDatas);
            // Kullanıcı Verisi Güncelle
            case (strtoupper(Methods::getUpdate())):
                return self::Update($argUserDatas, $argNewUserDatas);
            // Kullanıcı Sil
            case (strtoupper(Methods::getDelete())):
                return self::Delete($argUserDatas);
        }

        // Veri yok, boş dönsün
        return null;
    }
}