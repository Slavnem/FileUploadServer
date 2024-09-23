<?php
// Slavnem @2024-09-20
namespace LanguageApi\v1\Core;

// LANGUAGE IMPLEMENTS FUNCTIONS
interface LanguageImplFunctions {
    public function Request(
        ?string $argRequestMethod,
        ?array $argLanguageDatas
    ): ?array;
}