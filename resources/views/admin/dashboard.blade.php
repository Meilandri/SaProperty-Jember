@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-extrabold mb-1">Dashboard</h1>
<p class="text-sm text-gray-500 mb-8">Selamat datang, {{ auth()->user()->name }}.</p>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
  @foreach ($stats as [$label, $value, $icon, $color])
    <div class="bg-white border border-surface-container-high rounded-2xl p-5 shadow-sm">
      <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3 {{ $color }}"><i class="fa-solid {{ $icon }}"></i></div>
      <p class="text-2xl font-extrabold">{{ $value }}</p>
      <p class="text-xs text-gray-500">{{ $label }}</p>
    </div>
  @endforeach
</div>

<h2 class="font-bold mb-4">Aksi Cepat</h2>
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
  @foreach ([
    [route('admin.projects.create'), 'Tambah Proyek', 'fa-plus'],
    [route('admin.catalog.create'), 'Tambah Layanan Katalog', 'fa-plus'],
    [route('admin.settings.edit', 'beranda'), 'Ganti Gambar Hero', 'fa-image'],
    [route('admin.categories.index'), 'Kelola Kategori', 'fa-tags'],
  ] as [$href, $label, $icon])
    <a href="{{ $href }}"
       class="bg-white border border-surface-container-high rounded-2xl p-5 shadow-sm flex items-center gap-3 font-semibold text-sm hover:border-primary-container hover:text-primary-container transition-colors">
      <i class="fa-solid {{ $icon }}"></i> {{ $label }}
    </a>
  @endforeach
</div>
@endsection