<?php

namespace App\Services;

use InvalidArgumentException;
use ZipArchive;

class SecureZipInspector
{
    /**
     * Validate archive before extraction (zip slip / zip bomb limits).
     *
     * @throws InvalidArgumentException
     */
    public function assertSafeArchive(string $zipPath): void
    {
        $zip = new ZipArchive;
        if ($zip->open($zipPath) !== true) {
            throw new InvalidArgumentException('Cannot open ZIP archive.');
        }

        try {
            $maxEntries = config('upload_security.zip_max_entries', 2000);
            if ($zip->numFiles > $maxEntries) {
                throw new InvalidArgumentException("ZIP contains too many files (max {$maxEntries}).");
            }

            $maxUncompressed = (int) config('upload_security.zip_max_uncompressed_kb', 512000) * 1024;
            $totalUncompressed = 0;

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if ($name === false) {
                    throw new InvalidArgumentException('Invalid ZIP entry name.');
                }

                $this->assertSafeEntryName($name);

                $stat = $zip->statIndex($i);
                if ($stat !== false && isset($stat['size'])) {
                    $totalUncompressed += $stat['size'];
                }
            }

            if ($totalUncompressed > $maxUncompressed) {
                throw new InvalidArgumentException('ZIP uncompressed size exceeds allowed limit.');
            }
        } finally {
            $zip->close();
        }
    }

    protected function assertSafeEntryName(string $name): void
    {
        if ($name === '') {
            throw new InvalidArgumentException('ZIP contains an empty path.');
        }

        if (str_contains($name, '..') || str_contains($name, "\0")) {
            throw new InvalidArgumentException('ZIP contains invalid path segments.');
        }

        if (str_starts_with($name, '/') || preg_match('#^[a-zA-Z]:[\\\\/]#', $name) === 1) {
            throw new InvalidArgumentException('ZIP contains absolute paths.');
        }
    }
}
