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
        Schema::table('jadwal_fotografer', function (Blueprint $table) {
            // Buat kolom jam_mulai dan jam_selesai nullable jika ada
            if (Schema::hasColumn('jadwal_fotografer', 'jam_mulai')) {
                $table->time('jam_mulai')->nullable()->change();
            }
            if (Schema::hasColumn('jadwal_fotografer', 'jam_selesai')) {
                $table->time('jam_selesai')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_fotografer', function (Blueprint $table) {
            // Revert jika diperlukan
            if (Schema::hasColumn('jadwal_fotografer', 'jam_mulai')) {
                $table->time('jam_mulai')->nullable(false)->change();
            }
            if (Schema::hasColumn('jadwal_fotografer', 'jam_selesai')) {
                $table->time('jam_selesai')->nullable(false)->change();
            }
        });
    }
};
