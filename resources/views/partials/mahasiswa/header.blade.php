<header class="sticky top-0 z-50 bg-primary text-white border-b border-[#b71c1c] shadow-sm">
    <div class="max-w-[1440px] mx-auto flex items-center justify-between px-6 py-3 gap-6">

        {{-- LEFT : BRAND --}}
        <div class="flex items-center gap-3 shrink-0">
            <div class="w-9 h-9 bg-white text-primary rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined" style="font-size:20px">school</span>
            </div>
            <h1 class="font-bold text-lg tracking-tight">
                Forum UMKM Tel-U
            </h1>
        </div>

        {{-- CENTER : SEARCH --}}
        <div class="hidden md:flex flex-1 justify-center">
            <form action="{{ url('/search') }}" method="GET"
                  class="w-full max-w-md relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    search
                </span>
                <input type="text"
                       name="q"
                       placeholder="Cari UMKM, diskusi, atau acara..."
                       class="w-full rounded-lg pl-10 pr-4 py-2 text-sm
                              text-gray-800 bg-white
                              focus:ring-2 focus:ring-white/30 focus:outline-none">
            </form>
        </div>

        {{-- RIGHT : ACTION --}}
        <div class="flex items-center gap-3 shrink-0">

            <button class="p-2 rounded-lg hover:bg-white/10 transition">
                <span class="material-symbols-outlined">notifications</span>
            </button>

            <button class="p-2 rounded-lg hover:bg-white/10 transition">
                <span class="material-symbols-outlined">chat_bubble</span>
            </button>

            {{-- AVATAR --}}
            <a href="{{ route('mahasiswa.profile') }}"
                    class="w-9 h-9 rounded-full bg-white/20
                            flex items-center justify-center
                            font-semibold cursor-pointer
                            hover:bg-white/30 transition"
                    title="Profil Saya">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="p-2 rounded-lg hover:bg-white/10 transition">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>

        </div>

    </div>
</header>
