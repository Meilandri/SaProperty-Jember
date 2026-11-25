@extends('layouts.app')

@section('content')

{{-- HERO --}}
<section class="relative bg-brand-dark text-white overflow-hidden hero-curved-bottom shadow-xl">
  <div class="absolute inset-0 z-0">
    <img src="{{ asset(Setting::get('hero_image')) }}" alt="SA Properti"
         class="w-full h-full object-cover brightness-[0.82]" style="object-position: left center;">
    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/60"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-transparent to-black/50"></div>
  </div>

  <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-[480px] lg:min-h-[560px] flex items-center py-16">
    <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-8">
      <div class="hidden lg:block lg:col-span-5"></div>
      <div class="lg:col-span-7 flex flex-col items-start lg:items-end text-left lg:text-right">
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight max-w-2xl">
          {{ Setting::get('hero_title') }}
        </h1>
        <p class="mt-4 text-sm sm:text-base text-gray-200 leading-relaxed max-w-xl">
          {{ Setting::get('hero_subtitle') }}
        </p>
        <div class="mt-8">
          <a href="{{ route('projects.index') }}"
             class="inline-block px-8 py-3 rounded-full bg-white text-brand-dark font-bold text-sm hover:bg-brand-red hover:text-white transition">Lihat Proyek</a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- 3 PROYEK TERBARU --}}
<section class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" id="proyek">
  <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
      <span class="text-xs uppercase font-bold tracking-widest text-brand-red block mb-1">Portofolio Unggulan</span>
      <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">Proyek Terbaru Kami</h2>
    </div>
    <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-primary-container hover:underline">
      Lihat semua proyek <i class="fa-solid fa-arrow-right text-xs ml-1"></i>
    </a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach ($projects as $item)
      <x-portfolio-card :item="$item" />
    @endforeach
  </div>
</section>

@include('partials.features')
@include('partials.cta')

@endsection