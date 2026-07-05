<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Booking;
use App\Models\Transaksi;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingUserController extends Controller
{
    public function create($id)
    {
        $kost = Kost::findOrFail($id);
        $items = Kost::latest()->get();
        return view('pages.booking', compact('kost', 'items'));
    }

    public function identityForm(Request $request)
    {
        $request->validate([
            'kost_id' => 'required',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
        ]);

        $kost = Kost::findOrFail($request->kost_id);

        if ($kost->kamar_tersedia <= 0) {
            return redirect()->back()->with('error', 'Mohon maaf, kamar penuh.');
        }

        $bookingData = $request->only(['kost_id', 'tanggal_masuk', 'tanggal_keluar']);

        return view('pages.booking_identity', compact('kost', 'bookingData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kost_id' => 'required',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $kost = Kost::findOrFail($request->kost_id);

        if ($kost->kamar_tersedia <= 0) {
            return redirect()->route('user.booking.create', $kost->id)->with('error', 'Kamar penuh, booking ditolak.');
        }

        $ktpPath = null;
        if ($request->hasFile('ktp')) {
            $ktpPath = $request->file('ktp')->store('ktp_penyewa', 'public');
        }

        $penyewa = Penyewa::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'ktp' => $ktpPath
        ]);

        $kodeBooking = strtoupper(Str::random(8));

        $booking = Booking::create([
            'penyewa_id' => $penyewa->id,
            'kode_booking' => $kodeBooking,
            'kost_id' => $request->kost_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
            'status' => 'aktif',
            'status_pembayaran' => 'pending'
        ]);

        Transaksi::create([
            'booking_id' => $booking->id,
            'kost_id' => $request->kost_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
            'status_pembayaran' => 'pending',
            'status' => 'aktif'
        ]);

        // Sync sisa kamar
        $kost->syncKamarTersedia();

        session(['last_booking_kode' => $kodeBooking]);

        return redirect()->route('guest.transaksi.show', $kodeBooking)->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran dan simpan Kode Booking Anda: ' . $kodeBooking);
    }
}
