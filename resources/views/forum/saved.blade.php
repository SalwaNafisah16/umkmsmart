@extends('layouts.mahasiswa')

@section('title', 'Postingan Disimpan')

@section('content')

<h2 class="text-lg font-bold mb-4">Postingan Disimpan</h2>

<div class="flex flex-col gap-6">

@forelse ($savedPosts as $item)
    @include('partials.mahasiswa.post-card', [
        'post' => $item->forumPost
    ])
@empty
    <div class="bg-white rounded-xl shadow-sm border p-8 text-center">
        <p class="text-gray-500 text-sm italic">
            Belum ada postingan yang disimpan.
        </p>
    </div>
@endforelse

</div>

@endsection
