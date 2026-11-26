@php
  $links = [
    ['home', 'Beranda'],
    ['about', 'Tentang Kami'],
    ['catalog.index', 'Katalog'],
    ['projects.index', 'Proyek'],
    ['contact', 'Kontak'],
  ];
  $isActive = fn ($route) => request()->routeIs($route) || request()->routeIs(str_replace('.index', '.*', $route));
@endphp

<div id="site-header" class="fixed top-0 inset-x-0 z-50">

  <div class="bg-white border-b border-surface-container-high">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 h-14 flex items-center justify-between">

      <a href="{{ route('home') }}" class="flex items-center gap-2">
        <img src="{{ asset('images/logo.png') }}" alt="SA Properti" class="h-8 w-auto object-contain"
             onerror="this.style.display='none'">
        <span class="font-extrabold tracking-wider text-sm uppercase">SA <span class="text-primary-container">Properti</span></span>
      </a>

      <div class="flex items-center gap-4 text-gray-500 text-sm">
        <a href="{{ Setting::get('instagram') }}" target="_blank" class="hidden sm:block hover:text-primary transition-colors" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="{{ Setting::get('facebook') }}" target="_blank" class="hidden sm:block hover:text-primary transition-colors" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="{{ Setting::get('tiktok') }}" target="_blank" class="hidden sm:block hover:text-primary transition-colors" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>

        <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}"
           title="{{ auth()->check() ? 'Dashboard Admin' : 'Login' }}"
           class="w-9 h-9 rounded-full bg-red-50 text-primary-container flex items-center justify-center hover:bg-primary-container hover:text-white transition-colors">
          <i class="fa-solid fa-user text-sm"></i>
        </a>
      </div>
    </div>
  </div>

  <nav class="hidden md:block bg-brand-dark text-white border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 h-14 flex items-center justify-between">
      <div class="flex items-center gap-8 text-sm font-medium tracking-wide">
        @foreach ($links as [$route, $label])
          <a href="{{ route($route) }}"
             class="{{ $isActive($route) ? 'text-white font-semibold border-b-2 border-primary-container pb-1' : 'text-gray-300 hover:text-white transition-colors' }}">
            {{ $label }}
          </a>
        @endforeach
      </div>
      <a href="https://wa.me/{{ Setting::get('whatsapp') }}" target="_blank"
         class="press inline-flex items-center px-5 py-2 rounded-full bg-white text-brand-dark font-bold text-xs hover:bg-primary-container hover:text-white transition-all">
        <i class="fa-brands fa-whatsapp mr-1.5 text-secondary"></i> WhatsApp
      </a>
    </div>
  </nav>
</div>