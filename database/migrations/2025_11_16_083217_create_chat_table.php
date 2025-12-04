<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->id('id_chat');
            $table->unsignedBigInteger('id_pengirim');
            $table->unsignedBigInteger('id_penerima');
            $table->text('pesan');
            $table->timestamp('tgl_dikirim')->useCurrent();

            // foreign key
            $table->foreign('id_pengirim')
                  ->references('id_pengguna')
                  ->on('pengguna')
                  ->onDelete('cascade');

            $table->foreign('id_penerima')
                  ->references('id_pengguna')
                  ->on('pengguna')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
