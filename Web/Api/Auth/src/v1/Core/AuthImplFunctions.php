<?php
// Slavnem @2024-07-06
namespace AuthApi\v1\Core;

// USER FUNCTIONS
interface AuthImplFunctions {
    public function Request(
        ?string $argRequestMethod,
        ?array $argUserDatas,
        ?array $argNewUserDatas
    ): ?array;
}