<?php
/**
 * Script untuk mengecek konfigurasi Google OAuth
 * Jalankan: php check-google-config.php
 */

require __DIR__ . '/vendor/autoload.php';

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    echo "❌ File .env tidak ditemukan!\n";
    exit(1);
}

$envContent = file_get_contents($envFile);
$lines = explode("\n", $envContent);

$clientId = null;
$clientSecret = null;
$redirectUrl = null;

foreach ($lines as $line) {
    $line = trim($line);
    
    if (strpos($line, 'GOOGLE_CLIENT_ID=') === 0) {
        $clientId = substr($line, strlen('GOOGLE_CLIENT_ID='));
    }
    
    if (strpos($line, 'GOOGLE_CLIENT_SECRET=') === 0) {
        $clientSecret = substr($line, strlen('GOOGLE_CLIENT_SECRET='));
    }
    
    if (strpos($line, 'GOOGLE_REDIRECT_URL=') === 0) {
        $redirectUrl = substr($line, strlen('GOOGLE_REDIRECT_URL='));
    }
}

echo "=== CEK KONFIGURASI GOOGLE OAUTH ===\n\n";

// Cek Client ID
if (empty($clientId) || trim($clientId) === '') {
    echo "❌ GOOGLE_CLIENT_ID: BELUM DIISI\n";
    echo "   Format: GOOGLE_CLIENT_ID=123456789-abc...apps.googleusercontent.com\n\n";
} else {
    echo "✅ GOOGLE_CLIENT_ID: " . substr($clientId, 0, 30) . "... (" . strlen($clientId) . " karakter)\n\n";
}

// Cek Client Secret
if (empty($clientSecret) || trim($clientSecret) === '') {
    echo "❌ GOOGLE_CLIENT_SECRET: BELUM DIISI\n";
    echo "   Format: GOOGLE_CLIENT_SECRET=GOCSPX-abc...\n\n";
} else {
    echo "✅ GOOGLE_CLIENT_SECRET: " . substr($clientSecret, 0, 20) . "... (" . strlen($clientSecret) . " karakter)\n\n";
}

// Cek Redirect URL
if (empty($redirectUrl) || trim($redirectUrl) === '') {
    echo "⚠️  GOOGLE_REDIRECT_URL: BELUM DIISI (akan menggunakan default)\n\n";
} else {
    echo "✅ GOOGLE_REDIRECT_URL: $redirectUrl\n\n";
}

// Kesimpulan
if (empty($clientId) || empty($clientSecret)) {
    echo "❌ KONFIGURASI BELUM LENGKAP!\n\n";
    echo "Langkah selanjutnya:\n";
    echo "1. Buka file .env di folder ini\n";
    echo "2. Isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET\n";
    echo "3. Dapatkan kredensial dari: https://console.cloud.google.com/\n";
    echo "4. Jalankan: php artisan config:clear\n";
    exit(1);
} else {
    echo "✅ KONFIGURASI SUDAH LENGKAP!\n\n";
    echo "Langkah selanjutnya:\n";
    echo "1. Jalankan: php artisan config:clear\n";
    echo "2. Buka browser dan coba login dengan Google\n";
    exit(0);
}

