@props(['item'])
@php
  $img = str_starts_with($item['image'], 'http') ? $item['image'] : asset($item['image']);
  $badgeClass = match ($item['badge_style']) {
      'green' => 'bg-secondary text-on-secondary',
      'red'   => 'bg-primary-container text-on-primary',
      default => 'bg-on-surface text-surface',
  };
@endphp

<article class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
  <div class="relative h-64 w-full overflow-hidden bg-surface-container">
    <img src="{{ $img }}" alt="{{ $item['title'] }}" loading="lazy"
         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
    <span class="absolute top-4 left-4 px-3.5 py-1.5 rounded-full bg-on-surface/85 backdrop-blur-md text-surface text-sm font-semibold">
      {{ $item['category_label'] }}
    </span>
    <span class="absolute bottom-4 right-4 px-3 py-1 rounded-full text-sm font-semibold shadow-sm {{ $badgeClass }}">
      {{ $item['badge'] }}
    </span>
  </div>

  <div class="p-6 flex flex-col flex-1 justify-between gap-5">
    <div class="space-y-3">
      <h3 class="text-xl font-semibold line-clamp-2">{{ $item['title'] }}</h3>
      <div class="flex flex-wrap items-center gap-2 text-sm font-semibold text-tertiary">
        <span class="px-2.5 py-1 rounded-lg bg-surface-container">LT {{ $item['lt'] }}</span>
        <span class="px-2.5 py-1 rounded-lg bg-surface-container">LB {{ $item['lb'] }}</span>
        <span class="px-2.5 py-1 rounded-lg bg-surface-container">Durasi: {{ $item['duration'] }}</span>
      </div>
    </div>

    <div class="flex items-center justify-between pt-2">
      <span class="font-semibold text-primary-container">Lihat Detail Proyek</span>
      <a href="{{ route('projects.show', $item['slug']) }}"
         class="w-12 h-12 rounded-full bg-surface-container group-hover:bg-primary-container text-on-surface group-hover:text-white flex items-center justify-center transition-colors">
        <i class="fa-solid fa-arrow-right"></i>
      </a>
    </div>
  </div>
</article>