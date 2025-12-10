<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Layanan;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user pelanggan
        $pelanggan = User::where('role', 'pelanggan')->get();
        
        // Ambil layanan
        $layanan = Layanan::all();
        
        if ($pelanggan->isEmpty() || $layanan->isEmpty()) {
            $this->command->warn('User pelanggan atau layanan belum ada. Jalankan UserSeeder dan LayananSeeder terlebih dahulu.');
            return;
        }

        $statuses = ['pending', 'diproses', 'selesai', 'dibatalkan'];
        $metodePembayaran = ['Transfer Bank', 'E-Wallet', 'Cash', 'Credit Card'];

        // Buat 20 pesanan
        for ($i = 0; $i < 20; $i++) {
            $randomPelanggan = $pelanggan->random();
            $randomLayanan = $layanan->random();
            $randomStatus = $statuses[array_rand($statuses)];
            $randomMetode = $metodePembayaran[array_rand($metodePembayaran)];

            Pesanan::create([
                'id_pengguna' => $randomPelanggan->id_pengguna,
                'id_layanan' => $randomLayanan->id_layanan,
                'metode_pembayaran' => $randomMetode,
                'status' => $randomStatus,
                'alamat' => 'Jl. Contoh No. ' . ($i + 1) . ', Jakarta',
                'tgl_acara' => now()->addDays(rand(1, 60)),
                'tgl_pesanan' => now()->subDays(rand(1, 90)),
            ]);
        }

        // Buat beberapa pesanan dengan status selesai untuk testimoni
        for ($i = 0; $i < 5; $i++) {
            $randomPelanggan = $pelanggan->random();
            $randomLayanan = $layanan->random();

            Pesanan::create([
                'id_pengguna' => $randomPelanggan->id_pengguna,
                'id_layanan' => $randomLayanan->id_layanan,
                'metode_pembayaran' => 'Transfer Bank',
                'status' => 'selesai',
                'alamat' => 'Jl. Testimoni No. ' . ($i + 1) . ', Jakarta',
                'tgl_acara' => now()->subDays(rand(10, 30)),
                'tgl_pesanan' => now()->subDays(rand(30, 60)),
            ]);
        }
    }
}
