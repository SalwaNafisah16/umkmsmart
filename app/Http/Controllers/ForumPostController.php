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
        // Pastikan user terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();

        $request->validate([
            'content'    => 'required|string|max:5000',
            'product_id' => 'nullable|exists:products,id',
            'image'      => 'nullable|image|max:2048',
        ]);

        try {
            $post = new ForumPost();
            $post->user_id = $user->id;
            $post->title   = $user->role === 'umkm'
                ? 'Postingan UMKM'
                : 'Postingan Mahasiswa';

            $post->content = $request->input('content');

            // 🔐 SESUAI ENUM: diskusi, promosi, event
            $post->type = $user->role === 'umkm'
                ? 'promosi'
                : 'diskusi';

            if ($request->filled('product_id')) {
                $post->product_id = $request->input('product_id');
            }

            if ($request->hasFile('image')) {
                $post->image = $request->file('image')
                    ->store('forum_posts', 'public');
            }

            $post->save();

            return back()->with('success', 'Postingan berhasil dibuat');
            
        } catch (\Exception $e) {
            \Log::error('ForumPostController@store error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * ======================
     * DELETE POST
     * ======================
     */
    public function destroy(ForumPost $forumPost)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() !== $forumPost->user_id) {
            abort(403, 'Anda tidak memiliki akses');
        }

        try {
            if ($forumPost->image) {
                Storage::disk('public')->delete($forumPost->image);
            }

            $forumPost->delete();

            return back()->with('success', 'Postingan berhasil dihapus');
            
        } catch (\Exception $e) {
            \Log::error('ForumPostController@destroy error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * ======================
     * MAHASISWA / UMKM
     * POSTINGAN SAYA
     * ======================
     */
    public function myPosts()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $posts = ForumPost::where('user_id', Auth::id())
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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($forumPost->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses');
        }

        return view('forum.edit', compact('forumPost'));
    }

    /**
     * ======================
     * UPDATE POST
     * ======================
     */
    public function update(Request $request, ForumPost $forumPost)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($forumPost->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses');
        }

        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        try {
            $forumPost->update([
                'content' => $request->input('content'),
            ]);

            return redirect()
                ->route('forum.show', $forumPost->id)
                ->with('success', 'Postingan berhasil diperbarui');
                
        } catch (\Exception $e) {
            \Log::error('ForumPostController@update error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
