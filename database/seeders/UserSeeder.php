<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 🔥 ADMIN
        User::create([
            'nama_pengguna' => 'Admin Utama',
            'username' => 'admin',
            'email' => 'admin@fotografi.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status_akun' => 'aktif',
            'no_hp' => '081234567890',
            'tgl_dibuat' => now(),
        ]);

        // 🔥 FOTOGRAFER
        User::create([
            'nama_pengguna' => 'Budi Fotografer',
            'username' => 'budi_foto',
            'email' => 'budi@fotografi.com',
            'password' => Hash::make('password123'),
            'role' => 'fotografer',
            'status_akun' => 'aktif',
            'no_hp' => '081234567891',
            'tgl_dibuat' => now(),
        ]);

        // 🔥 PELANGGAN
        User::create([
            'nama_pengguna' => 'Sari Pelanggan',
            'username' => 'sari_customer',
            'email' => 'sari@email.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'status_akun' => 'aktif',
            'no_hp' => '081234567892',
            'tgl_dibuat' => now(),
        ]);
    }
}
