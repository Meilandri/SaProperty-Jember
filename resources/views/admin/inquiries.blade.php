@extends('layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')
<h1 class="text-2xl font-extrabold mb-6">Pesan Masuk</h1>

<div class="space-y-4">
  @forelse ($inquiries as $q)
    <div class="bg-white border rounded-2xl p-5 shadow-sm {{ $q->read_at ? 'border-surface-container-high' : 'border-primary-container/40' }}">
      <div class="flex flex-wrap items-start justify-between gap-2">
        <div>
          <p class="font-bold">
            {{ $q->name }}
            @unless ($q->read_at) <span class="ml-1 px-2 py-0.5 rounded-full bg-red-50 text-primary-container text-[10px] font-bold">BARU</span> @endunless
          </p>
          <p class="text-xs text-gray-500 mt-0.5">
            {{ $q->phone }}@if ($q->email) &middot; {{ $q->email }}@endif
          </p>
        </div>
        <span class="text-xs text-gray-400">{{ $q->created_at->translatedFormat('d M Y, H:i') }}</span>
      </div>

      @if ($q->service)
        <span class="inline-block mt-3 px-3 py-1 rounded-full bg-surface-container text-xs font-semibold">{{ $q->service }}</span>
      @endif

      <p class="mt-3 text-sm text-gray-700 whitespace-pre-line">{{ $q->message }}</p>

      <div class="mt-4 flex flex-wrap gap-2">
        <a href="{{ $q->wa_link }}" target="_blank"
           class="px-4 py-2 rounded-full bg-green-500 hover:bg-green-600 text-white text-xs font-bold">
          <i class="fa-brands fa-whatsapp mr-1"></i> Balas WhatsApp
        </a>

        @unless ($q->read_at)
          <form method="POST" action="{{ route('admin.inquiries.read', $q) }}">@csrf @method('PATCH')
            <button class="px-4 py-2 rounded-full bg-surface-container hover:bg-surface-container-high text-xs font-semibold">Tandai dibaca</button>
          </form>
        @endunless

        <form method="POST" action="{{ route('admin.inquiries.destroy', $q) }}"
              onsubmit="return confirm('Hapus pesan ini?')">@csrf @method('DELETE')
          <button class="px-4 py-2 rounded-full bg-red-50 hover:bg-primary-container hover:text-white text-primary-container text-xs font-semibold transition-colors">Hapus</button>
        </form>
      </div>
    </div>
  @empty
    <div class="bg-white border border-surface-container-high rounded-2xl p-12 text-center text-gray-500 text-sm">Belum ada pesan masuk.</div>
  @endforelse
</div>

<div class="mt-6">{{ $inquiries->links() }}</div>
@endsection