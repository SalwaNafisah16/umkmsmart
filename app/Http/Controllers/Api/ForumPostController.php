<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ForumPostController extends Controller
{
    /**
     * =============================================
     * INDEX - Daftar Semua Postingan Forum (Paginated)
     * =============================================
     * 
     * GET /api/forum/posts
     * Query: page, search, type (promosi/forum)
     */
    public function index(Request $request)
    {
        $query = ForumPost::with(['user', 'likes', 'comments', 'saves'])
            ->latest();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search by content
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $posts = $query->paginate(15);

        // Transform untuk menyertakan count likes, comments, saves
        $posts->getCollection()->transform(function ($post) {
            $post->likes_count    = $post->likes->count();
            $post->comments_count = $post->comments->count();
            $post->saves_count    = $post->saves->count();
            $post->is_liked       = $post->likes->contains('user_id', auth()->id());
            $post->is_saved       = $post->saves->contains('user_id', auth()->id());
            
            // Tambahkan URL gambar lengkap
            if ($post->image) {
                $post->image_url = asset('storage/' . $post->image);
            }
            
            return $post;
        });

        return response()->json([
            'message' => 'Berhasil mengambil data forum posts',
            'data'    => $posts,
        ], 200);
    }

    /**
     * =============================================
     * SHOW - Detail Postingan
     * =============================================
     * 
     * GET /api/forum/posts/{id}
     */
    public function show($id)
    {
        $post = ForumPost::with(['user', 'likes', 'comments.user', 'comments.replies.user', 'saves'])
            ->find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        $post->likes_count    = $post->likes->count();
        $post->comments_count = $post->comments->count();
        $post->saves_count    = $post->saves->count();
        $post->is_liked       = $post->likes->contains('user_id', auth()->id());
        $post->is_saved       = $post->saves->contains('user_id', auth()->id());

        if ($post->image) {
            $post->image_url = asset('storage/' . $post->image);
        }

        return response()->json([
            'message' => 'Berhasil mengambil detail post',
            'data'    => $post,
        ], 200);
    }

    /**
     * =============================================
     * STORE - Buat Postingan Baru
     * =============================================
     * 
     * POST /api/forum/posts
     * Body: title (optional), body/content, image (optional)
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'title'   => 'nullable|string|max:255',
            'body'    => 'nullable|string|max:5000',
            'content' => 'nullable|string|max:5000',
            'image'   => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Ambil content dari body atau content field
        $content = $request->input('body') ?? $request->input('content') ?? '';

        $post = new ForumPost();
        $post->user_id = $user->id;
        $post->title   = $request->input('title') ?? ($user->role === 'umkm' ? 'Postingan UMKM' : 'Postingan Mahasiswa');
        $post->content = $content;
        $post->type    = $user->role === 'umkm' ? 'promosi' : 'diskusi';

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('forum_posts', 'public');
        }

        $post->save();

        // Load relations
        $post->load(['user', 'likes', 'comments', 'saves']);
        $post->likes_count    = 0;
        $post->comments_count = 0;
        $post->saves_count    = 0;

        if ($post->image) {
            $post->image_url = asset('storage/' . $post->image);
        }

        return response()->json([
            'message' => 'Postingan berhasil dibuat',
            'data'    => $post,
        ], 201);
    }

    /**
     * =============================================
     * UPDATE - Edit Postingan
     * =============================================
     * 
     * PUT /api/forum/posts/{id}
     * Body: content
     */
    public function update(Request $request, $id)
    {
        $post = ForumPost::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        if ($post->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk mengedit post ini',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $post->update([
            'content' => $request->input('content'),
        ]);

        $post->load(['user', 'likes', 'comments', 'saves']);

        return response()->json([
            'message' => 'Postingan berhasil diupdate',
            'data'    => $post,
        ], 200);
    }

    /**
     * =============================================
     * DESTROY - Hapus Postingan
     * =============================================
     * 
     * DELETE /api/forum/posts/{id}
     */
    public function destroy(Request $request, $id)
    {
        $post = ForumPost::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        if ($post->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk menghapus post ini',
            ], 403);
        }

        // Hapus gambar jika ada
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'message' => 'Postingan berhasil dihapus',
        ], 200);
    }

    /**
     * =============================================
     * MY POSTS - Postingan Saya
     * =============================================
     * 
     * GET /api/forum/my-posts
     */
    public function myPosts(Request $request)
    {
        $posts = ForumPost::where('user_id', $request->user()->id)
            ->with(['user', 'likes', 'comments', 'saves'])
            ->latest()
            ->paginate(15);

        $posts->getCollection()->transform(function ($post) {
            $post->likes_count    = $post->likes->count();
            $post->comments_count = $post->comments->count();
            $post->saves_count    = $post->saves->count();
            $post->is_liked       = $post->likes->contains('user_id', auth()->id());
            $post->is_saved       = $post->saves->contains('user_id', auth()->id());

            if ($post->image) {
                $post->image_url = asset('storage/' . $post->image);
            }

            return $post;
        });

        return response()->json([
            'message' => 'Berhasil mengambil postingan saya',
            'data'    => $posts,
        ], 200);
    }
}
