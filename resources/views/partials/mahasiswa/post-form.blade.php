{{-- PAGE TITLE CARD --}}
<div class="bg-white rounded-xl border shadow-sm p-4 flex flex-col gap-1">

    <h1 class="text-base font-bold text-gray-900">
        Forum Pertukaran Informasi
    </h1>

    <p class="text-sm text-gray-500">
        Diskusi, tanya jawab, dan interaksi antara mahasiswa dan UMKM
    </p>

</div>


<form method="POST" action="{{ route('forum.post.store') }}"
      class="bg-white rounded-xl shadow-sm border overflow-hidden">
    @csrf

    <div class="p-4 flex gap-4">
        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
            {{ strtoupper(auth()->user()->name[0]) }}
        </div>

        <textarea name="content" rows="2"
            class="w-full bg-gray-100 rounded-lg border-0 p-3 text-sm resize-none"
            placeholder="Mulai diskusi atau promosikan UMKM Anda..."
            required></textarea>
    </div>

    <div class="px-4 pb-3 flex justify-between items-center">
        <div class="flex gap-2 text-primary">
            <span class="material-symbols-outlined">image</span>
            <span class="material-symbols-outlined">link</span>
            <span class="material-symbols-outlined">tag</span>
        </div>

        <button class="bg-primary hover:bg-red-700 text-white text-sm px-5 py-2 rounded-lg">
            Posting
        </button>
    </div>
</form>
