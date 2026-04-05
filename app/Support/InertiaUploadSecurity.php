<?php

namespace App\Support;

class InertiaUploadSecurity
{
    /**
     * @return array{maxMb: float, scanEnabled: bool, svgAllowed: bool}
     */
    public static function media(): array
    {
        return [
            'maxMb' => round((int) config('upload_security.media_max_kb', 10240) / 1024, 1),
            'scanEnabled' => (bool) config('upload_security.scan_enabled', false),
            'svgAllowed' => (bool) config('upload_security.media_allow_svg', false),
        ];
    }

    /**
     * @return array{zipMaxMb: float, zipMaxEntries: int, zipMaxUncompressedMb: float, scanEnabled: bool}
     */
    public static function extensionZip(): array
    {
        return [
            'zipMaxMb' => round((int) config('upload_security.zip_max_kb', 10240) / 1024, 1),
            'zipMaxEntries' => (int) config('upload_security.zip_max_entries', 2000),
            'zipMaxUncompressedMb' => round((int) config('upload_security.zip_max_uncompressed_kb', 512000) / 1024, 0),
            'scanEnabled' => (bool) config('upload_security.scan_enabled', false),
        ];
    }
}
