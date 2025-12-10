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
        Schema::create('chat', function (Blueprint $table) {
            $table->id('id_chat');
            $table->unsignedBigInteger('id_pesanan'); // Relasi ke pesanan
            $table->unsignedBigInteger('id_pengirim'); // User yang mengirim pesan
            $table->unsignedBigInteger('id_penerima'); // User yang menerima pesan
            $table->text('pesan');
            $table->boolean('dibaca')->default(false);
            $table->timestamp('tgl_kirim')->useCurrent();
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_pengirim')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('id_penerima')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            
            $table->index(['id_pesanan', 'tgl_kirim']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
