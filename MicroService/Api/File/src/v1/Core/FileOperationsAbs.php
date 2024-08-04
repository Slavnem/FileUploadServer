<?php
// Slavnem @2024-08-03
namespace FileApi\v1\Core;

// Dosya İşlemler Soyut Fonksiyonlar
abstract class FileOperationsAbs {
    abstract protected function Fetch (
        ?array $argFileDatas
    ): ?array;

    abstract protected function Upload (
        ?array $argFileDatas
    ): ?array;

    abstract protected function Delete (
        ?array $argFileDatas
    ): ?array;
}