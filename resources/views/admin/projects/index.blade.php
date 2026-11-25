@extends('layouts.admin')
@section('title', 'Proyek')

@section('content')
<div class="flex items-center justify-between gap-4 mb-6">
  <h1 class="text-2xl font-extrabold">Portofolio Proyek</h1>
  <a href="{{ route('admin.projects.create') }}"
     class="px-5 py-2.5 rounded-full bg-primary-container hover:bg-primary text-white text-sm font-bold transition-colors">
    <i class="fa-solid fa-plus mr-1"></i> Tambah
  </a>
</div>

<div class="bg-white border border-surface-container-high rounded-2xl shadow-sm divide-y divide-surface-container-high">
  @forelse ($items as $item)
    <div class="p-4 flex flex-col sm:flex-row sm:items-center gap-4">
      <img src="{{ asset($item->image) }}" alt="" class="w-full sm:w-24 h-32 sm:h-16 rounded-xl object-cover bg-surface-container">
      <div class="min-w-0 flex-1">
        <p class="font-bold truncate">{{ $item->title }}</p>
        <p class="text-xs text-gray-500 mt-0.5">
          {{ $item->category_label }}@if ($item->completed_at) &middot; {{ $item->completed_at->translatedFormat('d M Y') }}@endif
        </p>
        <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $item->is_published ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
          {{ $item->is_published ? 'Tayang' : 'Draf' }}
        </span>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('projects.show', $item->slug) }}" target="_blank" class="px-4 py-2 rounded-full bg-surface-container hover:bg-surface-container-high text-xs font-semibold">Lihat</a>
        <a href="{{ route('admin.projects.edit', $item) }}" class="px-4 py-2 rounded-full bg-brand-dark text-white text-xs font-semibold">Edit</a>
        <form method="POST" action="{{ route('admin.projects.destroy', $item) }}" onsubmit="return confirm('Hapus proyek ini?')">
          @csrf @method('DELETE')
          <button class="px-4 py-2 rounded-full bg-red-50 hover:bg-primary-container hover:text-white text-primary-container text-xs font-semibold transition-colors">Hapus</button>
        </form>
      </div>
    </div>
  @empty
    <p class="p-12 text-center text-sm text-gray-500">Belum ada proyek. Klik Tambah untuk memulai.</p>
  @endforelse
</div>

<div class="mt-6">{{ $items->links() }}</div>
@endsection