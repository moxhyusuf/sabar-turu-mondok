<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'nama' => 'Admin Kecamatan',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'alamat' => 'Kantor Kecamatan Probolinggo',
            'role' => 'admin',
            'status' => 'approved',
        ]);

        // Perpajakan
        User::create([
            'nama' => 'Petugas Pajak',
            'username' => 'perpajakan',
            'password' => Hash::make('pajak123'),
            'alamat' => 'Dinas Pajak Kecamatan',
            'role' => 'perpajakan',
            'status' => 'approved',
        ]);

        // Perizinan
        User::create([
            'nama' => 'Petugas Perizinan',
            'username' => 'perizinan',
            'password' => Hash::make('izin123'),
            'alamat' => 'Bagian Perizinan Kecamatan',
            'role' => 'perizinan',
            'status' => 'approved',
        ]);
    }
}
