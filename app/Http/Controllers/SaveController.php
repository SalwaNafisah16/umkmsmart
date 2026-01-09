<?php

namespace App\Http\Controllers;

use App\Models\Save;
use App\Models\ForumPost;

class SaveController extends Controller
{
    /**
     * ======================
     * TOGGLE SAVE / UNSAVE
     * ======================
     */
    public function toggle($postId)
    {
        $save = Save::where('user_id', auth()->id())
            ->where('forum_post_id', $postId)
            ->first();

        if ($save) {
            $save->delete(); // unsave
        } else {
            Save::create([
                'user_id' => auth()->id(),
                'forum_post_id' => $postId,
            ]);
        }

        return back();
    }

    /**
     * ======================
     * LIST SAVED POSTS
     * ======================
     */
    public function index()
    {
        $posts = ForumPost::whereHas('saves', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->with(['user', 'likes', 'comments', 'saves'])
            ->latest()
            ->get();

        return view('dashboard.mahasiswa.saved', compact('posts'));
    }
}
