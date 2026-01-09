{{-- ================= UMKM TRENDING ================= --}}
<div class="bg-white rounded-xl shadow-sm border p-5 space-y-4">

    <div class="flex items-center justify-between">
        <h3 class="font-semibold text-sm">UMKM Trending</h3>
        <a href="{{ route('mahasiswa.produk') }}"
           class="text-primary text-xs font-medium hover:underline">
            Lihat Semua
        </a>
    </div>

    {{-- ITEM UMKM --}}
    <div class="space-y-3">

        {{-- UMKM ITEM --}}
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center font-bold text-primary">
                U
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate">UMKM Contoh</p>
                <p class="text-xs text-gray-500 truncate">Kuliner • 120 postingan</p>
            </div>
            <button class="text-xs font-semibold text-primary hover:underline">
                Ikuti
            </button>
        </div>

        {{-- UMKM ITEM --}}
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center font-bold text-primary">
                K
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate">Kopi Tel-U</p>
                <p class="text-xs text-gray-500 truncate">Minuman • 98 postingan</p>
            </div>
            <button class="text-xs font-semibold text-primary hover:underline">
                Ikuti
            </button>
        </div>

        {{-- EMPTY STATE --}}
        {{-- Kalau nanti mau dinamis, ini tinggal diganti loop --}}
    </div>
</div>

{{-- ================= ACARA TERDEKAT ================= --}}
<div class="bg-white rounded-xl shadow-sm border p-5 space-y-4">

    <h3 class="font-semibold text-sm">Acara Mendatang</h3>

    <div class="space-y-3 text-sm">

        <div class="flex gap-3">
            <div class="flex flex-col items-center bg-gray-100 rounded-lg px-2 py-1">
                <span class="text-xs font-bold text-primary">NOV</span>
                <span class="text-sm font-bold">20</span>
            </div>
            <div>
                <p class="font-semibold">Bazaar UMKM Tel-U</p>
                <p class="text-xs text-gray-500">Gedung TULT • 09.00</p>
            </div>
        </div>

        <div class="flex gap-3">
            <div class="flex flex-col items-center bg-gray-100 rounded-lg px-2 py-1">
                <span class="text-xs font-bold text-primary">DES</span>
                <span class="text-sm font-bold">05</span>
            </div>
            <div>
                <p class="font-semibold">Seminar Kewirausahaan</p>
                <p class="text-xs text-gray-500">Auditorium • 13.00</p>
            </div>
        </div>

    </div>

    <a href="/forum/event"
       class="block text-center text-xs font-medium text-gray-500 hover:text-primary">
        Lihat semua acara →
    </a>

</div>
