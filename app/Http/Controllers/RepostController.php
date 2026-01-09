<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repost;


class RepostController extends Controller
{
    public function store($postId)
    {
        Repost::create([
            'user_id' => auth()->id(),
            'forum_post_id' => $postId
        ]);

        return back();
    }
}
