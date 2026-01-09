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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('dashboard.umkm.products.create');
    }

    /**
     * Simpan produk baru + AUTO POST KE FORUM
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
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
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'title'      => $product->nama_produk,
                'content'    =>
                    "📢 *Produk Baru UMKM*\n\n" .
                    $product->nama_produk . "\n" .
                    "Harga: Rp " . number_format($product->harga, 0, ',', '.') . "\n" .
                    "Stok: " . $product->stok . "\n\n" .
                    $product->deskripsi,
                'image'    => $product->gambar ?? null,
                'type'     => 'promosi',
                'category' => 'produk',
            ]);

            return redirect()
                ->route('umkm.products.index')
                ->with('success', 'Produk berhasil ditambahkan & diposting ke forum');
                
        } catch (\Exception $e) {
            \Log::error('ProductController@store error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Form edit produk
     */
    public function edit(Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($product->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses');
        }

        return view('dashboard.umkm.products.edit', compact('product'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($product->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
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
                
        } catch (\Exception $e) {
            \Log::error('ProductController@update error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus produk
     */
    public function destroy(Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($product->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses');
        }

        try {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }

            $product->delete();

            return redirect()
                ->route('umkm.products.index')
                ->with('success', 'Produk berhasil dihapus');
                
        } catch (\Exception $e) {
            \Log::error('ProductController@destroy error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
                ->with('success', 'Produk berhasil dihapus');
                
        } catch (\Exception $e) {
            \Log::error('ProductController@destroy error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
