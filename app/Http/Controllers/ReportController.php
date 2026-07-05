<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Kost::query();

        // Filter Tanggal (created_at)
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        // Filter Kelurahan
        if ($request->filled('kelurahan')) {
            $query->where('kelurahan', $request->kelurahan);
        }

        // Filter Status Izin
        if ($request->filled('status_izin')) {
            $query->where('status_izin', $request->status_izin);
        }

        $kosts = $query->get();

        // Summary Calculations
        $summary = [
            'total' => $kosts->count(),
            'berizin' => $kosts->where('status_izin', 'berizin')->count(),
            'belum_berizin' => $kosts->where('status_izin', 'belum_berizin')->count(),
        ];

        // Group by Kelurahan for Report Type 1
        $perKelurahan = $kosts->groupBy('kelurahan')->map(function ($items) {
            return $items->count();
        });

        // Get unique Kelurahan for Filter Dropdown
        $listKelurahan = Kost::distinct()->pluck('kelurahan')->filter()->values();

        return view('admin.reports.index', compact('kosts', 'summary', 'perKelurahan', 'listKelurahan'));
    }

    public function exportPdf(Request $request)
    {
        $query = Kost::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        if ($request->filled('kelurahan')) {
            $query->where('kelurahan', $request->kelurahan);
        }

        if ($request->filled('status_izin')) {
            $query->where('status_izin', $request->status_izin);
        }

        $kosts = $query->get();
        
        $pdf = Pdf::loadView('admin.reports.pdf', compact('kosts'));
        return $pdf->stream('laporan_rumah_kos_' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Kost::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        if ($request->filled('kelurahan')) {
            $query->where('kelurahan', $request->kelurahan);
        }

        if ($request->filled('status_izin')) {
            $query->where('status_izin', $request->status_izin);
        }

        $kosts = $query->get();

        $fileName = 'laporan_rumah_kos_' . now()->format('YmdHis') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama Kos', 'Pemilik', 'Kelurahan', 'Status Perizinan', 'Tanggal Input'];

        $callback = function() use($kosts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($kosts as $kost) {
                $row['Nama Kos']  = $kost->nama_kost;
                $row['Pemilik']   = $kost->nama_pemilik;
                $row['Kelurahan'] = $kost->kelurahan;
                $row['Status']    = $kost->status_izin == 'berizin' ? 'Berizin' : 'Belum Berizin';
                $row['Tanggal']   = $kost->created_at->format('Y-m-d');

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * ==========================================
     * ✅ LAPORAN PEMILIK KOS (OWNER)
     * ==========================================
     */

    public function ownerIndex(Request $request)
    {
        $user = auth()->user();
        $kostIds = Kost::where('user_id', $user->id)->pluck('id');

        $query = Transaksi::with(['booking.penyewa', 'kost'])
            ->whereIn('kost_id', $kostIds);

        // Filter Tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->latest()->get();

        // Statistik Kamar
        $myKosts = Kost::where('user_id', $user->id)->get();
        $totalKamar = $myKosts->sum('jumlah_kamar');
        $kamarTerisi = Transaksi::whereIn('kost_id', $kostIds)->active()->count();
        $kamarKosong = max(0, $totalKamar - $kamarTerisi);

        // Statistik Penghuni
        $penghuniAktif = $kamarTerisi;
        $penghuniKeluar = Transaksi::whereIn('kost_id', $kostIds)->where('status', 'selesai')->count();

        $summary = [
            'total_kamar' => $totalKamar,
            'kamar_terisi' => $kamarTerisi,
            'kamar_kosong' => $kamarKosong,
            'penghuni_aktif' => $penghuniAktif,
            'penghuni_keluar' => $penghuniKeluar,
        ];

        return view('pemilik_dekost.reports.index', compact('transaksis', 'summary'));
    }

    public function ownerExportPdf(Request $request)
    {
        $user = auth()->user();
        $kostIds = Kost::where('user_id', $user->id)->pluck('id');

        $query = Transaksi::with(['booking.penyewa', 'kost'])
            ->whereIn('kost_id', $kostIds);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->latest()->get();
        
        $pdf = Pdf::loadView('pemilik_dekost.reports.pdf', compact('transaksis'));
        return $pdf->stream('laporan_pemilik_kos_' . now()->format('YmdHis') . '.pdf');
    }

    public function ownerExportExcel(Request $request)
    {
        $user = auth()->user();
        $kostIds = Kost::where('user_id', $user->id)->pluck('id');

        $query = Transaksi::with(['booking.penyewa', 'kost'])
            ->whereIn('kost_id', $kostIds);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->latest()->get();

        $fileName = 'laporan_pemilik_kos_' . now()->format('YmdHis') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $columns = ['Nama Penyewa', 'Kost', 'Tanggal Masuk', 'Tanggal Keluar', 'Status', 'Tanggal Transaksi'];

        $callback = function() use($transaksis, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transaksis as $t) {
                $row['Penyewa'] = $t->booking->penyewa->nama ?? 'N/A';
                $row['Kost']    = $t->kost->nama_kost ?? 'N/A';
                $row['Masuk']   = $t->booking->tanggal_masuk ?? 'N/A';
                $row['Keluar']  = $t->tanggal_keluar ?? 'N/A';
                $row['Status']  = ucfirst($t->status);
                $row['Tgl']     = $t->created_at->format('Y-m-d');

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
