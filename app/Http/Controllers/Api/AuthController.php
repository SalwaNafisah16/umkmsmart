<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MahasiswaProfile;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * =============================================
     * REGISTER - Daftar User Baru (Mahasiswa / UMKM)
     * =============================================
     * 
     * POST /api/register
     * 
     * Body: name, email, password, password_confirmation, role
     * Role: "mahasiswa" atau "umkm"
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:mahasiswa,umkm'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Simpan user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Buat profil berdasarkan role
        if ($request->role === 'mahasiswa') {
            MahasiswaProfile::create([
                'user_id' => $user->id,
                'nim'     => $request->nim ?? null,
                'prodi'   => $request->prodi ?? null,
            ]);
        } elseif ($request->role === 'umkm') {
            UmkmProfile::create([
                'user_id'      => $user->id,
                'nama_usaha'   => $request->nama_usaha ?? $user->name,
                'jenis_usaha'  => $request->jenis_usaha ?? null,
                'alamat_usaha' => $request->alamat_usaha ?? null,
                'no_hp_usaha'  => $request->no_hp_usaha ?? null,
                'deskripsi'    => $request->deskripsi ?? null,
            ]);
        }

        // Generate token
        $token = $user->createToken('flutter-app')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'data'    => [
                'user'         => $user,
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ],
        ], 201);
    }

    /**
     * =============================================
     * LOGIN - Masuk ke Aplikasi
     * =============================================
     * 
     * POST /api/login
     * 
     * Body: email, password
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Cek email
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah',
            ], 401);
        }

        // Generate token
        $token = $user->createToken('flutter-app')->plainTextToken;

        return response()->json([
            'message'      => 'Login berhasil',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user,
        ], 200);
    }

    /**
     * =============================================
     * ME - Data User Login Saat Ini
     * =============================================
     * 
     * GET /api/me
     * Header: Authorization: Bearer {token}
     */
    public function me(Request $request)
    {
        $user = $request->user();
        
        // Load profil berdasarkan role
        if ($user->role === 'mahasiswa') {
            $user->load('mahasiswaProfile');
        } elseif ($user->role === 'umkm') {
            $user->load('umkmProfile');
        }

        return response()->json($user, 200);
    }

    /**
     * =============================================
     * LOGOUT - Keluar dari Aplikasi
     * =============================================
     * 
     * POST /api/logout
     * Header: Authorization: Bearer {token}
     */
    public function logout(Request $request)
    {
        // Hapus token saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ], 200);
    }
}
