<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fotografer', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('nama_pengguna');
            $table->string('username')->unique();
            $table->string('no_hp');
            $table->string('status_akun')->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotografer');
    }
};
