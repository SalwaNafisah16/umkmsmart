    <!DOCTYPE html>
    <html lang="id" class="light">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Forum UMKM</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#ec1313',
                    bgLight: '#f8f6f6'
                },
                fontFamily: {
                    inter: ['Inter', 'sans-serif']
                }
            }
        }
    }
    </script>
    </head>

    <body class="bg-bgLight font-inter text-gray-800 min-h-screen flex flex-col">

    <!-- ================= HEADER ================= -->
    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-3xl">
                    storefront
                </span>
                <span class="font-bold text-lg">Forum UMKM Telkom University</span>
            </div>

            <nav class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('umkm.dashboard') }}" class="hover:text-primary">
                    Beranda
                </a>
                <a href="{{ route('umkm.products.index') }}" class="hover:text-primary">
                    Kelola Produk
                </a>
                <span class="text-gray-400">|</span>
                <span class="text-gray-700">{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </nav>

        </div>
    </header>

    <!-- ================= MAIN ================= -->
    <main class="flex-grow flex justify-center py-10 px-4">
    <div class="w-full max-w-4xl">

        <!-- Breadcrumb -->
        <div class="text-sm text-gray-500 mb-4 flex items-center gap-2">
            <a href="{{ route('umkm.dashboard') }}" class="hover:text-primary">Beranda</a>
            <span>&gt;</span>
            <a href="{{ route('umkm.products.index') }}" class="hover:text-primary">Kelola Produk</a>
            <span>&gt;</span>
            <span class="font-semibold text-gray-800">Tambah Produk</span>
        </div>

        <h1 class="text-3xl font-black mb-2">Formulir Tambah Produk Baru</h1>
        <p class="text-gray-500 mb-6">
            Lengkapi detail di bawah ini untuk menambahkan produk baru.
        </p>

        <!-- ================= FORM ================= -->
        <form action="{{ route('umkm.products.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white rounded-xl shadow-sm border overflow-hidden">
            @csrf

            <!-- Informasi Dasar -->
            <div class="p-6 border-b">
                <h3 class="flex items-center gap-2 font-bold text-lg mb-6">
                    <span class="material-symbols-outlined text-primary">info</span>
                    Informasi Dasar
                </h3>

                <div class="grid gap-5">
                    <div>
                        <label class="block text-sm font-bold mb-2">Nama Produk</label>
                        <input type="text"
                            name="nama_produk"
                            value="{{ old('nama_produk') }}"
                            class="w-full rounded-lg border px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary">
                        @error('nama_produk')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="4"
                            class="w-full rounded-lg border px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary resize-none">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Detail Penjualan -->
            <div class="p-6 border-b">
                <h3 class="flex items-center gap-2 font-bold text-lg mb-6">
                    <span class="material-symbols-outlined text-primary">sell</span>
                    Detail Penjualan
                </h3>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">Harga</label>
                        <input type="number" name="harga" value="{{ old('harga') }}"
                            class="w-full rounded-lg border px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary">
                        @error('harga')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok') }}"
                            class="w-full rounded-lg border px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary">
                        @error('stok')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="p-6 border-b">
                <h3 class="flex items-center gap-2 font-bold text-lg mb-6">
                    <span class="material-symbols-outlined text-primary">image</span>
                    Media Produk
                </h3>

                <label class="block text-sm font-bold mb-2">Gambar Produk</label>
                <input type="file" name="gambar"
                    class="w-full rounded-lg border px-4 py-3">
                @error('gambar')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="p-6">
                <label class="block text-sm font-bold mb-3">Status</label>
                <select name="status"
                        class="w-full rounded-lg border px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Non Aktif</option>
                </select>
            </div>

            <!-- Action -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t">
                <a href="{{ route('umkm.products.index') }}"
                class="px-6 h-11 flex items-center rounded-lg border font-medium hover:bg-gray-100">
                    Kembali
                </a>
                <button type="submit"
                    class="px-6 h-11 rounded-lg bg-primary text-white font-bold hover:bg-red-700 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan
                </button>
            </div>

        </form>
    </div>
    </main>

    <footer class="bg-white border-t py-6 text-center text-sm text-gray-500">
        © 2024 Forum UMKM Telkom University
    </footer>

    </body>
    </html>
