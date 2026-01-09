
@extends('layouts.umkm')

@section('title','Profil UMKM')

@section('page-title','Profil UMKM')
@section('page-desc','Kelola informasi usaha Anda')

@section('content')

{{-- ================= ALERT SUCCESS ================= --}}
@if(session('success'))
    <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700 border border-green-200">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- ================= PROFIL SAAT INI ================= --}}
    <div class="bg-white rounded-xl border p-6">
        <h3 class="text-lg font-bold mb-4">Profil Saat Ini</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

            <div>
                <p class="text-gray-500">Nama Usaha</p>
                <p class="font-semibold">
                    {{ $profile->nama_usaha ?? 'Belum diisi' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Jenis Usaha</p>
                <p class="font-semibold">
                    {{ $profile->jenis_usaha ?? 'Belum diisi' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">No HP</p>
                <p class="font-semibold">
                    {{ $profile->no_hp_usaha ?? 'Belum diisi' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <span class="inline-block px-3 py-1 text-xs rounded-full
                    {{ ($profile->status_usaha ?? 'aktif') === 'aktif'
                        ? 'bg-green-100 text-green-700'
                        : 'bg-gray-100 text-gray-600' }}">
                    {{ ucfirst($profile->status_usaha ?? 'aktif') }}
                </span>
            </div>

            <div class="md:col-span-2">
                <p class="text-gray-500">Alamat Usaha</p>
                <p class="font-semibold">
                    {{ $profile->alamat_usaha ?? 'Belum diisi' }}
                </p>
            </div>

            <div class="md:col-span-2">
                <p class="text-gray-500">Deskripsi</p>
                <p class="font-semibold">
                    {{ $profile->deskripsi ?? 'Belum diisi' }}
                </p>
            </div>

        </div>
    </div>

    {{-- ================= FORM EDIT PROFIL ================= --}}
    <form method="POST"
          action="{{ route('profil.update') }}"
          class="bg-white rounded-xl border p-6 space-y-5">
        @csrf

        <h3 class="text-lg font-bold mb-2">Edit Profil UMKM</h3>

        <div>
            <label class="text-sm text-gray-500">Nama Usaha</label>
            <input type="text"
                   name="nama_usaha"
                   value="{{ old('nama_usaha', $profile->nama_usaha ?? '') }}"
                   class="w-full rounded-lg border-gray-300 mt-1"
                   required>
        </div>

        <div>
            <label class="text-sm text-gray-500">Jenis Usaha</label>
            <input type="text"
                   name="jenis_usaha"
                   value="{{ old('jenis_usaha', $profile->jenis_usaha ?? '') }}"
                   class="w-full rounded-lg border-gray-300 mt-1">
        </div>

        <div>
            <label class="text-sm text-gray-500">Alamat Usaha</label>
            <textarea name="alamat_usaha"
                      rows="3"
                      class="w-full rounded-lg border-gray-300 mt-1">{{ old('alamat_usaha', $profile->alamat_usaha ?? '') }}</textarea>
        </div>

        <div>
            <label class="text-sm text-gray-500">No HP Usaha</label>
            <input type="text"
                   name="no_hp_usaha"
                   value="{{ old('no_hp_usaha', $profile->no_hp_usaha ?? '') }}"
                   class="w-full rounded-lg border-gray-300 mt-1">
        </div>

        <div>
            <label class="text-sm text-gray-500">Deskripsi Usaha</label>
            <textarea name="deskripsi"
                      rows="4"
                      class="w-full rounded-lg border-gray-300 mt-1">{{ old('deskripsi', $profile->deskripsi ?? '') }}</textarea>
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="bg-primary text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary/90">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>

@endsection
