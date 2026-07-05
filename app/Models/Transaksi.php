<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kost;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relationship to Kost
    public function kost()
    {
        return $this->belongsTo(Kost::class, 'kost_id');
    }

    // Scope for active transactions
    public function scopeActive($query)
    {
        return $query->where('status_pembayaran', 'lunas')
            ->whereNotIn('status', ['selesai', 'batal', 'ditolak']);
    }
}
