@extends('layouts.app')

@section('title', 'Kontak - SA Properti')

@section('content')

<section class="relative w-full pt-14 pb-10 overflow-hidden">
  <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-primary-container/5 blur-3xl pointer-events-none"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 relative z-10 space-y-4">
    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-fixed text-on-primary-fixed text-sm font-semibold tracking-wider uppercase">
      <span class="w-2 h-2 rounded-full bg-primary-container"></span> Hubungi Kami
    </div>
    <h1 class="text-3xl lg:text-5xl font-extrabold tracking-tight">Mari Diskusikan Rencana Anda</h1>
    <p class="text-lg text-tertiary max-w-2xl">Hubungi kami langsung atau kunjungi kantor kami. Konsultasi dan survei lokasi tanpa biaya.</p>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pb-16">
  <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

    {{-- Info kontak --}}
    <div class="lg:col-span-2 space-y-4">
      @php
        $info = [
          ['fa-phone', 'Telepon / WhatsApp', Setting::get('phone_display'), 'https://wa.me/' . Setting::get('whatsapp')],
          ['fa-envelope', 'Email', Setting::get('email'), 'mailto:' . Setting::get('email')],
          ['fa-location-dot', 'Alamat', Setting::get('address'), null],
          ['fa-clock', 'Jam Operasional', Setting::get('hours'), null],
        ];
      @endphp

      @foreach ($info as [$icon, $label, $value, $href])
        <div class="bg-white border border-surface-container-high rounded-2xl p-5 flex gap-4 shadow-sm">
          <div class="w-11 h-11 shrink-0 bg-red-50 text-primary-container rounded-xl flex items-center justify-center"><i class="fa-solid {{ $icon }}"></i></div>
          <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide">{{ $label }}</p>
            @if ($href)
              <a href="{{ $href }}" target="_blank" class="font-semibold hover:text-primary-container">{{ $value }}</a>
            @else
              <p class="font-semibold whitespace-pre-line">{{ $value }}</p>
            @endif
          </div>
        </div>
      @endforeach

      <a href="https://wa.me/{{ Setting::get('whatsapp') }}" target="_blank"
         class="flex items-center justify-center gap-2 w-full py-3.5 rounded-full bg-green-500 hover:bg-green-600 text-white font-bold text-sm transition-colors">
        <i class="fa-brands fa-whatsapp text-lg"></i> Chat via WhatsApp
      </a>
    </div>

    {{-- Lokasi (menggantikan form) --}}
    <div class="lg:col-span-3 space-y-4">

      {{-- Ikon sosial media di atas peta --}}
      <div class="bg-white border border-surface-container-high rounded-2xl p-5 shadow-sm flex flex-wrap items-center justify-between gap-4">
        <p class="font-semibold text-sm">Ikuti kami di sosial media</p>
        <div class="flex items-center gap-3">
          @foreach ([
            ['instagram', 'fa-instagram', 'Instagram'],
            ['facebook', 'fa-facebook-f', 'Facebook'],
            ['tiktok', 'fa-tiktok', 'TikTok'],
          ] as [$key, $icon, $name])
            <a href="{{ Setting::get($key) }}" target="_blank" rel="noopener" aria-label="{{ $name }}" title="{{ $name }}"
               class="w-11 h-11 rounded-full bg-red-50 text-primary-container flex items-center justify-center text-lg hover:bg-primary-container hover:text-white transition-colors">
              <i class="fa-brands {{ $icon }}"></i>
            </a>
          @endforeach
        </div>
      </div>

      <x-location-map :location="['name' => 'Kantor SA Properti', 'address' => Setting::get('address'), 'query' => Setting::get('map_query')]" />
    </div>
  </div>
</section>

@endsection