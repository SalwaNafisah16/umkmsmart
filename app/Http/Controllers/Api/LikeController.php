<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\ForumPost;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * =============================================
     * TOGGLE - Like / Unlike Forum Post
     * =============================================
     * 
     * POST /api/forum/posts/{id}/like
     */
    public function toggle(Request $request, $id)
    {
        $user = $request->user();
        $post = ForumPost::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        $like = Like::where('user_id', $user->id)
            ->where('forum_post_id', $id)
            ->first();

        if ($like) {
            // Unlike
            $like->delete();
            $isLiked = false;
            $message = 'Berhasil unlike';
        } else {
            // Like
            Like::create([
                'user_id'       => $user->id,
                'forum_post_id' => $id,
            ]);
            $isLiked = true;
            $message = 'Berhasil like';
        }

        // Hitung total likes
        $likesCount = Like::where('forum_post_id', $id)->count();

        return response()->json([
            'message'     => $message,
            'data'        => [
                'is_liked'    => $isLiked,
                'likes_count' => $likesCount,
            ],
        ], 200);
    }
}
