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
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id('id_portofolio');
            $table->unsignedBigInteger('fotografer_id');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->nullable(); // wedding, prewedding, event, product, dll
            $table->string('gambar'); // path gambar utama
            $table->date('tanggal_foto')->nullable();
            $table->string('lokasi')->nullable();
            $table->boolean('is_featured')->default(false); // untuk ditampilkan di homepage
            $table->timestamps();

            $table->foreign('fotografer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolios');
    }
};
