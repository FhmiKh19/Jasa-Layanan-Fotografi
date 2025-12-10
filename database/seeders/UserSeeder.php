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
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama_pengguna' => 'Admin Utama',
                'email' => 'admin@fotografi.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status_akun' => 'aktif',
                'no_hp' => '081234567890',
                'tgl_dibuat' => now()->subMonths(6),
            ]
        );

        // 🔥 FOTOGRAFER (3 fotografer)
        $fotografer = [
            [
                'username' => 'budi_foto',
                'nama_pengguna' => 'Budi Santoso',
                'email' => 'budi@fotografi.com',
                'password' => Hash::make('password123'),
                'role' => 'fotografer',
                'status_akun' => 'aktif',
                'no_hp' => '081234567891',
                'tgl_dibuat' => now()->subMonths(5),
            ],
            [
                'username' => 'sinta_foto',
                'nama_pengguna' => 'Sinta Wijaya',
                'email' => 'sinta@fotografi.com',
                'password' => Hash::make('password123'),
                'role' => 'fotografer',
                'status_akun' => 'aktif',
                'no_hp' => '081234567892',
                'tgl_dibuat' => now()->subMonths(4),
            ],
            [
                'username' => 'rizki_foto',
                'nama_pengguna' => 'Rizki Pratama',
                'email' => 'rizki@fotografi.com',
                'password' => Hash::make('password123'),
                'role' => 'fotografer',
                'status_akun' => 'aktif',
                'no_hp' => '081234567893',
                'tgl_dibuat' => now()->subMonths(3),
            ],
        ];

        foreach ($fotografer as $foto) {
            User::updateOrCreate(
                ['username' => $foto['username']],
                $foto
            );
        }

        // 🔥 PELANGGAN (10 pelanggan)
        $pelanggan = [
            [
                'username' => 'sari_customer',
                'nama_pengguna' => 'Sari Indah',
                'email' => 'sari@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567894',
                'tgl_dibuat' => now()->subMonths(2),
            ],
            [
                'username' => 'andi_k',
                'nama_pengguna' => 'Andi Kurniawan',
                'email' => 'andi@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567895',
                'tgl_dibuat' => now()->subMonths(2),
            ],
            [
                'username' => 'dewi_l',
                'nama_pengguna' => 'Dewi Lestari',
                'email' => 'dewi@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567896',
                'tgl_dibuat' => now()->subMonths(1),
            ],
            [
                'username' => 'bambang_s',
                'nama_pengguna' => 'Bambang Setiawan',
                'email' => 'bambang@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567897',
                'tgl_dibuat' => now()->subMonths(1),
            ],
            [
                'username' => 'maya_s',
                'nama_pengguna' => 'Maya Sari',
                'email' => 'maya@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567898',
                'tgl_dibuat' => now()->subWeeks(3),
            ],
            [
                'username' => 'rudi_h',
                'nama_pengguna' => 'Rudi Hermawan',
                'email' => 'rudi@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567899',
                'tgl_dibuat' => now()->subWeeks(2),
            ],
            [
                'username' => 'lina_k',
                'nama_pengguna' => 'Lina Kartika',
                'email' => 'lina@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567900',
                'tgl_dibuat' => now()->subWeeks(2),
            ],
            [
                'username' => 'eko_p',
                'nama_pengguna' => 'Eko Prasetyo',
                'email' => 'eko@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567901',
                'tgl_dibuat' => now()->subWeeks(1),
            ],
            [
                'username' => 'nina_w',
                'nama_pengguna' => 'Nina Wulandari',
                'email' => 'nina@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567902',
                'tgl_dibuat' => now()->subWeeks(1),
            ],
            [
                'username' => 'ahmad_f',
                'nama_pengguna' => 'Ahmad Fauzi',
                'email' => 'ahmad@email.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_akun' => 'aktif',
                'no_hp' => '081234567903',
                'tgl_dibuat' => now()->subDays(5),
            ],
        ];

        foreach ($pelanggan as $p) {
            User::updateOrCreate(
                ['username' => $p['username']],
                $p
            );
        }
    }
}
