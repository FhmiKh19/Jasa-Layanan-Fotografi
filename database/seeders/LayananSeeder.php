<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanan = [
            [
                'nama_layanan' => 'Paket Wedding Premium',
                'deskripsi' => 'Paket lengkap untuk pernikahan dengan 2 fotografer, 1 videografer, album foto hardcover, dan semua foto dalam format digital. Durasi 10 jam, termasuk pre-wedding dan dokumentasi acara.',
                'harga' => 15000000,
                'status' => 'aktif',
                'tgl_dibuat' => now()->subDays(30),
            ],
            [
                'nama_layanan' => 'Paket Wedding Standar',
                'deskripsi' => 'Paket pernikahan dengan 1 fotografer, dokumentasi acara, dan semua foto dalam format digital. Durasi 8 jam.',
                'harga' => 8000000,
                'status' => 'aktif',
                'tgl_dibuat' => now()->subDays(25),
            ],
            [
                'nama_layanan' => 'Paket Pre-Wedding',
                'deskripsi' => 'Sesi foto pre-wedding di lokasi pilihan, 3 set pakaian, editing profesional, dan 50 foto terpilih dalam format digital.',
                'harga' => 3500000,
                'status' => 'aktif',
                'tgl_dibuat' => now()->subDays(20),
            ],
            [
                'nama_layanan' => 'Paket Engagement',
                'deskripsi' => 'Sesi foto tunangan dengan 2 set pakaian, editing profesional, dan 30 foto terpilih dalam format digital.',
                'harga' => 2000000,
                'status' => 'aktif',
                'tgl_dibuat' => now()->subDays(15),
            ],
            [
                'nama_layanan' => 'Paket Family Photo',
                'deskripsi' => 'Sesi foto keluarga dengan maksimal 8 orang, 2 set pakaian, dan 25 foto terpilih dalam format digital.',
                'harga' => 1500000,
                'status' => 'aktif',
                'tgl_dibuat' => now()->subDays(10),
            ],
            [
                'nama_layanan' => 'Paket Corporate Event',
                'deskripsi' => 'Dokumentasi acara perusahaan, seminar, atau workshop. Durasi 4 jam dengan semua foto dalam format digital.',
                'harga' => 3000000,
                'status' => 'aktif',
                'tgl_dibuat' => now()->subDays(5),
            ],
            [
                'nama_layanan' => 'Paket Graduation',
                'deskripsi' => 'Sesi foto wisuda dengan 2 set pakaian, editing profesional, dan 20 foto terpilih dalam format digital.',
                'harga' => 1200000,
                'status' => 'aktif',
                'tgl_dibuat' => now()->subDays(3),
            ],
            [
                'nama_layanan' => 'Paket Birthday Party',
                'deskripsi' => 'Dokumentasi pesta ulang tahun dengan durasi 3 jam dan semua foto dalam format digital.',
                'harga' => 1000000,
                'status' => 'aktif',
                'tgl_dibuat' => now()->subDays(1),
            ],
        ];

        foreach ($layanan as $item) {
            Layanan::updateOrCreate(
                ['nama_layanan' => $item['nama_layanan']],
                $item
            );
        }
    }
}
