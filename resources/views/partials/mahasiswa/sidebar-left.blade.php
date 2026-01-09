<div class="bg-white rounded-xl shadow-sm border p-4 space-y-1">

    {{-- BERANDA --}}
    <a href="{{ route('dashboard.mahasiswa') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg
              {{ request()->routeIs('dashboard.mahasiswa') ? 'bg-primary/10 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
        <span class="material-symbols-outlined">home</span>
        Beranda
    </a>

    {{-- POSTINGAN SAYA --}}
    <a href="{{ route('mahasiswa.posts') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg
              {{ request()->routeIs('mahasiswa.posts') ? 'bg-primary/10 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
        <span class="material-symbols-outlined">edit_square</span>
        Postingan Saya
    </a>

    {{-- DISIMPAN --}}
    <a href="{{ route('mahasiswa.saved') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg
              {{ request()->routeIs('mahasiswa.saved') ? 'bg-primary/10 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
        <span class="material-symbols-outlined">bookmark</span>
        Disimpan
    </a>

    {{-- KATALOG UMKM --}}
    <a href="{{ route('mahasiswa.produk') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg
              {{ request()->routeIs('mahasiswa.produk') ? 'bg-primary/10 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
        <span class="material-symbols-outlined">storefront</span>
        Katalog UMKM
    </a>

    {{-- ACARA (BELUM ADA USE CASE) --}}
    <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 cursor-not-allowed">
        <span class="material-symbols-outlined">calendar_month</span>
        Acara
    </div>

</div>
