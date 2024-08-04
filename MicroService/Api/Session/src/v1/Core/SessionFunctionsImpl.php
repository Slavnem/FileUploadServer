<?php
// Slavnem @2024-08-03
namespace SessionApi\v1\Core;

// Oturum İmplementasyon Fonksiyonları
interface SessionFunctionsImpl {
    public function Request(
        ?string $argRequestMethod,
        ?array $argDatas,
        ?array $argNewDatas
    ): ?array;
}