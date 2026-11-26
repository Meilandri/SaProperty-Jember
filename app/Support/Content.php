<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Content
{
    /** Simpan gambar (dikecilkan + WebP). Mengembalikan path untuk asset(). */
    public static function store(UploadedFile $file, string $dir, int $maxWidth = 1600): string
    {
        $path = $file->getRealPath();
        $mime = $file->getMimeType();

        $src = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($path),
            'image/png'  => @imagecreatefrompng($path),
            'image/webp' => @imagecreatefromwebp($path),
            default      => false,
        };

        // Jika GD/WebP tidak tersedia, simpan apa adanya
        if (! $src || ! function_exists('imagewebp')) {
            return 'storage/' . $file->store($dir, 'public');
        }

        imagepalettetotruecolor($src);

        // Perbaiki orientasi foto HP
        if ($mime === 'image/jpeg' && function_exists('exif_read_data')) {
            $orientation = @exif_read_data($path)['Orientation'] ?? 1;
            $angle = match ($orientation) { 3 => 180, 6 => -90, 8 => 90, default => 0 };
            if ($angle !== 0 && ($rotated = imagerotate($src, $angle, 0))) {
                $src = $rotated;
            }
        }

        if (imagesx($src) > $maxWidth && ($scaled = imagescale($src, $maxWidth))) {
            $src = $scaled;
        }

        imagealphablending($src, true);
        imagesavealpha($src, true);

        ob_start();
        imagewebp($src, null, 82);
        $data = ob_get_clean();
        imagedestroy($src);

        $name = $dir . '/' . Str::random(40) . '.webp';
        Storage::disk('public')->put($name, $data);

        return 'storage/' . $name;
    }

    /** Hapus gambar hanya jika hasil upload (bukan gambar bawaan di public/images). */
    public static function delete(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, 8));
        }
    }

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