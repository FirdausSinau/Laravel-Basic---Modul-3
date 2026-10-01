<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * Mengisi tabel categories.
 */
class CategorySeeder extends Seeder
{
    /**
     * Seed data kategori kegiatan.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Workshop', 'slug' => 'workshop'],
            ['name' => 'Seminar', 'slug' => 'seminar'],
            ['name' => 'Study Club', 'slug' => 'study-club'],
            ['name' => 'Lomba', 'slug' => 'lomba'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']],
            );
        }
    }
}
