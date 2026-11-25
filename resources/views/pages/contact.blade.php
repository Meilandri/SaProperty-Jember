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
    <p class="text-lg text-tertiary max-w-2xl">Isi formulir di bawah atau hubungi kami langsung. Konsultasi dan survei lokasi tanpa biaya.</p>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pb-16">
  <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

    {{-- Info --}}
    <div class="lg:col-span-2 space-y-4">
      @foreach ([
        ['fa-phone', 'Telepon / WhatsApp', '+62 812-3456-7890', 'https://wa.me/6281234567890'],
        ['fa-envelope', 'Email', 'info@saproperti.com', 'mailto:info@saproperti.com'],
        ['fa-location-dot', 'Alamat', 'Grand Serpong Estate & Cilandak, Jakarta Selatan', null],
        ['fa-clock', 'Jam Operasional', 'Senin-Jumat 08.30-17.30 WIB, Sabtu 09.00-15.00 WIB', null],
      ] as [$icon, $label, $value, $href])
        <div class="bg-white border border-surface-container-high rounded-2xl p-5 flex gap-4 shadow-sm">
          <div class="w-11 h-11 shrink-0 bg-red-50 text-primary-container rounded-xl flex items-center justify-center"><i class="fa-solid {{ $icon }}"></i></div>
          <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide">{{ $label }}</p>
            @if ($href)
              <a href="{{ $href }}" target="_blank" class="font-semibold hover:text-primary-container">{{ $value }}</a>
            @else
              <p class="font-semibold">{{ $value }}</p>
            @endif
          </div>
        </div>
      @endforeach

      <a href="https://wa.me/6281234567890" target="_blank"
         class="flex items-center justify-center gap-2 w-full py-3.5 rounded-full bg-green-500 hover:bg-green-600 text-white font-bold text-sm transition-colors">
        <i class="fa-brands fa-whatsapp text-lg"></i> Chat via WhatsApp
      </a>
    </div>

    {{-- Form --}}
    <div class="lg:col-span-3">
      <form method="POST" action="{{ route('contact.store') }}"
            class="bg-white border border-surface-container-high rounded-3xl p-6 sm:p-8 shadow-sm space-y-5">
        @csrf

        @if (session('success'))
          <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
          </div>
        @endif

        {{-- Honeypot (disembunyikan) --}}
        <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

        @php
          $field = 'w-full px-4 py-3 rounded-xl border border-gray-200 bg-surface focus:outline-none focus:border-primary-container text-sm';
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div>
            <label for="name" class="block text-sm font-semibold mb-1.5">Nama <span class="text-primary-container">*</span></label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" class="{{ $field }}" required>
            @error('name') <p class="mt-1 text-xs text-primary">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="phone" class="block text-sm font-semibold mb-1.5">No. WhatsApp <span class="text-primary-container">*</span></label>
            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="0812xxxxxxx" class="{{ $field }}" required>
            @error('phone') <p class="mt-1 text-xs text-primary">{{ $message }}</p> @enderror
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div>
            <label for="email" class="block text-sm font-semibold mb-1.5">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="{{ $field }}">
            @error('email') <p class="mt-1 text-xs text-primary">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="service" class="block text-sm font-semibold mb-1.5">Layanan yang diminati</label>
            <select id="service" name="service" class="{{ $field }}">
              <option value="">Pilih layanan</option>
              @foreach ($services as $s)
                <option value="{{ $s }}" @selected(old('service') === $s)>{{ $s }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div>
          <label for="message" class="block text-sm font-semibold mb-1.5">Pesan <span class="text-primary-container">*</span></label>
          <textarea id="message" name="message" rows="5" class="{{ $field }}" required>{{ old('message') }}</textarea>
          @error('message') <p class="mt-1 text-xs text-primary">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-primary-container hover:bg-primary text-white font-bold text-sm transition-colors">
          Kirim Pesan
        </button>
      </form>
    </div>
  </div>

  {{-- Peta --}}
  <div class="mt-12">
    <x-location-map :location="['name' => 'Kantor SA Properti', 'address' => 'Grand Serpong Estate, Tangerang Selatan', 'query' => 'Grand Serpong Estate, Tangerang Selatan']" />
  </div>
</section>

@endsection