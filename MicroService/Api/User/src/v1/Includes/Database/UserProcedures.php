<?php
// Slavnem @2024-07-06
// Kullanıcı Veritabanı
namespace UserApi\v1\Includes\Database;

use UserApi\v1\Includes\Database\Param\UserParams as UserParams;
use UserApi\v1\Includes\Database\Param\UpdateUserParams as UpdateUserParams;

trait UserProcedures {
    // Getir
    final public static function getFetch(): ?string {
        return "CALL ProcFetchUser_v1("
            .":" .UserParams::getUsername() . ", "
            .":" .UserParams::getEmail() . ", "
            .":" .UserParams::getPassword()
        . ")";
    }

    // Oluştur
    final public static function getCreate(): ?string {
        return "CALL ProcCreateUser_v1("
            .":" .UserParams::getUsername() . ", "
            .":" .UserParams::getFirstname() . ", "
            .":" .UserParams::getLastname() . ", "
            .":" .UserParams::getEmail() . ", "
            .":" .UserParams::getPassword() . ", "
            .":" .UserParams::getLanguage() . ", "
            .":" .UserParams::getTheme()
        . ")";
    }

    // Güncelle
    final public static function getUpdate(): ?string {
        return "CALL ProcUpdateUser_v1("
            .":" .UserParams::getUsername() . ", "
            .":" .UserParams::getEmail() . ", "
            .":" .UserParams::getPassword() . ", "
            .":" .UpdateUserParams::getUsername() . ", "
            .":" .UpdateUserParams::getFirstname() . ", "
            .":" .UpdateUserParams::getLastname() . ", "
            .":" .UpdateUserParams::getEmail() . ", "
            .":" .UpdateUserParams::getPassword() . ", "
            .":" .UpdateUserParams::getMember() . ", "
            .":" .UpdateUserParams::getLanguage() . ", "
            .":" .UpdateUserParams::getVerify() . ", "
            .":" .UpdateUserParams::getTheme()
        . ")";
    }

    // Sil
    final public static function getDelete(): ?string {
        return "CALL ProcDeleteUser_v1("
            .":" .UserParams::getUsername() . ", "
            .":" .UserParams::getEmail() . ", "
            .":" .UserParams::getPassword()
        . ")";
    }
}