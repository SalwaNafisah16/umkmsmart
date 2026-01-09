<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard Mahasiswa
     */
    public function mahasiswa()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $posts = ForumPost::with(['likes', 'comments'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard.umkm.index', compact('posts', 'products'));
    }
}
