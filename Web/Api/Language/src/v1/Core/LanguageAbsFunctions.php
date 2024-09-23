<?php
// Slavnem @2024-09-20
namespace LanguageApi\v1\Core;

// LANGUAGE ABSTRACT FUNCTIONS
abstract class LanguageAbsFunctions {
    abstract protected function Fetch (
        ?array $argLanguageDatas
    ): ?array;
}