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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_pengguna'); // User yang menerima notifikasi
            $table->string('tipe'); // 'chat', 'pesanan', dll
            $table->string('judul');
            $table->text('pesan');
            $table->string('link')->nullable(); // Link ke halaman terkait
            $table->boolean('dibaca')->default(false);
            $table->timestamp('tgl_dibuat')->useCurrent();
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->index(['id_pengguna', 'dibaca', 'tgl_dibuat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
