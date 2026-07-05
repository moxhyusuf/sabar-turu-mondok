<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $transaksis = Transaksi::whereHas('kost', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('booking.penyewa')->latest()->get();
        
        return view('pemilik_dekost.transaksi.index', compact('transaksis'));
    }

    public function verifyPayment($id, $action)
    {
        $user = auth()->user();
        $transaksi = Transaksi::whereHas('kost', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->findOrFail($id);

        if ($action == 'approve') {
            $transaksi->update(['status_pembayaran' => 'lunas']);
            
            // Update booking status_pembayaran ke 'lunas' agar sinkron
            if ($transaksi->booking) {
                $transaksi->booking->update(['status_pembayaran' => 'lunas']);
            }

            // Update sisa kamar
            if ($transaksi->kost) {
                $transaksi->kost->syncKamarTersedia();
            }

            return back()->with('success', 'Pembayaran diverifikasi.');
        } elseif ($action == 'reject') {
            $transaksi->update([
                'status_pembayaran' => 'ditolak',
                'status' => 'ditolak'
            ]);
            
            // Update booking status agar sinkron
            if ($transaksi->booking) {
                $transaksi->booking->update([
                    'status_pembayaran' => 'ditolak',
                    'status' => 'ditolak'
                ]);
            }
            
            // Update sisa kamar
            if ($transaksi->kost) {
                $transaksi->kost->syncKamarTersedia();
            }
            
            return back()->with('error', 'Pembayaran ditolak.');
        }
    }

    public function create()
    {
        $user = auth()->user();
        $kosts = \App\Models\Kost::where('user_id', $user->id)->get();
        
        $penyewas = \App\Models\Penyewa::whereHas('bookings', function($q) use ($kosts) {
            $q->whereIn('kost_id', $kosts->pluck('id'));
        })
        ->with(['bookings' => function($q) use ($kosts) {
            $q->whereIn('kost_id', $kosts->pluck('id'));
        }])
        ->orderBy('nama', 'asc')
        ->get();
        
        return view('pemilik_dekost.transaksi.create', compact('kosts', 'penyewas'));
    }


    public function storeManual(Request $request)
    {
        $request->validate([
            'kost_id' => 'required|exists:kosts,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
            'metode_pembayaran' => 'required|in:cash,transfer',
            'nominal' => 'required|numeric|min:1',
            'bukti_pembayaran' => 'required_if:metode_pembayaran,transfer|image|mimes:jpeg,png,jpg|max:2048',
            
            // Resident validation
            'penyewa_id' => 'nullable|exists:penyewas,id',
            'nama' => 'required_without:penyewa_id|string|max:255',
            'no_hp' => 'required_without:penyewa_id|string|max:20',
            'alamat' => 'required_without:penyewa_id|string',
        ]);

        $kost = \App\Models\Kost::where('user_id', auth()->id())->findOrFail($request->kost_id);

        if ($kost->kamar_tersedia <= 0) {
            return back()->with('error', 'Mohon maaf, kamar penuh.');
        }

        // 1. Handle Penyewa
        if ($request->penyewa_id) {
            $penyewaId = $request->penyewa_id;
        } else {
            $ktpPath = null;
            if ($request->hasFile('ktp')) {
                $ktpPath = $request->file('ktp')->store('ktp_penyewa', 'public');
            }

            $penyewa = \App\Models\Penyewa::create([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'ktp' => $ktpPath
            ]);
            $penyewaId = $penyewa->id;
        }

        // 2. Create Booking (bypass normal flow)
        $booking = \App\Models\Booking::create([
            'penyewa_id' => $penyewaId,
            'kode_booking' => 'WALK-' . strtoupper(\Illuminate\Support\Str::random(6)),
            'kost_id' => $request->kost_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
            'status' => 'aktif',
            'status_pembayaran' => 'lunas'
        ]);

        // 3. Create Transaksi
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        \App\Models\Transaksi::create([
            'booking_id' => $booking->id,
            'kost_id' => $request->kost_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
            'status_pembayaran' => 'lunas',
            'status' => 'aktif',
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_bayar' => $request->nominal,
            'bukti_pembayaran' => $buktiPath
        ]);

        // 4. Sync Room Availability
        $kost->syncKamarTersedia();

        return redirect()->route('pemilik_dekost.transaksi.index')->with('success', 'Transaksi manual berhasil ditambahkan dan kamar telah diperbarui.');
    }
}
