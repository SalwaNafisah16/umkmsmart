<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    /**
     * Simpan komentar atau balasan komentar
     *
     * - Mahasiswa: hanya boleh komentar utama
     * - UMKM: boleh komentar utama & balasan
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // ================= VALIDASI =================
        $rules = [
            'forum_post_id' => 'required|exists:forum_posts,id',
            'content'       => 'required|string',
        ];

        // Hanya UMKM yang boleh punya parent_id (balasan)
        if ($user->role === 'umkm') {
            $rules['parent_id'] = [
                'nullable',
                Rule::exists('comments', 'id')->where(function ($query) use ($request) {
                    $query->where('forum_post_id', $request->forum_post_id);
                }),
            ];
        }

        $validated = $request->validate($rules);

        // ================= SIMPAN =================
        Comment::create([
            'forum_post_id' => $validated['forum_post_id'],
            'user_id'       => $user->id,
            'content'       => $validated['content'],
            // Mahasiswa DIPAKSA null walaupun inject request
            'parent_id'     => $user->role === 'umkm'
                                ? ($validated['parent_id'] ?? null)
                                : null,
        ]);

        // ================= REDIRECT =================
        return back()->with('success', 'Komentar berhasil dikirim');
    }

    public function umkmIndex()
{
    $comments = Comment::with(['user','forumPost','replies.user'])
    ->whereHas('forumPost', function ($q) {
        $q->where('user_id', auth()->id());
    })
    ->whereNull('parent_id')
    ->latest()
    ->get();

    return view('dashboard.umkm.comments', compact('comments'));
}


}
