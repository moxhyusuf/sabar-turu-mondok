<?php

namespace App\Http\Controllers;

use App\Models\Kost;

class DashboardController extends Controller
{
    public function index()
    {
        $dataKelurahan = [
            'kanigaran' => Kost::whereRaw('LOWER(kelurahan) = ?', ['kanigaran'])->count(),
            'curahgrinting' => Kost::whereRaw('LOWER(kelurahan) = ?', ['curahgrinting'])->count(),
            'kebonsari_wetan' => Kost::whereRaw('LOWER(kelurahan) = ?', ['kebonsari wetan'])->count(),
            'kebonsari_kulon' => Kost::whereRaw('LOWER(kelurahan) = ?', ['kebonsari kulon'])->count(),
            'sukoharjo' => Kost::whereRaw('LOWER(kelurahan) = ?', ['sukoharjo'])->count(),
            'tisnonegaran' => Kost::whereRaw('LOWER(kelurahan) = ?', ['tisnonegaran'])->count(),
        ];

        $totalKost = Kost::count();

        // ⬅️ PENTING: arahkan ke admin.dashboard
        return view('admin.dashboard', compact('dataKelurahan', 'totalKost'));
    }
}
