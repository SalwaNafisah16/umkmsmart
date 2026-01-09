<aside class="w-64 bg-white border-r">
    <div class="p-6">
        <h1 class="font-black text-lg mb-6">Forum UMKM Telkom</h1>

        <nav class="space-y-1">

            {{-- DASHBOARD --}}
            <a href="{{ route('umkm.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100">
                <span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>

            {{-- PRODUK --}}
            <a href="{{ route('umkm.products.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100">
                <span class="material-symbols-outlined">inventory_2</span>
                Katalog Produk
            </a>

            {{-- KOMENTAR --}}
            <a href="{{ route('umkm.comments') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100">
                <span class="material-symbols-outlined">chat</span>
                Komentar Masuk
            </a>

            {{-- EDIT PROFIL UMKM --}}
            <a href="{{ route('profil.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100">
                <span class="material-symbols-outlined">person</span>
                Profil UMKM
            </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}" class="pt-4">
                @csrf
                <button class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-red-600 hover:bg-red-50">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>

        </nav>
    </div>
</aside>
