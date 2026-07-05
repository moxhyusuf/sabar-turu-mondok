<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $bookings = Booking::whereHas('kost', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('penyewa')->latest()->get();
        
        return view('pemilik_dekost.booking.index', compact('bookings'));
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $booking = Booking::whereHas('kost', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->findOrFail($id);
        
        if ($booking->status == 'batal') {
            $kost = $booking->kost;
            if ($booking->transaksi) {
                $booking->transaksi->delete();
            }
            if ($booking->penyewa) {
                $booking->penyewa->delete();
            }
            $booking->delete();

            // Sync room count after deletion
            if ($kost) {
                $kost->syncKamarTersedia();
            }

            return back()->with('success', 'Data booking batal berhasil dihapus.');
        }

        return back()->with('error', 'Hanya booking dengan status batal yang bisa dihapus.');
    }

    public function selesai($id)
    {
        $user = auth()->user();
        $booking = Booking::whereHas('kost', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->findOrFail($id);

        $booking->update(['status' => 'selesai']);
        \App\Models\Transaksi::where('booking_id', $booking->id)->update(['status' => 'selesai']);

        // Sync room count after finishing
        if ($booking->kost) {
            $booking->kost->syncKamarTersedia();
        }

        return back()->with('success', 'Status sewa telah ditandai selesai.');
    }
}
