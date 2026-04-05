<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class UploadScanStatusCommand extends Command
{
    protected $signature = 'upload-scan:status';

    protected $description = 'Show ClamAV upload-scan config and whether the binary is available on this server';

    public function handle(): int
    {
        $enabled = (bool) config('upload_security.scan_enabled');
        $driver = (string) config('upload_security.scan_driver');
        $binary = (string) config('upload_security.clamav_binary');
        $failOnError = (bool) config('upload_security.scan_fail_on_scanner_error');

        $this->components->info('Upload malware scan (ClamAV)');
        $this->newLine();

        $this->table(
            ['Setting', 'Value'],
            [
                ['UPLOAD_SCAN_ENABLED', $enabled ? 'true' : 'false'],
                ['UPLOAD_SCAN_DRIVER', $driver],
                ['CLAMAV_BINARY', $binary !== '' ? $binary : '(empty)'],
                ['UPLOAD_SCAN_FAIL_ON_ERROR', $failOnError ? 'true' : 'false'],
            ]
        );

        $this->newLine();

        if (! $enabled) {
            $this->components->warn('Scanning is disabled. Set UPLOAD_SCAN_ENABLED=true in .env to use ClamAV.');
            $this->newLine();
        }

        if ($driver !== 'clamav') {
            $this->components->warn("Driver is not clamav ({$driver}) — binary check below only applies when driver is clamav.");
            $this->newLine();
        }

        if ($binary === '') {
            $this->components->error('CLAMAV_BINARY is empty. Set e.g. CLAMAV_BINARY=clamscan in .env.');

            return $enabled && $driver === 'clamav' ? self::FAILURE : self::SUCCESS;
        }

        $resolved = $this->resolveBinary($binary);

        if ($resolved === null) {
            $this->components->error("Binary not found or not executable: {$binary}");
            $this->line('  Tip: install <fg=gray>clamav</> (e.g. <fg=gray>sudo apt install clamav</>) or set full path to <fg=gray>clamscan</>/<fg=gray>clamdscan</>.');

            return $enabled && $driver === 'clamav' ? self::FAILURE : self::SUCCESS;
        }

        $this->line("  <fg=green>Resolved path:</> {$resolved}");

        $version = $this->readVersion($resolved);
        if ($version !== null) {
            $this->line("  <fg=green>Version:</> {$version}");
        } else {
            $this->components->warn('Could not read --version (check execute permission for this user).');
        }

        if ($enabled && $driver === 'clamav') {
            $this->newLine();
            $this->components->info('Scanning is enabled: uploads will be scanned with ClamAV.');
        }

        return self::SUCCESS;
    }

    private function resolveBinary(string $binary): ?string
    {
        if (str_contains($binary, '/') || str_contains($binary, '\\')) {
            return is_executable($binary) ? $binary : null;
        }

        return (new ExecutableFinder)->find($binary);
    }

    private function readVersion(string $path): ?string
    {
        $process = new Process([$path, '--version']);
        $process->setTimeout(8);

        try {
            $process->run();
        } catch (\Throwable) {
            return null;
        }

        if (! $process->isSuccessful()) {
            return null;
        }

        $first = strtok(trim($process->getOutput()), "\n");

        return $first !== false && $first !== '' ? $first : null;
    }
}
