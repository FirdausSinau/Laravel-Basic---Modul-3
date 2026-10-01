<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * Mengisi tabel activities.
 */
class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil id kategori berdasarkan slug, bukan angka hardcode.
        $categoryId = Category::pluck('id', 'slug');

        $activities = [
            // ---------- DRAFT ----------

            // Draft lengkap, bisa dipublikasikan.
            [
                'code' => 'ACT-001',
                'category_id' => $categoryId['workshop'],
                'title' => 'Workshop Persiapan Semester Ganjil',
                'description' => 'Perencanaan agenda kegiatan semester ganjil bagi seluruh unit kerja.',
                'activity_date' => '2026-10-05',
                'status' => 'Draft',
                'location' => 'Ruang Kelas A',
                'capacity' => 60,
                'start_at' => '2026-10-05 09:00:00',
                'end_at' => '2026-10-05 12:00:00',
            ],

            // Draft tanpa location, publish harus ditolak.
            [
                'code' => 'ACT-006',
                'category_id' => $categoryId['seminar'],
                'title' => 'Seminar Tamu Industri',
                'description' => 'Sharing practice bersama praktisi industri. Lokasi masih menentukan.',
                'activity_date' => '2026-10-09',
                'status' => 'Draft',
                'location' => null,
                'capacity' => 80,
                'start_at' => '2026-10-09 10:00:00',
                'end_at' => '2026-10-09 13:00:00',
            ],

            [
                'code' => 'ACT-003',
                'category_id' => $categoryId['study-club'],
                'title' => 'Study Group Struktur Data',
                'description' => 'Diskusi mingguan membahas array, linked list, tree, dan graph.',
                'activity_date' => '2026-10-07',
                'status' => 'Draft',
                'location' => 'Lab Komputer 2',
                'capacity' => 30,
                'start_at' => '2026-10-07 15:00:00',
                'end_at' => '2026-10-07 17:00:00',
            ],

            [
                'code' => 'ACT-004',
                'category_id' => $categoryId['lomba'],
                'title' => 'Lomba Desain Web Internal',
                'description' => 'Kompetisi desain tampilan web antar mahasiswa Teknik Informatika.',
                'activity_date' => '2026-10-14',
                'status' => 'Draft',
                'location' => 'Gedung Serbaguna',
                'capacity' => 45,
                'start_at' => '2026-10-14 08:00:00',
                'end_at' => '2026-10-14 17:00:00',
            ],

            [
                'code' => 'ACT-005',
                'category_id' => $categoryId['workshop'],
                'title' => 'Workshop Review Kode',
                'description' => 'Latihan membaca dan mereview kode rekan tim.',
                'activity_date' => '2026-10-20',
                'status' => 'Draft',
                'location' => 'Ruang Kelas B',
                'capacity' => 25,
                'start_at' => '2026-10-20 09:00:00',
                'end_at' => '2026-10-20 11:00:00',
            ],

            [
                'code' => 'ACT-002',
                'category_id' => $categoryId['seminar'],
                'title' => 'Rapat Koordinasi Panitia',
                'description' => 'Koordinator memfinalisasi pembagian tugas panitia.',
                'activity_date' => '2026-10-02',
                'status' => 'Draft',
                'location' => 'Ruang Rapat',
                'capacity' => 20,
                'start_at' => '2026-10-02 13:00:00',
                'end_at' => '2026-10-02 15:00:00',
            ],

            // ---------- PUBLISHED (wajib lengkap agar lolos guard publish) ----------

            // Kapasitas kecil, untuk uji pendaftaran saat penuh.
            [
                'code' => 'ACT-009',
                'category_id' => $categoryId['study-club'],
                'title' => 'Study Group SQL Query',
                'description' => 'Latihan menulis query JOIN, agregasi, dan subquery.',
                'activity_date' => '2026-10-06',
                'status' => 'Published',
                'location' => 'Lab Komputer 1',
                'capacity' => 3,
                'start_at' => '2026-10-06 14:00:00',
                'end_at' => '2026-10-06 16:00:00',
            ],

            // Sudah dimulai, untuk uji pendaftaran yang ditolak.
            [
                'code' => 'ACT-010',
                'category_id' => $categoryId['lomba'],
                'title' => 'Lomba Prototipe Aplikasi',
                'description' => 'Kompetisi membangun purwarupa aplikasi dalam 24 jam.',
                'activity_date' => '2026-09-15',
                'status' => 'Published',
                'location' => 'Gedung Serbaguna',
                'capacity' => 25,
                'start_at' => '2026-09-15 08:00:00',
                'end_at' => '2026-09-15 20:00:00',
            ],

            [
                'code' => 'ACT-007',
                'category_id' => $categoryId['workshop'],
                'title' => 'Workshop Clean Code',
                'description' => 'Praktik penulisan kode yang mudah dibaca dan dipelihara.',
                'activity_date' => '2026-10-13',
                'status' => 'Published',
                'location' => 'Ruang Kelas A',
                'capacity' => 50,
                'start_at' => '2026-10-13 09:00:00',
                'end_at' => '2026-10-13 12:00:00',
            ],

            [
                'code' => 'ACT-008',
                'category_id' => $categoryId['seminar'],
                'title' => 'Seminar Kualitas Data',
                'description' => 'Pembahasan integritas referensial, constraint, dan validasi.',
                'activity_date' => '2026-10-15',
                'status' => 'Published',
                'location' => 'Aula Utama',
                'capacity' => 30,
                'start_at' => '2026-10-15 10:00:00',
                'end_at' => '2026-10-15 12:30:00',
            ],

            [
                'code' => 'ACT-011',
                'category_id' => $categoryId['workshop'],
                'title' => 'Workshop Relasi Eloquent',
                'description' => 'Pembahasan hasMany, belongsTo, dan eager loading.',
                'activity_date' => '2026-10-22',
                'status' => 'Published',
                'location' => 'Lab Komputer 3',
                'capacity' => 40,
                'start_at' => '2026-10-22 09:00:00',
                'end_at' => '2026-10-22 12:00:00',
            ],

            [
                'code' => 'ACT-012',
                'category_id' => $categoryId['seminar'],
                'title' => 'Seminar Praktik Transaction',
                'description' => 'Simulasi kasus pendaftaran peserta dengan database transaction.',
                'activity_date' => '2026-10-27',
                'status' => 'Published',
                'location' => 'Ruang Kelas C',
                'capacity' => 60,
                'start_at' => '2026-10-27 13:00:00',
                'end_at' => '2026-10-27 16:00:00',
            ],

            // ---------- COMPLETED ----------
            [
                'code' => 'ACT-013',
                'category_id' => $categoryId['workshop'],
                'title' => 'Workshop Laravel Dasar',
                'description' => 'Pengenalan instalasi Laravel dan struktur proyek.',
                'activity_date' => '2026-09-10',
                'status' => 'Completed',
                'location' => 'Ruang Kelas A',
                'capacity' => 50,
                'start_at' => '2026-09-10 09:00:00',
                'end_at' => '2026-09-10 12:00:00',
            ],

            [
                'code' => 'ACT-014',
                'category_id' => $categoryId['study-club'],
                'title' => 'Study Group Git dan Github',
                'description' => 'Praktik branch, commit, dan permintaan review kode.',
                'activity_date' => '2026-09-17',
                'status' => 'Completed',
                'location' => 'Lab Komputer 1',
                'capacity' => 30,
                'start_at' => '2026-09-17 15:00:00',
                'end_at' => '2026-09-17 17:00:00',
            ],

            [
                'code' => 'ACT-015',
                'category_id' => $categoryId['lomba'],
                'title' => 'Lomba Prototipe Web Modul 2',
                'description' => 'Kompetisi membangun halaman web statis dan responsif.',
                'activity_date' => '2026-09-22',
                'status' => 'Completed',
                'location' => 'Gedung Serbaguna',
                'capacity' => 40,
                'start_at' => '2026-09-22 08:00:00',
                'end_at' => '2026-09-22 17:00:00',
            ],

            [
                'code' => 'ACT-016',
                'category_id' => $categoryId['seminar'],
                'title' => 'Seminar Dokumentasi Produk',
                'description' => 'Praktik menulis dokumentasi fitur yang mudah dipahami pengguna.',
                'activity_date' => '2026-09-24',
                'status' => 'Completed',
                'location' => 'Aula Utama',
                'capacity' => 70,
                'start_at' => '2026-09-24 10:00:00',
                'end_at' => '2026-09-24 12:00:00',
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
