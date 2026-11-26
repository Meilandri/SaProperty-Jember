@extends('layouts.admin')
@section('title', 'Testimoni')

@section('content')
@php
  $field = 'w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-primary-container text-sm';
@endphp

<h1 class="text-2xl font-extrabold mb-1">Testimoni Klien</h1>
<p class="text-sm text-gray-500 mb-6">Tampil di bagian "Apa Kata Klien Kami?" pada halaman Proyek (6 terbaru yang berstatus tayang).</p>

<div class="max-w-3xl space-y-6">

  {{-- Tambah --}}
  <form method="POST" action="{{ route('admin.testimonials.store') }}"
        class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-4">
    @csrf
    <h2 class="font-bold">Tambah Testimoni</h2>
    <div class="grid sm:grid-cols-2 gap-4">
      <input name="name" placeholder="Nama klien" class="{{ $field }}" required>
      <input name="role" placeholder="Keterangan (mis. Pemilik Rumah, BSD City)" class="{{ $field }}">
    </div>
    <textarea name="text" rows="3" placeholder="Isi testimoni" class="{{ $field }}" required></textarea>
    <div class="flex items-center justify-between gap-4">
      <label class="flex items-center gap-2 text-sm font-semibold">
        <input type="checkbox" name="is_published" value="1" class="rounded" checked> Tayangkan
      </label>
      <button class="px-6 py-2.5 rounded-full bg-primary-container hover:bg-primary text-white text-sm font-bold transition-colors">Tambah</button>
    </div>
  </form>

  {{-- Daftar --}}
  @forelse ($items as $t)
    <div class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm">
      <form method="POST" action="{{ route('admin.testimonials.update', $t) }}" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid sm:grid-cols-2 gap-4">
          <input name="name" value="{{ $t->name }}" class="{{ $field }}" required>
          <input name="role" value="{{ $t->role }}" class="{{ $field }}">
        </div>
        <textarea name="text" rows="3" class="{{ $field }}" required>{{ $t->text }}</textarea>
        <div class="flex items-center justify-between gap-4">
          <label class="flex items-center gap-2 text-sm font-semibold">
            <input type="checkbox" name="is_published" value="1" class="rounded" @checked($t->is_published)> Tayangkan
          </label>
          <button class="px-5 py-2 rounded-full bg-brand-dark text-white text-xs font-semibold">Simpan</button>
        </div>
      </form>

      <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}"
            onsubmit="return confirm('Hapus testimoni ini?')" class="mt-3">
        @csrf @method('DELETE')
        <button class="text-xs font-semibold text-primary-container hover:underline">Hapus testimoni ini</button>
      </form>
    </div>
  @empty
    <p class="text-sm text-gray-500">Belum ada testimoni.</p>
  @endforelse
</div>
@endsection