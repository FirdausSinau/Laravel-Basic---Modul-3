<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Kategori harus dibuat lebih dulu karena direferensikan activities.
        $this->call(CategorySeeder::class);
        $this->call(ActivitySeeder::class);
    }
}
