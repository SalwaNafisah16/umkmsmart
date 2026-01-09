<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard Mahasiswa
     */
    public function mahasiswa()
    {
        $posts = ForumPost::with([
            'user',
            'likes',
            'saves',
            'comments.user',
            'comments.replies.user',
        ])
        ->latest()
        ->get();

        return view('dashboard.mahasiswa.index', compact('posts'));
    }

    /**
     * Dashboard UMKM
     */
    public function umkm()
    {
        $posts = ForumPost::with(['likes', 'comments'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $products = Product::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard.umkm.index', compact('posts', 'products'));
    }
}
