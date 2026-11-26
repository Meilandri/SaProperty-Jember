@extends('layouts.admin')
@section('title', $def['label'])

@section('content')
@php
  $field = 'w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-primary-container text-sm';
@endphp

<h1 class="text-2xl font-extrabold mb-1">{{ $def['label'] }}</h1>
<p class="text-sm text-gray-500 mb-6">Perubahan langsung tampil di website setelah disimpan.</p>

<form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update', $group) }}"
      class="max-w-3xl bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-6">
  @csrf
  @method('PUT')

  @foreach ($def['fields'] as $key => $f)
    @php
      $label = $f[0];
      $type  = $f[1];
      $hint  = $f[3] ?? null;
    @endphp

    <div>
      <label for="{{ $key }}" class="block text-sm font-semibold mb-1.5">{{ $label }}</label>

      @if ($type === 'image')
        <img src="{{ asset(Setting::get($key)) }}" alt="" data-preview="{{ $key }}"
             class="w-full max-w-sm h-48 object-cover rounded-xl mb-3 bg-surface-container">
        <input id="{{ $key }}" type="file" name="{{ $key }}" accept="image/*" class="text-sm" data-file="{{ $key }}">
        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
      @elseif ($type === 'map')
        <x-map-picker :name="$key" :value="old($key, Setting::get($key))" :search="Setting::get('address')" />
      @elseif ($type === 'textarea')
        <textarea id="{{ $key }}" name="{{ $key }}" rows="4" class="{{ $field }}">{{ old($key, Setting::get($key)) }}</textarea>
      @else
        <input id="{{ $key }}" name="{{ $key }}" value="{{ old($key, Setting::get($key)) }}" class="{{ $field }}">
      @endif

      @if ($hint)
        <p class="text-xs text-gray-400 mt-1">{{ $hint }}</p>
      @endif
    </div>
  @endforeach

  <button class="px-8 py-3 rounded-full bg-primary-container hover:bg-primary text-white font-bold text-sm transition-colors">
    Simpan Perubahan
  </button>
</form>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('[data-file]').forEach(function (input) {
    input.addEventListener('change', function () {
      var f = input.files[0];
      var img = document.querySelector('[data-preview="' + input.dataset.file + '"]');
      if (f && img) img.src = URL.createObjectURL(f);
    });
  });
</script>
@endpush