<?php
// Slavnem @2024-08-03
namespace SessionApi\v1\Core;

// Oturum Soyut Fonksiyonlar
abstract class SessionFunctionsAbs {
    abstract protected function Fetch (): ?array;

    abstract protected function Create (
        ?array $argUserDatas
    ): ?array;

    abstract protected function Update (): ?array;

    abstract protected function Delete (): ?array;

    abstract protected function Verify(): ?array;
}