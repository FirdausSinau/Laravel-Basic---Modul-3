<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Urutan wajib: kategori dibuat lebih dulu karena activities.category_id
        // mereferensikan categories.id (foreign key BR-01).
        $this->call(CategorySeeder::class);
        $this->call(ActivitySeeder::class);
    }
}
