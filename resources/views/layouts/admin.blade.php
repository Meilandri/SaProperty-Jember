<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex">
  <title>@yield('title', 'Dashboard') - Admin SA Properti</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-brand-dark font-sans antialiased">

@php
  $menu = [
  ['Utama', [
    [route('admin.dashboard'), 'Dashboard', 'fa-gauge', request()->routeIs('admin.dashboard')],
  ]],
  ['Konten', [
    [route('admin.catalog.index'), 'Katalog', 'fa-book-open', request()->routeIs('admin.catalog.*')],
    [route('admin.projects.index'), 'Proyek', 'fa-building', request()->routeIs('admin.projects.*')],
    [route('admin.categories.index'), 'Kategori', 'fa-tags', request()->routeIs('admin.categories.*')],
    [route('admin.testimonials.index'), 'Testimoni', 'fa-comments', request()->routeIs('admin.testimonials.*')],
  ]],
  ['Pengaturan Situs', collect(\App\Models\Setting::groups())->map(fn ($g, $key) => [
    route('admin.settings.edit', $key), $g['label'], $g['icon'], request()->is('admin/pengaturan/'.$key),
  ])->values()->all()],
  ['Akun', [
    [route('admin.account.index'), 'Admin & Password', 'fa-user-shield', request()->routeIs('admin.account.*')],
  ]],
];
@endphp

<div class="min-h-screen md:flex">

  <aside class="bg-brand-dark text-white md:w-64 md:fixed md:inset-y-0 md:flex md:flex-col">
    <div class="px-5 h-14 md:h-16 flex items-center justify-between md:border-b md:border-white/10">
      <p class="font-extrabold tracking-wider text-sm uppercase">SA <span class="text-primary-container">Properti</span> <span class="text-gray-400 font-medium normal-case tracking-normal">Admin</span></p>
      <form method="POST" action="{{ route('logout') }}" class="md:hidden">@csrf
        <button class="text-gray-300 hover:text-white text-sm" aria-label="Keluar"><i class="fa-solid fa-right-from-bracket"></i></button>
      </form>
    </div>

    <nav class="px-3 pb-3 md:py-4 md:flex-1 md:overflow-y-auto flex md:block gap-1 overflow-x-auto">
      @foreach ($menu as [$section, $links])
        <p class="hidden md:block px-4 pt-4 pb-1 text-[11px] uppercase tracking-widest text-gray-500">{{ $section }}</p>
        @foreach ($links as $l)
          <a href="{{ $l[0] }}"
             class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium whitespace-nowrap transition-colors {{ $l[3] ? 'bg-primary-container text-white' : 'text-gray-300 hover:bg-white/10' }}">
            <i class="fa-solid {{ $l[2] }} w-4 text-center"></i> {{ $l[1] }}
          </a>
        @endforeach
      @endforeach
      <a href="{{ route('home') }}" target="_blank"
         class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium whitespace-nowrap text-gray-300 hover:bg-white/10 md:mt-4">
        <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center"></i> Lihat Website
      </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="hidden md:block p-3 border-t border-white/10">@csrf
      <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-gray-300 hover:bg-white/10">
        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Keluar
      </button>
    </form>
  </aside>

  <main class="flex-1 md:ml-64 p-4 sm:p-6 lg:p-10 min-w-0">
    @if (session('status'))
      <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('status') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
        <p class="font-semibold mb-1">Ada isian yang perlu diperbaiki:</p>
        <ul class="list-disc pl-5 space-y-0.5">
          @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif
    @yield('content')
  </main>
</div>

@stack('scripts')
</body>
</html>