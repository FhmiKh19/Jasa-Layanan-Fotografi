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
            AND TABLE_NAME = 'chat' 
            AND (COLUMN_NAME = 'id_pengirim' OR COLUMN_NAME = 'id_penerima')
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        
        foreach ($foreignKeys as $fk) {
            try {
                DB::statement("ALTER TABLE `chat` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
            } catch (\Exception $e) {
                // Ignore jika constraint tidak ada
            }
        }
        
        // Hapus data yang tidak valid (id_pengirim atau id_penerima yang tidak ada di tabel users)
        DB::statement('DELETE FROM chat WHERE id_pengirim NOT IN (SELECT id FROM users) OR id_penerima NOT IN (SELECT id FROM users)');
        
        // Cek apakah foreign key sudah ada sebelum membuat
        $existingFk = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'chat' 
            AND CONSTRAINT_NAME IN ('chat_id_pengirim_foreign', 'chat_id_penerima_foreign')
        ");
        
        $existingFkNames = array_column($existingFk, 'CONSTRAINT_NAME');
        
        // Buat foreign key constraint yang benar ke tabel users jika belum ada
        if (!in_array('chat_id_pengirim_foreign', $existingFkNames)) {
            Schema::table('chat', function (Blueprint $table) {
                $table->foreign('id_pengirim', 'chat_id_pengirim_foreign')->references('id')->on('users')->onDelete('cascade');
            });
        }
        
        if (!in_array('chat_id_penerima_foreign', $existingFkNames)) {
            Schema::table('chat', function (Blueprint $table) {
                $table->foreign('id_penerima', 'chat_id_penerima_foreign')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat', function (Blueprint $table) {
            // Hapus foreign key constraint yang benar
            $table->dropForeign(['id_pengirim']);
            $table->dropForeign(['id_penerima']);
        });
    }
};
