<?php
/**
 * Script untuk memperbaiki gambar layanan yang tidak muncul
 * Jalankan: php fix_service_images.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;

echo "========================================\n";
echo "PERBAIKAN GAMBAR LAYANAN\n";
echo "========================================\n\n";

try {
    // Pastikan folder ada
    $layananPath = 'public/layanan';
    if (!Storage::exists($layananPath)) {
        Storage::makeDirectory($layananPath);
        echo "✓ Folder storage/app/public/layanan dibuat\n\n";
    } else {
        echo "✓ Folder storage/app/public/layanan sudah ada\n\n";
    }

    // Ambil semua layanan
    $layanan = Layanan::all();
    
    echo "Total layanan: " . $layanan->count() . "\n";
    echo str_repeat("-", 50) . "\n\n";

    $fixed = 0;
    $notFound = 0;
    
    foreach ($layanan as $item) {
        echo "Layanan: {$item->nama_layanan}\n";
        echo "  ID: {$item->id_layanan}\n";
        
        if ($item->gambar && !empty($item->gambar)) {
            echo "  Gambar di DB: {$item->gambar}\n";
            
            // Cek apakah file ada
            $filePath = $layananPath . '/' . $item->gambar;
            if (Storage::exists($filePath)) {
                echo "  ✓ File ditemukan di: storage/app/{$filePath}\n";
                echo "  ✓ URL: " . asset('storage/layanan/' . $item->gambar) . "\n";
            } else {
                echo "  ✗ File TIDAK ditemukan!\n";
                echo "    Mencari di: storage/app/{$filePath}\n";
                $notFound++;
            }
        } else {
            echo "  ⚠ Tidak ada gambar di database\n";
        }
        
        echo "\n";
    }
    
    echo str_repeat("=", 50) . "\n";
    echo "RINGKASAN:\n";
    echo str_repeat("=", 50) . "\n";
    echo "Total layanan: " . $layanan->count() . "\n";
    echo "Gambar tidak ditemukan: {$notFound}\n";
    
    if ($notFound > 0) {
        echo "\n⚠ PERHATIAN: Ada {$notFound} layanan dengan gambar yang tidak ditemukan.\n";
        echo "Solusi:\n";
        echo "1. Upload ulang gambar untuk layanan tersebut\n";
        echo "2. Atau pastikan file gambar ada di folder: storage/app/public/layanan/\n";
    } else {
        echo "\n✓ Semua gambar ditemukan!\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n";

