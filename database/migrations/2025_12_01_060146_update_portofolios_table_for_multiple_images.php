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
        Schema::table('portofolios', function (Blueprint $table) {
            // Tambah kolom kategori_id sebagai foreign key
            $table->unsignedBigInteger('kategori_id')->nullable()->after('fotografer_id');
            
            // Hapus kolom gambar karena sekarang pakai tabel portofolio_gambars
            if (Schema::hasColumn('portofolios', 'gambar')) {
                $table->dropColumn('gambar');
            }
            
            // Hapus kolom kategori string karena sekarang pakai foreign key
            if (Schema::hasColumn('portofolios', 'kategori')) {
                $table->dropColumn('kategori');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portofolios', function (Blueprint $table) {
            $table->dropColumn('kategori_id');
            $table->string('gambar')->nullable();
            $table->string('kategori')->nullable();
        });
    }
};
