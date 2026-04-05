<?php

use App\Models\Theme;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

it('melewati tema dengan theme.json rusak tanpa error dan tidak mendaftarkan tema itu', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');

    $folder = '__scan_test_invalid_'.uniqid();
    $path = base_path("themes/{$folder}");
    File::makeDirectory($path, 0755, true);
    File::put($path.'/theme.json', '{not valid json');

    try {
        $this->actingAs($user)
            ->post(route('admin.themes.scan'))
            ->assertRedirect();

        expect(Theme::where('folder_name', $folder)->exists())->toBeFalse();
    } finally {
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }
    }
});

it('mendaftarkan tema saat theme.json valid', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');

    $folder = '__scan_test_valid_'.uniqid();
    $path = base_path("themes/{$folder}");
    File::makeDirectory($path, 0755, true);
    $slug = 'scan-test-'.$folder;
    File::put($path.'/theme.json', json_encode([
        'name' => 'Scan Test Theme',
        'slug' => $slug,
        'version' => '0.0.1',
        'description' => 'test',
    ]));

    try {
        $this->actingAs($user)
            ->post(route('admin.themes.scan'))
            ->assertRedirect();

        $theme = Theme::where('folder_name', $folder)->first();
        expect($theme)->not->toBeNull();
        expect($theme->name)->toBe('Scan Test Theme');
    } finally {
        Theme::where('folder_name', $folder)->delete();
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }
    }
});
