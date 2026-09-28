<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('code')->nullable()->unique()->after('id');
            $table->dateTime('start_at')->nullable()->after('status');
            $table->dateTime('end_at')->nullable()->after('start_at');
            $table->string('location')->nullable()->after('end_at');
            $table->integer('capacity')->default(0)->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['code', 'start_at', 'end_at', 'location', 'capacity']);
        });
    }
};
