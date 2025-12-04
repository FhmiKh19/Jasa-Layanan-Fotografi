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
        Schema::create('laporans', function (Blueprint $table) {
            $table->bigIncrements('id_laporan');

            // Foreign key ke tabel pengguna
            $table->unsignedBigInteger('fotografer_id');

            $table->string('judul');
            $table->text('deskripsi');
            $table->date('tanggal');

            $table->timestamps();

            $table->foreign('fotografer_id')
                ->references('id_pengguna')     // kolom PK di tabel pengguna
                ->on('pengguna')                // nama tabel pengguna
                ->onDelete('cascade');          // kalau pengguna dihapus, laporan ikut hilang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
