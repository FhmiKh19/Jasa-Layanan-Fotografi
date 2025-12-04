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
        Schema::create('layanan', function (Blueprint $table) {
            $table->bigIncrements('id_layanan');      // Primary key
            $table->string('nama_layanan');           // Nama layanan
            $table->text('deskripsi')->nullable();    // Deskripsi layanan
            $table->integer('harga');                 // Harga layanan
            $table->string('gambar')->nullable();     // Path gambar
            $table->timestamp('tgl_dibuat')->nullable(); // tanggal dibuat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
