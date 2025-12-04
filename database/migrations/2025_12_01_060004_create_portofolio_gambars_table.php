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
        Schema::create('portofolio_gambars', function (Blueprint $table) {
            $table->id('id_gambar');
            $table->unsignedBigInteger('portofolio_id');
            $table->string('file_gambar');
            $table->string('caption')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_cover')->default(false);
            $table->timestamps();

            $table->foreign('portofolio_id')->references('id_portofolio')->on('portofolios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio_gambars');
    }
};
