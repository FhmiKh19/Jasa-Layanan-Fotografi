<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('jadwal_fotografer', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_pengguna');
        $table->date('tgl_acara');
        $table->time('waktu_mulai');
        $table->time('waktu_selesai');
        $table->string('nama_klien');
        $table->unsignedBigInteger('id_layanan');
        $table->text('alamat');
        $table->text('catatan')->nullable();
        $table->string('status')->default('terjadwal');
        $table->timestamps();

        $table->foreign('id_pengguna')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_layanan')->references('id')->on('layanan')->onDelete('cascade');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('jadwal_fotografer');
    }
};
