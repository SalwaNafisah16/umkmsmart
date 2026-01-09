<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle($postId)
    {
        $like = Like::where('user_id', auth()->id())
            ->where('forum_post_id', $postId)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'forum_post_id' => $postId,
            ]);
        }

        return back();
    }
}

