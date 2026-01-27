<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'jumlah_kamar',
        'harga',
        'lokasi_pemondokan'
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
}
