@extends('layouts.umkm')

@section('title','Dashboard UMKM')

@section('page-title','Dashboard UMKM')
@section('page-desc','Kelola postingan promosi, produk, dan interaksi mahasiswa')

@section('content')

{{-- ===================== STATISTIK ===================== --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <div class="bg-white rounded-xl p-6 border">
        <p class="text-sm text-gray-500">Total Postingan</p>
        <h3 class="text-3xl font-black mt-1">{{ $posts->count() }}</h3>
    </div>

    <div class="bg-white rounded-xl p-6 border">
        <p class="text-sm text-gray-500">Total Produk</p>
        <h3 class="text-3xl font-black mt-1">{{ $products->count() }}</h3>
    </div>

    <div class="bg-white rounded-xl p-6 border">
        <p class="text-sm text-gray-500">Komentar Masuk</p>
        <h3 class="text-3xl font-black mt-1">
            {{ \App\Models\Comment::whereHas('forumPost', fn ($q) =>
                $q->where('user_id', auth()->id())
            )->count() }}
        </h3>
    </div>

</div>

{{-- ===================== GRID UTAMA ===================== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ===================== KIRI (POSTINGAN) ===================== --}}
    <div class="lg:col-span-2 space-y-8">

        {{-- ================= FORM POSTING ================= --}}
        <div class="bg-white border rounded-xl p-6">
            <h3 class="font-bold text-lg mb-4">Buat Postingan Promosi</h3>

            <form method="POST"
                  action="{{ route('forum.post.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-4">
                @csrf

                {{-- PILIH PRODUK (OPSIONAL) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Produk Terkait (Opsional)
                    </label>
                    <select name="product_id"
                            class="w-full rounded-lg border-gray-300">
                        <option value="">— Tanpa Produk —</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- KONTEN --}}
                <div>
                    <textarea name="content"
                              rows="3"
                              class="w-full rounded-lg border-gray-300"
                              placeholder="Tulis postingan promosi UMKM..."
                              required></textarea>
                </div>

                {{-- GAMBAR --}}
                <div>
                    <input type="file" name="image">
                </div>

                <div class="pt-2">
                    <button class="bg-primary text-white px-6 py-2 rounded-lg font-semibold">
                        Posting
                    </button>
                </div>
            </form>
        </div>

        {{-- ================= LIST POSTING ================= --}}
        <div class="space-y-6">

            @forelse ($posts as $post)
                @include('partials.mahasiswa.post-card', [
                    'post' => $post,
                    'showDelete' => true
                ])
            @empty
                <div class="bg-white border rounded-xl p-10 text-center">
                    <p class="text-gray-500 italic">
                        Belum ada postingan promosi UMKM.
                    </p>
                </div>
            @endforelse

        </div>

    </div>

    {{-- ===================== KANAN (PROFIL UMKM) ===================== --}}
    <aside class="space-y-6">

        <div class="bg-white border rounded-xl p-6">
            <h3 class="font-bold text-lg mb-4">Profil UMKM</h3>

            <div class="space-y-4 text-sm">

                <div>
                    <p class="text-gray-500">Nama Usaha</p>
                    <p class="font-semibold">
                        {{ auth()->user()->umkmProfile->nama_usaha
                            ?? auth()->user()->name }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Email</p>
                    <p>{{ auth()->user()->email }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Status</p>
                    <span class="inline-block px-3 py-1 text-xs
                        bg-green-100 text-green-700 rounded-full">
                        UMKM Aktif
                    </span>
                </div>

                <div class="pt-2">
                    <a href="{{ route('profil.index') }}"
                       class="inline-block text-primary font-semibold hover:underline">
                        Edit Profil UMKM
                    </a>
                </div>

            </div>
        </div>

    </aside>

</div>

@endsection
