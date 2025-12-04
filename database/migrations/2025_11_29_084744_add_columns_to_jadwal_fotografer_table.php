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
        //$table->time('waktu_mulai')->nullable();
        //$table->time('waktu_selesai')->nullable();
        //$table->string('nama_klien')->nullable();
        //$table->unsignedBigInteger('id_layanan')->nullable();
        //$table->text('alamat')->nullable();
        //$table->text('catatan')->nullable();
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
