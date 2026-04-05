<?php

namespace App\Installer;

use Illuminate\Support\Facades\File;

/**
 * Menyimpan payload wizard instalasi di disk (bukan sesi) agar langkah AJAX /install/run
 * tetap valid setelah APP_KEY berubah (cookie terenkripsi tidak lagi cocok dengan sesi file).
 */
class InstallerWizardStore
{
    public static function pathForToken(string $token): string
    {
        return storage_path('framework/installer-wizard/'.hash('sha256', $token).'.json');
    }

    public static function put(string $token, array $payload): void
    {
        $path = static::pathForToken($token);
        $dir = dirname($path);
        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        File::put($path, json_encode($payload, JSON_THROW_ON_ERROR));
    }

    public static function get(string $token): ?array
    {
        $path = static::pathForToken($token);
        if (! File::exists($path)) {
            return null;
        }

        try {
            return json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return null;
        }
    }

    public static function forget(string $token): void
    {
        $path = static::pathForToken($token);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
