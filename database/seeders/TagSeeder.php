<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $name = 'Pengumuman';
        $slug = Str::slug($name);

        Tag::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'description' => 'Tag contoh',
                'color' => '#0d9488',
            ]
        );
    }
}
