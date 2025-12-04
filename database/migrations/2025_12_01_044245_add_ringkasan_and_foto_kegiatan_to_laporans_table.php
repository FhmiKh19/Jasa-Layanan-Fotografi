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
        Schema::table('laporans', function (Blueprint $table) {
            if (!Schema::hasColumn('laporans', 'ringkasan')) {
                $table->text('ringkasan')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('laporans', 'foto_kegiatan')) {
                $table->string('foto_kegiatan')->nullable()->after('ringkasan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['ringkasan', 'foto_kegiatan']);
        });
    }
};
