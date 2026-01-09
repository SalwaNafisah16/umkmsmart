<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk milik UMKM
     */
    public function index()
    {
        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard.umkm.products.index', compact('products'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        return view('dashboard.umkm.products.create');
    }

    /**
     * Simpan produk baru + AUTO POST KE FORUM
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ================= SIMPAN PRODUK =================
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['status']  = 'aktif';

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('products', 'public');
        }

        $product = Product::create($data);

        // ================= AUTO BUAT POST FORUM =================
        ForumPost::create([
            'user_id'  => Auth::id(),
            'title'    => $product->nama_produk,
            'content'  =>
                "📢 *Produk Baru UMKM*\n\n" .
                $product->nama_produk . "\n" .
                "Harga: Rp " . number_format($product->harga, 0, ',', '.') . "\n" .
                "Stok: " . $product->stok . "\n\n" .
                $product->deskripsi,
            'image'    => $product->gambar ?? null,
            'type'     => 'promosi',   // ✅ FIX
            'category' => 'produk',    // ✅ FIX
        ]);

        return redirect()
            ->route('umkm.products.index')
            ->with('success', 'Produk berhasil ditambahkan & diposting ke forum');
    }

    /**
     * Form edit produk
     */
    public function edit(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);

        return view('dashboard.umkm.products.edit', compact('product'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }

            $data['gambar'] = $request->file('gambar')
                ->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('umkm.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Hapus produk
     */
    public function destroy(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);

        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()
            ->route('umkm.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
