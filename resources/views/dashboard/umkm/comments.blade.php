@extends('layouts.umkm')

@section('title','Komentar Masuk')

@section('page-title','Komentar Masuk')
@section('page-desc','Komentar dari mahasiswa pada postingan Anda')

@section('content')

<div class="space-y-5">

@forelse($comments as $comment)
    <div class="bg-white border rounded-xl p-5 space-y-4">

        {{-- KOMENTAR MAHASISWA --}}
        <div>
            <p class="font-bold text-sm">{{ $comment->user->name }}</p>
            <p class="text-xs text-gray-500">
                {{ $comment->created_at->diffForHumans() }}
            </p>

            <p class="text-sm mt-2">
                {{ $comment->content }}
            </p>

            <div class="text-xs text-gray-500 mt-2">
                Pada postingan:
                <span class="font-semibold">
                    {{ Str::limit($comment->forumPost->content, 60) }}
                </span>
            </div>
        </div>

        {{-- BALASAN UMKM (JIKA ADA) --}}
        @if($comment->replies->count())
            <div class="space-y-2 border-l-2 border-primary pl-4 ml-4">
                @foreach($comment->replies as $reply)
                    <div class="bg-primary/5 border border-primary/20 rounded-lg p-3">
                        <p class="text-sm font-semibold text-primary">
                            Anda (UMKM)
                        </p>
                        <p class="text-sm mt-1">
                            {{ $reply->content }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $reply->created_at->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- FORM BALAS --}}
        <form method="POST"
              action="{{ route('comment.store') }}"
              class="flex gap-2 pt-2">
            @csrf
            <input type="hidden" name="forum_post_id" value="{{ $comment->forum_post_id }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">

            <input type="text"
                   name="content"
                   placeholder="Tulis balasan..."
                   class="flex-1 text-sm rounded-lg border-gray-300 px-3 py-2"
                   required>

            <button class="bg-primary text-white px-4 rounded-lg text-sm">
                Kirim
            </button>
        </form>

    </div>
@empty
    <div class="text-center text-gray-500 italic py-10">
        Belum ada komentar masuk.
    </div>
@endforelse

</div>

@endsection
