<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Revisi 5 - Special Challenge Modul 3.
 *
 * Menghapus kolom legacy "category" (varchar) yang berasal dari CRUD dasar
 * Week 3. Kolom tersebut sudah digantikan oleh category_id + tabel categories.
 *
 * Aside: selama kolom ini masih ada, akses $activity->category pada Blade
 * selalu mengembalikan nilai kolom (NULL), bukan objek relasi. Akibatnya
 * nama kategori tidak pernah tampil dan eager loading menjadi sia-sia.
 *
 * Semua nilai pada kolom ini NULL, jadi tidak ada data yang hilang.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('category', 50)->nullable()->after('activity_date');
        });
    }
};
