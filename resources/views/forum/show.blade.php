@extends('layouts.mahasiswa')

@section('title', 'Detail Postingan')

@section('content')

    {{-- BACK --}}
    <a href="{{ url()->previous() }}"
       class="text-sm text-primary font-semibold mb-3 inline-block">
        ← Kembali
    </a>

    {{-- POST --}}
    <article class="bg-white rounded-xl shadow-sm border overflow-hidden">

        {{-- HEADER --}}
        <div class="p-4 flex justify-between">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                    {{ strtoupper(substr($post->user->name,0,1)) }}
                </div>
                <div>
                    <p class="font-bold text-sm">{{ $post->user->name }}</p>
                    <p class="text-xs text-gray-500">
                        {{ $post->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="px-4 text-sm leading-relaxed">
            {{ $post->content }}
        </div>

        {{-- IMAGE --}}
        @if($post->image)
            <img src="{{ asset('storage/'.$post->image) }}"
                 class="w-full max-h-96 object-cover mt-3">
        @endif

        {{-- ACTION --}}
        <div class="flex justify-between items-center px-4 py-3 border-t text-sm text-gray-600">

            <div class="flex gap-6">

                {{-- LIKE --}}
                <form method="POST" action="/post/{{ $post->id }}/like">
                    @csrf
                    <button class="flex items-center gap-1 hover:text-primary">
                        <span class="material-symbols-outlined
                            {{ $post->likes->where('user_id',auth()->id())->count() ? 'icon-fill text-primary' : '' }}">
                            thumb_up
                        </span>
                        {{ $post->likes->count() }}
                    </button>
                </form>

                {{-- COMMENT COUNT --}}
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined">mode_comment</span>
                    {{ $post->comments->count() }}
                </span>
            </div>

            {{-- SAVE --}}
            <form method="POST" action="/post/{{ $post->id }}/save">
                @csrf
                <button class="hover:text-primary">
                    <span class="material-symbols-outlined
                        {{ $post->saves->where('user_id',auth()->id())->count() ? 'icon-fill text-primary' : '' }}">
                        bookmark
                    </span>
                </button>
            </form>
        </div>
    </article>

    {{-- KOMENTAR --}}
    <div class="bg-white rounded-xl shadow-sm border p-4 mt-6">
        <h3 class="font-bold text-sm mb-3">
            Komentar ({{ $post->comments->count() }})
        </h3>

        @foreach ($post->comments as $comment)
            @include('partials.mahasiswa.comment-item', [
                'comment' => $comment,
                'post' => $post
            ])
        @endforeach

        @include('partials.mahasiswa.comment-form', ['post' => $post])
    </div>

@endsection
