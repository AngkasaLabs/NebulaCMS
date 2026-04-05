<?php

namespace App\Contracts;

interface UploadScanner
{
    /**
     * Scan a file on disk. Throws if malware is detected or if configured to fail on scanner errors.
     *
     * @throws \App\Exceptions\UploadScanException
     */
    public function scanPath(string $absolutePath): void;

    public function isEnabled(): bool;
}
