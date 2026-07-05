<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    public static function checkAutoCancel()
    {
        $expiredBookings = self::where('status_pembayaran', 'pending')
            ->where('created_at', '<', now()->subHours(24))
            ->get();
            
        foreach ($expiredBookings as $booking) {
            $booking->update([
                'status' => 'batal',
                'status_pembayaran' => 'batal'
            ]);
            
            if ($booking->transaksi) {
                $booking->transaksi->update([
                    'status' => 'batal',
                    'status_pembayaran' => 'batal'
                ]);
            }

            // Sinkronisasi sisa kamar
            if ($booking->kost) {
                $booking->kost->syncKamarTersedia();
            }
        }
    }
}
