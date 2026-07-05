<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;

class Kost extends Model
{
    protected $fillable = [
        'user_id',
        'nama_kost',
        'nama_pemilik',
        'nik_pemilik',
        'nib',
        'alamat',
        'kelurahan',
        'contact_person',
        'jenis_kost',
        'type_kamar',
        'jumlah_kamar',
        'kamar_tersedia',
        'harga',
        'lokasi_pemondokan',
        'peraturan_kost',
        'nama_bank',
        'no_rekening',
        'status_izin'
    ];

    public function fasilitas()
    {
        return $this->hasOne(KostFasilitas::class);
    }

    public function images()
    {
        return $this->hasMany(KostImage::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'kost_id');
    }

    public function getKamarTersediaAttribute()
    {
        // Dynamic calculation based on active transactions
        $occupied = $this->transaksis()->active()->count();
        return max(0, $this->jumlah_kamar - $occupied);
    }

    /**
     * Sinkronisasi field kamar_tersedia di database
     */
    public function syncKamarTersedia()
    {
        $this->kamar_tersedia = $this->getKamarTersediaAttribute();
        $this->save();
        return $this->kamar_tersedia;
    }
}
