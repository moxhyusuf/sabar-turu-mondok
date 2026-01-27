<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan KostSeeder
        $this->call([
            KostSeeder::class,
        ]);

        $this->call([
            AboutKamiSeeder::class,
        ]);

        $this->call([
            AlurPendaftaranSeeder::class,
        ]);
        $this->call([
            UserSeeder::class,
        ]);
    }
}
