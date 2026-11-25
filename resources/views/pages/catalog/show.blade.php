@extends('layouts.app')

@section('title', $item['title'] . ' - SA Properti')

@php
  $img = str_starts_with($item['image'], 'http') ? $item['image'] : asset($item['image']);
  $wa  = 'https://wa.me/6281234567890?text=' . rawurlencode('Halo SA Properti, saya tertarik dengan ' . $item['title'] . '. Bisa minta informasi lebih lanjut?');
@endphp

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pt-8 pb-16">

  <a href="{{ route('catalog.index') }}"
   class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full bg-white border border-surface-container-high text-sm font-semibold hover:bg-primary-container hover:text-white hover:border-primary-container transition-colors">
  <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Katalog
  </a>

  <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

    {{-- Kiri: gambar & isi --}}
    <div class="lg:col-span-3 space-y-8">
      <div class="rounded-3xl overflow-hidden bg-surface-container aspect-[4/3]">
        <img src="{{ $img }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover">
      </div>

      <div>
        <h2 class="text-xl font-bold mb-3">Deskripsi</h2>
        <p class="text-gray-600 leading-relaxed">{{ $item['long'] }}</p>
      </div>

      <div>
        <h2 class="text-xl font-bold mb-3">Yang Anda Dapatkan</h2>
        <ul class="space-y-2.5">
          @foreach ($item['features'] as $f)
            <li class="flex items-start gap-3 text-gray-700">
              <i class="fa-solid fa-circle-check text-secondary mt-1"></i> <span>{{ $f }}</span>
            </li>
          @endforeach
        </ul>
      </div>

      @isset($item['location'])
        <div>
          <h2 class="text-xl font-bold mb-3">Lokasi</h2>
          <x-location-map :location="$item['location']" />
        </div>
      @endisset
    </div>

    {{-- Kanan: ringkasan --}}
    <aside class="lg:col-span-2">
      <div class="lg:sticky lg:top-36 bg-white border border-surface-container-high rounded-3xl p-6 shadow-sm space-y-5">
        <span class="inline-block px-3.5 py-1.5 rounded-full bg-on-surface text-surface text-xs font-semibold">
          {{ $categories[$item['category']] }}
        </span>
        <div>
          <h1 class="text-2xl font-extrabold leading-snug">{{ $item['title'] }}</h1>
          <p class="text-sm text-gray-400 mt-1">{{ $item['size'] }}</p>
        </div>

        <div class="grid grid-cols-2 gap-3 p-4 bg-surface-container-low rounded-2xl">
          @foreach ($item['specs'] as [$label, $value])
            <div>
              <span class="block text-[11px] text-gray-400 uppercase">{{ $label }}</span>
              <span class="font-bold text-sm">{{ $value }}</span>
            </div>
          @endforeach
        </div>

        <div class="pt-2 border-t border-surface-container-high">
          <span class="text-xs text-gray-400">{{ $item['price_note'] }}</span>
          <p class="text-2xl font-extrabold text-primary-container">{{ $item['price_text'] }}</p>
        </div>

        <a href="{{ $wa }}" target="_blank"
           class="flex items-center justify-center gap-2 w-full py-3.5 rounded-full bg-green-500 hover:bg-green-600 text-white font-bold text-sm transition-colors">
          <i class="fa-brands fa-whatsapp text-lg"></i> Tanya via WhatsApp
        </a>
      </div>
    </aside>
  </div>
</section>

{{-- Lainnya --}}
<section class="bg-surface-container-low py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
    <h2 class="text-2xl font-extrabold mb-8">Layanan Lainnya</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
      @foreach ($related as $r)
        <x-catalog-card :item="$r" :categories="$categories" />
      @endforeach
    </div>
  </div>
</section>

@include('partials.cta')
@endsection