<?php
/**
 * Script untuk mengecek table yang ada di database
 * Jalankan: php check_tables.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "========================================\n";
echo "CEK TABLE DI DATABASE\n";
echo "========================================\n\n";

try {
    $database = DB::connection()->getDatabaseName();
    echo "Database: {$database}\n\n";
    
    // Ambil semua table
    $tables = DB::select('SHOW TABLES');
    $tableKey = 'Tables_in_' . $database;
    
    echo "Table yang ditemukan:\n";
    echo str_repeat("-", 50) . "\n";
    
    $allTables = [];
    foreach ($tables as $table) {
        $tableName = $table->$tableKey;
        $allTables[] = $tableName;
        echo "- {$tableName}\n";
    }
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "ANALISIS TABLE:\n";
    echo str_repeat("=", 50) . "\n\n";
    
    // Table yang digunakan
    $usedTables = [
        'pengguna' => '✓ Table utama untuk user',
        'layanan' => '✓ Table untuk layanan fotografi',
        'pesanan' => '✓ Table untuk pesanan',
        'portofolio' => '✓ Table untuk portofolio',
        'testimoni' => '✓ Table untuk testimoni',
        'password_reset_tokens' => '✓ Table untuk reset password',
        'sessions' => '✓ Table untuk session Laravel',
    ];
    
    // Table yang mungkin tidak perlu
    $unusedTables = [
        'users' => '✗ Tidak digunakan (pakai pengguna)',
        'cache' => '? Hanya jika tidak pakai cache',
        'cache_locks' => '? Hanya jika tidak pakai cache',
        'jobs' => '? Hanya jika tidak pakai queue',
        'job_batches' => '? Hanya jika tidak pakai queue',
        'failed_jobs' => '? Hanya jika tidak pakai queue',
    ];
    
    echo "TABLE YANG DIGUNAKAN:\n";
    foreach ($usedTables as $table => $desc) {
        $exists = in_array($table, $allTables);
        $status = $exists ? '✓' : '✗';
        echo "  {$status} {$table} - {$desc}\n";
    }
    
    echo "\nTABLE YANG MUNGKIN TIDAK PERLU:\n";
    foreach ($unusedTables as $table => $desc) {
        $exists = in_array($table, $allTables);
        $status = $exists ? '⚠' : '✓';
        echo "  {$status} {$table} - {$desc}\n";
    }
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "REKOMENDASI:\n";
    echo str_repeat("=", 50) . "\n\n";
    
    $toDelete = [];
    if (in_array('users', $allTables)) {
        $toDelete[] = 'users';
        echo "⚠ Table 'users' ditemukan dan bisa dihapus (pakai 'pengguna')\n";
    }
    
    if (in_array('cache', $allTables)) {
        echo "? Table 'cache' ditemukan - hapus jika tidak pakai cache\n";
    }
    
    if (in_array('jobs', $allTables)) {
        echo "? Table 'jobs' ditemukan - hapus jika tidak pakai queue\n";
    }
    
    if (empty($toDelete)) {
        echo "✓ Tidak ada table yang perlu dihapus\n";
    } else {
        echo "\nSQL untuk menghapus:\n";
        foreach ($toDelete as $table) {
            echo "DROP TABLE IF EXISTS `{$table}`;\n";
        }
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

