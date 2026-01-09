<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Komentar Masuk</title>

<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

<script>
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        primary: "#DC2626",
        secondary: "#991B1B",
        "background-light": "#F3F4F6",
        "background-dark": "#111827",
        "surface-light": "#FFFFFF",
        "surface-dark": "#1F2937",
        "text-light": "#1F2937",
        "text-dark": "#F9FAFB",
        "text-muted-light": "#6B7280",
        "text-muted-dark": "#9CA3AF",
        "border-light": "#E5E7EB",
        "border-dark": "#374151",
      },
      fontFamily: {
        sans: ["Inter", "sans-serif"],
      },
    },
  },
};
</script>
</head>

<body class="bg-background-light dark:bg-background-dark font-sans min-h-screen pb-12">

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

<!-- HEADER -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
  <div>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
      Komentar Masuk
    </h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
      Kelola interaksi dan pertanyaan dari pengguna UMKM.
    </p>
  </div>

  <a href="{{ route('dashboard.umkm') }}"
     class="group inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-300
            hover:text-primary dark:hover:text-primary transition-colors
            bg-white dark:bg-gray-800 px-4 py-2 rounded-lg shadow-sm
            border border-gray-200 dark:border-gray-700 hover:border-primary">
    <span class="material-symbols-outlined text-xl mr-2 group-hover:-translate-x-1 transition-transform">
      arrow_back
    </span>
    Kembali ke Dashboard
  </a>
</div>

<!-- LIST KOMENTAR -->
<div class="space-y-8">

@forelse ($comments as $comment)
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border-t-4 border-t-primary overflow-hidden">

  <!-- POST INFO -->
  <div class="bg-red-50 dark:bg-red-900/10 px-6 py-3 border-b border-red-100 dark:border-red-900/20 flex items-center gap-2">
    <span class="material-symbols-outlined text-primary text-[20px]">storefront</span>
    <span class="text-sm text-gray-700 dark:text-gray-300">
      Postingan:
      <span class="font-bold text-gray-900 dark:text-white">
        {{ \Illuminate\Support\Str::limit($comment->forumPost->content, 50) }}
      </span>
    </span>
  </div>

  <div class="p-6">

    <!-- KOMENTAR MAHASISWA -->
    <div class="flex items-start gap-4">
      <div class="flex-shrink-0">
        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600
                    flex items-center justify-center text-white shadow-sm">
          <span class="font-bold text-lg">
            {{ strtoupper(substr($comment->user->name,0,1)) }}
          </span>
        </div>
      </div>

      <div class="flex-1 min-w-0">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
          {{ $comment->user->name }}
        </h3>

        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mt-1">
          <span class="material-symbols-outlined text-[16px]">schedule</span>
          <span>{{ $comment->created_at->diffForHumans() }}</span>
        </div>

        <p class="mt-3 text-gray-800 dark:text-gray-200">
          {{ $comment->content }}
        </p>
      </div>
    </div>

    <!-- BALASAN UMKM -->
    @foreach ($comment->replies as $reply)
    <div class="mt-6 pl-16">
      <div class="relative pl-4 border-l-2 border-gray-200 dark:border-gray-700">
        <div class="flex items-start gap-3">
          <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center
                      text-white text-xs font-bold">
            UM
          </div>
          <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg rounded-tl-none
                      p-3.5 border border-gray-100 dark:border-gray-700 flex-1">
            <span class="font-bold text-sm text-gray-900 dark:text-white">
  {{ $reply->user->umkmProfile->nama_usaha ?? $reply->user->name }}
</span>

            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
              {{ $reply->content }}
            </p>
          </div>
        </div>
      </div>
    </div>
    @endforeach

    <!-- FORM BALAS -->
    <div class="mt-6 pl-16">
      <form method="POST" action="{{ route('comment.store') }}">
        @csrf
        <input type="hidden" name="forum_post_id" value="{{ $comment->forum_post_id }}">
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">

        <textarea name="content"
                  rows="2"
                  class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                         bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                         focus:border-primary focus:ring-primary sm:text-sm"
                  placeholder="Tulis balasan Anda..."
                  required></textarea>

        <div class="flex justify-end mt-2">
          <button class="inline-flex items-center px-4 py-2 text-sm font-medium
                         rounded-md text-white bg-primary hover:bg-red-700">
            <span class="material-symbols-outlined text-lg mr-1.5">send</span>
            Kirim
          </button>
        </div>
      </form>
    </div>

  </div>
</div>
@empty
<p class="text-gray-500 italic">
  Belum ada komentar masuk.
</p>
@endforelse

</div>
</div>

</body>
</html>
