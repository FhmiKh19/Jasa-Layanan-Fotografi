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
        Schema::table('portofolio', function (Blueprint $table) {
            $table->foreignId('id_fotografer')->nullable()->after('id_portofolio')->constrained('pengguna', 'id_pengguna')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portofolio', function (Blueprint $table) {
            $table->dropForeign(['id_fotografer']);
            $table->dropColumn('id_fotografer');
        });
    }
};
