<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::query()->insert([
            [
                'title' => 'Workshop Git Dasar',
                'description' => 'Latihan kolaborasi repository dan branch management.',
                'activity_date' => '2026-10-05',
                'category' => 'Workshop',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Seminar Web Quality',
                'description' => 'Pengenalan maintainability, clean code, dan static analysis.',
                'activity_date' => '2026-10-12',
                'category' => 'Seminar',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sesi Belajar Algoritma',
                'description' => 'Eksplorasi struktur data dan pemecahan masalah algoritma.',
                'activity_date' => '2026-10-15',
                'category' => 'Study Club',
                'status' => 'Ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Hackathon Internal Kampus',
                'description' => 'Membangun purwarupa aplikasi web dalam waktu 24 jam.',
                'activity_date' => '2026-09-20',
                'category' => 'Competition',
                'status' => 'Done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Review Blueprint Web Proyek',
                'description' => 'Evaluasi arsitektur perangkat lunak bersama tim modul.',
                'activity_date' => '2026-09-15',
                'category' => 'Review',
                'status' => 'Done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
