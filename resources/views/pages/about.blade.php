@extends('layouts.app')

@section('title', 'Tentang Kami - SA Properti')

@section('content')

{{-- HEADER --}}
<section class="relative w-full pt-14 pb-12 overflow-hidden">
  <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-primary-container/5 blur-3xl pointer-events-none"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 relative z-10 space-y-5">
    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-fixed text-on-primary-fixed text-sm font-semibold tracking-wider uppercase">
      <span class="w-2 h-2 rounded-full bg-primary-container"></span> Tentang Kami
    </div>
    <h1 class="text-3xl lg:text-5xl font-extrabold tracking-tight max-w-3xl">Mitra Terpercaya untuk Hunian dan Investasi Properti Anda</h1>
    <p class="text-lg text-tertiary max-w-2xl">
      SA Properti memadukan estetika, kekuatan struktur, dan efisiensi anggaran dalam setiap proyek rancang bangun, renovasi, dan pengurusan legalitas.
    </p>
  </div>
</section>

{{-- CERITA --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pb-16">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
    <div class="rounded-3xl overflow-hidden bg-surface-container aspect-[4/3]">
      <img src="{{ asset('images/tentang.jpg') }}" alt="Tim SA Properti" class="w-full h-full object-cover" loading="lazy">
    </div>
    <div class="space-y-4">
      <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Siapa Kami</h2>
      <p class="text-gray-600 leading-relaxed">
        PT SA Karya Properti Indonesia adalah perusahaan kontraktor arsitektur dan konsultan properti yang melayani Jabodetabek dan sekitarnya.
        Kami mendampingi klien dari tahap konsep, gambar kerja, perizinan, hingga serah terima kunci.
      </p>
      <p class="text-gray-600 leading-relaxed">
        Setiap proyek dikerjakan dengan RAB transparan, laporan progres rutin, dan garansi pemeliharaan setelah serah terima.
      </p>
    </div>
  </div>
</section>

{{-- ANGKA --}}
<section class="bg-brand-dark text-white py-14">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
    @foreach ([['50+', 'Proyek Selesai'], ['5+', 'Tahun Pengalaman'], ['12 Bln', 'Garansi Pemeliharaan'], ['100%', 'RAB Transparan']] as [$num, $label])
      <div>
        <p class="text-3xl sm:text-4xl font-extrabold text-primary-container">{{ $num }}</p>
        <p class="mt-1 text-sm text-gray-300">{{ $label }}</p>
      </div>
    @endforeach
  </div>
</section>

{{-- VISI MISI --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-16">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white border border-surface-container-high rounded-3xl p-8 shadow-sm">
      <div class="w-12 h-12 bg-red-50 text-primary-container rounded-xl flex items-center justify-center text-xl mb-5"><i class="fa-solid fa-eye"></i></div>
      <h3 class="text-xl font-bold mb-2">Visi</h3>
      <p class="text-gray-600 leading-relaxed">Menjadi perusahaan rancang bangun dan konsultan properti yang paling dipercaya di Indonesia.</p>
    </div>
    <div class="bg-white border border-surface-container-high rounded-3xl p-8 shadow-sm">
      <div class="w-12 h-12 bg-red-50 text-primary-container rounded-xl flex items-center justify-center text-xl mb-5"><i class="fa-solid fa-bullseye"></i></div>
      <h3 class="text-xl font-bold mb-2">Misi</h3>
      <ul class="space-y-2 text-gray-600">
        <li class="flex gap-3"><i class="fa-solid fa-circle-check text-secondary mt-1"></i> Memberikan biaya yang transparan dan terukur.</li>
        <li class="flex gap-3"><i class="fa-solid fa-circle-check text-secondary mt-1"></i> Mengutamakan kualitas struktur dan ketepatan waktu.</li>
        <li class="flex gap-3"><i class="fa-solid fa-circle-check text-secondary mt-1"></i> Mendampingi klien sampai legalitas selesai.</li>
      </ul>
    </div>
  </div>
</section>

{{-- ALUR KERJA --}}
<section class="bg-surface-container-low py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
    <div class="text-center max-w-2xl mx-auto mb-12">
      <span class="text-primary-container font-bold text-xs uppercase tracking-widest">Cara Kerja</span>
      <h2 class="text-2xl sm:text-3xl font-bold mt-1">Alur Kerja Bersama SA Properti</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      @foreach ([
        ['Konsultasi', 'Ceritakan kebutuhan dan anggaran Anda, gratis.'],
        ['Survei & Desain', 'Survei lokasi, denah, dan simulasi 3D.'],
        ['RAB & Kontrak', 'Rincian biaya terbuka dan kontrak jelas.'],
        ['Pembangunan', 'Pengerjaan dengan laporan progres mingguan.'],
      ] as $i => [$title, $text])
        <div class="bg-white rounded-2xl p-6 border border-surface-container-high">
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