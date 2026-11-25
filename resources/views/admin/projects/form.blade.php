@extends('layouts.admin')
@section('title', $item ? 'Edit Proyek' : 'Tambah Proyek')

@section('content')
@php
  $field = 'w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-primary-container text-sm';
  $label = 'block text-sm font-semibold mb-1.5';
@endphp

<a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-2 mb-5 text-sm font-semibold text-gray-500 hover:text-primary-container">
  <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
</a>
<h1 class="text-2xl font-extrabold mb-6">{{ $item ? 'Edit Proyek' : 'Tambah Proyek' }}</h1>

<form method="POST" enctype="multipart/form-data"
      action="{{ $item ? route('admin.projects.update', $item) : route('admin.projects.store') }}"
      class="max-w-3xl space-y-6">
  @csrf
  @if ($item) @method('PUT') @endif

  <div class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-5">
    <h2 class="font-bold">Informasi Proyek</h2>

    <div>
      <label class="{{ $label }}">Judul <span class="text-primary-container">*</span></label>
      <input name="title" value="{{ old('title', $item?->title) }}" class="{{ $field }}" placeholder="Hunian Tropis Modern 2 Lantai — Cilandak" required>
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
      <div>
        <label class="{{ $label }}">Kategori <span class="text-primary-container">*</span></label>
        <select name="category" class="{{ $field }}" required>
          @foreach ($categories as $key => $name)
            <option value="{{ $key }}" @selected(old('category', $item?->category) === $key)>{{ $name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="{{ $label }}">Lokasi</label>
        <input name="location" value="{{ old('location', $item?->location) }}" class="{{ $field }}" placeholder="Cilandak, Jakarta Selatan">
      </div>
    </div>

    <div class="grid sm:grid-cols-3 gap-5">
      <div>
        <label class="{{ $label }}">Luas Tanah</label>
        <input name="lt" value="{{ old('lt', $item?->lt) }}" class="{{ $field }}" placeholder="180 m²">
      </div>
      <div>
        <label class="{{ $label }}">Luas Bangunan</label>
        <input name="lb" value="{{ old('lb', $item?->lb) }}" class="{{ $field }}" placeholder="220 m²">
      </div>
      <div>
        <label class="{{ $label }}">Durasi</label>
        <input name="duration" value="{{ old('duration', $item?->duration) }}" class="{{ $field }}" placeholder="6 Bulan">
      </div>
    </div>

    <div class="grid sm:grid-cols-3 gap-5">
      <div>
        <label class="{{ $label }}">Label Status</label>
        <input name="badge" value="{{ old('badge', $item?->badge) }}" class="{{ $field }}" placeholder="Serah Terima 2025">
      </div>
      <div>
        <label class="{{ $label }}">Warna Label</label>
        <select name="badge_style" class="{{ $field }}">
          @foreach (['green' => 'Hijau', 'dark' => 'Gelap', 'red' => 'Merah'] as $k => $n)
            <option value="{{ $k }}" @selected(old('badge_style', $item?->badge_style ?? 'dark') === $k)>{{ $n }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="{{ $label }}">Tanggal Selesai</label>
        <input type="date" name="completed_at" value="{{ old('completed_at', $item?->completed_at?->format('Y-m-d')) }}" class="{{ $field }}">
      </div>
    </div>

    <div>
      <label class="{{ $label }}">Deskripsi <span class="text-primary-container">*</span></label>
      <textarea name="desc" rows="4" class="{{ $field }}" required>{{ old('desc', $item?->desc) }}</textarea>
    </div>

    <div>
      <label class="{{ $label }}">Sorotan <span class="text-gray-400 font-normal">(satu baris satu poin)</span></label>
      <textarea name="highlights_text" rows="3" class="{{ $field }}">{{ old('highlights_text', $item ? implode("\n", $item->highlights ?? []) : '') }}</textarea>
    </div>
  </div>

  <div class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-5">
    <h2 class="font-bold">Gambar & Tayang</h2>
    <div>
      <label class="{{ $label }}">Gambar @unless ($item) <span class="text-primary-container">*</span> @endunless</label>
      <img id="preview" src="{{ $item ? asset($item->image) : '' }}" alt=""
           class="{{ $item ? '' : 'hidden' }} w-full max-w-xs h-44 object-cover rounded-xl mb-3 bg-surface-container">
      <input id="image" type="file" name="image" accept="image/*" class="text-sm">
      @if ($item) <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p> @endif
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
      <div>
        <label class="{{ $label }}">Urutan populer</label>
        <input name="popular" type="number" min="1" value="{{ old('popular', $item?->popular ?? 99) }}" class="{{ $field }}">
        <p class="text-xs text-gray-400 mt-1">Angka kecil tampil lebih dulu.</p>
      </div>
      <div class="flex items-end">
        <input type="hidden" name="is_published" value="0">
        <label class="flex items-center gap-2 text-sm font-semibold">
          <input type="checkbox" name="is_published" value="1" class="rounded" @checked(old('is_published', $item?->is_published ?? true))>
          Tayangkan di website
        </label>
      </div>
    </div>
  </div>

  <button class="px-8 py-3 rounded-full bg-primary-container hover:bg-primary text-white font-bold text-sm transition-colors">
    {{ $item ? 'Simpan Perubahan' : 'Terbitkan' }}
  </button>
</form>
@endsection

@push('scripts')
<script>
  document.getElementById('image').addEventListener('change', function () {
    const f = this.files[0];
    const img = document.getElementById('preview');
    if (!f) return;
    img.src = URL.createObjectURL(f);
    img.classList.remove('hidden');
  });
</script>
@endpush