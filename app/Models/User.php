<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;
use App\Models\Comment;



// ⬇️ WAJIB TAMBAH INI
use App\Models\MahasiswaProfile;
use App\Models\UmkmProfile;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 👤 Relasi Mahasiswa
    public function mahasiswaProfile()
    {
        return $this->hasOne(MahasiswaProfile::class);
    }

    // 🏪 Relasi Pelaku UMKM (Legacy)
   public function umkmProfile()
{
    return $this->hasOne(\App\Models\UmkmProfile::class);
}


    // 📦 Produk UMKM
        public function products()
        {
            return $this->hasMany(Product::class);
        }

        // 💬 Komentar (Mahasiswa & UMKM)
        public function comments()
        {
            return $this->hasMany(Comment::class);
        }
        


}
