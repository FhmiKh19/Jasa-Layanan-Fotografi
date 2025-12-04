<?php
/**
 * Script sederhana untuk melihat data user di database
 * Jalankan dengan: php lihat-data-user.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n========================================\n";
echo "LIHAT DATA USER DI DATABASE\n";
echo "========================================\n\n";

try {
    // Cek koneksi database
    $pdo = DB::connection()->getPdo();
    echo "✅ Koneksi database berhasil!\n\n";
    
    // Ambil semua data user
    $users = DB::table('users')->get();
    
    if ($users->isEmpty()) {
        echo "⚠️  Belum ada user yang terdaftar.\n\n";
    } else {
        echo "📊 DAFTAR USER (Total: " . $users->count() . "):\n";
        echo "========================================\n\n";
        
        foreach ($users as $index => $user) {
            echo "User #" . ($index + 1) . ":\n";
            echo "  ID        : " . $user->id . "\n";
            echo "  Nama      : " . $user->name . "\n";
            echo "  Telepon   : " . $user->telepon . "\n";
            echo "  Alamat    : " . $user->alamat . "\n";
            echo "  Email     : " . ($user->email ?? '-') . "\n";
            echo "  Dibuat    : " . $user->created_at . "\n";
            echo "\n";
        }
    }
    
    // Cek tabel bookings juga
    echo "========================================\n";
    $bookings = DB::table('bookings')->get();
    echo "📋 DAFTAR BOOKING (Total: " . $bookings->count() . "):\n";
    echo "========================================\n\n";
    
    if ($bookings->isEmpty()) {
        echo "⚠️  Belum ada booking.\n\n";
    } else {
        foreach ($bookings as $index => $booking) {
            echo "Booking #" . ($index + 1) . ":\n";
            echo "  ID            : " . $booking->id . "\n";
            echo "  Nama Pemesan  : " . $booking->nama_pemesan . "\n";
            echo "  Jam Booking   : " . $booking->jam_booking . "\n";
            echo "  Dibuat        : " . $booking->created_at . "\n";
            echo "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n\n";
    
    if (strpos($e->getMessage(), '2002') !== false || strpos($e->getMessage(), 'refused') !== false) {
        echo "═══════════════════════════════════════════════════════\n";
        echo "MySQL tidak berjalan!\n\n";
        echo "SOLUSI:\n";
        echo "1. Buka Laragon\n";
        echo "2. Klik kanan ikon Laragon di system tray\n";
        echo "3. Pilih 'Start All' atau 'MySQL' > 'Start'\n";
        echo "4. Jalankan script ini lagi\n";
    } elseif (strpos($e->getMessage(), "doesn't exist") !== false) {
        echo "═══════════════════════════════════════════════════════\n";
        echo "Database belum dibuat!\n\n";
        echo "SOLUSI:\n";
        echo "1. Buka phpMyAdmin: http://127.0.0.1/phpmyadmin\n";
        echo "2. Buat database baru\n";
        echo "3. Update DB_DATABASE di file .env\n";
        echo "4. Jalankan: php artisan migrate\n";
    }
}

echo "========================================\n";
echo "Selesai.\n";
echo "========================================\n\n";

