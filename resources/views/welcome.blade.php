<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Forum UMKM Universitas Telkom</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#ce2029",
                        surface: "#f6f7f8",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white text-[#111418] font-display antialiased">

{{-- ================= HEADER ================= --}}
<header class="sticky top-0 z-50 bg-white border-b px-8 py-3 flex justify-between items-center">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary/10 text-primary">
            <span class="material-symbols-outlined">hub</span>
        </div>
        <h1 class="font-bold text-lg">Forum UMKM Telkom University</h1>
    </div>

    <div class="flex gap-2">
        @auth
            {{-- ⛔ JANGAN ARAHKAN KE DASHBOARD DI SINI --}}
            <a href="{{ url('/dashboard') }}"
               class="px-4 h-9 flex items-center rounded-lg bg-primary text-white font-semibold">
                Masuk Dashboard
            </a>
        @else
            <a href="{{ route('login') }}"
               class="px-4 h-9 flex items-center rounded-lg bg-gray-100 font-semibold">
                Masuk
            </a>
            <a href="{{ route('register') }}"
               class="px-4 h-9 flex items-center rounded-lg bg-primary text-white font-semibold">
                Daftar
            </a>
        @endauth
    </div>
</header>

{{-- ================= HERO ================= --}}
<section class="flex justify-center px-6 py-16">
    <div class="w-full max-w-5xl rounded-2xl bg-gradient-to-br from-primary to-red-900
                text-center text-white p-12">

        <span class="inline-block mb-4 px-4 py-1 text-xs border border-white/30 rounded-full">
            FORUM RESMI UMKM TEL-U
        </span>

        <h2 class="text-4xl md:text-5xl font-black mb-4">
            UMKM & Mahasiswa<br>
            Dalam Satu Ekosistem Digital
        </h2>

        <p class="max-w-2xl mx-auto text-white/90 mb-8">
            Wadah kolaborasi UMKM dan mahasiswa Telkom University
            untuk diskusi, promosi, dan kegiatan kewirausahaan.
        </p>

        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ route('register') }}"
               class="bg-white text-primary font-bold px-6 py-3 rounded-lg">
                Gabung Sekarang
            </a>
            <a href="{{ route('login') }}"
               class="border border-white px-6 py-3 rounded-lg font-bold">
                Sudah Punya Akun
            </a>
        </div>
    </div>
</section>

{{-- ================= STAT ================= --}}
<section class="max-w-5xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-surface p-6 rounded-xl text-center">
        <h3 class="text-3xl font-bold text-primary">300+</h3>
        <p>UMKM Terdaftar</p>
    </div>
    <div class="bg-surface p-6 rounded-xl text-center">
        <h3 class="text-3xl font-bold text-primary">1.000+</h3>
        <p>Mahasiswa Aktif</p>
    </div>
    <div class="bg-surface p-6 rounded-xl text-center">
        <h3 class="text-3xl font-bold text-primary">100+</h3>
        <p>Postingan & Diskusi</p>
    </div>
</section>

{{-- ================= FOOTER ================= --}}
<footer class="mt-20 border-t px-6 py-10 text-sm text-gray-500">
    <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between gap-6">
        <p>
            © {{ date('Y') }} Forum UMKM Telkom University<br>
            Sistem Informasi Akademik
        </p>
        <div class="flex gap-4">
            <a href="#">Tentang</a>
            <a href="#">Kontak</a>
            <a href="#">Privasi</a>
        </div>
    </div>
</footer>

</body>
</html>
