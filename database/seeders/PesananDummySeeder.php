<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Layanan;
use Carbon\Carbon;

class PesananDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil fotografer (user dengan ID 4 - Nezha)
        $fotografer = User::find(4);
        
        // Ambil layanan pertama
        $layanan = Layanan::first();
        
        // Buat user dummy untuk pelanggan jika belum ada
        $pelanggan = User::firstOrCreate(
            ['email' => 'pelanggan@example.com'],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => 'pelanggan',
            ]
        );

        // Buat pesanan dummy
        Pesanan::create([
            'id_pengguna' => $pelanggan->id,
            'id_layanan' => $layanan->id_layanan ?? 1,
            'fotografer_id' => $fotografer->id ?? 4,
            'metode_pembayaran' => 'Transfer Bank',
            'bukti_pembayaran' => 'bukti_dummy.jpg',
            'tgl_pesanan' => Carbon::now()->subDays(5)->format('Y-m-d'),
            'status' => 'pending',
            'alamat' => 'Jl. Raya Contoh No. 123, Jakarta Selatan',
            'tgl_acara' => Carbon::now()->addDays(10)->format('Y-m-d'),
        ]);

        $this->command->info('Data dummy pesanan berhasil dibuat!');
    }
}
