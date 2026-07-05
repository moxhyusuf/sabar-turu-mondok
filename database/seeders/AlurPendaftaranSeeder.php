<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlurPendaftaran;

class AlurPendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        AlurPendaftaran::create([
            'title' => 'Alur Pendaftaran Rumah Pemondokan',
            'img' => 'alur_pendaftaran/step1.png',
        ]);
    }
}
