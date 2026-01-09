<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'category',
        'type', // umkm | mahasiswa
    ];

    // 🔗 Relasi ke User (UMKM / Mahasiswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 💬 Relasi ke Komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 🛒 Relasi ke Produk (opsional)
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    // ❤️ Relasi ke Like
    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }

    // 🔖 Relasi ke Save
    public function saves()
    {
        return $this->hasMany(\App\Models\Save::class);
    }

    // 🔁 Relasi ke Repost
    public function reposts()
    {
        return $this->hasMany(\App\Models\Repost::class);
    }
}
