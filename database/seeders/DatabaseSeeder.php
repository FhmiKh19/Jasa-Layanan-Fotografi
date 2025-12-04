<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            LayananSeeder::class,
            PortofolioSeeder::class,
            PesananSeeder::class,
            TestimoniSeeder::class,
        ]);
    }
}
