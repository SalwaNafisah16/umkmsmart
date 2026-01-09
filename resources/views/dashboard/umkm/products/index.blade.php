@extends('layouts.umkm')

@section('title','Katalog Produk UMKM')

@section('page-title','Katalog Produk Anda')
@section('page-desc','Kelola seluruh produk UMKM')

@section('content')

<a href="{{ route('umkm.products.create') }}"
   class="inline-flex mb-6 items-center gap-2 bg-primary text-white px-5 py-3 rounded-lg font-bold">
    <span class="material-symbols-outlined">add_circle</span>
    Tambah Produk
</a>

<div class="bg-white rounded-xl border overflow-hidden">
<table class="w-full text-sm">

<thead class="bg-gray-50 border-b">
<tr>
    <th class="px-6 py-4 text-left">Produk</th>
    <th class="px-6 py-4 text-left">Harga</th>
    <th class="px-6 py-4 text-left">Stok</th>
    <th class="px-6 py-4 text-left">Status</th>
    <th class="px-6 py-4 text-right">Aksi</th>
</tr>
</thead>

<tbody class="divide-y">
@forelse($products as $product)
<tr>

    {{-- PRODUK + GAMBAR --}}
    <td class="px-6 py-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-lg bg-gray-100 overflow-hidden border">
                @if($product->gambar)
                    <img src="{{ asset('storage/'.$product->gambar) }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                        No Image
                    </div>
                @endif
            </div>

            <div>
                <p class="font-bold">{{ $product->nama_produk }}</p>
            </div>
        </div>
    </td>

    {{-- HARGA --}}
    <td class="px-6 py-4">
        Rp {{ number_format($product->harga,0,',','.') }}
    </td>

    {{-- STOK --}}
    <td class="px-6 py-4">
        {{ $product->stok }}
    </td>

    {{-- STATUS --}}
    <td class="px-6 py-4">
        @if($product->status === 'aktif')
            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                Aktif
            </span>
        @else
            <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                Nonaktif
            </span>
        @endif
    </td>

    {{-- AKSI --}}
    <td class="px-6 py-4 text-right">
        <div class="flex justify-end gap-4">

            {{-- EDIT --}}
            <a href="{{ route('umkm.products.edit',$product->id) }}"
               class="text-primary font-semibold hover:underline">
                Edit
            </a>

            {{-- HAPUS --}}
            <form method="POST"
                  action="{{ route('umkm.products.destroy',$product->id) }}"
                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="text-red-600 font-semibold hover:underline">
                    Hapus
                </button>
            </form>

        </div>
    </td>

</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-10 text-gray-400">
        Belum ada produk
    </td>
</tr>
@endforelse
</tbody>

</table>
</div>

@endsection
