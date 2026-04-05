<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Satu artikel contoh (hello world). Membutuhkan user dengan peran Super Admin.
     */
    public function run(): void
    {
        if (Post::query()->where('slug', 'hello-world')->exists()) {
            return;
        }

        $author = User::role('Super Admin')->first();
        if (! $author) {
            return;
        }

        $category = Category::query()->first();
        $tag = Tag::query()->first();
        if (! $category || ! $tag) {
            return;
        }

        $post = Post::create([
            'user_id' => $author->id,
            'category_id' => $category->id,
            'title' => 'Selamat datang di NebulaCMS',
            'slug' => 'hello-world',
            'excerpt' => 'Instalasi selesai. Ini adalah contoh artikel pertama di situs Anda.',
            'content' => '<p>Selamat! Situs Anda sudah siap. Anda bisa menyunting atau menghapus artikel ini dari panel admin.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $post->tags()->sync([$tag->id]);
    }
}
