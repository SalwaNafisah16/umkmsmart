@extends('layouts.mahasiswa')

@section('title', 'Postingan Saya | Forum UMKM Tel-U')

@section('content')

<div class="bg-white rounded-xl shadow-sm border p-6 mb-4">
    <h2 class="text-lg font-bold">Postingan Saya</h2>
    <p class="text-sm text-gray-500">
        Semua postingan yang pernah kamu buat
    </p>
</div>

<div class="flex flex-col gap-6">

    @forelse ($posts as $post)

        @include('partials.mahasiswa.post-card', [
            'post' => $post,
            'showDelete' => true
        ])

    @empty
        <div class="bg-white rounded-xl shadow-sm border p-10 text-center">
            <p class="text-gray-500 text-sm italic">
                Kamu belum pernah membuat postingan.
            </p>
        </div>
    @endforelse

</div>

@endsection
