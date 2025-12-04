<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek dan hapus foreign key constraint yang salah jika ada
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'jadwal_fotografer' 
            AND COLUMN_NAME = 'id_pengguna' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        
        foreach ($foreignKeys as $fk) {
            Schema::table('jadwal_fotografer', function (Blueprint $table) use ($fk) {
                $table->dropForeign([$fk->CONSTRAINT_NAME]);
            });
        }
        
        // Hapus data yang tidak valid (id_pengguna yang tidak ada di tabel users)
        DB::statement('DELETE FROM jadwal_fotografer WHERE id_pengguna NOT IN (SELECT id FROM users)');
        
        // Buat foreign key constraint yang benar ke tabel users
        Schema::table('jadwal_fotografer', function (Blueprint $table) {
            $table->foreign('id_pengguna')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_fotografer', function (Blueprint $table) {
            // Hapus foreign key constraint yang benar
            $table->dropForeign(['id_pengguna']);
        });
        
        Schema::table('jadwal_fotografer', function (Blueprint $table) {
            // Kembalikan foreign key constraint yang salah (jika diperlukan)
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }
};
