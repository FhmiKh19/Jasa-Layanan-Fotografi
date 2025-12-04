<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <- pastikan ini ada
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nezha',
            'username' => 'fotografer1',
            'email' => 'fotografer@example.com',
            'password' => Hash::make('fotografer123'), // password default
            'role' => 'fotografer', // sesuaikan kolom role
        ]);
    }
}
