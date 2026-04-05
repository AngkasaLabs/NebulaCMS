<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Menu awal minimal. Aman dijalankan ulang: hanya mengisi jika menu masih kosong.
     */
    public function run(): void
    {
        $headerMenu = Menu::firstOrCreate(
            ['location' => 'header'],
            [
                'name' => 'Header Menu',
                'is_active' => true,
            ]
        );

        if (! $headerMenu->allItems()->exists()) {
            $headerMenu->items()->create([
                'title' => 'Beranda',
                'url' => '/',
                'order' => 1,
                'type' => 'custom',
            ]);

            $headerMenu->items()->create([
                'title' => 'Blog',
                'url' => '/blog',
                'order' => 2,
                'type' => 'custom',
            ]);

            $headerMenu->items()->create([
                'title' => 'Selamat datang',
                'url' => '/pages/welcome',
                'order' => 3,
                'type' => 'custom',
            ]);
        }

        $footerMenu = Menu::firstOrCreate(
            ['location' => 'footer'],
            [
                'name' => 'Footer Menu',
                'is_active' => true,
            ]
        );

        if (! $footerMenu->allItems()->exists()) {
            $footerMenu->items()->create([
                'title' => 'Beranda',
                'url' => '/',
                'order' => 1,
                'type' => 'custom',
            ]);

            $footerMenu->items()->create([
                'title' => 'Blog',
                'url' => '/blog',
                'order' => 2,
                'type' => 'custom',
            ]);

            $footerMenu->items()->create([
                'title' => 'Selamat datang',
                'url' => '/pages/welcome',
                'order' => 3,
                'type' => 'custom',
            ]);
        }
    }
}
