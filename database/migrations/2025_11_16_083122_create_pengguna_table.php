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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->bigIncrements('id_pengguna');
            $table->string('nama_pengguna');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'fotografer', 'pelanggan']);
            $table->enum('status_akun', ['aktif', 'non-aktif', 'diblokir'])->default('aktif');
            $table->string('no_hp')->nullable();
            $table->timestamp('tgl_dibuat')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
