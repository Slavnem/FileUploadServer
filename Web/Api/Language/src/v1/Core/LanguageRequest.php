<?php
// Slavnem @2024-09-20
namespace LanguageApi\v1\Core;

// Gerekli Sınıflar
use LanguageApi\v1\Core\LanguageImplFunctions as LanguageImplFunctions;
use LanguageApi\v1\Core\LanguageAbsFunctions as LanguageAbsFunctions;
use LanguageApi\v1\Core\LanguageMethods as Methods;
use LanguageApi\v1\Core\LanguageErrors as Errors;

// Parametreler
use LanguageApi\v1\Includes\Params as Params;

// Dil
use LanguageApi\v1\Data\LanguageData as LanguageData;

// Language Request
final class LanguageRequest extends LanguageAbsFunctions implements LanguageImplFunctions  {
    // Getir
    final protected function Fetch(?array $argLanguageDatas): ?array {
        // argüman verileri depolamak
        $language = $argLanguageDatas[Params::getLanguage()] ?? null;
        $page = $argLanguageDatas[Params::getPage()] ?? null;

        // dil ve sayfa bilgisine göre getirsin
        return LanguageData::getData($language, $page) ?? null;
    }

    // Sorgu
    final public function Request(
        ?string $argRequestMethod,
        ?array $argLanguageDatas
    ): ?array
    {
        // işlem metodu
        $requestMethod = strtoupper($argRequestMethod);

        // Methoda göre işlem
        switch($requestMethod) {
            // Dil Verisini Getir
            case (strtoupper(Methods::getGet())):
            case (strtoupper(Methods::getFetch())):
                return self::Fetch($argLanguageDatas);
        }

        // Veri yok, boş dönsün
        return null;
    }
}