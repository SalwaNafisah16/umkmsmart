@extends('layouts.umkm')

@section('title','Edit Produk')

@section('page-title','Edit Produk')
@section('page-desc','Perbarui informasi produk UMKM')

@section('content')

<a href="{{ route('umkm.products.index') }}"
   class="inline-flex mb-6 items-center gap-2 text-sm text-gray-600 hover:text-primary">
    ← Kembali ke Katalog
</a>

<form method="POST"
      action="{{ route('umkm.products.update', $product->id) }}"
      enctype="multipart/form-data"
      class="bg-white border rounded-xl p-6 max-w-xl">

    @csrf
    @method('PUT')

    {{-- NAMA --}}
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nama Produk</label>
        <input type="text"
               name="nama_produk"
               value="{{ old('nama_produk',$product->nama_produk) }}"
               class="w-full rounded-lg border-gray-300"
               required>
    </div>

    {{-- HARGA --}}
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Harga</label>
        <input type="number"
               name="harga"
               value="{{ old('harga',$product->harga) }}"
               class="w-full rounded-lg border-gray-300"
               required>
    </div>

    {{-- STOK --}}
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Stok</label>
        <input type="number"
               name="stok"
               value="{{ old('stok',$product->stok) }}"
               class="w-full rounded-lg border-gray-300"
               required>
    </div>

    {{-- GAMBAR --}}
    <div class="mb-4">
        <label class="block text-sm font-medium mb-2">Gambar Produk</label>

        @if($product->gambar)
            <img src="{{ asset('storage/'.$product->gambar) }}"
                 class="w-32 h-32 object-cover rounded-lg mb-2 border">
        @endif

        <input type="file" name="gambar">
    </div>

    {{-- DESKRIPSI --}}
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="deskripsi"
                  rows="3"
                  class="w-full rounded-lg border-gray-300">{{ old('deskripsi',$product->deskripsi) }}</textarea>
    </div>

    {{-- STATUS --}}
    <div class="mb-6">
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status" class="w-full rounded-lg border-gray-300">
            <option value="aktif" {{ $product->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ $product->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    <button class="bg-primary text-white px-6 py-2 rounded-lg font-semibold">
        Simpan Perubahan
    </button>
</form>

@endsection
