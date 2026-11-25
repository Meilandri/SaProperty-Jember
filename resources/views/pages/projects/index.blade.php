@extends('layouts.app')

@section('title', 'Portofolio Proyek - SA Properti')

@section('content')

{{-- HEADER --}}
<section class="relative w-full pt-16 pb-14 overflow-hidden">
  <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-primary-container/5 blur-3xl pointer-events-none"></div>
  <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 space-y-5">
    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-fixed text-on-primary-fixed text-sm font-semibold tracking-wider uppercase">
      <span class="w-2 h-2 rounded-full bg-primary-container"></span> Portofolio Terpilih
    </div>
    <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight max-w-3xl">Karya & Proyek Konstruksi Terpercaya</h1>
    <p class="text-lg text-tertiary max-w-2xl">
      Rekam jejak pembangunan rumah baru, renovasi modern, pengembangan kavling, hingga pendampingan legalitas di Jabodetabek & sekitarnya.
    </p>
  </div>
</section>

{{-- FILTER --}}
<section class="w-full pb-10">
  <div class="max-w-7xl mx-auto px-6 lg:px-12">
    <div class="bg-white rounded-2xl p-4 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-4">

      <div class="flex flex-wrap items-center gap-2.5">
        @foreach (['all' => 'Semua Proyek'] + $categories as $key => $label)
          <a href="{{ route('projects.index', ['kategori' => $key, 'urut' => $sort]) }}"
             class="h-12 px-5 rounded-full text-sm font-semibold inline-flex items-center transition-all
                    {{ $active === $key ? 'bg-on-surface text-surface' : 'bg-surface-container text-on-surface hover:bg-surface-container-high' }}">
            {{ $label }}
          </a>
        @endforeach
      </div>

      <form method="GET" action="{{ route('projects.index') }}" class="flex items-center gap-3 shrink-0">
        <input type="hidden" name="kategori" value="{{ $active }}">
        <span class="text-sm font-semibold text-tertiary">Urutkan:</span>
        <div class="relative">
          <select name="urut" onchange="this.form.submit()"
                  class="h-12 pl-4 pr-10 rounded-xl bg-surface-container text-sm font-semibold appearance-none focus:outline-none cursor-pointer">
            <option value="terbaru"    @selected($sort === 'terbaru')>Terbaru</option>
            <option value="terpopuler" @selected($sort === 'terpopuler')>Terpopuler</option>
          </select>
          <i class="fa-solid fa-chevron-down text-xs absolute right-4 top-1/2 -translate-y-1/2 text-tertiary pointer-events-none"></i>
        </div>
      </form>
    </div>
  </div>
</section>

{{-- GRID --}}
<section class="w-full pb-20">
  <div class="max-w-7xl mx-auto px-6 lg:px-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse ($items as $item)
        <x-portfolio-card :item="$item" />
      @empty
        <p class="col-span-full text-center text-gray-500 py-12">Belum ada proyek pada kategori ini.</p>
      @endforelse
    </div>
  </div>
</section>

{{-- TESTIMONI --}}
<section class="w-full bg-surface-container-low py-20">
  <div class="max-w-7xl mx-auto px-6 lg:px-12">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
      <div class="space-y-3">
        <span class="text-sm font-semibold text-primary-container tracking-wider uppercase">Kepercayaan Klien</span>
        <h2 class="text-3xl lg:text-4xl font-bold">Apa Kata Klien Kami?</h2>
      </div>
      <p class="text-tertiary max-w-md">Kepuasan pemilik hunian dan investor adalah standar utama dalam setiap serah terima proyek SA Properti.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @foreach ($testimonials as $t)
        <div class="bg-white rounded-3xl p-8 shadow-sm flex flex-col justify-between gap-6">
          <div class="space-y-4">
            <div class="flex items-center gap-1 text-primary-container">
              @for ($i = 0; $i < 5; $i++)
                <i class="fa-solid fa-star"></i>
              @endfor
            </div>
            <p class="leading-relaxed">“{{ $t['text'] }}”</p>
          </div>
          <div class="flex items-center gap-3 pt-2">
            <div class="w-11 h-11 rounded-full bg-primary-fixed text-on-primary-fixed flex items-center justify-center font-semibold">
              {{ $t['initial'] }}
            </div>
            <div>
              <p class="font-semibold">{{ $t['name'] }}</p>
              <p class="text-sm text-tertiary">{{ $t['role'] }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

@include('partials.cta', [
  'title' => 'Ingin Proyek Anda Menjadi Karya Kami Berikutnya?',
  'text'  => 'Konsultasikan rencana bangun baru, renovasi, atau pengurusan legalitas properti Anda bersama tim arsitek & sipil kami.',
])

@endsection