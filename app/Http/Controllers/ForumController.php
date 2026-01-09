<?php

namespace App\Http\Controllers;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class ForumController extends Controller
{

public function show(\App\Models\ForumPost $forumPost)
{
    // Ambil KOMENTAR UTAMA saja (parent_id = null)
    // + eager loading user & replies
    $comments = $forumPost->comments()
        ->whereNull('parent_id')
        ->with(['user', 'replies.user'])
        ->latest()
        ->get();

    return view('forum.show', compact('forumPost', 'comments'));
}
    /**
     * Simpan postingan Mahasiswa (TANPA GAMBAR)
     */
    public function storeMahasiswa(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        ForumPost::create([
            'user_id' => Auth::id(),
            'title'   => 'Diskusi Mahasiswa',
            'content' => $request->input('content'),
            'type'    => 'diskusi',
        ]);

        return back()->with('success', 'Postingan berhasil dibuat');
    }

    /**
     * Simpan postingan UMKM (BOLEH GAMBAR)
     */
    public function storeUmkm(Request $request): RedirectResponse
    {
        $request->validate([
            'title'   => 'required|string',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('forum', 'public');
        }

        ForumPost::create([
            'user_id' => Auth::id(),
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
            'image'   => $imagePath,
            'type'    => 'promosi',
        ]);

        return back()->with('success', 'Postingan UMKM berhasil dibuat');
    }
    public function index()
    {
        $posts = ForumPost::latest()->get();
        return view('forum.index', compact('posts'));
    }
    public function event()
    {
        $posts = ForumPost::where('type', 'event')
            ->latest()
            ->get();

        return view('forum.index', compact('posts'));
    }

    public function promosi()
    {
        $posts = ForumPost::where('type', 'promosi')
            ->latest()
            ->get();

        return view('forum.index', compact('posts'));
    }

    public function diskusi()
    {
        $posts = ForumPost::where('type', 'diskusi')
            ->latest()
            ->get();

        return view('forum.index', compact('posts'));
    }

}
