<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'prodi',
        // 'minat' - kolom ini tidak ada di database
        // 'avatar' - kolom ini tidak ada di database
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}