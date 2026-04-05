<?php

use App\Models\Page;
use App\Models\User;
use Database\Seeders\PageSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\Hash;

test('page seeder runs when super admin exists', function () {
    $this->seed(RoleAndPermissionSeeder::class);

    $user = User::query()->create([
        'name' => 'Admin Test',
        'email' => 'admin-test@example.com',
        'password' => Hash::make('password'),
    ]);
    $user->assignRole('Super Admin');

    $this->seed(PageSeeder::class);

    expect(Page::query()->count())->toBe(1)
        ->and(Page::query()->where('slug', 'welcome')->exists())->toBeTrue();
});
