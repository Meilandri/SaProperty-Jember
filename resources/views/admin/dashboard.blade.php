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

<div class="bg-white border border-surface-container-high rounded-2xl shadow-sm">
  <div class="px-5 py-4 flex items-center justify-between border-b border-surface-container-high">
    <h2 class="font-bold">Pesan Terbaru</h2>
    <a href="{{ route('admin.inquiries.index') }}" class="text-sm font-semibold text-primary-container hover:underline">Lihat semua</a>
  </div>

  @forelse ($latest as $q)
    <div class="px-5 py-4 border-b last:border-0 border-surface-container-high flex items-start justify-between gap-4">
      <div class="min-w-0">
        <p class="font-semibold text-sm">
          {{ $q->name }}
          @unless ($q->read_at) <span class="ml-1 px-2 py-0.5 rounded-full bg-red-50 text-primary-container text-[10px] font-bold">BARU</span> @endunless
        </p>
        <p class="text-xs text-gray-500 truncate">{{ $q->message }}</p>
      </div>
      <span class="text-xs text-gray-400 whitespace-nowrap">{{ $q->created_at->diffForHumans() }}</span>
    </div>
  @empty
    <p class="px-5 py-10 text-center text-sm text-gray-500">Belum ada pesan masuk.</p>
  @endforelse
</div>
@endsection