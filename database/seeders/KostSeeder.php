<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kost;
use App\Models\KostFasilitas;
use App\Models\KostImage;

class KostSeeder extends Seeder
{
    public function run(): void
    {
        $kost = Kost::create([
            'nama_kost'        => 'Fermata De’Kost',
            'nama_pemilik'     => 'Arsya Fermata Riando',
            'nik_pemilik'      => '3574011106780001',
            'alamat'           => 'Jl. Slamet Riyadi No. 000',
            'kelurahan'        => 'Kanigaran',
            'contact_person'   => '0813 8765 7484',
            'jenis_kost'       => 'putri',
            'jumlah_kamar'     => 10,
            'lokasi_pemondokan' => 'satu_atap',
        ]);

        // Fasilitas
        KostFasilitas::create([
            'kost_id'            => $kost->id,
            'lahan_parkir'       => true,
            'pagar'              => true,
            'cctv'               => true,
            'ac_kipas'           => true,
            'meteran_listrik'    => true,
            'wifi'               => true,
            'peraturan_penghuni' => true,
            'penjaga'            => false,
        ]);
    }
}
