<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Daftar Sebagai Pelaku UMKM - Telkom University UMKM Forum</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#9e2a2b", // Deep Red / Maroon from reference
                        "primary-hover": "#7d2122",
                        "accent": "#fffdf7", // Cream/Off-white
                        "text-brown": "#5d4037", // Dark brown for headings
                        "background-light": "#ffffff",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1rem", "full": "9999px"},
                },
            },
        }
    </script>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-[#111418] dark:text-white antialiased overflow-x-hidden">
    <div class="flex min-h-screen w-full">
        <!-- Left Panel -->
        <div class="hidden lg:flex lg:w-1/2 relative flex-col justify-center items-center bg-primary text-center px-12">
            <div class="relative z-10 flex flex-col items-center gap-6 max-w-lg">
                <div class="size-32 bg-accent rounded-3xl flex items-center justify-center shadow-lg mb-4">
                    <span class="material-symbols-outlined text-primary text-7xl">storefront</span>
                </div>
                <h1 class="text-5xl font-bold text-accent mb-2 leading-tight">Bergabung sebagai Pelaku UMKM!</h1>
                <p class="text-accent/90 text-xl leading-relaxed font-medium">
                    Daftar untuk mempromosikan usaha Anda dan<br/>terhubung dengan mahasiswa Telkom University.
                </p>
            </div>
            <div class="absolute bottom-8 text-white/40 text-sm">
                © Telkom University
            </div>
        </div>

        <!-- Right Panel -->
        <div class="flex flex-1 flex-col justify-center items-center bg-white dark:bg-background-dark px-6 py-12 lg:px-24">
            <div class="w-full max-w-[480px] flex flex-col gap-6">
                <!-- Mobile Header -->
                <div class="flex lg:hidden flex-col items-center gap-2 mb-4 text-primary">
                    <div class="size-16 bg-primary rounded-xl flex items-center justify-center text-white mb-2">
                        <span class="material-symbols-outlined text-4xl">storefront</span>
                    </div>
                    <span class="text-2xl font-bold text-primary">Daftar Pelaku UMKM</span>
                </div>

                <!-- Page Title -->
                <div class="flex flex-col items-center gap-2 mb-2">
                    <h2 class="text-text-brown dark:text-white text-[32px] font-bold leading-tight">Daftar Sebagai Pelaku UMKM</h2>
                    <p class="text-[#8d6e63] dark:text-gray-300 text-sm text-center">Lengkapi data diri dan usaha Anda</p>
                </div>

                <!-- Role Toggle -->
                <div class="flex flex-col gap-3 mb-4">
                    <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider text-center">Daftar Sebagai</p>
                    <div class="flex w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-1">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="role_toggle" value="mahasiswa" class="sr-only">
                            <div class="w-full text-center py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                Mahasiswa
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="role_toggle" value="umkm" class="sr-only" checked>
                            <div class="w-full text-center py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 bg-primary text-white">
                                Pelaku UMKM
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register.umkm.store') }}" class="flex flex-col gap-5">
                    @csrf

                    <!-- Name -->
                    <label class="flex flex-col gap-2">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Nama Lengkap Pemilik</p>
                        <div class="relative">
                            <input 
                                id="name"
                                name="name" 
                                type="text" 
                                value="{{ old('name') }}"
                                required 
                                autofocus 
                                autocomplete="name"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-14 px-4 text-base font-normal leading-normal transition-colors {{ $errors->get('name') ? 'border-red-500' : '' }}" 
                                placeholder="Masukkan nama lengkap Anda"/>
                        </div>
                        @if($errors->get('name'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</p>
                        @endif
                    </label>

                    <!-- Email -->
                    <label class="flex flex-col gap-2">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Email</p>
                        <div class="relative">
                            <input 
                                id="email"
                                name="email" 
                                type="email" 
                                value="{{ old('email') }}"
                                required 
                                autocomplete="username"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-14 px-4 text-base font-normal leading-normal transition-colors {{ $errors->get('email') ? 'border-red-500' : '' }}" 
                                placeholder="email@umkm.com"/>
                        </div>
                        @if($errors->get('email'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</p>
                        @endif
                    </label>

                    <!-- Nama Usaha -->
                    <label class="flex flex-col gap-2">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Nama Usaha</p>
                        <div class="relative">
                            <input 
                                id="nama_usaha"
                                name="nama_usaha" 
                                type="text" 
                                value="{{ old('nama_usaha') }}"
                                required 
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-14 px-4 text-base font-normal leading-normal transition-colors {{ $errors->get('nama_usaha') ? 'border-red-500' : '' }}" 
                                placeholder="Masukkan nama usaha Anda"/>
                        </div>
                        @if($errors->get('nama_usaha'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('nama_usaha') }}</p>
                        @endif
                    </label>

                    <!-- Jenis Usaha -->
                    <label class="flex flex-col gap-2">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Jenis Usaha</p>
                        <div class="relative">
                            <select 
                                id="jenis_usaha"
                                name="jenis_usaha" 
                                required
                                class="form-select flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-14 px-4 text-base font-normal leading-normal transition-colors {{ $errors->get('jenis_usaha') ? 'border-red-500' : '' }}">
                                <option value="">-- Pilih Jenis Usaha --</option>
                                <option value="Kuliner" {{ old('jenis_usaha') == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                                <option value="Fashion" {{ old('jenis_usaha') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                                <option value="Kerajinan" {{ old('jenis_usaha') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                                <option value="Teknologi" {{ old('jenis_usaha') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                <option value="Jasa" {{ old('jenis_usaha') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                <option value="Perdagangan" {{ old('jenis_usaha') == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                                <option value="Lainnya" {{ old('jenis_usaha') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        @if($errors->get('jenis_usaha'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('jenis_usaha') }}</p>
                        @endif
                    </label>

                    <!-- Alamat Usaha -->
                    <label class="flex flex-col gap-2">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Alamat Usaha</p>
                        <div class="relative">
                            <textarea 
                                id="alamat_usaha"
                                name="alamat_usaha" 
                                required
                                rows="3"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary px-4 py-3 text-base font-normal leading-normal transition-colors {{ $errors->get('alamat_usaha') ? 'border-red-500' : '' }}" 
                                placeholder="Masukkan alamat lengkap usaha Anda">{{ old('alamat_usaha') }}</textarea>
                        </div>
                        @if($errors->get('alamat_usaha'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('alamat_usaha') }}</p>
                        @endif
                    </label>

                    <!-- No HP Usaha -->
                    <label class="flex flex-col gap-2">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">No HP/WhatsApp Usaha</p>
                        <div class="relative">
                            <input 
                                id="no_hp_usaha"
                                name="no_hp_usaha" 
                                type="tel" 
                                value="{{ old('no_hp_usaha') }}"
                                required 
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-14 px-4 text-base font-normal leading-normal transition-colors {{ $errors->get('no_hp_usaha') ? 'border-red-500' : '' }}" 
                                placeholder="08xxxxxxxxxx"/>
                        </div>
                        @if($errors->get('no_hp_usaha'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('no_hp_usaha') }}</p>
                        @endif
                    </label>

                    <!-- Deskripsi -->
                    <label class="flex flex-col gap-2">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Deskripsi Usaha (Opsional)</p>
                        <div class="relative">
                            <textarea 
                                id="deskripsi"
                                name="deskripsi" 
                                rows="3"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary px-4 py-3 text-base font-normal leading-normal transition-colors {{ $errors->get('deskripsi') ? 'border-red-500' : '' }}" 
                                placeholder="Ceritakan tentang usaha Anda...">{{ old('deskripsi') }}</textarea>
                        </div>
                        @if($errors->get('deskripsi'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('deskripsi') }}</p>
                        @endif
                    </label>

                    <!-- Password -->
                    <label class="flex flex-col gap-2">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Kata Sandi</p>
                        <div class="relative">
                            <input 
                                id="password"
                                name="password" 
                                type="password" 
                                required 
                                autocomplete="new-password"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-14 px-4 pr-12 text-base font-normal leading-normal transition-colors tracking-widest {{ $errors->get('password') ? 'border-red-500' : '' }}" 
                                placeholder="••••••••"/>
                        </div>
                        @if($errors->get('password'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('password') }}</p>
                        @endif
                    </label>

                    <!-- Confirm Password -->
                    <label class="flex flex-col gap-2">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Konfirmasi Kata Sandi</p>
                        <div class="relative">
                            <input 
                                id="password_confirmation"
                                name="password_confirmation" 
                                type="password" 
                                required 
                                autocomplete="new-password"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-14 px-4 pr-12 text-base font-normal leading-normal transition-colors tracking-widest {{ $errors->get('password_confirmation') ? 'border-red-500' : '' }}" 
                                placeholder="••••••••"/>
                        </div>
                        @if($errors->get('password_confirmation'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('password_confirmation') }}</p>
                        @endif
                    </label>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-4 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary-hover transition-colors shadow-md mt-4">
                        <span class="truncate">Daftar Sebagai Pelaku UMKM</span>
                    </button>

                    <!-- Links -->
                    <div class="text-center mt-4">
                        <p class="text-[#8d6e63] dark:text-gray-300 text-sm">
                            Ingin daftar sebagai mahasiswa? 
                            <a href="{{ route('register') }}" class="text-primary hover:text-primary-hover font-medium underline">
                                Daftar Mahasiswa
                            </a>
                        </p>
                        <p class="text-[#8d6e63] dark:text-gray-300 text-sm mt-2">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-primary hover:text-primary-hover font-medium underline">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle role toggle
        document.querySelectorAll('input[name="role_toggle"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'mahasiswa') {
                    // Redirect to Mahasiswa registration page
                    window.location.href = "{{ route('register') }}";
                }
                // If pelaku_umkm is selected, stay on current page (do nothing)
            });
        });
    </script>
</body>
</html>