@extends('layouts.admin')
@section('title', $item ? 'Edit Layanan' : 'Tambah Layanan')

@section('content')
@php
  $field = 'w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:border-primary-container text-sm';
  $label = 'block text-sm font-semibold mb-1.5';
  $loc   = $item?->location ?? [];
@endphp

<a href="{{ route('admin.catalog.index') }}" class="inline-flex items-center gap-2 mb-5 text-sm font-semibold text-gray-500 hover:text-primary-container">
  <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
</a>
<h1 class="text-2xl font-extrabold mb-6">{{ $item ? 'Edit Layanan' : 'Tambah Layanan' }}</h1>

<form method="POST" enctype="multipart/form-data"
      action="{{ $item ? route('admin.catalog.update', $item) : route('admin.catalog.store') }}"
      class="max-w-3xl space-y-6">
  @csrf
  @if ($item) @method('PUT') @endif

  <div class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-5">
    <h2 class="font-bold">Informasi Utama</h2>

    <div>
      <label class="{{ $label }}">Judul <span class="text-primary-container">*</span></label>
      <input name="title" value="{{ old('title', $item?->title) }}" class="{{ $field }}" required>
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
        <label class="{{ $label }}">Keterangan Singkat (mis. ukuran lahan)</label>
        <input name="size" value="{{ old('size', $item?->size) }}" class="{{ $field }}" placeholder="Lahan 7×15m">
      </div>
    </div>

    <div>
      <label class="{{ $label }}">Deskripsi Singkat (tampil di kartu) <span class="text-primary-container">*</span></label>
      <textarea name="desc" rows="2" class="{{ $field }}" required>{{ old('desc', $item?->desc) }}</textarea>
    </div>

    <div>
      <label class="{{ $label }}">Deskripsi Lengkap (halaman detail)</label>
      <textarea name="long" rows="4" class="{{ $field }}">{{ old('long', $item?->long) }}</textarea>
    </div>

    <div>
      <label class="{{ $label }}">Yang Anda Dapatkan <span class="text-gray-400 font-normal">(satu baris satu poin)</span></label>
      <textarea name="features_text" rows="4" class="{{ $field }}">{{ old('features_text', $item ? implode("\n", $item->features ?? []) : '') }}</textarea>
    </div>
  </div>

  <div class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-5">
    <h2 class="font-bold">Spesifikasi <span class="text-gray-400 font-normal text-sm">(maksimal 4, baris kosong diabaikan)</span></h2>
    <div class="grid sm:grid-cols-2 gap-3">
      @for ($i = 0; $i < 4; $i++)
        <div class="flex gap-2">
          <input name="specs[{{ $i }}][label]" value="{{ old("specs.$i.label", $item?->specs[$i][0] ?? '') }}" placeholder="Label (LT)" class="{{ $field }} w-2/5">
          <input name="specs[{{ $i }}][value]" value="{{ old("specs.$i.value", $item?->specs[$i][1] ?? '') }}" placeholder="Nilai (105 m²)" class="{{ $field }}">
        </div>
      @endfor
    </div>
  </div>

  <div class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-5">
    <h2 class="font-bold">Harga</h2>
    <div class="grid sm:grid-cols-3 gap-5">
      <div>
        <label class="{{ $label }}">Keterangan Harga</label>
        <input name="price_note" value="{{ old('price_note', $item?->price_note) }}" class="{{ $field }}" placeholder="Harga Mulai:">
      </div>
      <div>
        <label class="{{ $label }}">Teks Harga</label>
        <input name="price_text" value="{{ old('price_text', $item?->price_text) }}" class="{{ $field }}" placeholder="Rp 540 Jt">
      </div>
      <div>
        <label class="{{ $label }}">Angka untuk urutan (juta)</label>
        <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $item?->price) }}" class="{{ $field }}" placeholder="540">
      </div>
    </div>
  </div>

  <div class="bg-white border border-surface-container-high rounded-2xl p-6 shadow-sm space-y-5">
  <h2 class="font-bold">Lokasi <span class="text-gray-400 font-normal text-sm">(opsional, untuk jual beli tanah/rumah)</span></h2>

  <x-map-picker name="loc_point" :value="old('loc_point', $pt)" :search="old('loc_address', $loc['address'] ?? '')" />

  <div class="grid sm:grid-cols-2 gap-5">
    <div>
      <label class="{{ $label }}">Nama Lokasi</label>
      <input name="loc_name" value="{{ old('loc_name', $loc['name'] ?? '') }}" class="{{ $field }}">
    </div>
    <div>
      <label class="{{ $label }}">Alamat Tampilan</label>
      <input name="loc_address" value="{{ old('loc_address', $loc['address'] ?? '') }}" class="{{ $field }}">
    </div>
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
<div>
  <label class="{{ $label }}">Galeri Foto Tambahan <span class="text-gray-400 font-normal">(maksimal 10, boleh pilih banyak sekaligus)</span></label>

  @if ($item && $item->images->count())
    <p class="text-xs text-gray-500 mb-2">Centang foto yang ingin dihapus:</p>
    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4">
      @foreach ($item->images as $img)
        <label class="relative block cursor-pointer">
          <img src="{{ asset($img->path) }}" alt="" class="w-full h-24 object-cover rounded-xl bg-surface-container">
          <input type="checkbox" name="remove_images[]" value="{{ $img->id }}"
                 class="absolute top-2 left-2 w-5 h-5 rounded">
        </label>
      @endforeach
    </div>
  @endif

  <input type="file" name="gallery[]" accept="image/*" multiple class="text-sm">
</div>
    <div>
      <input type="hidden" name="is_published" value="0">
      <label class="flex items-center gap-2 text-sm font-semibold">
        <input type="checkbox" name="is_published" value="1" class="rounded" @checked(old('is_published', $item?->is_published ?? true))>
        Tayangkan di website
      </label>
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