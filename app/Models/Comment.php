<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ForumPost;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'forum_post_id',
        'parent_id',
        'content'
    ];

    /**
     * Komentar dibuat oleh User (Mahasiswa / UMKM)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Komentar milik postingan forum
     */
    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class);
    }

    /**
     * Komentar induk (untuk balasan)
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Balasan komentar
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
