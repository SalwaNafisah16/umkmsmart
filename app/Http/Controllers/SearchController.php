<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ForumPost;
use App\Models\Comment;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        if (!$q) {
            return back();
        }

        // ======================
        // SEARCH USER (UMKM & MAHASISWA)
        // ======================
        $users = User::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->get();

        // ======================
        // SEARCH PRODUK
        // ======================
        $products = Product::where(function ($query) use ($q) {
        $query->where('nama_produk', 'like', "%$q%")
              ->orWhere('deskripsi', 'like', "%$q%");
            })
            ->orWhereHas('user.umkmProfile', function ($query) use ($q) {
                $query->where('alamat_usaha', 'like', "%$q%");
            })
            ->with(['user.umkmProfile'])
            ->get();

        // ======================
        // SEARCH POST FORUM
        // ======================
        $posts = ForumPost::where('content', 'like', "%{$q}%")
            ->orWhereHas('user', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->with(['user', 'comments'])
            ->get();

        // ======================
        // SEARCH KOMENTAR
        // ======================
        $comments = Comment::where('content', 'like', "%{$q}%")
            ->with(['user', 'forumPost'])
            ->get();

        return view('search.index', compact(
            'q',
            'users',
            'products',
            'posts',
            'comments'
        ));
    }
}
