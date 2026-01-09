<article class="bg-white rounded-2xl shadow-sm border overflow-hidden">

    {{-- ================= HEADER ================= --}}
    <div class="p-5 flex justify-between items-center">
        <div class="flex gap-3 items-center">
            <div class="w-11 h-11 rounded-full bg-primary text-white
                        flex items-center justify-center font-bold text-lg">
                {{ strtoupper(substr($post->user->name,0,1)) }}
            </div>
            <div>
                <p class="font-semibold text-sm leading-none">
                    {{ $post->user->name }}
                </p>
                <p class="text-xs text-gray-500">
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>

    {{-- ================= CONTENT ================= --}}
    <div class="px-5 text-sm leading-relaxed text-gray-800">
        {{ $post->content }}
    </div>

    {{-- ================= PRODUK TERKAIT (JIKA ADA) ================= --}}
    @if($post->product)
        <div class="mx-5 mt-4 border rounded-xl bg-gray-50 overflow-hidden">

            <div class="flex gap-4 p-4">

                {{-- GAMBAR PRODUK --}}
                @if($post->product->gambar)
                    <img src="{{ asset('storage/'.$post->product->gambar) }}"
                         class="w-24 h-24 rounded-lg object-cover border">
                @else
                    <div class="w-24 h-24 bg-gray-200
                                rounded-lg flex items-center justify-center text-xs text-gray-500">
                        No Image
                    </div>
                @endif

                {{-- INFO PRODUK --}}
                <div class="flex-1 space-y-1">

                    <span class="inline-block text-[11px] px-2 py-0.5 rounded-full
                                 bg-primary/10 text-primary font-semibold">
                        Produk Terkait
                    </span>

                    <h4 class="font-semibold text-sm line-clamp-1">
                        {{ $post->product->nama_produk }}
                    </h4>

                    <p class="text-xs text-gray-500 line-clamp-2">
                        {{ $post->product->deskripsi }}
                    </p>

                    <div class="flex justify-between items-center pt-1">
                        <span class="text-primary font-bold text-sm">
                            Rp {{ number_format($post->product->harga,0,',','.') }}
                        </span>

                        <a href="{{ route('mahasiswa.produk.show',$post->product->id) }}"
                           class="text-xs font-semibold text-primary hover:underline">
                            Lihat Produk →
                        </a>
                    </div>

                </div>
            </div>

        </div>
    @endif

    {{-- ================= IMAGE POST ================= --}}
    @if($post->image)
        <img src="{{ asset('storage/'.$post->image) }}"
             class="w-full max-h-[420px] object-cover mt-4">
    @endif

    {{-- ================= ACTION ================= --}}
    <div class="flex justify-between items-center px-5 py-3 border-t text-sm text-gray-600">

        <div class="flex gap-6 items-center">

            {{-- LIKE --}}
            <form method="POST" action="{{ route('post.like',$post->id) }}">
                @csrf
                <button class="flex items-center gap-1 hover:text-primary transition">
                    <span class="material-symbols-outlined text-base
                        {{ $post->likes->where('user_id',auth()->id())->count() ? 'icon-fill text-primary' : '' }}">
                        thumb_up
                    </span>
                    {{ $post->likes->count() }}
                </button>
            </form>

            {{-- COMMENT --}}
            <button onclick="scrollToComment({{ $post->id }})"
                    class="flex items-center gap-1 hover:text-primary transition">
                <span class="material-symbols-outlined text-base">
                    mode_comment
                </span>
                {{ $post->comments->count() }}
            </button>

        </div>

        {{-- SAVE --}}
        <form method="POST" action="{{ route('post.save',$post->id) }}">
            @csrf
            <button class="hover:text-primary transition">
                <span class="material-symbols-outlined
                    {{ $post->saves->where('user_id',auth()->id())->count() ? 'icon-fill text-primary' : '' }}">
                    bookmark
                </span>
            </button>
        </form>
    </div>

    {{-- ================= COMMENT SECTION ================= --}}
    <div id="comment-section-{{ $post->id }}"
         class="px-5 py-4 space-y-3 bg-gray-50">

        @foreach ($post->comments->whereNull('parent_id') as $comment)

            {{-- KOMENTAR UTAMA --}}
            <div class="flex gap-3 items-start">
                <div class="w-8 h-8 rounded-full bg-gray-200
                            flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr($comment->user->name,0,1)) }}
                </div>

                <div class="bg-white border rounded-xl px-4 py-2 text-sm w-full">
                    <span class="font-semibold">
                        {{ $comment->user->name }}
                    </span>
                    <p class="leading-snug mt-0.5">
                        {{ $comment->content }}
                    </p>
                </div>
            </div>

            {{-- BALASAN UMKM --}}
            @foreach ($comment->replies as $reply)
                <div class="flex gap-3 ml-10 items-start">
                    <div class="w-7 h-7 rounded-full bg-primary text-white
                                flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr($reply->user->name,0,1)) }}
                    </div>

                    <div class="bg-primary/5 border border-primary/20
                                rounded-xl px-4 py-2 text-sm w-full">
                        <span class="font-semibold text-primary">
                            {{ $reply->user->name }}
                        </span>
                        <span class="ml-1 text-[10px] px-2 py-0.5
                                     bg-primary/10 text-primary rounded-full">
                            UMKM
                        </span>
                        <p class="leading-snug mt-1 text-gray-800">
                            {{ $reply->content }}
                        </p>
                    </div>
                </div>
            @endforeach

        @endforeach

        {{-- FORM KOMENTAR --}}
        <form method="POST"
              action="{{ route('comment.store') }}"
              id="comment-form-{{ $post->id }}"
              class="flex gap-3 items-center mt-3">
            @csrf
            <input type="hidden" name="forum_post_id" value="{{ $post->id }}">

            <input type="text"
                   name="content"
                   placeholder="Tulis komentar..."
                   class="flex-1 text-sm rounded-full border-gray-300
                          px-4 py-2 focus:ring-primary"
                   onkeydown="submitOnEnter(event, {{ $post->id }})"
                   required>

            <button type="submit"
                    class="text-primary hover:scale-110 transition">
                <span class="material-symbols-outlined">send</span>
            </button>
        </form>

    </div>

</article>
