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
            if (!Schema::hasColumn('jadwal_fotografer', 'catatan')) {
                $table->text('catatan')->nullable()->after('alamat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_fotografer', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_fotografer', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }
};
