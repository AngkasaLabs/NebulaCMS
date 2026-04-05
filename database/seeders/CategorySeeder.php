<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $name = 'Umum';
        $slug = Str::slug($name);

        Category::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'description' => 'Kategori bawaan untuk konten Anda',
                'color' => '#4f46e5',
            ]
        );
    }
}
