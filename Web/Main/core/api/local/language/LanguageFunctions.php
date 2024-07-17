<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
    case ((bool)class_exists(LanguageData::class) !== true):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Dil Fonksiyonları
class LanguageFunctions {
    // Tüm Dil Bilgileri
    protected static function procAllLanguage(): ?array {
        return ((array)LanguageData::$LanguageData);
    }

    // Sadece Seçili Dil Bilgileri
    protected static function procOnlyLanguage(
        string $argLanguageId,
        bool $argSimplify = false): ?array
    {
        // depolanacak bilgi için
        $dataStored = null;

        // dil bilgisini al
        foreach(LanguageData::$LanguageData as $keyLanguage => $valueLanguage) {
            if($keyLanguage != $argLanguageId || empty($valueLanguage)) {
                continue;
            }
            
            // veriyi depola
            $dataStored[$keyLanguage] = $valueLanguage;
        }

        // Veriyi sadeleştir ya normal kalsın
        switch($argSimplify) {
            case true: // sadeleştir
                (isset($dataStored[$argLanguageId]) && empty($dataStored[$argLanguageId]) !== true) ?
                    ($dataStored =  $dataStored[$argLanguageId]) : ($dataStored = null);
        }

        // eğer dil bilgisi varsa döndürsün, yoksa boş dönsün
        return (isset($dataStored)) ? ((array)$dataStored) : null;
    }

    // Sadece Seçili Dil'e Seçili Parça İçin
    protected static function procOnlyLanguagePart(
        string $argLanguageId,
        string $argPartId,
        bool $argSimplify = false): ?array
    {
        // depolanacak bilgi için
        $dataStored = null;

        // bilgiyi geçici olarak depola
        $tempStored = (array)self::procOnlyLanguage($argLanguageId);

        // veriyi al
        (isset($tempStored[$argLanguageId][$argPartId]) && empty($tempStored[$argLanguageId][$argPartId]) !== true) ?
            ($dataStored[$argLanguageId][$argPartId] = $tempStored[$argLanguageId][$argPartId]):
            ($dataStored = null);

        // Veriyi sadeleştir ya normal kalsın
        switch($argSimplify) {
            case true: // sadeleştir
                return (isset($dataStored[$argLanguageId][$argPartId]) && empty($dataStored[$argLanguageId][$argPartId]) !== true) ?
                    ((array)$dataStored[$argLanguageId][$argPartId]):
                    (null);
        }

        // eğer dil bilgisi varsa döndürsün, yoksa boş dönsün
        return (isset($dataStored)) ? ((array)$dataStored) : null;
    }

    // Sadece Seçili Dil'e Ait Seçili Parçanın Anahtarı İçin
    protected static function procOnlyLanguagePartKey(
        string $argLanguageId,
        string $argPartId,
        string $argKeyId,
        bool $argSimplify = false): ?array
    {
        // depolanacak bilgi için
        $dataStored = null;

        // bilgiyi geçici olarak depola
        $tempStored = (array)self::procOnlyLanguagePart($argLanguageId, $argPartId);

        // veriyi al
        (isset($tempStored[$argLanguageId][$argPartId][$argKeyId]) && empty($tempStored[$argLanguageId][$argPartId][$argKeyId]) !== true) ?
            ($dataStored[$argLanguageId][$argPartId][$argKeyId] = $tempStored[$argLanguageId][$argPartId][$argKeyId]):
            ($dataStored = null);

        // Veriyi sadeleştir ya normal kalsın
        switch($argSimplify) {
            case true: // sadeleştir
                return (isset($dataStored[$argLanguageId][$argPartId][$argKeyId]) && empty($dataStored[$argLanguageId][$argPartId][$argKeyId]) !== true) ?
                    ((array)$dataStored[$argLanguageId][$argPartId][$argKeyId]):
                    (null);
        }

        // eğer dil bilgisi varsa döndürsün, yoksa boş dönsün
        return (isset($dataStored)) ? ((array)$dataStored) : null;
    }

    // Basit şekilde bilgileri almak için
    public static function GetBasicLanguage(
        string $argLanguageId = null,
        string $argPartId = null,
        string $argKeyId = null,
        bool $argSimplify): ?array
    {
        // Verileri saklayacak dizi
        $dataStored = null;

        // İşlem
        switch(true) {
            // tüm diller
            case ($argLanguageId === null || empty($argLanguageId)):
                return (self::procAllLanguage());
            // dil bilgisi için döngü
            case ($argPartId === null || empty($argPartId)):
                return (self::procOnlyLanguage($argLanguageId, $argSimplify));
            // parça bilgisi için
            case ($argKeyId === null || empty($argKeyId)):
                return (self::procOnlyLanguagePart($argLanguageId, $argPartId, $argSimplify));
            // argümanlar sorunsuz, parça bilgisi için
            default:
                return (self::procOnlyLanguagePartKey($argLanguageId, $argPartId, $argKeyId, $argSimplify));
        }
    }

    // Detaylı şekilde bilgi almak için
    public static function GetDetailedLanguage(
        string $argLanguageId = null,
        string $argPartId = null,
        string $argKeyId = null,
        bool $argSimplify): ?array {
        return [
            "languageid" => $argLanguageId,
            "partid" => $argPartId,
            "keyid" => $argKeyId,
            "simplify" => $argSimplify
        ];
    }
}