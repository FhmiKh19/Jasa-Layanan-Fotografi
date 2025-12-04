<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_layanan')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->date('tgl_pesanan')->nullable();
            $table->string('status')->default('pending');
            $table->string('alamat')->nullable();
            $table->date('tgl_acara')->nullable();
            $table->string('jam')->nullable();
            $table->unsignedBigInteger('fotografer_id')->nullable();
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
};
