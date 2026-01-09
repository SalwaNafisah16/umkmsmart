@extends('layouts.mahasiswa')

@section('title', 'Katalog Produk UMKM')

@section('content')

<div class="bg-white rounded-xl p-6 mb-6 border">
    <h1 class="text-xl font-bold">Katalog Produk UMKM</h1>
    <p class="text-sm text-gray-500">
        Temukan produk terbaik dari UMKM mitra Tel-U
    </p>
</div>

{{-- GRID PRODUK --}}
@if($products->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($products as $product)
            @include('partials.mahasiswa.product-card', [
                'product' => $product
            ])
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-8">
        {{ $products->links('pagination::tailwind') }}
    </div>
@else
    <div class="bg-white rounded-xl border p-8 text-center text-gray-500">
        Belum ada produk UMKM tersedia.
    </div>
@endif

@endsection
