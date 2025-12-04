<?php
/**
 * Script Helper untuk Mengisi Kredensial Google OAuth
 * Jalankan: php isi-kredensial.php
 */

echo "═══════════════════════════════════════════════════════════════\n";
echo "  HELPER: MENGISI KREDENSIAL GOOGLE OAUTH\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    echo "❌ File .env tidak ditemukan!\n";
    exit(1);
}

// Baca file .env
$envContent = file_get_contents($envFile);

// Cek apakah sudah ada kredensial
if (preg_match('/^GOOGLE_CLIENT_ID=(.+)$/m', $envContent, $matches)) {
    $currentClientId = trim($matches[1]);
    if (!empty($currentClientId)) {
        echo "✅ GOOGLE_CLIENT_ID sudah diisi: " . substr($currentClientId, 0, 30) . "...\n\n";
    } else {
        echo "❌ GOOGLE_CLIENT_ID masih kosong\n\n";
    }
} else {
    echo "❌ GOOGLE_CLIENT_ID tidak ditemukan di file .env\n\n";
}

if (preg_match('/^GOOGLE_CLIENT_SECRET=(.+)$/m', $envContent, $matches)) {
    $currentSecret = trim($matches[1]);
    if (!empty($currentSecret)) {
        echo "✅ GOOGLE_CLIENT_SECRET sudah diisi: " . substr($currentSecret, 0, 20) . "...\n\n";
    } else {
        echo "❌ GOOGLE_CLIENT_SECRET masih kosong\n\n";
    }
} else {
    echo "❌ GOOGLE_CLIENT_SECRET tidak ditemukan di file .env\n\n";
}

echo "═══════════════════════════════════════════════════════════════\n";
echo "  CARA MENGISI KREDENSIAL:\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "1. Buka Google Cloud Console:\n";
echo "   https://console.cloud.google.com/\n\n";

echo "2. Pilih project: My Project 19557\n\n";

echo "3. Buka: APIs & Services > Credentials\n\n";

echo "4. Klik: Create Credentials > OAuth Client ID\n\n";

echo "5. Pilih: Web Application\n\n";

echo "6. Isi:\n";
echo "   - Name: Jasa Fotografi Web Client\n";
echo "   - Authorized redirect URIs: http://127.0.0.1:8000/google/callback\n\n";

echo "7. Klik: Create\n\n";

echo "8. SALIN Client ID dan Client Secret\n\n";

echo "9. Buka file .env di folder ini:\n";
echo "   " . $envFile . "\n\n";

echo "10. Cari baris:\n";
echo "    GOOGLE_CLIENT_ID=\n";
echo "    GOOGLE_CLIENT_SECRET=\n\n";

echo "11. Isi dengan kredensial yang sudah disalin:\n";
echo "    GOOGLE_CLIENT_ID=PASTE_CLIENT_ID_DISINI\n";
echo "    GOOGLE_CLIENT_SECRET=PASTE_CLIENT_SECRET_DISINI\n\n";

echo "12. Simpan file (Ctrl + S)\n\n";

echo "13. Jalankan: php artisan config:clear\n\n";

echo "═══════════════════════════════════════════════════════════════\n";
echo "  LOKASI FILE .ENV:\n";
echo "═══════════════════════════════════════════════════════════════\n\n";
echo $envFile . "\n\n";

echo "Tekan Enter untuk membuka file .env di Notepad...";
fgets(STDIN);

// Buka file .env di Notepad (Windows)
if (PHP_OS_FAMILY === 'Windows') {
    exec('notepad "' . $envFile . '"');
    echo "\n✅ File .env sudah dibuka di Notepad\n";
    echo "   Silakan isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET\n";
    echo "   Setelah selesai, simpan file dan jalankan: php artisan config:clear\n";
} else {
    echo "\n⚠️  Silakan buka file .env secara manual\n";
}

