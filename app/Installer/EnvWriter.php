<?php

namespace App\Installer;

use Illuminate\Support\Str;

class EnvWriter
{
    /**
     * Write key=value pairs to the .env file.
     * Existing keys are updated in-place; new keys are appended.
     */
    public static function write(array $values): void
    {
        $envPath = base_path('.env');
        $examplePath = base_path('.env.example');

        // Bootstrap .env from .env.example if it doesn't exist yet
        if (! file_exists($envPath) && file_exists($examplePath)) {
            copy($examplePath, $envPath);
        }

        $contents = file_exists($envPath) ? file_get_contents($envPath) : '';

        foreach ($values as $key => $value) {
            $escapedValue = static::escapeValue((string) $value);

            if (Str::contains($contents, "{$key}=")) {
                $contents = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$escapedValue}",
                    $contents
                );
            } else {
                $contents = rtrim($contents)."\n{$key}={$escapedValue}\n";
            }
        }

        // `php artisan key:generate` must find an APP_KEY= line; empty/new .env without .env.example can omit it.
        if (! preg_match('/^APP_KEY=/m', $contents)) {
            $contents = $contents === '' ? "APP_KEY=\n" : rtrim($contents)."\nAPP_KEY=\n";
        }

        file_put_contents($envPath, $contents);
    }

    /**
     * Quote the value if it contains spaces or special chars.
     */
    private static function escapeValue(string $value): string
    {
        if ($value === '') {
            return '';
        }

        // If value contains spaces, #, or quotes — wrap in double quotes
        if (preg_match('/[\s#"\'\\\\]/', $value)) {
            $value = '"'.addslashes($value).'"';
        }

        return $value;
    }
}
