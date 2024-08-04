<?php
// Slavnem @2024-08-03
namespace FileApi\v1\Core;

// Oturum İmplementasyon Fonksiyonları
interface FileOperationsImpl {
    public function Request(
        ?string $argRequestMethod,
        ?array $argDatas,
        ?array $argNewDatas
    ): ?array;
}