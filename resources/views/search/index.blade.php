@extends('layouts.mahasiswa')

@section('title','Hasil Pencarian')

@section('content')

<div class="bg-white rounded-xl border p-4">
    <h1 class="font-bold text-lg">
        Hasil pencarian: "{{ $q }}"
    </h1>
</div>

{{-- ================= USER ================= --}}
@if($users->count())
<div class="bg-white rounded-xl border p-4">
    <h2 class="font-bold mb-3">Pengguna</h2>
    @foreach($users as $user)
        <p class="text-sm">
            👤 {{ $user->name }} ({{ ucfirst($user->role) }})
        </p>
    @endforeach
</div>
@endif

{{-- ================= PRODUK ================= --}}
@if($products->count())
<div class="bg-white rounded-xl border p-4">
    <h2 class="font-bold mb-3">Produk UMKM</h2>
    <div class="grid grid-cols-2 gap-4">
        @foreach($products as $product)
            @include('partials.mahasiswa.product-card', ['product' => $product])
        @endforeach
    </div>
</div>
@endif

{{-- ================= POST ================= --}}
@if($posts->count())
<div class="bg-white rounded-xl border p-4">
    <h2 class="font-bold mb-3">Postingan Forum</h2>
    @foreach($posts as $post)
        @include('partials.mahasiswa.post-card', ['post' => $post])
    @endforeach
</div>
@endif

{{-- ================= KOMENTAR ================= --}}
@if($comments->count())
<div class="bg-white rounded-xl border p-4">
    <h2 class="font-bold mb-3">Komentar</h2>
    @foreach($comments as $comment)
        <p class="text-sm">
            💬 <b>{{ $comment->user->name }}</b>:
            {{ $comment->content }}
        </p>
    @endforeach
</div>
@endif

@endsection
