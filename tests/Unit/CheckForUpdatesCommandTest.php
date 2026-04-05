<?php

use App\Services\UpdateService;
use Illuminate\Support\Facades\Cache;

uses(Tests\TestCase::class);

beforeEach(function () {
    Cache::forget(UpdateService::CACHE_KEY);
});

describe('command cms:check-updates', function () {
    it('saves the full result to cache when an update is available', function () {
        $payload = [
            'available' => true,
            'current' => '1.0.0',
            'latest' => '1.2.0',
            'release_notes' => 'Notes',
            'download_url' => 'https://example.com/release.zip',
            'published_at' => '2026-01-01T00:00:00Z',
        ];

        $this->mock(UpdateService::class, function ($mock) use ($payload) {
            $mock->shouldReceive('checkForUpdate')->once()->andReturn($payload);
        });

        $this->artisan('cms:check-updates')->assertExitCode(0);

        expect(Cache::get(UpdateService::CACHE_KEY))->toBe($payload);
    });

    it('menghapus cache ketika sistem sudah mutakhir', function () {
        Cache::put(UpdateService::CACHE_KEY, [
            'available' => true,
            'current' => '1.0.0',
            'latest' => '9.9.9',
        ], now()->addHour());

        $this->mock(UpdateService::class, function ($mock) {
            $mock->shouldReceive('checkForUpdate')->once()->andReturn([
                'available' => false,
                'current' => '1.1.0',
            ]);
        });

        $this->artisan('cms:check-updates')->assertExitCode(0);

        expect(Cache::get(UpdateService::CACHE_KEY))->toBeNull();
    });

    it('returns a failure code when checkForUpdate throws an exception', function () {
        $this->mock(UpdateService::class, function ($mock) {
            $mock->shouldReceive('checkForUpdate')->once()->andThrow(new \RuntimeException('API cannot be reached'));
        });

        $this->artisan('cms:check-updates')->assertExitCode(1);
    });
});
