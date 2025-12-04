<?php
/**
 * Script untuk test koneksi database
 * Jalankan dengan: php test-db-connection.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n========================================\n";
echo "TEST KONEKSI DATABASE\n";
echo "========================================\n\n";

// Cek konfigurasi dari .env
echo "Konfigurasi Database:\n";
echo "- DB_CONNECTION: " . env('DB_CONNECTION', 'not set') . "\n";
echo "- DB_HOST: " . env('DB_HOST', 'not set') . "\n";
echo "- DB_PORT: " . env('DB_PORT', 'not set') . "\n";
echo "- DB_DATABASE: " . env('DB_DATABASE', 'not set') . "\n";
echo "- DB_USERNAME: " . env('DB_USERNAME', 'not set') . "\n";
echo "- DB_PASSWORD: " . (empty(env('DB_PASSWORD')) ? '(kosong)' : '***') . "\n";
echo "\n";

// Test koneksi
echo "Mencoba koneksi ke database...\n";
try {
    $pdo = DB::connection()->getPdo();
    echo "✅ BERHASIL! Koneksi database berhasil.\n\n";
    
    // Test query
    echo "Mencoba query database...\n";
    $tables = DB::select("SHOW TABLES");
    echo "✅ BERHASIL! Database dapat diakses.\n";
    echo "Jumlah tabel: " . count($tables) . "\n";
    
    // Cek apakah tabel users ada
    $usersExists = DB::select("SHOW TABLES LIKE 'users'");
    if (!empty($usersExists)) {
        echo "✅ Tabel 'users' sudah ada.\n";
        $userCount = DB::table('users')->count();
        echo "   Jumlah user: $userCount\n";
    } else {
        echo "⚠️  Tabel 'users' belum ada. Jalankan: php artisan migrate\n";
    }
    
} catch (\Illuminate\Database\QueryException $e) {
    echo "❌ ERROR KONEKSI DATABASE!\n\n";
    echo "Pesan Error: " . $e->getMessage() . "\n\n";
    
    if (strpos($e->getMessage(), '2002') !== false || strpos($e->getMessage(), 'refused') !== false) {
        echo "═══════════════════════════════════════════════════════\n";
        echo "SOLUSI:\n";
        echo "═══════════════════════════════════════════════════════\n";
        echo "MySQL tidak berjalan atau tidak bisa diakses.\n\n";
        echo "LANGKAH PERBAIKAN:\n";
        echo "1. Buka Laragon\n";
        echo "2. Klik kanan ikon Laragon di system tray\n";
        echo "3. Pilih 'Start All' atau 'MySQL' > 'Start'\n";
        echo "4. Pastikan status MySQL menunjukkan 'Running' (hijau)\n";
        echo "5. Jalankan script ini lagi untuk verifikasi\n";
        echo "\n";
        echo "Lihat file: CARA_MEMPERBAIKI_MYSQL_LOGIN_GOOGLE.txt\n";
        echo "untuk panduan lengkap.\n";
    } elseif (strpos($e->getMessage(), '1045') !== false || strpos($e->getMessage(), 'Access denied') !== false) {
        echo "═══════════════════════════════════════════════════════\n";
        echo "SOLUSI:\n";
        echo "═══════════════════════════════════════════════════════\n";
        echo "Username atau password database salah.\n\n";
        echo "Periksa file .env dan pastikan:\n";
        echo "- DB_USERNAME=root\n";
        echo "- DB_PASSWORD= (kosong untuk Laragon)\n";
    } elseif (strpos($e->getMessage(), '1049') !== false || strpos($e->getMessage(), "doesn't exist") !== false) {
        echo "═══════════════════════════════════════════════════════\n";
        echo "SOLUSI:\n";
        echo "═══════════════════════════════════════════════════════\n";
        echo "Database belum dibuat.\n\n";
        echo "LANGKAH PERBAIKAN:\n";
        echo "1. Buka phpMyAdmin: http://127.0.0.1/phpmyadmin\n";
        echo "2. Buat database baru dengan nama yang sesuai\n";
        echo "3. Update DB_DATABASE di file .env\n";
        echo "4. Jalankan: php artisan migrate\n";
    }
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "Selesai.\n";
echo "========================================\n\n";

