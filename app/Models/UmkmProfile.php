<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_usaha',
        'jenis_usaha',
        'alamat_usaha',
        'no_hp_usaha',
        'deskripsi',
        'status_usaha',
        // Kolom tambahan dari migration kedua
        'alamat',
        'latitude',
        'longitude',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
