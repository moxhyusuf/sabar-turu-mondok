<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'password',
        'alamat',
        'role',
        'status',
        'bukti_ktp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function kosts()
    {
        return $this->hasMany(Kost::class);
    }
}
