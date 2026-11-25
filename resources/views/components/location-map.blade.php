@props(['location'])
@php $q = urlencode($location['query']); @endphp

<div class="rounded-2xl overflow-hidden border border-surface-container-high bg-white">
  <iframe src="https://www.google.com/maps?q={{ $q }}&output=embed"
          class="w-full h-72 border-0" loading="lazy" allowfullscreen
          referrerpolicy="no-referrer-when-downgrade" title="Peta lokasi {{ $location['name'] }}"></iframe>
  <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div class="text-sm">
      <p class="font-semibold">{{ $location['name'] }}</p>
      <p class="text-gray-500 text-xs mt-0.5"><i class="fa-solid fa-location-dot text-primary-container mr-1.5"></i>{{ $location['address'] }}</p>
    </div>
    <a href="https://www.google.com/maps/search/?api=1&query={{ $q }}" target="_blank" rel="noopener"
       class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-full bg-surface-container hover:bg-primary-container hover:text-white text-xs font-semibold transition-colors">
      <i class="fa-solid fa-diamond-turn-right"></i> Buka di Google Maps
    </a>
  </div>
</div>