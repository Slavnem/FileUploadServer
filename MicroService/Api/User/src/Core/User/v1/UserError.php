<?php
// Slavnem @2024-07-06
namespace UserApi\Core\User\v1;

// USER ERROR
trait UserError {
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

    protected static array $AutoErrorUsernameTaken = [
        "code" => -1,
        "message" => "Username Already Using",
        "description" => "Try another username because this username has already been taken before",
    ];

    protected static array $AutoErrorEmailTaken = [
        "code" => -1,
        "message" => "Username Already Using",
        "description" => "Try another email address because this email address has already been taken before",
    ];

    protected static array $AutoErrorCreateUserFail = [
        "code" => -1,
        "message" => "Failed To Create New User",
        "description" => "Attempted to create a new user but failed with an error",
    ];

    protected static array $AutoErrorUpdateUserFail = [
        "code" => -1,
        "message" => "Failed To Update a User",
        "description" => "Attempted to update a user but failed with an error",
    ];

    protected static array $AutoErrorDeleteUserFail = [
        "code" => -1,
        "message" => "Failed To Delete a User",
        "description" => "Attempted to delete a user but failed with an error",
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

    protected static array $AutoErrorNotFoundLanguageid = [
        "code" => -1,
        "message" => "Language ID Value Not Found",
        "description" => "Language ID value not found, make sure you entered the parameter",
    ];

    protected static array $AutoErrorNotFoundThemeid = [
        "code" => -1,
        "message" => "Theme ID Value Not Found",
        "description" => "Theme ID value not found, make sure you entered the parameter",
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

    final public static function getAutoErrorUsernameTaken(): ?array {
        return self::$AutoErrorUsernameTaken;
    }

    final public static function getAutoErrorEmailTaken(): ?array {
        return self::$AutoErrorEmailTaken;
    }

    final public static function getAutoErrorCreateUserFail(): ?array {
        return self::$AutoErrorCreateUserFail;
    }

    final public static function getAutoErrorUpdateUserFail(): ?array {
        return self::$AutoErrorUpdateUserFail;
    }

    final public static function getAutoErrorDeleteUserFail(): ?array {
        return self::$AutoErrorDeleteUserFail;
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

    final public static function getAutoErrorNotFoundLanguageid(): ?array {
        return self::$AutoErrorNotFoundLanguageid;
    }

    final public static function getAutoErrorNotFoundThemeid(): ?array {
        return self::$AutoErrorNotFoundThemeid;
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
