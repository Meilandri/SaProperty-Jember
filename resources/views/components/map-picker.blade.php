@props(['name', 'value' => '', 'search' => ''])

<div data-map-picker class="space-y-3">
  <div class="flex gap-2">
    <input type="text" data-map-search value="{{ $search }}" placeholder="Cari alamat atau nama tempat..."
           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-primary-container text-sm">
    <button type="button" data-map-find
            class="px-5 py-2.5 rounded-full bg-brand-dark text-white text-xs font-semibold whitespace-nowrap">
      <i class="fa-solid fa-magnifying-glass mr-1"></i> Cari
    </button>
  </div>

  <div data-map-canvas class="isolate w-full h-80 rounded-2xl border border-surface-container-high"></div>

  <input type="hidden" name="{{ $name }}" value="{{ $value }}" data-map-value>

  <div class="flex flex-wrap items-center justify-between gap-2">
    <p data-map-info class="text-xs text-gray-600"></p>
    <button type="button" data-map-clear class="text-xs font-semibold text-primary-container hover:underline">Hapus titik</button>
  </div>
  <p class="text-xs text-gray-400">Ketik alamat lalu klik Cari. Jika kurang tepat, klik langsung di peta atau geser pin ke titik yang benar.</p>
</div>