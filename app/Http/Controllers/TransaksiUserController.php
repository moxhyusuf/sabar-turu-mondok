<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiUserController extends Controller
{
    public function index()
    {
        Booking::checkAutoCancel();
        
        $transaksis = Transaksi::whereHas('booking', function($query) {
            $query->where('user_id', Auth::id());
        })->with(['kost'])->latest()->get();

        $items = \App\Models\Kost::latest()->get();

        return view('pages.transaksi', compact('transaksis', 'items'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $messages = [
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
            'bukti_pembayaran.mimes' => 'Format file harus JPG atau PNG.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.'
        ];

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], $messages);

        $transaksi = Transaksi::findOrFail($id);
        
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('bukti_pembayaran', $fileName, 'public');

            $transaksi->update([
                'bukti_pembayaran' => 'bukti_pembayaran/' . $fileName,
                'status_pembayaran' => 'menunggu_verifikasi'
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi pemilik kost.');
    }
    public function guestShow($identifier)
    {
        Booking::checkAutoCancel();
        
        $transaksis = Transaksi::whereHas('booking', function($query) use ($identifier) {
            $query->where('kode_booking', $identifier)
                  ->orWhereHas('penyewa', function($q) use ($identifier) {
                      $q->where('email', $identifier)
                        ->orWhere('no_hp', $identifier);
                  });
        })->with(['kost', 'booking.penyewa'])->latest()->get();

        $items = \App\Models\Kost::latest()->get();

        if ($transaksis->isEmpty()) {
            return redirect()->route('guest.cek_booking')->with('error', 'Data Booking tidak ditemukan.');
        }

        return view('pages.transaksi', compact('transaksis', 'items'));
    }

    public function guestUpload(Request $request, $kode_booking)
    {
        $messages = [
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
            'bukti_pembayaran.mimes' => 'Format file harus JPG atau PNG.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.'
        ];

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], $messages);

        $transaksi = Transaksi::whereHas('booking', function($query) use ($kode_booking) {
            $query->where('kode_booking', $kode_booking);
        })->firstOrFail();
        
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('bukti_pembayaran', $fileName, 'public');

            $transaksi->update([
                'bukti_pembayaran' => 'bukti_pembayaran/' . $fileName,
                'status_pembayaran' => 'menunggu_verifikasi'
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi pemilik kost.');
    }

    public function cetakStruk($id)
    {
        $transaksi = Transaksi::with(['booking.penyewa', 'kost'])->findOrFail($id);

        // Hanya bisa cetak jika lunas
        if ($transaksi->status_pembayaran !== 'lunas') {
            return abort(403, 'Akses ditolak. Transaksi belum lunas.');
        }

        $pdf = Pdf::loadView('pages.struk', compact('transaksi'));
        
        return $pdf->stream('Struk-Booking-'.$transaksi->booking->kode_booking.'.pdf');
    }
}
