<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Save;
use App\Models\ForumPost;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    /**
     * =============================================
     * TOGGLE - Save / Unsave Forum Post
     * =============================================
     * 
     * POST /api/forum/posts/{id}/save
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

        $save = Save::where('user_id', $user->id)
            ->where('forum_post_id', $id)
            ->first();

        if ($save) {
            // Unsave
            $save->delete();
            $isSaved = false;
            $message = 'Berhasil unsave';
        } else {
            // Save
            Save::create([
                'user_id'       => $user->id,
                'forum_post_id' => $id,
            ]);
            $isSaved = true;
            $message = 'Berhasil save';
        }

        // Hitung total saves
        $savesCount = Save::where('forum_post_id', $id)->count();

        return response()->json([
            'message' => $message,
            'data'    => [
                'is_saved'    => $isSaved,
                'saves_count' => $savesCount,
            ],
        ], 200);
    }

    /**
     * =============================================
     * INDEX - Daftar Post yang Disimpan
     * =============================================
     * 
     * GET /api/forum/saved
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $savedPosts = Save::where('user_id', $user->id)
            ->with(['forumPost.user', 'forumPost.likes', 'forumPost.comments', 'forumPost.saves'])
            ->latest()
            ->paginate(15);

        // Transform untuk menambahkan info tambahan
        $savedPosts->getCollection()->transform(function ($save) use ($user) {
            $post = $save->forumPost;
            
            if ($post) {
                $post->likes_count    = $post->likes->count();
                $post->comments_count = $post->comments->count();
                $post->saves_count    = $post->saves->count();
                $post->is_liked       = $post->likes->contains('user_id', $user->id);
                $post->is_saved       = true;

                if ($post->image) {
                    $post->image_url = asset('storage/' . $post->image);
                }
            }

            return $save;
        });

        return response()->json([
            'message' => 'Berhasil mengambil post yang disimpan',
            'data'    => $savedPosts,
        ], 200);
    }
}
