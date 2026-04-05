<?php

namespace App\Exceptions;

use RuntimeException;

class UploadScanException extends RuntimeException
{
    public static function infected(string $detail = ''): self
    {
        return new self($detail !== '' ? $detail : 'File failed malware scan.');
    }

    public static function scannerError(string $message): self
    {
        return new self('Upload scanner error: '.$message);
    }
}
