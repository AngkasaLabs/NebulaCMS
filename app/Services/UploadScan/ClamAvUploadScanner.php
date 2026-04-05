<?php

namespace App\Services\UploadScan;

use App\Contracts\UploadScanner;
use App\Exceptions\UploadScanException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class ClamAvUploadScanner implements UploadScanner
{
    public function __construct(
        protected string $binary,
        protected bool $failOnScannerError
    ) {}

    public function scanPath(string $absolutePath): void
    {
        if (! is_readable($absolutePath)) {
            throw UploadScanException::scannerError('File not readable for scan.');
        }

        $process = new Process([$this->binary, '--no-summary', $absolutePath]);
        $process->setTimeout(120);
        $process->run();

        $exit = $process->getExitCode();
        $stderr = $process->getErrorOutput();
        $stdout = $process->getOutput();

        // clamscan: 0 = clean, 1 = infected, 2 = error
        if ($exit === 1) {
            Log::warning('ClamAV detected signature', ['path' => $absolutePath, 'out' => $stdout]);

            throw UploadScanException::infected('ClamAV reported an issue with this file.');
        }

        if ($exit === 2 || $exit === null) {
            $msg = trim($stderr ?: $stdout ?: 'unknown error');
            Log::warning('ClamAV scan error', ['path' => $absolutePath, 'message' => $msg]);

            if ($this->failOnScannerError) {
                throw UploadScanException::scannerError($msg);
            }
        }
    }

    public function isEnabled(): bool
    {
        return true;
    }
}
