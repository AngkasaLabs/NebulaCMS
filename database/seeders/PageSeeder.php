<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Satu halaman contoh. Membutuhkan user dengan peran Super Admin.
     */
    public function run(): void
    {
        $author = User::role('Super Admin')->first();
        if (! $author) {
            return;
        }

        Page::updateOrCreate(
            ['slug' => 'welcome'],
            [
                'title' => 'Selamat datang',
                'content' => '<p>Instalasi NebulaCMS selesai. Ini halaman contoh — ubah dari admin sesuai kebutuhan Anda.</p>',
                'meta_description' => 'Halaman contoh setelah instalasi',
                'meta_keywords' => 'welcome, nebulacms',
                'status' => 'published',
                'order' => 1,
                'user_id' => $author->id,
            ]
        );
    }
}
