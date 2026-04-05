<?php

namespace App\Services\UploadScan;

use App\Contracts\UploadScanner;

class NullUploadScanner implements UploadScanner
{
    public function scanPath(string $absolutePath): void {}

    public function isEnabled(): bool
    {
        return false;
    }
}
