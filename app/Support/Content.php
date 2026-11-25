<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Content
{
    /** Simpan gambar, kembalikan path yang bisa langsung dipakai asset(). */
    public static function store(UploadedFile $file, string $dir): string
    {
        return 'storage/' . $file->store($dir, 'public');
    }

    /** Hapus gambar hanya jika hasil upload (bukan gambar bawaan di public/images). */
    public static function delete(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, 8));
        }
    }

    /** Teks beberapa baris menjadi array. */
    public static function lines(?string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $text))));
    }

    public static function uniqueSlug(string $model, string $title): string
    {
        $base = Str::slug($title) ?: 'item';
        $slug = $base;
        $i = 2;
        while ($model::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}