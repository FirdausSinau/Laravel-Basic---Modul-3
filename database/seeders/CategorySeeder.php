<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * Mengisi tabel categories sebagai fixture untuk Special Challenge Modul 3.
 *
 * Dijalankan sebelum ActivitySeeder karena setiap kegiatan wajib
 * menunjuk satu kategori yang tersedia (BR-01).
 */
class CategorySeeder extends Seeder
{
    /**
     * Seed data kategori kegiatan.
     *
     * Menggunakan updateOrCreate agar seeder idempoten: menjalankan
     * `php artisan db:seed` berulang tidak menghasilkan duplikat slug.
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
