<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Masuk Akun - Telkom University UMKM Forum</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
                    <span class="text-primary text-7xl font-bold">T</span>
                </div>
                <h1 class="text-5xl font-bold text-accent mb-2 leading-tight">Selamat Datang!</h1>
                <p class="text-accent/90 text-xl leading-relaxed font-medium">
                    untuk mengakses forum promosi dan<br/>pertukaran informasi.
                </p>
            </div>
            <div class="absolute bottom-8 text-white/40 text-sm">
                © Telkom University
            </div>
        </div>

        <!-- Right Panel -->
        <div class="flex flex-1 flex-col justify-center items-center bg-white dark:bg-background-dark px-6 py-12 lg:px-24">
            <div class="w-full max-w-[480px] flex flex-col gap-8">
                <!-- Mobile Header -->
                <div class="flex lg:hidden flex-col items-center gap-2 mb-4 text-primary">
                    <div class="size-16 bg-primary rounded-xl flex items-center justify-center text-white mb-2">
                        <span class="text-4xl font-bold">T</span>
                    </div>
                    <span class="text-2xl font-bold text-primary">Selamat Datang!</span>
                </div>

                <!-- Page Title -->
                <div class="flex flex-col items-center gap-2 mb-2">
                    <h2 class="text-text-brown dark:text-white text-[32px] font-bold leading-tight">Masuk Akun</h2>
                </div>

                <!-- Role Toggle -->
                <div class="bg-accent border border-[#f0e6d2] p-1.5 rounded-xl flex w-full mb-2">
                    <label class="flex-1 cursor-pointer">
                        <input id="role_mahasiswa" class="peer sr-only" name="role_toggle" type="radio" value="mahasiswa" checked/>
                        <div class="flex items-center justify-center gap-2 py-3 rounded-lg text-[#8d6e63] font-bold text-sm transition-all peer-checked:bg-primary peer-checked:text-white peer-checked:shadow-md">
                            <span class="material-symbols-outlined text-[20px]">school</span>
                            Mahasiswa
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input id="role_pelaku_umkm" class="peer sr-only" name="role_toggle" type="radio" value="pelaku_umkm"/>
                        <div class="flex items-center justify-center gap-2 py-3 rounded-lg text-[#8d6e63] font-bold text-sm transition-all peer-checked:bg-primary peer-checked:text-white peer-checked:shadow-md">
                            <span class="material-symbols-outlined text-[20px]">storefront</span>
                            Pelaku Usaha
                        </div>
                    </label>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                    @csrf

                    <!-- Email -->
                    <label class="flex flex-col gap-2">
                        <p id="email_label" class="text-[#8d6e63] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Email SSO Mahasiswa</p>
                        <div class="relative">
                            <input 
                                id="email"
                                name="email" 
                                type="email" 
                                value="{{ old('email') }}"
                                required 
                                autofocus
                                autocomplete="username"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-14 px-4 text-base font-normal leading-normal transition-colors {{ $errors->get('email') ? 'border-red-500' : '' }}" 
                                id="email_input"
                                placeholder="nim@student.telkomuniversity.ac.id"/>
                        </div>
                        @if($errors->get('email'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</p>
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
                                autocomplete="current-password"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111418] dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-14 px-4 pr-12 text-base font-normal leading-normal transition-colors tracking-widest {{ $errors->get('password') ? 'border-red-500' : '' }}" 
                                placeholder="••••••••"/>
                            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary" type="button">
                            </button>
                        </div>
                        @if($errors->get('password'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('password') }}</p>
                        @endif
                    </label>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-4 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary-hover transition-colors shadow-md mt-4">
                        <span class="truncate">Masuk ke Platform</span>
                    </button>

                    <!-- Links -->
                    <div class="flex flex-col gap-2 mt-4 text-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-primary-hover underline">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        
                        <p class="text-[#8d6e63] dark:text-gray-300 text-sm">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-primary hover:text-primary-hover font-medium underline">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle role toggle - update email placeholder
        document.querySelectorAll('input[name="role_toggle"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const emailLabel = document.getElementById('email_label');
                const emailInput = document.getElementById('email_input');
                
                if (this.value === 'mahasiswa') {
                    emailLabel.textContent = 'Email SSO Mahasiswa';
                    emailInput.placeholder = 'nim@student.telkomuniversity.ac.id';
                } else {
                    emailLabel.textContent = 'Email Pelaku Usaha';
                    emailInput.placeholder = 'email@umkm.com';
                }
            });
        });
    </script>
</body>
</html>
