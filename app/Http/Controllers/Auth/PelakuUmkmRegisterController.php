<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UmkmProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class PelakuUmkmRegisterController extends Controller
{
    /**
     * Display the registration view for pelaku UMKM.
     */
    public function create(): View
    {
        return view('auth.register-umkm');
    }

    /**
     * Handle an incoming registration request for pelaku UMKM.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ✅ VALIDASI UNTUK PELAKU UMKM
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nama_usaha' => ['required', 'string', 'max:255'],
            'jenis_usaha' => ['required', 'string', 'max:100'],
            'alamat_usaha' => ['required', 'string', 'max:500'],
            'no_hp_usaha' => ['required', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
        ]);

        // ✅ SIMPAN USER DENGAN ROLE PELAKU_UMKM
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'umkm',
        ]);

        // ✅ SIMPAN PROFIL PELAKU UMKM
        UmkmProfile::create([
            'user_id' => $user->id,
            'nama_usaha' => $request->nama_usaha,
            'jenis_usaha' => $request->jenis_usaha,
            'alamat_usaha' => $request->alamat_usaha,
            'no_hp_usaha' => $request->no_hp_usaha,
            'deskripsi' => $request->deskripsi,
            'status_usaha' => 'aktif',
        ]);

        // Event bawaan Breeze
        event(new Registered($user));

        // Auto login setelah register
        Auth::login($user);

        // Redirect setelah login
        return redirect(route('dashboard', absolute: false));
    }
}
