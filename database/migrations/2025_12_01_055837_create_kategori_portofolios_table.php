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
        Schema::create('kategori_portofolios', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->unsignedBigInteger('fotografer_id');
            $table->string('nama_kategori');
            $table->string('slug')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('fotografer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_portofolios');
    }
};
