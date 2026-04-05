<?php

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

it('menolak unggah media dengan ekstensi berbahaya', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');

    $file = UploadedFile::fake()->create('shell.php', 100, 'application/x-php');

    $this->actingAs($user)
        ->post(route('admin.media.store'), [
            'files' => [$file],
        ])
        ->assertSessionHasErrors('files.0');
});
