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
  $unread = \App\Models\Inquiry::whereNull('read_at')->count();
  $menu = [
    ['admin.dashboard', 'Dashboard', 'fa-gauge'],
    ['admin.inquiries.index', 'Pesan Masuk', 'fa-envelope'],
  ];
@endphp

<div class="min-h-screen md:flex">

  {{-- Sidebar (di HP menjadi bar atas) --}}
  <aside class="bg-brand-dark text-white md:w-64 md:fixed md:inset-y-0 md:flex md:flex-col">
    <div class="px-5 h-14 md:h-16 flex items-center justify-between md:border-b md:border-white/10">
      <p class="font-extrabold tracking-wider text-sm uppercase">SA <span class="text-primary-container">Properti</span> <span class="text-gray-400 font-medium normal-case tracking-normal">Admin</span></p>
      <form method="POST" action="{{ route('logout') }}" class="md:hidden">@csrf
        <button class="text-gray-300 hover:text-white text-sm"><i class="fa-solid fa-right-from-bracket"></i></button>
      </form>
    </div>

    <nav class="flex md:flex-col gap-1 px-3 pb-3 md:py-4 overflow-x-auto md:flex-1">
      @foreach ($menu as [$route, $label, $icon])
        @php $active = request()->routeIs($route); @endphp
        <a href="{{ route($route) }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium whitespace-nowrap transition-colors {{ $active ? 'bg-primary-container text-white' : 'text-gray-300 hover:bg-white/10' }}">
          <i class="fa-solid {{ $icon }} w-4 text-center"></i> {{ $label }}
          @if ($route === 'admin.inquiries.index' && $unread > 0)
            <span class="ml-auto px-2 py-0.5 rounded-full bg-white text-primary-container text-[11px] font-bold">{{ $unread }}</span>
          @endif
        </a>
      @endforeach
      <a href="{{ route('home') }}" target="_blank"
         class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium whitespace-nowrap text-gray-300 hover:bg-white/10">
        <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center"></i> Lihat Website
      </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="hidden md:block p-3 border-t border-white/10">@csrf
      <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-gray-300 hover:bg-white/10">
        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Keluar
      </button>
    </form>
  </aside>

  {{-- Konten --}}
  <main class="flex-1 md:ml-64 p-4 sm:p-6 lg:p-10">
    @if (session('status'))
      <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm">{{ session('status') }}</div>
    @endif
    @yield('content')
  </main>
</div>

</body>
</html>