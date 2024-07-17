<?php
// Slavnem @2024-07-06
namespace UserApi\Core\User\v1;

// USER ABSTRACT FUNCTIONS
abstract class UserFunctionsAbs {
    abstract protected function procUserAuth(
        ?string $argUsername,
        ?string $argPassword,
        ?string $argEmail
    ): ?array;

    abstract protected function procUserUsername(
        ?string $argUsername
    ): ?array;

    abstract protected function procUserEmail(
        ?string $argEmail
    ): ?array;

    abstract protected function UserFetch(
        ?array $argUserDatas
    ): ?array;

    abstract protected function UserCreate(
        ?array $argUserDatas
    ): ?array;

    abstract protected function UserUpdate(
        ?array $argUserDatas,
        ?array $argNewUserDatas
    ): ?array;

    abstract protected function UserDelete(
        ?array $argUserDatas
    ): ?array;
}