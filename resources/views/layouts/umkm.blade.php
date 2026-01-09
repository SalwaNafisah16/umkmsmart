<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title','Dashboard UMKM')</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: "#ec1313",
                background: "#f8f6f6"
            },
            fontFamily: {
                display: ["Inter","sans-serif"]
            }
        }
    }
}
</script>
</head>

<body class="bg-background font-display text-[#181111]">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('partials.umkm.sidebar')

    {{-- MAIN --}}
    <main class="flex-1 flex flex-col">

        {{-- HEADER --}}
        @include('partials.umkm.header')

        {{-- CONTENT --}}
        <section class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </section>

    </main>

</div>

</body>
</html>
