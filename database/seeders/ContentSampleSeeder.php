<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Konten demo minimal (menu, kategori, tag, satu post, satu halaman, pengaturan).
 * Dipanggil setelah migrasi; untuk instalasi wizard dijalankan setelah akun Super Admin dibuat.
 */
class ContentSampleSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DefaultThemeSeeder::class,
            MenuSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            PageSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}
