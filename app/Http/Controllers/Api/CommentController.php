<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ForumPost;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * =============================================
     * INDEX - Daftar Komentar pada Forum Post
     * =============================================
     * 
     * GET /api/forum/posts/{id}/comments
     */
    public function index($id)
    {
        $post = ForumPost::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        $comments = Comment::where('forum_post_id', $id)
            ->whereNull('parent_id') // Hanya komentar utama
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Berhasil mengambil komentar',
            'data'    => $comments,
        ], 200);
    }

    /**
     * =============================================
     * STORE - Tambah Komentar pada Forum Post
     * =============================================
     * 
     * POST /api/forum/posts/{id}/comments
     * Body: content/isi, parent_id (optional untuk reply)
     */
    public function store(Request $request, $id)
    {
        $user = $request->user();
        $post = ForumPost::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'content'   => 'nullable|string',
            'isi'       => 'nullable|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Ambil content dari field content atau isi
        $content = $request->content ?? $request->isi;

        if (empty($content)) {
            return response()->json([
                'message' => 'Konten komentar harus diisi',
            ], 422);
        }

        // Mahasiswa hanya boleh komentar utama (tidak bisa reply)
        $parentId = null;
        if ($user->role === 'umkm' && $request->filled('parent_id')) {
            $parentId = $request->parent_id;
        }

        $comment = Comment::create([
            'forum_post_id' => $id,
            'user_id'       => $user->id,
            'content'       => $content,
            'parent_id'     => $parentId,
        ]);

        $comment->load(['user', 'replies.user']);

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan',
            'data'    => $comment,
        ], 201);
    }

    /**
     * =============================================
     * PRODUCT COMMENTS - Komentar pada Produk
     * =============================================
     * 
     * GET /api/products/{id}/comments
     */
    public function productComments($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        // Cari forum post terkait produk (jika ada)
        $forumPost = ForumPost::where('product_id', $id)->first();

        if (!$forumPost) {
            // Jika tidak ada forum post, cari berdasarkan title produk
            $forumPost = ForumPost::where('title', $product->nama_produk)
                ->where('user_id', $product->user_id)
                ->first();
        }

        if (!$forumPost) {
            return response()->json([
                'message' => 'Berhasil mengambil komentar',
                'data'    => [],
            ], 200);
        }

        $comments = Comment::where('forum_post_id', $forumPost->id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Berhasil mengambil komentar produk',
            'data'    => $comments,
        ], 200);
    }

    /**
     * =============================================
     * STORE PRODUCT COMMENT - Komentar pada Produk
     * =============================================
     * 
     * POST /api/products/{id}/comments
     * Body: isi/content, parent_id (optional)
     */
    public function storeProductComment(Request $request, $id)
    {
        $user    = $request->user();
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'content'   => 'nullable|string',
            'isi'       => 'nullable|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $content = $request->content ?? $request->isi;

        if (empty($content)) {
            return response()->json([
                'message' => 'Konten komentar harus diisi',
            ], 422);
        }

        // Cari atau buat forum post untuk produk
        $forumPost = ForumPost::where('product_id', $id)->first();

        if (!$forumPost) {
            $forumPost = ForumPost::where('title', $product->nama_produk)
                ->where('user_id', $product->user_id)
                ->first();
        }

        if (!$forumPost) {
            // Buat forum post untuk produk jika belum ada
            $forumPost = ForumPost::create([
                'user_id'    => $product->user_id,
                'title'      => $product->nama_produk,
                'content'    => $product->deskripsi,
                'image'      => $product->gambar,
                'type'       => 'promosi',
                'category'   => 'produk',
                'product_id' => $product->id,
            ]);
        }

        $parentId = null;
        if ($user->role === 'umkm' && $request->filled('parent_id')) {
            $parentId = $request->parent_id;
        }

        $comment = Comment::create([
            'forum_post_id' => $forumPost->id,
            'user_id'       => $user->id,
            'content'       => $content,
            'parent_id'     => $parentId,
        ]);

        $comment->load(['user', 'replies.user']);

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan',
            'data'    => $comment,
        ], 201);
    }
}
