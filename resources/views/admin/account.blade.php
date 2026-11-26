@extends('layouts.admin')
@section('title', 'Akun Admin')

@section('content')
@php
  $field = 'w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-primary-container text-sm';
  $label = 'block text-sm font-semibold mb-1.5';
@endphp

<h1 class="text-2xl font-extrabold mb-6">Akun Admin</h1>

<div class="max-w-3xl space-y-6">

  {{-- Ganti password --}}
  <form method="POST" action="{{ route('admin.account.password') }}"
        class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-4">
    @csrf @method('PUT')
    <h2 class="font-bold">Ganti Password Saya</h2>
    <div>
      <label class="{{ $label }}">Password saat ini</label>
      <input type="password" name="current_password" class="{{ $field }}" required autocomplete="current-password">
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <label class="{{ $label }}">Password baru</label>
        <input type="password" name="password" class="{{ $field }}" required autocomplete="new-password">
      </div>
      <div>
        <label class="{{ $label }}">Ulangi password baru</label>
        <input type="password" name="password_confirmation" class="{{ $field }}" required autocomplete="new-password">
      </div>
    </div>
    <p class="text-xs text-gray-400">Minimal 8 karakter, mengandung huruf dan angka.</p>
    <button class="px-6 py-2.5 rounded-full bg-primary-container hover:bg-primary text-white text-sm font-bold transition-colors">Simpan Password</button>
  </form>

  {{-- Daftar admin --}}
  <div class="bg-white border border-surface-container-high rounded-2xl shadow-sm">
    <h2 class="font-bold px-6 pt-6 pb-3">Daftar Admin</h2>
    <div class="divide-y divide-surface-container-high">
      @foreach ($admins as $a)
        <div class="px-6 py-3 flex items-center justify-between gap-4">
          <div class="min-w-0">
            <p class="font-semibold text-sm truncate">
              {{ $a->name }}
              @if ($a->id === auth()->id()) <span class="ml-1 px-2 py-0.5 rounded-full bg-red-50 text-primary-container text-[10px] font-bold">ANDA</span> @endif
            </p>
            <p class="text-xs text-gray-500 truncate">{{ $a->email }}</p>
          </div>
          @if ($a->id !== auth()->id())
            <form method="POST" action="{{ route('admin.account.destroy', $a) }}" onsubmit="return confirm('Hapus admin ini?')">
              @csrf @method('DELETE')
              <button class="px-4 py-2 rounded-full bg-red-50 hover:bg-primary-container hover:text-white text-primary-container text-xs font-semibold transition-colors">Hapus</button>
            </form>
          @endif
        </div>
      @endforeach
    </div>
  </div>

  {{-- Tambah admin --}}
  <form method="POST" action="{{ route('admin.account.store') }}"
        class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-4">
    @csrf
    <h2 class="font-bold">Tambah Admin Baru</h2>
    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <label class="{{ $label }}">Nama</label>
        <input name="name" value="{{ old('name') }}" class="{{ $field }}" required>
      </div>
      <div>
        <label class="{{ $label }}">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="{{ $field }}" required>
      </div>
    </div>
    <div>
      <label class="{{ $label }}">Password</label>
      <input type="password" name="password" class="{{ $field }}" required autocomplete="new-password">
    </div>
    <button class="px-6 py-2.5 rounded-full bg-brand-dark text-white text-sm font-bold">Tambah Admin</button>
  </form>
</div>
@endsection