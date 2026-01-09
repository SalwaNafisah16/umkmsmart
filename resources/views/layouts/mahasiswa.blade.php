<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Forum UMKM Tel-U')</title>

    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    {{-- TAILWIND --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#c62828",
                        bgLight: "#f6f7f8",
                    },
                    fontFamily: {
                        display: ["Inter","sans-serif"]
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: Inter, sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;
        }
        .icon-fill { font-variation-settings: 'FILL' 1; }
    </style>

    @yield('style')
</head>

<body class="bg-bgLight text-gray-900 min-h-screen">

{{-- ================= HEADER ================= --}}
@include('partials.mahasiswa.header')

{{-- ================= PAGE TITLE ================= --}}
@if(View::hasSection('page-title'))
<section class="max-w-[1440px] mx-auto px-4 md:px-6 mt-6">
    <div class="bg-white rounded-xl border p-6">
        <h2 class="text-xl font-bold">
            @yield('page-title')
        </h2>

        @hasSection('page-desc')
            <p class="text-sm text-gray-500 mt-1">
                @yield('page-desc')
            </p>
        @endif
    </div>
</section>
@endif

{{-- ================= MAIN LAYOUT ================= --}}
<div class="max-w-[1440px] mx-auto px-4 md:px-6 py-6
            grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    {{-- SIDEBAR KIRI --}}
    <aside class="hidden lg:block lg:col-span-3 sticky top-24">
        @include('partials.mahasiswa.sidebar-left')
    </aside>

    {{-- CONTENT --}}
    <main class="col-span-1 lg:col-span-6 flex flex-col gap-6">
        @yield('content')
    </main>

    {{-- SIDEBAR KANAN --}}
    <aside class="hidden lg:block lg:col-span-3 sticky top-24">
        @include('partials.mahasiswa.sidebar-right')
    </aside>

</div>

@yield('script')

<script>
function scrollToComment(id){
    const el = document.getElementById('comment-section-'+id);
    if(el){
        el.scrollIntoView({behavior:'smooth',block:'center'});
        el.querySelector('input')?.focus();
    }
}
</script>

</body>
</html>
