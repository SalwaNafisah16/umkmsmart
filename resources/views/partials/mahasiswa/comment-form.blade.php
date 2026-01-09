<form method="POST"
      action="{{ route('comment.store') }}"
      class="flex items-center gap-2 mt-3">
    @csrf

    <input type="hidden" name="forum_post_id" value="{{ $post->id }}">

    <input type="text"
           name="content"
           placeholder="Tulis komentar..."
           class="flex-1 text-sm rounded-full border-gray-300 px-4 py-2 focus:ring-primary"
           onkeydown="submitOnEnter(event,this)"
           required>

    <button class="text-primary">
        <span class="material-symbols-outlined icon-fill">send</span>
    </button>
</form>
