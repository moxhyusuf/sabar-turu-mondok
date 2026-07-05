<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Transaksi;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ======================
        // ✅ DATA ADMIN
        // ======================
        $dataKelurahan = [];
        $totalKost = 0;

        if ($user->role === 'admin') {
            $dataKelurahan = [
                'kanigaran' => Kost::whereRaw('LOWER(kelurahan) = ?', ['kanigaran'])->count(),
                'curahgrinting' => Kost::whereRaw('LOWER(kelurahan) = ?', ['curahgrinting'])->count(),
                'kebonsari_wetan' => Kost::whereRaw('LOWER(kelurahan) = ?', ['kebonsari wetan'])->count(),
                'kebonsari_kulon' => Kost::whereRaw('LOWER(kelurahan) = ?', ['kebonsari kulon'])->count(),
                'sukoharjo' => Kost::whereRaw('LOWER(kelurahan) = ?', ['sukoharjo'])->count(),
                'tisnonegaran' => Kost::whereRaw('LOWER(kelurahan) = ?', ['tisnonegaran'])->count(),
            ];

            $totalKost = Kost::count();
        }

        // ======================
        // ✅ DATA PEMILIK KOST
        // ======================
        $statsPemilik = [
            'jumlah_penghuni' => 0,
            'kamar_terisi' => 0,
            'kamar_tersedia' => 0,
            'total_transaksi' => 0,
        ];

        if ($user->role === 'pemilik_dekost') {

            // Ambil semua kost milik user
            $kosts = Kost::where('user_id', $user->id)->get();
            $kostIds = $kosts->pluck('id');

            // ======================
            // ✅ HITUNG STATISTIK (SINKRON DENGAN REPORT)
            // ======================
            $kamarTerisi = Transaksi::whereIn('kost_id', $kostIds)->active()->count();
            $penghuniKeluar = Transaksi::whereIn('kost_id', $kostIds)->where('status', 'selesai')->count();
            $totalTransaksi = $kamarTerisi;

            $statsPemilik = [
                'jumlah_penghuni' => $kamarTerisi, // Penghuni Aktif
                'penghuni_keluar' => $penghuniKeluar,
                'kamar_terisi' => $kamarTerisi,
                'kamar_tersedia' => $kosts->sum('kamar_tersedia'),
                'total_transaksi' => $totalTransaksi,
            ];

            // ======================
            // ✅ STATISTIK BULANAN
            // ======================
            $currentYear = now()->year;
            $statsBulanan = [
                'aktif' => array_fill(1, 12, 0),
                'keluar' => array_fill(1, 12, 0),
            ];

            $monthlyActive = Transaksi::whereIn('kost_id', $kostIds)
                ->whereYear('created_at', $currentYear)
                ->where('status', 'aktif')
                ->selectRaw('month(created_at) as month, count(*) as count')
                ->groupBy('month')
                ->pluck('count', 'month');

            $monthlyExited = Transaksi::whereIn('kost_id', $kostIds)
                ->whereYear('created_at', $currentYear)
                ->where('status', 'selesai')
                ->selectRaw('month(created_at) as month, count(*) as count')
                ->groupBy('month')
                ->pluck('count', 'month');

            foreach ($monthlyActive as $month => $count) {
                $statsBulanan['aktif'][$month] = $count;
            }
            foreach ($monthlyExited as $month => $count) {
                $statsBulanan['keluar'][$month] = $count;
            }

            // ======================
            // ✅ AKTIVITAS TERBARU
            // ======================
            $recentBookings = Booking::with(['penyewa', 'kost'])
                ->whereIn('kost_id', $kostIds)
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            $recentPayments = Transaksi::with(['booking.penyewa', 'kost'])
                ->whereIn('kost_id', $kostIds)
                ->where('status_pembayaran', 'pending')
                ->latest()
                ->take(5)
                ->get();

            return view('admin.dashboard', compact('dataKelurahan', 'totalKost', 'statsPemilik', 'statsBulanan', 'recentBookings', 'recentPayments'));
        }

        return view('admin.dashboard', compact('dataKelurahan', 'totalKost', 'statsPemilik'));
    }
}
