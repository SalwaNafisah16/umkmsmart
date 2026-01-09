@extends('layouts.mahasiswa')

@section('title', $product->nama_produk.' | Detail Produk')

@section('content')

<div class="bg-white rounded-xl border shadow-sm overflow-hidden">

    {{-- ================= IMAGE ================= --}}
    <div class="w-full h-[320px] bg-gray-100">
        @if($product->gambar)
            <img src="{{ asset('storage/'.$product->gambar) }}"
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                Tidak ada gambar
            </div>
        @endif
    </div>

    {{-- ================= CONTENT ================= --}}
    <div class="p-6 space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $product->nama_produk }}
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                UMKM:
                <span class="font-semibold">
                    {{ $product->user->name ?? '-' }}
                </span>
            </p>

            {{-- ALAMAT UMKM --}}
            <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                <span class="material-symbols-outlined text-[18px]">
                    location_on
                </span>
                {{ $product->user->umkmProfile->alamat_usaha ?? 'Alamat belum diisi' }}
            </p>
        </div>

        {{-- PRICE & STATUS --}}
        <div class="flex flex-wrap gap-6 items-center">

            <p class="text-3xl font-extrabold text-primary">
                Rp {{ number_format($product->harga,0,',','.') }}
            </p>

            <span class="px-3 py-1 text-xs rounded-full
                {{ $product->status === 'aktif'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-100 text-gray-600' }}">
                {{ ucfirst($product->status) }}
            </span>

            <p class="text-sm text-gray-600">
                Stok: <b>{{ $product->stok }}</b>
            </p>

        </div>

        {{-- DESKRIPSI --}}
        <div>
            <h3 class="font-semibold mb-2">Deskripsi Produk</h3>
            <p class="text-sm text-gray-700 leading-relaxed">
                {{ $product->deskripsi ?? 'Tidak ada deskripsi.' }}
            </p>
        </div>

        {{-- INFO UMKM (BIAR MAKIN KELAS) --}}
        <div class="bg-gray-50 rounded-lg p-4 text-sm space-y-2">
            <h4 class="font-semibold text-gray-800">Informasi UMKM</h4>

            <p>
                <span class="text-gray-500">Nama Usaha:</span>
                {{ $product->user->umkmProfile->nama_usaha ?? '-' }}
            </p>

            <p>
                <span class="text-gray-500">Jenis Usaha:</span>
                {{ $product->user->umkmProfile->jenis_usaha ?? '-' }}
            </p>

            <p>
                <span class="text-gray-500">No. HP:</span>
                {{ $product->user->umkmProfile->no_hp_usaha ?? '-' }}
            </p>
        </div>

        {{-- ACTION --}}
        <div class="flex gap-4 pt-4 border-t">
            <a href="{{ route('mahasiswa.produk') }}"
               class="px-5 py-2 rounded-lg border text-sm font-semibold hover:bg-gray-50">
                ← Kembali
            </a>
        </div>

    </div>
</div>

@endsection
