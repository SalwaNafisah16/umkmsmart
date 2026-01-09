<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaProfile;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * =============================================
     * SHOW - Data Profil User
     * =============================================
     * 
     * GET /api/profile
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'mahasiswa') {
            $user->load('mahasiswaProfile');
        } elseif ($user->role === 'umkm') {
            $user->load('umkmProfile');
        }

        return response()->json([
            'message' => 'Berhasil mengambil profil',
            'data'    => $user,
        ], 200);
    }

    /**
     * =============================================
     * UPDATE - Update Profil User
     * =============================================
     * 
     * POST /api/profile
     * Body: name, avatar (file), + fields sesuai role
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Validasi dasar
        $rules = [
            'name'   => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        // Validasi tambahan berdasarkan role
        if ($user->role === 'mahasiswa') {
            $rules['nim']   = 'nullable|string|max:20';
            $rules['prodi'] = 'nullable|string|max:100';
        } elseif ($user->role === 'umkm') {
            $rules['nama_usaha']   = 'nullable|string|max:255';
            $rules['jenis_usaha']  = 'nullable|string|max:100';
            $rules['alamat_usaha'] = 'nullable|string|max:500';
            $rules['no_hp_usaha']  = 'nullable|string|max:20';
            $rules['deskripsi']    = 'nullable|string|max:1000';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Update nama user
        if ($request->filled('name')) {
            $user->name = $request->name;
            $user->save();
        }

        // Update profil berdasarkan role
        if ($user->role === 'mahasiswa') {
            $profile = MahasiswaProfile::firstOrCreate(['user_id' => $user->id]);
            
            if ($request->filled('nim')) {
                $profile->nim = $request->nim;
            }
            if ($request->filled('prodi')) {
                $profile->prodi = $request->prodi;
            }
            if ($request->hasFile('avatar')) {
                // Hapus avatar lama jika ada
                if ($profile->avatar) {
                    Storage::disk('public')->delete($profile->avatar);
                }
                $profile->avatar = $request->file('avatar')->store('avatars', 'public');
            }
            
            $profile->save();
            $user->load('mahasiswaProfile');

        } elseif ($user->role === 'umkm') {
            $profile = UmkmProfile::firstOrCreate(['user_id' => $user->id]);
            
            if ($request->filled('nama_usaha')) {
                $profile->nama_usaha = $request->nama_usaha;
            }
            if ($request->filled('jenis_usaha')) {
                $profile->jenis_usaha = $request->jenis_usaha;
            }
            if ($request->filled('alamat_usaha')) {
                $profile->alamat_usaha = $request->alamat_usaha;
            }
            if ($request->filled('no_hp_usaha')) {
                $profile->no_hp_usaha = $request->no_hp_usaha;
            }
            if ($request->filled('deskripsi')) {
                $profile->deskripsi = $request->deskripsi;
            }
            if ($request->hasFile('avatar')) {
                if ($profile->logo) {
                    Storage::disk('public')->delete($profile->logo);
                }
                $profile->logo = $request->file('avatar')->store('logos', 'public');
            }
            
            $profile->save();
            $user->load('umkmProfile');
        }

        return response()->json([
            'message' => 'Profil berhasil diupdate',
            'data'    => $user,
        ], 200);
    }
}
