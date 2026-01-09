<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Forum UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto p-6 space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="bg-white p-6 rounded-xl shadow space-y-4">

        <h1 class="text-2xl font-bold text-gray-800">
            Forum UMKM
        </h1>

        {{-- FILTER --}}
        <div class="flex gap-4 text-sm font-semibold">
            <a href="/forum" class="text-gray-600 hover:text-red-600">Semua</a>
            <a href="/forum/event" class="text-gray-600 hover:text-red-600">Event</a>
            <a href="/forum/promosi" class="text-gray-600 hover:text-red-600">Promosi</a>
            <a href="/forum/diskusi" class="text-gray-600 hover:text-red-600">Diskusi</a>
        </div>

        {{-- SEARCH --}}
        <form action="/search" method="GET" class="flex gap-2">
            <input type="text"
                   name="q"
                   placeholder="Cari UMKM / postingan..."
                   class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-red-200">
            <button class="bg-red-600 text-white px-4 rounded-lg">
                Cari
            </button>
        </form>

    </div>

    {{-- ================= LIST POSTINGAN ================= --}}
    @forelse ($posts as $post)

        <div class="bg-white p-6 rounded-xl shadow space-y-4">

            {{-- USER --}}
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-800">
                        {{ $post->user->name }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $post->created_at->diffForHumans() }}
                    </p>
                </div>

                <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-600">
                    {{ strtoupper($post->type) }}
                </span>
            </div>

            {{-- KONTEN --}}
            <div>
                @if ($post->title)
                    <h3 class="font-bold text-lg mb-1">
                        {{ $post->title }}
                    </h3>
                @endif

                <p class="text-gray-700">
                    {{ $post->content }}
                </p>
            </div>

            {{-- GAMBAR --}}
            @if ($post->image)
                <img src="{{ asset('storage/'.$post->image) }}"
                     class="rounded-lg max-h-80 object-cover">
            @endif

            {{-- ================= AKSI ================= --}}
            <div class="flex gap-6 items-center text-sm">

                {{-- LIKE --}}
                <form action="/post/{{ $post->id }}/like" method="POST">
                    @csrf
                    <button type="submit" class="hover:text-red-600">
                        ❤️ {{ $post->likes->count() }}
                    </button>
                </form>

                {{-- SAVE --}}
                <form action="/post/{{ $post->id }}/save" method="POST">
                    @csrf
                    <button type="submit" class="hover:text-red-600">
                        🔖 Simpan
                    </button>
                </form>

                {{-- REPOST --}}
                <form action="/post/{{ $post->id }}/repost" method="POST">
                    @csrf
                    <button type="submit" class="hover:text-red-600">
                        🔁 Repost
                    </button>
                </form>

                {{-- DETAIL --}}
                <a href="{{ route('forum.show', $post->id) }}"
                   class="ml-auto text-red-600 font-semibold">
                    Lihat Detail →
                </a>

            </div>

        </div>

    @empty
        <div class="text-center text-gray-500">
            Belum ada postingan.
        </div>
    @endforelse

</div>

</body>
</html>
