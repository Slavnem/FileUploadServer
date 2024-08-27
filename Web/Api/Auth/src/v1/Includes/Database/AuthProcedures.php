<?php
// Slavnem @2024-07-06
// Kullanıcı Veritabanı
namespace AuthApi\v1\Includes\Database;

use AuthApi\v1\Includes\Database\Param\AuthParams as AuthParams;
use AuthApi\v1\Includes\Database\Param\UpdateAuthParams as UpdateAuthParams;

trait AuthProcedures {
    // Getir
    final public static function getFetch(): ?string {
        return "CALL ProcFetchUser_v1("
            .":" .AuthParams::getUsername() . ", "
            .":" .AuthParams::getEmail() . ", "
            .":" .AuthParams::getPassword()
        . ")";
    }

    // Oluştur
    final public static function getCreate(): ?string {
        return "CALL ProcCreateUser_v1("
            .":" .AuthParams::getUsername() . ", "
            .":" .AuthParams::getFirstname() . ", "
            .":" .AuthParams::getLastname() . ", "
            .":" .AuthParams::getEmail() . ", "
            .":" .AuthParams::getPassword() . ", "
            .":" .AuthParams::getLanguage() . ", "
            .":" .AuthParams::getTheme()
        . ")";
    }

    // Güncelle
    final public static function getUpdate(): ?string {
        return "CALL ProcUpdateUser_v1("
            .":" .AuthParams::getUsername() . ", "
            .":" .AuthParams::getEmail() . ", "
            .":" .AuthParams::getPassword() . ", "
            .":" .UpdateAuthParams::getUsername() . ", "
            .":" .UpdateAuthParams::getFirstname() . ", "
            .":" .UpdateAuthParams::getLastname() . ", "
            .":" .UpdateAuthParams::getEmail() . ", "
            .":" .UpdateAuthParams::getPassword() . ", "
            .":" .UpdateAuthParams::getMember() . ", "
            .":" .UpdateAuthParams::getLanguage() . ", "
            .":" .UpdateAuthParams::getVerify() . ", "
            .":" .UpdateAuthParams::getTheme()
        . ")";
    }

    // Sil
    final public static function getDelete(): ?string {
        return "CALL ProcDeleteUser_v1("
            .":" .AuthParams::getUsername() . ", "
            .":" .AuthParams::getEmail() . ", "
            .":" .AuthParams::getPassword()
        . ")";
    }

    // Doğrula
    final public static function getVerify(): ?string {
        return "CALL ProcVerifyUser_v1("
            .":" .AuthParams::getUsername() . ", "
            .":" .AuthParams::getEmail() . ", "
            .":" .AuthParams::getPassword()
        . ")";
    }
}