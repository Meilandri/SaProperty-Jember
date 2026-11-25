@php
  $items = [
    ['home', 'Beranda', 'fa-house'],
    ['catalog.index', 'Katalog', 'fa-book-open'],
    ['projects.index', 'Proyek', 'fa-table-cells-large'],
    ['about', 'Tentang', 'fa-circle-info'],
    ['contact', 'Kontak', 'fa-phone'],
  ];
@endphp

<nav class="md:hidden fixed bottom-0 inset-x-0 z-50 bg-white border-t border-gray-200 pb-[env(safe-area-inset-bottom)]">
  <div class="grid grid-cols-5">
    @foreach ($items as [$route, $label, $icon])
      @php $active = request()->routeIs($route) || request()->routeIs(str_replace('.index', '.*', $route)); @endphp
      <a href="{{ route($route) }}"
         class="relative flex flex-col items-center gap-1 py-2.5 text-[11px] {{ $active ? 'text-primary-container font-bold' : 'text-gray-500' }}">
        @if ($active)
          <span class="absolute top-0 h-0.5 w-8 rounded-full bg-primary-container"></span>
        @endif
        <i class="fa-solid {{ $icon }} text-lg"></i>
        {{ $label }}
      </a>
    @endforeach
  </div>
</nav>