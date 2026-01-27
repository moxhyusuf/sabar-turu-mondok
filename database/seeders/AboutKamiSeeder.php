<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutKami;

class AboutKamiSeeder extends Seeder
{
    public function run(): void
    {
        AboutKami::create([
            'tentang_kami' => 'Selamat datang di halaman Tentang Kami. Silakan ubah konten ini melalui menu admin.',
            'img' => null,
        ]);
    }
}
