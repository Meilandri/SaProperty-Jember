@extends('layouts.app')

@section('title', 'Katalog Layanan - SA Properti')

@section('content')

{{-- HERO --}}
<section class="relative bg-brand-dark text-white overflow-hidden hero-curved-bottom shadow-xl">
  <div class="absolute inset-0 z-0">
    <img src="{{ asset('images/katalog-hero.jpg') }}" alt="Katalog SA Properti"
         class="hero-bg w-full h-full object-cover brightness-[0.75]" style="object-position: center 35%;">
    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/60"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
  </div>
  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 py-20 lg:py-28">
    <h1 class="hero-in text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight max-w-2xl">Katalog Layanan & Solusi Properti</h1>
    <p class="hero-in hero-in-2 mt-4 text-sm sm:text-base text-gray-200 max-w-xl">Dari bangun rumah, renovasi, kavling tanah, hingga legalitas, semua dalam satu tempat.</p>
  </div>
</section>

{{-- DAFTAR --}}
<section class="w-full py-16 md:py-24 max-w-7xl mx-auto px-6 lg:px-12">

  <div data-reveal class="mb-10">
    <span class="text-xs uppercase font-bold tracking-widest text-primary-container block mb-1">4 Pilar Layanan Unggulan</span>
    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">Katalog Layanan & Solusi Properti Terpadu</h2>
    <p class="mt-2 text-xs sm:text-sm text-gray-500 max-w-3xl leading-relaxed">
      Solusi terlengkap mulai dari bangun rumah impian, renovasi modern, kavling tanah siap bangun, hingga pengurusan legalitas PBG/SLF dan sertifikat resmi.
    </p>
  </div>

  {{-- Filter & urutan --}}
  <div class="bg-white border border-surface-container-high p-4 rounded-2xl flex flex-col md:flex-row gap-4 md:items-center justify-between mb-12 shadow-sm">

    <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
      @foreach (['all' => 'Semua Layanan'] + $categories as $key => $label)
        <a href="{{ route('catalog.index', ['kategori' => $key, 'urut' => $sort, 'q' => $q]) }}"
           class="px-5 py-2 rounded-full text-sm font-semibold whitespace-nowrap shrink-0 transition-colors
                  {{ $active === $key ? 'bg-brand-dark text-white shadow-sm' : 'bg-surface-container text-on-surface hover:bg-surface-container-high' }}">
          {{ $label }}
        </a>
      @endforeach
    </div>

    <form method="GET" action="{{ route('catalog.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2">
      <input type="hidden" name="kategori" value="{{ $active }}">

      <div class="flex items-center bg-surface-container-low px-4 py-2 rounded-xl text-sm">
        <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2"></i>
        <input type="search" name="q" value="{{ $q }}" placeholder="Cari layanan..."
               class="bg-transparent focus:outline-none w-full sm:w-48">
      </div>

      <div class="relative flex items-center bg-surface-container-low px-4 py-2 rounded-xl text-sm">
        <i class="fa-solid fa-arrow-up-wide-short text-secondary mr-2"></i>
        <select name="urut" onchange="this.form.submit()"
                class="bg-transparent focus:outline-none cursor-pointer appearance-none pr-6 font-medium">
          <option value="terbaru"    @selected($sort === 'terbaru')>Terbaru</option>
          <option value="price-low"  @selected($sort === 'price-low')>Biaya Terendah</option>
          <option value="price-high" @selected($sort === 'price-high')>Biaya Tertinggi</option>
        </select>
        <i class="fa-solid fa-chevron-down text-xs pointer-events-none absolute right-3 text-gray-400"></i>
      </div>
    </form>
  </div>

  {{-- Kartu --}}
  <div data-stagger class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
    @forelse ($items as $item)
      <x-catalog-card :item="$item" :categories="$categories" />
    @empty
      <p class="col-span-full text-center text-gray-500 py-12">Belum ada layanan pada kategori ini.</p>
    @endforelse
  </div>

  <div class="mt-10">{{ $items->links() }}</div>
</section>

@include('partials.features')
@include('partials.cta')

@endsection