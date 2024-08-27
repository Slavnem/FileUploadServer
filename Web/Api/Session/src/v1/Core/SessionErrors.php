<?php
// Slavnem @2024-08-03
namespace SessionApi\v1\Core;

// Oturum Hataları
trait SessionErrors {
    // Anahtar kelimeler
    protected static string $keyCode = "code";
    protected static string $keyMessage = "message";
    protected static string $keyDescription = "description";

    // Başlangıçta varolan hata çeşitleri
    protected static array $AutoErrorUserNotFound = [
        "code" => -1,
        "message" => "User Not Found",
        "description" => "Requested User Not Found"
    ];

    protected static array $AutoErrorNonData = [
        "code" => -1,
        "message" => "No Valid Data",
        "description" => "Lack of Valid Data Causes Error",
    ];

    protected static array $AutoErrorCreateSessionFail = [
        "code" => -1,
        "message" => "Failed To Create New Session",
        "description" => "Attempted to create a new session but failed with an error",
    ];

    protected static array $AutoErrorUpdateSessionFail = [
        "code" => -1,
        "message" => "Failed To Update a Session",
        "description" => "Attempted to update a session but failed with an error",
    ];

    protected static array $AutoErrorDeleteSessionFail = [
        "code" => -1,
        "message" => "Failed To Delete a Session",
        "description" => "Attempted to delete a session but failed with an error",
    ];

    protected static array $AutoErrorNotFoundUsername = [
        "code" => -1,
        "message" => "Username Not Found",
        "description" => "No Username parameter found. Make sure you have the parameters",
    ];

    protected static array $AutoErrorNotFoundEmail = [
        "code" => -1,
        "message" => "Email Not Found",
        "description" => "No Email parameter found. Make sure you have the parameters",
    ];

    protected static array $AutoErrorNotFoundPassword = [
        "code" => -1,
        "message" => "Password Value Not Found",
        "description" => "Password value not found, make sure you entered the parameter",
    ];

    protected static array $AutoErrorSessionNotFoundUsername = [
        "code" => -1,
        "message" => "Session Username Not Found",
        "description" => "Session Username value not found. Make sure you have the parameters",
    ];

    protected static array $AutoErrorSessionNotFoundEmail = [
        "code" => -1,
        "message" => "Session Email Not Found",
        "description" => "Session Email value not found. Make sure you have the parameters",
    ];

    protected static array $AutoErrorSessionNotFoundPassword = [
        "code" => -1,
        "message" => "Session Password Value Not Found",
        "description" => "Session Password value not found, make sure you entered the parameter",
    ];

    protected static array $AutoErrorNotValidEmail = [
        "code" => -1,
        "message" => "Email Address Is Not Valid",
        "description" => "Email address is not valid, it has to be like that: example@email.com"
    ];

    protected static array $AutoErrorLessThenMinPasswordLength = [
        "code" => -1,
        "message" => "Password Length Not Enough",
        "description" => "Your Password is Less Then Minimum Password Length"
    ];

    protected static array $AutoErrorUpdateDatasAreEmpty = [
        "code" => -1,
        "message" => "New Datas Not Found",
        "description" => "New Update Datas Are Empty or Not Valid"
    ];

    protected static array $AutoErrorSessionUserIdNotFound = [
        "code" => -1,
        "message" => "Session User ID Not Found",
        "description" => "No data was found for the Session User. The user may have been deleted from the database or there may have been an error. It would be good to report it"
    ];

    protected static array $AutoErrorSessionUserUsernameNotFound = [
        "code" => -1,
        "message" => "Session User Username Not Found",
        "description" => "No data was found for the Session User. The user may have been deleted from the database or there may have been an error. It would be good to report it"
    ];

    protected static array $AutoErrorSessionUserEmailNotFound = [
        "code" => -1,
        "message" => "Session User Email Not Found",
        "description" => "No data was found for the Session User. The user may have been deleted from the database or there may have been an error. It would be good to report it"
    ];

    protected static array $AutoErrorSessionUserPasswordNotFound = [
        "code" => -1,
        "message" => "Session User Password Not Found",
        "description" => "No data was found for the Session User. The user may have been deleted from the database or there may have been an error. It would be good to report it"
    ];

    protected static array $AutoErrorSessionNotFound = [
        "code" => -1,
        "message" => "Session User Password Not Found",
        "description" => "No data was found for the Session User"
    ];

    // Anahtar Kelimeleri Getirtme
    final public static function getCode(): ?string {
        return self::$keyCode;
    }

    final public static function getMessage(): ?string {
        return self::$keyMessage;
    }

    final public static function getDescription(): ?string {
        return self::$keyDescription;
    }

    // Hata Bilgilerini Getirtme
    final public static function getAutoErrorUserNotFound(): ?array {
        return self::$AutoErrorUserNotFound;
    }

    final public static function getAutoErrorNonData(): ?array {
        return self::$AutoErrorNonData;
    }

    final public static function getAutoErrorCreateSessionFail(): ?array {
        return self::$AutoErrorCreateSessionFail;
    }

    final public static function getAutoErrorUpdateSessionFail(): ?array {
        return self::$AutoErrorUpdateSessionFail;
    }

    final public static function getAutoErrorDeleteSessionFail(): ?array {
        return self::$AutoErrorDeleteSessionFail;
    }

    final public static function getAutoErrorNotFoundUsername(): ?array {
        return self::$AutoErrorNotFoundUsername;
    }

    final public static function getAutoErrorNotFoundEmail(): ?array {
        return self::$AutoErrorNotFoundEmail;
    }

    final public static function getAutoErrorNotFoundPassword(): ?array {
        return self::$AutoErrorNotFoundPassword;
    }

    final public static function getAutoErrorSessionNotFoundUsername(): ?array {
        return self::$AutoErrorSessionNotFoundUsername;
    }

    final public static function getAutoErrorSessionNotFoundEmail(): ?array {
        return self::$AutoErrorSessionNotFoundEmail;
    }

    final public static function getAutoErrorSessionNotFoundPassword(): ?array {
        return self::$AutoErrorSessionNotFoundPassword;
    }

    final public static function getAutoErrorNotValidEmail(): ?array {
        return self::$AutoErrorNotValidEmail;
    }

    final public static function getAutoErrorLessThenMinPasswordLength(): ?array {
        return self::$AutoErrorLessThenMinPasswordLength;
    }

    final public static function getAutoErrorUpdateDatasAreEmpty(): ?array {
        return self::$AutoErrorUpdateDatasAreEmpty;
    }

    final public static function getAutoErrorSessionUserIdNotFound(): ?array {
        return self::$AutoErrorSessionUserIdNotFound;
    }

    final public static function getAutoErrorSessionUserUsernameNotFound(): ?array {
        return self::$AutoErrorSessionUserUsernameNotFound;
    }

    final public static function getAutoErrorSessionUserEmailNotFound(): ?array {
        return self::$AutoErrorSessionUserEmailNotFound;
    }

    final public static function getAutoErrorSessionUserPasswordNotFound(): ?array {
        return self::$AutoErrorSessionUserPasswordNotFound;
    }

    final public static function getAutoErrorSessionNotFound(): ?array {
        return self::$AutoErrorSessionNotFound;
    }

    // Özel Hata Döndürme
    final public static function ErrorReturn(
        ?int $argErrCode = -1,
        ?string $argErrMsg,
        ?string $argErrDesc
    ): ?array
    {
        return [
            "code" => $argErrCode,
            "message" => $argErrMsg,
            "description" => $argErrDesc,
        ];
    }
}
