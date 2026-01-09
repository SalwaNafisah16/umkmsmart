@extends('layouts.mahasiswa')

@section('title','Edit Postingan')

@section('content')

<div class="bg-white rounded-xl shadow-sm border p-6">

    <h2 class="text-lg font-bold mb-4">Edit Postingan</h2>

    <form method="POST" action="{{ route('forum.update', $forum->id) }}">
        @csrf
        @method('PATCH')

        <textarea name="content"
                  rows="4"
                  class="w-full rounded-lg border-gray-300 p-4 text-sm"
                  required>{{ old('content',$forum->content) }}</textarea>

        <div class="flex justify-end gap-3 mt-4">
            <a href="{{ route('forum.show',$forum->id) }}"
               class="px-4 py-2 text-sm rounded-lg border">
                Batal
            </a>

            <button class="px-4 py-2 text-sm bg-primary text-white rounded-lg">
                Simpan
            </button>
        </div>
    </form>

</div>

@endsection
