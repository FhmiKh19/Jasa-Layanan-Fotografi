<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        Layanan::create([
            'nama_layanan' => 'Foto Prewedding',
            'deskripsi' => 'Paket prewedding',
            'harga' => 1500000,
            'gambar' => 'prewedding.jpg',
        ]);

        Layanan::create([
            'nama_layanan' => 'Foto Wedding',
            'deskripsi' => 'Paket wedding',
            'harga' => 2500000,
            'gambar' => 'wedding.jpg',
        ]);
    }
}
