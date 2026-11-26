@extends('layouts.app')

@section('title', 'Tentang Kami - SA Properti')

@section('content')

<section class="relative w-full pt-14 pb-12 overflow-hidden">
  <div class="floaty absolute -top-24 -right-24 w-96 h-96 rounded-full bg-primary-container/5 blur-3xl pointer-events-none"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 relative z-10 space-y-5">
    <div class="hero-in inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-fixed text-on-primary-fixed text-sm font-semibold tracking-wider uppercase">
      <span class="w-2 h-2 rounded-full bg-primary-container"></span> Tentang Kami
    </div>
    <h1 class="hero-in hero-in-2 text-3xl lg:text-5xl font-extrabold tracking-tight max-w-3xl">{{ Setting::get('about_title') }}</h1>
    <p class="hero-in hero-in-3 text-lg text-tertiary max-w-2xl">{{ Setting::get('about_intro') }}</p>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pb-16">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
    <div data-reveal="left" class="rounded-3xl overflow-hidden bg-surface-container aspect-[4/3]">
      <img src="{{ asset(Setting::get('about_image')) }}" alt="SA Properti" class="w-full h-full object-cover" loading="lazy">
    </div>
    <div data-reveal="right" class="space-y-4">
      <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Siapa Kami</h2>
      <p class="text-gray-600 leading-relaxed">{{ Setting::get('about_story_1') }}</p>
      <p class="text-gray-600 leading-relaxed">{{ Setting::get('about_story_2') }}</p>
    </div>
  </div>
</section>

<section class="bg-brand-dark text-white py-14">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
    @foreach (array_slice(Setting::lines('about_stats'), 0, 4) as $line)
      @php [$num, $label] = array_pad(explode('|', $line, 2), 2, ''); @endphp
      <div>
        <p data-count class="text-3xl sm:text-4xl font-extrabold text-primary-container">{{ trim($num) }}</p>
        <p class="mt-1 text-sm text-gray-300">{{ trim($label) }}</p>
      </div>
    @endforeach
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-16">
  <div data-stagger class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="lift bg-white border border-surface-container-high rounded-3xl p-8 shadow-sm">
      <div class="w-12 h-12 bg-red-50 text-primary-container rounded-xl flex items-center justify-center text-xl mb-5"><i class="fa-solid fa-eye"></i></div>
      <h3 class="text-xl font-bold mb-2">Visi</h3>
      <p class="text-gray-600 leading-relaxed">{{ Setting::get('about_vision') }}</p>
    </div>
    <div class="lift bg-white border border-surface-container-high rounded-3xl p-8 shadow-sm">
      <div class="w-12 h-12 bg-red-50 text-primary-container rounded-xl flex items-center justify-center text-xl mb-5"><i class="fa-solid fa-bullseye"></i></div>
      <h3 class="text-xl font-bold mb-2">Misi</h3>
      <ul class="space-y-2 text-gray-600">
        @foreach (Setting::lines('about_mission') as $m)
          <li class="flex gap-3"><i class="fa-solid fa-circle-check text-secondary mt-1"></i> <span>{{ $m }}</span></li>
        @endforeach
      </ul>
    </div>
  </div>
</section>

<section class="bg-surface-container-low py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
    <div data-reveal class="text-center max-w-2xl mx-auto mb-12">
      <span class="text-primary-container font-bold text-xs uppercase tracking-widest">Cara Kerja</span>
      <h2 class="text-2xl sm:text-3xl font-bold mt-1">Alur Kerja Bersama SA Properti</h2>
    </div>
    <div data-stagger class="grid grid-cols-1 md:grid-cols-4 gap-6">
      @foreach ([
        ['Konsultasi', 'Ceritakan kebutuhan dan anggaran Anda, gratis.'],
        ['Survei & Desain', 'Survei lokasi, denah, dan simulasi 3D.'],
        ['RAB & Kontrak', 'Rincian biaya terbuka dan kontrak jelas.'],
        ['Pembangunan', 'Pengerjaan dengan laporan progres mingguan.'],
      ] as $i => [$title, $text])
        <div class="lift bg-white rounded-2xl p-6 border border-surface-container-high">
          <span class="w-9 h-9 rounded-full bg-primary-container text-white font-bold flex items-center justify-center mb-4">{{ $i + 1 }}</span>
          <h4 class="font-bold mb-1">{{ $title }}</h4>
          <p class="text-sm text-gray-600">{{ $text }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

@include('partials.cta', ['title' => 'Siap Memulai Proyek Anda?', 'text' => 'Ceritakan rencana Anda, tim kami akan membantu dari survei hingga serah terima.'])

@endsection