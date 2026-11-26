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
  $dashboard = [route('admin.dashboard'), 'Dashboard', 'fa-gauge', request()->routeIs('admin.dashboard')];
  $catalog   = [route('admin.catalog.index'), 'Katalog', 'fa-book-open', request()->routeIs('admin.catalog.*')];
  $projects  = [route('admin.projects.index'), 'Proyek', 'fa-building', request()->routeIs('admin.projects.*')];
  $category  = [route('admin.categories.index'), 'Kategori', 'fa-tags', request()->routeIs('admin.categories.*')];
  $testi     = [route('admin.testimonials.index'), 'Testimoni', 'fa-comments', request()->routeIs('admin.testimonials.*')];
  $account   = [route('admin.account.index'), 'Admin & Password', 'fa-user-shield', request()->routeIs('admin.account.*')];
  $settings  = collect(\App\Models\Setting::groups())->map(fn ($g, $key) => [
      route('admin.settings.edit', $key), $g['label'], $g['icon'], request()->is('admin/pengaturan/'.$key),
  ])->values()->all();

  // Sidebar desktop
  $menu = [
    ['Utama', [$dashboard]],
    ['Konten', [$catalog, $projects, $category, $testi]],
    ['Pengaturan Situs', $settings],
    ['Akun', [$account]],
  ];

  // Mobile: 4 menu utama + panel "Lainnya"
  $primary = [$dashboard, $catalog, $projects, $category];
  $more = array_merge([$testi], $settings, [$account]);
  $moreActive = collect($more)->contains(fn ($l) => $l[3]);
@endphp

{{-- ===== Bar atas (mobile) ===== --}}
<header class="md:hidden bg-brand-dark text-white h-14 px-5 flex items-center">
  <p class="font-extrabold tracking-wider text-sm uppercase">SA <span class="text-primary-container">Properti</span> <span class="text-gray-400 font-medium normal-case tracking-normal">Admin</span></p>
</header>

{{-- ===== Sidebar (desktop) ===== --}}
<aside class="hidden md:flex md:flex-col bg-brand-dark text-white w-64 fixed inset-y-0 left-0">
  <div class="px-5 h-16 flex items-center border-b border-white/10">
    <p class="font-extrabold tracking-wider text-sm uppercase">SA <span class="text-primary-container">Properti</span> <span class="text-gray-400 font-medium normal-case tracking-normal">Admin</span></p>
  </div>

  <nav class="no-scrollbar flex-1 overflow-y-auto px-3 py-4">
    @foreach ($menu as [$section, $links])
      <p class="px-4 pt-4 pb-1 text-[11px] uppercase tracking-widest text-gray-500">{{ $section }}</p>
      @foreach ($links as $l)
        <a href="{{ $l[0] }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium whitespace-nowrap transition-colors {{ $l[3] ? 'bg-primary-container text-white' : 'text-gray-300 hover:bg-white/10' }}">
          <i class="fa-solid {{ $l[2] }} w-4 text-center"></i> {{ $l[1] }}
        </a>
      @endforeach
    @endforeach
    <a href="{{ route('home') }}" target="_blank"
       class="mt-4 flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:bg-white/10">
      <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center"></i> Lihat Website
    </a>
  </nav>

  <form method="POST" action="{{ route('logout') }}" class="p-3 border-t border-white/10">@csrf
    <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-gray-300 hover:bg-white/10">
      <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Keluar
    </button>
  </form>
</aside>

{{-- ===== Konten ===== --}}
<main class="md:ml-64 p-4 sm:p-6 lg:p-10 pb-28 md:pb-10 min-w-0">
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

{{-- ===== Panel "Lainnya" (mobile) ===== --}}
<div id="more-backdrop" class="hidden md:hidden fixed inset-0 z-40 bg-black/50"></div>

<div id="more-sheet" class="hidden md:hidden fixed inset-x-0 bottom-0 z-[45] bg-white rounded-t-3xl p-5 pb-24 max-h-[80vh] overflow-y-auto no-scrollbar shadow-2xl">
  <div class="w-10 h-1 rounded-full bg-gray-300 mx-auto mb-4"></div>

  <div class="grid grid-cols-2 gap-2">
    @foreach ($more as $l)
      <a href="{{ $l[0] }}"
         class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ $l[3] ? 'bg-primary-container text-white' : 'bg-surface-container text-brand-dark' }}">
        <i class="fa-solid {{ $l[2] }} w-4 text-center"></i> {{ $l[1] }}
      </a>
    @endforeach
    <a href="{{ route('home') }}" target="_blank"
       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold bg-surface-container">
      <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center"></i> Lihat Website
    </a>
  </div>

  <form method="POST" action="{{ route('logout') }}" class="mt-3">@csrf
    <button class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold bg-red-50 text-primary-container">
      <i class="fa-solid fa-right-from-bracket"></i> Keluar
    </button>
  </form>
</div>

{{-- ===== Navigasi bawah (mobile) ===== --}}
<nav class="md:hidden fixed bottom-0 inset-x-0 z-50 bg-white border-t border-gray-200 pb-[env(safe-area-inset-bottom)]">
  <div class="grid grid-cols-5">
    @foreach ($primary as $l)
      <a href="{{ $l[0] }}"
         class="relative flex flex-col items-center gap-1 py-2.5 text-[11px] {{ $l[3] ? 'text-primary-container font-bold' : 'text-gray-500' }}">
        @if ($l[3]) <span class="absolute top-0 h-0.5 w-8 rounded-full bg-primary-container"></span> @endif
        <i class="fa-solid {{ $l[2] }} text-lg"></i>
        {{ $l[1] }}
      </a>
    @endforeach

    <button type="button" id="more-toggle"
            class="relative flex flex-col items-center gap-1 py-2.5 text-[11px] {{ $moreActive ? 'text-primary-container font-bold' : 'text-gray-500' }}">
      @if ($moreActive) <span class="absolute top-0 h-0.5 w-8 rounded-full bg-primary-container"></span> @endif
      <i class="fa-solid fa-ellipsis text-lg"></i>
      Lainnya
    </button>
  </div>
</nav>

<script>
  (function () {
    const sheet = document.getElementById('more-sheet');
    const backdrop = document.getElementById('more-backdrop');
    const toggle = document.getElementById('more-toggle');
    const set = (open) => {
      sheet.classList.toggle('hidden', !open);
      backdrop.classList.toggle('hidden', !open);
    };
    toggle.addEventListener('click', () => set(sheet.classList.contains('hidden')));
    backdrop.addEventListener('click', () => set(false));
  })();
</script>

@stack('scripts')
</body>
</html>