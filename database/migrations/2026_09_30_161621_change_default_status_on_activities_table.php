<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Revisi 1 - Special Challenge Modul 3.
 *
 * Mengubah default kolom status dari "Planned" (sisa domain Week 3) menjadi
 * "Draft" sesuai modul 5.2 butir 1: "Pastikan status awal Activity adalah draft".
 *
 * Nilai "Draft" memakai kapital agar konsisten dengan ActivityService, seeder,
 * dan dropdown filter status yang sudah memakai Title Case.
 *
 * Default kolom di database adalah penjaga terakhir untuk jalur insert yang
 * tidak melalui ActivityService, misalnya seeding, import, atau query manual.
 * Sisi aplikasi tetap mem-set status secara eksplisit di ActivityService::create().
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('status', 20)->default('Draft')->change();
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('status', 20)->default('Planned')->change();
        });
    }
};
