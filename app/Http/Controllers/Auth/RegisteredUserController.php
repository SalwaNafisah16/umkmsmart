<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MahasiswaProfile;
use App\Models\PelakuUmkmProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ✅ VALIDASI DASAR
        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:mahasiswa,pelaku_umkm'],
        ];

        // ✅ VALIDASI TAMBAHAN BERDASARKAN ROLE
        if ($request->role === 'mahasiswa') {
            $validationRules['nim'] = ['required', 'string', 'max:20', 'unique:mahasiswa_profiles,nim'];
            $validationRules['prodi'] = ['required', 'string', 'max:100'];
        } elseif ($request->role === 'pelaku_umkm') {
            $validationRules['nama_usaha'] = ['required', 'string', 'max:255'];
            $validationRules['jenis_usaha'] = ['required', 'string', 'max:100'];
            $validationRules['alamat_usaha'] = ['required', 'string', 'max:500'];
            $validationRules['no_hp_usaha'] = ['required', 'string', 'max:20'];
            $validationRules['deskripsi'] = ['nullable', 'string', 'max:1000'];
        }

        $request->validate($validationRules);

        // ✅ SIMPAN USER + ROLE
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // ✅ SIMPAN PROFIL BERDASARKAN ROLE
        if ($request->role === 'mahasiswa') {
            MahasiswaProfile::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'prodi' => $request->prodi,
            ]);
        } elseif ($request->role === 'pelaku_umkm') {
            PelakuUmkmProfile::create([
                'user_id' => $user->id,
                'nama_usaha' => $request->nama_usaha,
                'jenis_usaha' => $request->jenis_usaha,
                'alamat_usaha' => $request->alamat_usaha,
                'no_hp_usaha' => $request->no_hp_usaha,
                'deskripsi' => $request->deskripsi,
                'status_usaha' => 'aktif',
            ]);
        }

        // event bawaan Breeze
        event(new Registered($user));

        // auto login setelah register
        Auth::login($user);

        // redirect setelah login
        return redirect(route('dashboard', absolute: false));
    }
}
