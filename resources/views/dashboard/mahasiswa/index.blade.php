@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa | Forum UMKM Tel-U')



@section('content')

@include('partials.mahasiswa.post-form')

<div class="flex gap-8 border-b border-gray-200 px-2 mt-2">
    <a href="{{ route('dashboard.mahasiswa') }}"
       class="pb-3 pt-2 border-b-[3px] border-primary text-sm font-bold text-gray-900">
        Terbaru
    </a>
    ...
</div>

<div class="flex flex-col gap-6 mt-4">
    @forelse ($posts as $post)
        @include('partials.mahasiswa.post-card', ['post' => $post])
    @empty
        ...
    @endforelse
</div>

@endsection
