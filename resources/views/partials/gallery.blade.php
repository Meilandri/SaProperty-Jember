@php
  $urls = collect([$item->image])
      ->merge($item->images->pluck('path'))
      ->filter()
      ->map(fn ($p) => str_starts_with($p, 'http') ? $p : asset($p))
      ->values();
@endphp

<div data-gallery>
  <div class="rounded-3xl overflow-hidden bg-surface-container aspect-[4/3]">
    <img data-main src="{{ $urls[0] ?? '' }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
  </div>

  @if ($urls->count() > 1)
    <div class="mt-3 grid grid-cols-5 gap-2">
      @foreach ($urls as $i => $u)
        <button type="button" data-thumb="{{ $u }}" aria-label="Foto {{ $i + 1 }}"
                class="aspect-square rounded-xl overflow-hidden border-2 {{ $i === 0 ? 'border-primary-container' : 'border-transparent' }} transition-colors">
          <img src="{{ $u }}" alt="" loading="lazy" class="w-full h-full object-cover">
        </button>
      @endforeach
    </div>
  @endif
</div>

@push('scripts')
<script>
  document.querySelectorAll('[data-gallery]').forEach(box => {
    const main = box.querySelector('[data-main]');
    const thumbs = box.querySelectorAll('[data-thumb]');
    thumbs.forEach(btn => btn.addEventListener('click', () => {
      main.src = btn.dataset.thumb;
      thumbs.forEach(b => b.classList.replace('border-primary-container', 'border-transparent'));
      btn.classList.replace('border-transparent', 'border-primary-container');
    }));
  });
</script>
@endpush