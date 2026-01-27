<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlurPendaftaran;

class AlurPendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        AlurPendaftaran::create([
            'img' => 'alur_pendaftaran/step1.png',
        ]);
    }
}
