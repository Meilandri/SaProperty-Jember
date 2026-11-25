@props(['item'])
@php
  $img = str_starts_with($item['image'], 'http') ? $item['image'] : asset($item['image']);
@endphp

<article class="relative flex flex-col group rounded-3xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all duration-300 border border-surface-container-high">
  <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-surface-container">
    <img src="{{ $img }}" alt="{{ $item['title'] }}" loading="lazy"
         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
    <span class="absolute bottom-5 left-5 project-card-badge text-white text-xs font-medium px-4 py-1.5 rounded-full">
      {{ $categories[$item['category']] ?? '' }}
    </span>
  </div>

  <div class="p-6 bg-white rounded-t-3xl -mt-4 relative z-10 flex flex-col justify-between flex-grow">
    <div>
      <div class="flex items-baseline justify-between gap-3 mb-1.5">
        <h3 class="font-bold text-lg leading-snug group-hover:text-primary-container transition-colors">{{ $item['title'] }}</h3>
        <span class="text-xs text-gray-400 font-medium whitespace-nowrap">{{ $item['size'] }}</span>
      </div>
      <p class="mt-2 text-xs text-gray-500 leading-relaxed line-clamp-2">{{ $item['desc'] }}</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 py-2.5 px-3 bg-surface-container-low rounded-xl mt-4">
      @foreach ($item['specs'] as [$label, $value])
        <div>
          <span class="block text-[11px] text-gray-400 uppercase">{{ $label }}</span>
          <span class="font-bold text-xs">{{ $value }}</span>
        </div>
      @endforeach
    </div>

    <div class="mt-5 pt-3 border-t border-surface-container-high flex items-center justify-between">
      <div class="flex flex-col">
        <span class="text-[11px] text-gray-400">{{ $item['price_note'] }}</span>
        <span class="text-base font-extrabold text-primary-container">{{ $item['price_text'] }}</span>
      </div>
      <a href="{{ route('catalog.show', $item['slug']) }}" aria-label="Detail {{ $item['title'] }}"
         class="w-9 h-9 rounded-full bg-surface-container hover:bg-primary-container text-gray-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
        <i class="fa-solid fa-arrow-right text-xs"></i>
      </a>
    </div>
  </div>
</article>