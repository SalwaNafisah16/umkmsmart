@extends('layouts.mahasiswa')

@section('title','Profil Mahasiswa')

@section('content')

{{-- ================= ALERT ================= --}}
@if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-700 border border-green-200">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- ================= PROFIL SAAT INI ================= --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <h2 class="text-lg font-bold mb-5">Profil Saat Ini</h2>

        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-full bg-primary text-white
                        flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>
            <div>
                <p class="font-semibold text-lg">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ auth()->user()->email }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 text-sm">

            <div>
                <p class="text-gray-500">Role</p>
                <span class="inline-block mt-1 px-3 py-1 text-xs
                             bg-primary/10 text-primary rounded-full">
                    Mahasiswa
                </span>
            </div>

        </div>
    </div>

    {{-- ================= EDIT PROFIL ================= --}}
    <form method="POST"
          action="{{ route('mahasiswa.profile.update') }}"
          class="bg-white rounded-2xl border shadow-sm p-6 space-y-5">
        @csrf

        <h2 class="text-lg font-bold mb-2">Edit Profil</h2>

        {{-- NAMA --}}
        <div>
            <label class="text-sm text-gray-500">Nama Lengkap</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', auth()->user()->name) }}"
                   class="w-full rounded-xl border-gray-300 mt-1
                          focus:ring-primary"
                   required>
        </div>

        {{-- EMAIL --}}
        <div>
            <label class="text-sm text-gray-500">Email</label>
            <input type="email"
                   name="email"
                   value="{{ old('email', auth()->user()->email) }}"
                   class="w-full rounded-xl border-gray-300 mt-1
                          focus:ring-primary"
                   required>
        </div>

        {{-- PRODI (OPSIONAL JIKA ADA) --}}
        <div>
            <label class="text-sm text-gray-500">Program Studi</label>
            <input type="text"
                   name="prodi"
                   value="{{ old('prodi', auth()->user()->mahasiswaProfile->prodi ?? '') }}"
                   class="w-full rounded-xl border-gray-300 mt-1
                          focus:ring-primary"
                   placeholder="Masukkan program studi">
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="bg-primary text-white px-6 py-2 rounded-xl
                           font-semibold hover:bg-primary/90 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>

@endsection
