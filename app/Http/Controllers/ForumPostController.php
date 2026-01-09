<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ForumPostController extends Controller
{
    /**
     * ======================
     * CREATE POST
     * ======================
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'content'    => 'required|string|max:5000',
            'product_id' => 'nullable|exists:products,id',
            'image'      => 'nullable|image|max:2048',
        ]);

        $post = new ForumPost();
        $post->user_id = $user->id;
        $post->title   = $user->role === 'umkm'
            ? 'Postingan UMKM'
            : 'Postingan Mahasiswa';

        $post->content = $request->content;

        // 🔐 SESUAI ENUM / DATA LAMA KAMU
        $post->type = $user->role === 'umkm'
            ? 'promosi'
            : 'forum';

        if ($request->filled('product_id')) {
            $post->product_id = $request->product_id;
        }

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')
                ->store('forum_posts', 'public');
        }

        $post->save();

        return back()->with('success', 'Postingan berhasil dibuat');
    }

    /**
     * ======================
     * DELETE POST
     * ======================
     */
    public function destroy(ForumPost $forumPost)
    {
        abort_if(Auth::id() !== $forumPost->user_id, 403);

        if ($forumPost->image) {
            Storage::disk('public')->delete($forumPost->image);
        }

        $forumPost->delete();

        return back()->with('success', 'Postingan berhasil dihapus');
    }

    /**
     * ======================
     * MAHASISWA / UMKM
     * POSTINGAN SAYA
     * ======================
     */
    public function myPosts()
    {
        $posts = ForumPost::where('user_id', auth()->id())
            ->with(['user', 'likes', 'comments', 'saves'])
            ->latest()
            ->get();

        return view('dashboard.mahasiswa.my-posts', compact('posts'));
    }

    /**
     * ======================
     * EDIT POST
     * ======================
     */
    public function edit(ForumPost $forumPost)
    {
        abort_if($forumPost->user_id !== auth()->id(), 403);

        return view('forum.edit', compact('forumPost'));
    }

    /**
     * ======================
     * UPDATE POST
     * ======================
     */
    public function update(Request $request, ForumPost $forumPost)
    {
        abort_if($forumPost->user_id !== auth()->id(), 403);

        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $forumPost->update([
            'content' => $request->content,
        ]);

        return redirect()
            ->route('forum.show', $forumPost->id)
            ->with('success', 'Postingan berhasil diperbarui');
    }
}
