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
        if (!Schema::hasColumn('jadwal_fotografer', 'waktu_mulai')) {
            $table->time('waktu_mulai')->nullable();
        }
        if (!Schema::hasColumn('jadwal_fotografer', 'waktu_selesai')) {
            $table->time('waktu_selesai')->nullable();
        }
        if (!Schema::hasColumn('jadwal_fotografer', 'nama_klien')) {
            $table->string('nama_klien')->nullable();
        }
        if (!Schema::hasColumn('jadwal_fotografer', 'id_layanan')) {
            $table->unsignedBigInteger('id_layanan')->nullable();
        }
        if (!Schema::hasColumn('jadwal_fotografer', 'alamat')) {
            $table->text('alamat')->nullable();
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_fotografer', function (Blueprint $table) {
            //
        });
    }
};
