<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * =============================================
     * INDEX - Daftar Semua Produk (Paginated)
     * =============================================
     * 
     * GET /api/products
     * Query: page, search, kategori
     */
    public function index(Request $request)
    {
        $query = Product::with('user')
            ->where('status', 'aktif')
            ->latest();

        // Search by nama produk
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $products = $query->paginate(15);

        // Transform untuk menambahkan URL gambar lengkap
        $products->getCollection()->transform(function ($product) {
            if ($product->gambar) {
                $product->gambar_url = asset('storage/' . $product->gambar);
            }
            return $product;
        });

        return response()->json([
            'message' => 'Berhasil mengambil data produk',
            'data'    => $products,
        ], 200);
    }

    /**
     * =============================================
     * SHOW - Detail Produk
     * =============================================
     * 
     * GET /api/products/{id}
     */
    public function show($id)
    {
        $product = Product::with('user')->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        if ($product->gambar) {
            $product->gambar_url = asset('storage/' . $product->gambar);
        }

        return response()->json([
            'message' => 'Berhasil mengambil detail produk',
            'data'    => $product,
        ], 200);
    }

    /**
     * =============================================
     * STORE - Tambah Produk Baru (UMKM Only)
     * =============================================
     * 
     * POST /api/products
     * Body: nama, deskripsi, harga, kategori, gambar (optional)
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Hanya UMKM yang boleh menambah produk
        if ($user->role !== 'umkm') {
            return response()->json([
                'message' => 'Hanya UMKM yang dapat menambah produk',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga'     => 'required|numeric|min:0',
            'kategori'  => 'nullable|string|max:100',
            'stok'      => 'nullable|integer|min:0',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = [
            'user_id'     => $user->id,
            'nama_produk' => $request->input('nama'),
            'deskripsi'   => $request->input('deskripsi'),
            'harga'       => $request->input('harga'),
            'stok'        => $request->input('stok', 0),
            'status'      => 'aktif',
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product = Product::create($data);

        // Auto buat post forum untuk promosi
        ForumPost::create([
            'user_id'  => $user->id,
            'title'    => $product->nama_produk,
            'content'  =>
                "📢 *Produk Baru UMKM*\n\n" .
                $product->nama_produk . "\n" .
                "Harga: Rp " . number_format($product->harga, 0, ',', '.') . "\n" .
                "Stok: " . $product->stok . "\n\n" .
                $product->deskripsi,
            'image'    => $product->gambar ?? null,
            'type'     => 'promosi',
            'category' => 'produk',
        ]);

        if ($product->gambar) {
            $product->gambar_url = asset('storage/' . $product->gambar);
        }

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'data'    => [
                'id'      => $product->id,
                'product' => $product,
            ],
        ], 201);
    }

    /**
     * =============================================
     * UPDATE - Edit Produk
     * =============================================
     * 
     * PUT /api/products/{id}
     * Body: nama, deskripsi, harga, kategori
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        if ($product->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk mengedit produk ini',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga'     => 'required|numeric|min:0',
            'kategori'  => 'nullable|string|max:100',
            'stok'      => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $product->update([
            'nama_produk' => $request->input('nama'),
            'deskripsi'   => $request->input('deskripsi'),
            'harga'       => $request->input('harga'),
            'stok'        => $request->input('stok', $product->stok),
        ]);

        if ($product->gambar) {
            $product->gambar_url = asset('storage/' . $product->gambar);
        }

        return response()->json([
            'message' => 'Produk berhasil diupdate',
            'data'    => $product,
        ], 200);
    }

    /**
     * =============================================
     * DESTROY - Hapus Produk
     * =============================================
     * 
     * DELETE /api/products/{id}
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        if ($product->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk menghapus produk ini',
            ], 403);
        }

        // Hapus gambar jika ada
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus',
        ], 200);
    }

    /**
     * =============================================
     * UPLOAD IMAGE - Upload Gambar Produk
     * =============================================
     * 
     * POST /api/products/{id}/gambar
     * Body: gambar (file)
     */
    public function uploadImage(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        if ($product->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk mengedit produk ini',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Hapus gambar lama jika ada
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        // Upload gambar baru
        $product->gambar = $request->file('gambar')->store('products', 'public');
        $product->save();

        $product->gambar_url = asset('storage/' . $product->gambar);

        return response()->json([
            'message' => 'Gambar berhasil diupload',
            'data'    => $product,
        ], 200);
    }

    /**
     * =============================================
     * MY PRODUCTS - Produk Saya (UMKM)
     * =============================================
     * 
     * GET /api/my-products
     */
    public function myProducts(Request $request)
    {
        $products = Product::where('user_id', $request->user()->id)
            ->with('user')
            ->latest()
            ->paginate(15);

        $products->getCollection()->transform(function ($product) {
            if ($product->gambar) {
                $product->gambar_url = asset('storage/' . $product->gambar);
            }
            return $product;
        });

        return response()->json([
            'message' => 'Berhasil mengambil produk saya',
            'data'    => $products,
        ], 200);
    }
}
