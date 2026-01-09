@extends('layouts.mahasiswa')

@section('title', 'Postingan Disimpan')

@section('content')

<h2 class="text-lg font-bold mb-4">Postingan Disimpan</h2>

<div class="flex flex-col gap-6">
    @forelse ($posts as $post)
        @include('partials.mahasiswa.post-card', ['post' => $post])
    @empty
        <div class="bg-white rounded-xl border p-6 text-center text-sm text-gray-500">
            Belum ada postingan yang disimpan.
        </div>
    @endforelse
</div>

@endsection
