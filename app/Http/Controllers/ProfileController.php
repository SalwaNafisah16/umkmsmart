<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaProfile;
use App\Models\UmkmProfile;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * ==============================
     * TAMPILKAN PROFIL SESUAI ROLE
     * ==============================
     */
   public function index()
{
    $user = auth()->user();

    if ($user->role === 'umkm') {
        $profile = UmkmProfile::where('user_id', $user->id)->first();

        return view('dashboard.umkm.profile', [
            'user' => $user,
            'profile' => $profile
        ]);
    }

    if ($user->role === 'mahasiswa') {
        return view('dashboard.mahasiswa.profile', [
            'user' => $user
        ]);
    }

    abort(403);
}



    /**
     * ==============================
     * UPDATE PROFIL SESUAI ROLE
     * ==============================
     */
    public function update(Request $request)
    {
        try {
            $user = User::find(auth()->id());

            // ===== UPDATE PROFIL MAHASISWA =====
            if ($user->role === 'mahasiswa') {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->save();

                MahasiswaProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    ['prodi' => $request->prodi]
                );

                return redirect()->route('mahasiswa.profile')
                    ->with('success', 'Profil berhasil diperbarui');
            }


            // ===== UPDATE PROFIL UMKM =====
            if ($user->role === 'umkm') {
                UmkmProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama_usaha'   => $request->nama_usaha,
                        'jenis_usaha'  => $request->jenis_usaha,
                        'alamat_usaha' => $request->alamat_usaha,
                        'no_hp_usaha'  => $request->no_hp_usaha,
                        'deskripsi'    => $request->deskripsi,
                        'status_usaha' => 'aktif'
                    ]
                );

                return redirect()->route('umkm.profil.index')
                    ->with('success', 'Profil berhasil diperbarui');
            }

            return back()->with('error', 'Role tidak dikenal');
            
        } catch (\Exception $e) {
            \Log::error('ProfileController@update error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * ==============================
     * EDIT AKUN (BREEZE)
     * ==============================
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * ==============================
     * UPDATE AKUN (NAME & EMAIL)
     * ==============================
     */
    public function updateAccount(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * ==============================
     * HAPUS AKUN
     * ==============================
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
