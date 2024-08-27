<?php
// Slavnem @2024-07-06
namespace AuthApi\v1\Core;

// USER ABSTRACT FUNCTIONS
abstract class AuthAbsFunctions {
    abstract protected function Fetch (
        ?array $argUserDatas
    ): ?array;

    abstract protected function Create (
        ?array $argUserDatas
    ): ?array;

    abstract protected function Update (
        ?array $argUserDatas,
        ?array $argNewUserDatas
    ): ?array;

    abstract protected function Delete (
        ?array $argUserDatas
    ): ?array;

    abstract protected function Verify(
        ?array $argUserDatas
    ): ?array;
}