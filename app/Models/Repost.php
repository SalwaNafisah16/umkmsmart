<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repost extends Model
{
    protected $fillable = ['user_id', 'forum_post_id'];

    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }
}