<?php
// Slavnem @2024-07-06
namespace UserApi\Core\User\v1;

// USER ERROR
trait UserError {
    // Anahtar kelimeler
    protected static string $keyCode = "code";
    protected static string $keyMsg = "message";
    protected static string $keyDesc = "description";

    // Başlangıçta varolan hata çeşitleri
    protected static array $AutoErrorNotFound = [
        self::$keyCode => -1,
        self::$keyMsg => "Not Found",
        self::$keyDesc => "Requested Data Not Found"
    ];

    protected static array $AutoErrorNonData = [
        self::$keyCode => -1,
        self::$keyMsg => "No Valid Data",
        self::$keyDesc => "Lack of Valid Data Causes Error",
    ];

    protected static array $AutoErrorUsernameTaken = [
        self::$keyCode => -1,
        self::$keyMsg => "Username Already Using",
        self::$keyDesc => "Try another username because this username has already been taken before",
    ];

    protected static array $AutoErrorEmailTaken = [
        self::$keyCode => -1,
        self::$keyMsg => "Username Already Using",
        self::$keyDesc => "Try another email address because this email address has already been taken before",
    ];

    protected static array $AutoErrorCreateUserFail = [
        self::$keyCode => -1,
        self::$keyMsg => "Failed To Create New User",
        self::$keyDesc => "Attempted to create a new user but failed with an error",
    ];

    protected static array $AutoErrorUpdateUserFail = [
        self::$keyCode => -1,
        self::$keyMsg => "Failed To Update a User",
        self::$keyDesc => "Attempted to update a user but failed with an error",
    ];

    protected static array $AutoErrorDeleteUserFail = [
        self::$keyCode => -1,
        self::$keyMsg => "Failed To Delete a User",
        self::$keyDesc => "Attempted to delete a user but failed with an error",
    ];

    protected static array $AutoErrorNotFoundUsername = [
        self::$keyCode => -1,
        self::$keyMsg => "Username Not Found",
        self::$keyDesc => "No Username parameter found. Make sure you have the parameters",
    ];

    protected static array $AutoErrorNotFoundEmail = [
        self::$keyCode => -1,
        self::$keyMsg => "Email Not Found",
        self::$keyDesc => "No Email parameter found. Make sure you have the parameters",
    ];

    protected static array $AutoErrorNotFoundPassword = [
        self::$keyCode => -1,
        self::$keyMsg => "Password Value Not Found",
        self::$keyDesc => "Password value not found, make sure you entered the parameter",
    ];

    protected static array $AutoErrorNotFoundLanguageid = [
        self::$keyCode => -1,
        self::$keyMsg => "Language ID Value Not Found",
        self::$keyDesc => "Language ID value not found, make sure you entered the parameter",
    ];

    protected static array $AutoErrorNotFoundThemeid = [
        self::$keyCode => -1,
        self::$keyMsg => "Theme ID Value Not Found",
        self::$keyDesc => "Theme ID value not found, make sure you entered the parameter",
    ];

    // Hata Bilgilerini Getirtme
    final public static function getAutoErrorNotFound(): ?array {
        return self::$AutoErrorNotFound;
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
            self::$keyCode => $argErrCode,
            self::$keyMsg => $argErrMsg,
            self::$keyDesc => $argErrDesc,
        ];
    }
}
