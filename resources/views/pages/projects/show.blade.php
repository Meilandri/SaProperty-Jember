@extends('layouts.app')

@section('title', $item['title'] . ' - SA Properti')

@php
  $img = str_starts_with($item['image'], 'http') ? $item['image'] : asset($item['image']);
  $wa  = 'https://wa.me/' . Setting::get('whatsapp') . '?text=' . rawurlencode('Halo SA Properti, saya tertarik dengan proyek seperti "' . $item['title'] . '". Bisa konsultasi?');
@endphp

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pt-8 pb-16">

  <a href="{{ route('projects.index') }}"
   class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full bg-white border border-surface-container-high text-sm font-semibold hover:bg-primary-container hover:text-white hover:border-primary-container transition-colors">
  <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Proyek
  </a>

  <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

    <div data-reveal="left" class="lg:col-span-3 space-y-8">
      @include('partials.gallery', ['item' => $item])

      <div>
        <h2 class="text-xl font-bold mb-3">Tentang Proyek</h2>
        <p class="text-gray-600 leading-relaxed">{{ $item['desc'] }}</p>
      </div>

      <div>
        <h2 class="text-xl font-bold mb-3">Sorotan</h2>
        <ul class="space-y-2.5">
          @foreach ($item['highlights'] as $h)
            <li class="flex items-start gap-3 text-gray-700">
              <i class="fa-solid fa-circle-check text-secondary mt-1"></i> <span>{{ $h }}</span>
            </li>
          @endforeach
        </ul>
      </div>
    </div>

    <aside data-reveal="right" class="lg:col-span-2">
      <div class="lg:sticky lg:top-36 bg-white border border-surface-container-high rounded-3xl p-6 shadow-sm space-y-5">
        <span class="inline-block px-3.5 py-1.5 rounded-full bg-on-surface text-surface text-xs font-semibold">
          {{ $item['category_label'] }}
        </span>
        <h1 class="text-2xl font-extrabold leading-snug">{{ $item['title'] }}</h1>

        <div class="grid grid-cols-2 gap-3 p-4 bg-surface-container-low rounded-2xl">
          <div><span class="block text-[11px] text-gray-400 uppercase">Luas Tanah</span><span class="font-bold text-sm">{{ $item['lt'] }}</span></div>
          <div><span class="block text-[11px] text-gray-400 uppercase">Luas Bangunan</span><span class="font-bold text-sm">{{ $item['lb'] }}</span></div>
          <div><span class="block text-[11px] text-gray-400 uppercase">Durasi</span><span class="font-bold text-sm">{{ $item['duration'] }}</span></div>
          <div><span class="block text-[11px] text-gray-400 uppercase">Status</span><span class="font-bold text-sm">{{ $item['badge'] }}</span></div>
        </div>

        <p class="text-sm text-gray-500"><i class="fa-solid fa-location-dot text-primary-container mr-2"></i>{{ $item['location'] }}</p>

        <a href="{{ $wa }}" target="_blank"
           class="press flex items-center justify-center gap-2 w-full py-3.5 rounded-full bg-green-500 hover:bg-green-600 text-white font-bold text-sm transition-colors">
          <i class="fa-brands fa-whatsapp text-lg"></i> Konsultasi Proyek Serupa
        </a>
      </div>
    </aside>
  </div>
</section>

<section class="bg-surface-container-low py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
    <h2 data-reveal class="text-2xl font-extrabold mb-8">Proyek Lainnya</h2>
    <div data-stagger class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach ($related as $r)
        <x-portfolio-card :item="$r" />
      @endforeach
    </div>
  </div>
</section>

@include('partials.cta')
@endsection