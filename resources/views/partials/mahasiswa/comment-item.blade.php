<div class="ml-{{ $level ?? 0 }} mt-3">

    <div class="text-sm">
        <span class="font-semibold">{{ $comment->user->name }}</span>
        {{ $comment->content }}
    </div>

    {{-- REPLY BUTTON --}}
    <button onclick="toggleReply({{ $comment->id }})"
            class="text-xs text-primary mt-1">
        Balas
    </button>

    {{-- FORM BALAS --}}
    <form method="POST"
          action="{{ route('comment.store') }}"
          id="reply-{{ $comment->id }}"
          class="hidden mt-2">
        @csrf
        <input type="hidden" name="forum_post_id" value="{{ $post->id }}">
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">

        <input type="text"
               name="content"
               class="w-full text-sm rounded-full border-gray-300 px-3 py-1"
               placeholder="Balas komentar..."
               onkeydown="submitOnEnter(event,this)"
               required>
    </form>

    {{-- RECURSIVE REPLIES --}}
    @foreach ($comment->replies as $reply)
        @include('partials.mahasiswa.comment-item', [
            'comment' => $reply,
            'post' => $post,
            'level' => ($level ?? 0) + 4
        ])
    @endforeach
</div>
