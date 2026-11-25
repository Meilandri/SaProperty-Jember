@extends('layouts.admin')
@section('title', 'Kategori')

@section('content')
@php
  $field = 'w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-primary-container text-sm';
@endphp

<h1 class="text-2xl font-extrabold mb-1">Kategori</h1>
<p class="text-sm text-gray-500 mb-6">Kategori tampil sebagai tombol filter di halaman Katalog dan Proyek. Angka di kolom kecil adalah urutan tampil.</p>

<div class="grid xl:grid-cols-2 gap-6 max-w-6xl">
  @foreach ($sections as $type => [$title, $rows, $use])
    <div class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm">
      <h2 class="font-bold mb-4">{{ $title }}</h2>

      <div class="divide-y divide-surface-container-high">
        @forelse ($rows as $c)
          <div class="py-3 space-y-2">
            <div class="flex flex-wrap items-center gap-2">
              <form method="POST" action="{{ route('admin.categories.update', $c) }}" class="flex flex-1 gap-2 min-w-0">
                @csrf @method('PUT')
                <input name="name" value="{{ $c->name }}" class="{{ $field }}" required>
                <input name="sort_order" type="number" min="0" value="{{ $c->sort_order }}" title="Urutan" class="{{ $field }} !w-20">
                <button class="px-4 py-2 rounded-full bg-brand-dark text-white text-xs font-semibold">Simpan</button>
              </form>

              <form method="POST" action="{{ route('admin.categories.destroy', $c) }}"
                    onsubmit="return confirm('Hapus kategori ini?')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 rounded-full bg-red-50 hover:bg-primary-container hover:text-white text-primary-container text-xs font-semibold transition-colors">Hapus</button>
              </form>
            </div>
            <p class="text-[11px] text-gray-400">{{ $use[$c->key] ?? 0 }} item memakai kategori ini</p>
          </div>
        @empty
          <p class="py-6 text-sm text-gray-500">Belum ada kategori.</p>
        @endforelse
      </div>

      <form method="POST" action="{{ route('admin.categories.store') }}" class="mt-5 pt-5 border-t border-surface-container-high flex gap-2">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <input name="name" placeholder="Nama kategori baru" class="{{ $field }}" required>
        <button class="px-5 py-2 rounded-full bg-primary-container hover:bg-primary text-white text-xs font-bold whitespace-nowrap transition-colors">
          <i class="fa-solid fa-plus mr-1"></i> Tambah
        </button>
      </form>
    </div>
  @endforeach
</div>
@endsection