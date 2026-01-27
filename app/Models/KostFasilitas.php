<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KostFasilitas extends Model
{
    protected $fillable = [
        'kost_id',
        'lahan_parkir',
        'pagar',
        'cctv',
        'ac_kipas',
        'meteran_listrik',
        'wifi',
        'peraturan_penghuni',
        'penjaga',
        'kasur',
        'bantal',
        'lemari',
        'guling',
        'kursi',
        'meja',
        'meja_rias',
        'mesin_cuci',
        'r_jemur',
        'dapur',
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}
