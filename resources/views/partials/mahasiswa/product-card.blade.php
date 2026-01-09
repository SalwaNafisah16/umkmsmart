<div class="bg-white rounded-xl shadow-sm border overflow-hidden hover:shadow-md transition">

    {{-- IMAGE --}}
    @if($product->gambar)
        <img src="{{ asset('storage/'.$product->gambar) }}"
             class="w-full h-44 object-cover">
    @else
        <div class="w-full h-44 bg-gray-100 flex items-center justify-center text-gray-400">
            Tidak ada gambar
        </div>
    @endif

    {{-- CONTENT --}}
    <div class="p-4 space-y-1">

        <h3 class="font-semibold text-sm line-clamp-1">
            {{ $product->nama_produk }}
        </h3>

        <p class="text-xs text-gray-500">
            UMKM: {{ $product->user->name }}
        </p>

        {{-- ALAMAT UMKM --}}
        <p class="text-xs text-gray-400 flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">location_on</span>
            {{ \Illuminate\Support\Str::limit(
                optional($product->user->umkmProfile)->alamat_usaha ?? 'Alamat belum diisi',
                35
            ) }}
        </p>

        <p class="text-primary font-bold text-sm">
            Rp {{ number_format($product->harga,0,',','.') }}
        </p>

        <p class="text-xs text-gray-600 line-clamp-2">
            {{ $product->deskripsi }}
        </p>
    </div>

    {{-- ACTION --}}
    <div class="p-4 pt-0">
        <a href="{{ route('mahasiswa.produk.show', $product->id) }}"
           class="block text-center bg-primary text-white text-sm py-2 rounded-lg hover:bg-primary/90">
            Lihat Detail
        </a>
    </div>

</div>
