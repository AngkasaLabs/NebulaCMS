<?php

use App\Models\User;
use App\Services\UpdateService;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

function adminWithSettings(): User
{
    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    return $user;
}

test('guests cannot access system update', function () {
    $this->get(route('admin.system.update', absolute: false))
        ->assertRedirect(route('login', absolute: false));
});

test('apply rejects when there is no pending update session', function () {
    $this->actingAs(adminWithSettings());

    $this->from(route('admin.system.update', absolute: false))
        ->post(route('admin.system.update.apply', absolute: false), [
            'download_url' => 'https://github.com/example/asset.zip',
        ])
        ->assertSessionHas('error');
});

test('apply rejects when download_url does not match pending session', function () {
    $this->actingAs(adminWithSettings());

    session([
        'pending_update' => [
            'download_url' => 'https://github.com/correct/asset.zip',
            'latest' => '1.2.0',
            'checked_at' => now()->timestamp,
        ],
    ]);

    $this->from(route('admin.system.update', absolute: false))
        ->post(route('admin.system.update.apply', absolute: false), [
            'download_url' => 'https://evil.example.com/payload.zip',
        ])
        ->assertSessionHas('error');
});

test('apply rejects when pending session is expired', function () {
    $this->actingAs(adminWithSettings());

    session([
        'pending_update' => [
            'download_url' => 'https://github.com/example/asset.zip',
            'latest' => '1.2.0',
            'checked_at' => now()->subHours(2)->timestamp,
        ],
    ]);

    $this->from(route('admin.system.update', absolute: false))
        ->post(route('admin.system.update.apply', absolute: false), [
            'download_url' => 'https://github.com/example/asset.zip',
        ])
        ->assertSessionHas('error');
});

test('apply succeeds when session matches and uses stubbed update service', function () {
    Config::set('nebula.version', '1.0.0');

    $stub = new class extends UpdateService
    {
        public function createBackup(): string
        {
            return storage_path('app/backups/stub-backup.zip');
        }

        public function applyUpdate(string $downloadUrl): array
        {
            return [
                'success' => true,
                'message' => 'Update applied successfully.',
                'from' => '1.0.0',
                'to' => '1.1.0',
            ];
        }
    };

    $this->instance(UpdateService::class, $stub);

    $this->actingAs(adminWithSettings());

    session([
        'pending_update' => [
            'download_url' => 'https://github.com/example/release.zip',
            'latest' => '1.1.0',
            'checked_at' => now()->timestamp,
        ],
    ]);

    $this->from(route('admin.system.update', absolute: false))
        ->post(route('admin.system.update.apply', absolute: false), [
            'download_url' => 'https://github.com/example/release.zip',
        ])
        ->assertSessionHas('success')
        ->assertSessionMissing('pending_update');

    expect(Cache::get(UpdateService::CACHE_KEY))->toBeNull();
});
