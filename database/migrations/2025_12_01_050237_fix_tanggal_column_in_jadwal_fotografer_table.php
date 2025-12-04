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
        Schema::table('jadwal_fotografer', function (Blueprint $table) {
            // Jika kolom tanggal ada, buat nullable atau hapus jika tidak digunakan
            if (Schema::hasColumn('jadwal_fotografer', 'tanggal')) {
                $table->date('tanggal')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_fotografer', function (Blueprint $table) {
            // Revert jika diperlukan
            if (Schema::hasColumn('jadwal_fotografer', 'tanggal')) {
                $table->date('tanggal')->nullable(false)->change();
            }
        });
    }
};
