<?php
// Slavnem @2024-07-06
namespace UserApi\Core\User\v1;

// USER FUNCTIONS
interface UserFunctionsImpl {
    public function Request(
        ?string $argRequestMethod,
        ?array $argUserDatas,
        ?array $argNewUserDatas
    ): ?array;
}