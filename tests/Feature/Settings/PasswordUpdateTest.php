<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

test('password can be updated', function () {
    // Create Super Admin role if it doesn't exist
    Role::firstOrCreate(['name' => 'Super Admin']);
    
    $user = User::factory()->create();
    $user->markEmailAsVerified();
    $user->assignRole('Super Admin');

    $response = $this
        ->actingAs($user)
        ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
        ->from('/admin/settings/password')
        ->put('/admin/settings/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/admin/settings/password');

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('correct password must be provided to update password', function () {
    // Create Super Admin role if it doesn't exist
    Role::firstOrCreate(['name' => 'Super Admin']);
    
    $user = User::factory()->create();
    $user->markEmailAsVerified();
    $user->assignRole('Super Admin');

    $response = $this
        ->actingAs($user)
        ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
        ->from('/admin/settings/password')
        ->put('/admin/settings/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasErrors('current_password')
        ->assertRedirect('/admin/settings/password');
});