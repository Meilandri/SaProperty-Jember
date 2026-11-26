<?php

namespace App\Models\Concerns;

use App\Models\GalleryImage;
use App\Support\Content;
use Illuminate\Http\Request;

trait HasGallery
{
    public function images()
    {
        return $this->morphMany(GalleryImage::class, 'imageable')->orderBy('sort_order')->orderBy('id');
    }

    /** Hapus foto yang dicentang, lalu simpan foto baru. */
    public function syncGallery(Request $request): void
    {
        $remove = array_filter((array) $request->input('remove_images', []));

        if ($remove) {
            $this->images()->whereIn('id', $remove)->get()->each(function ($img) {
                Content::delete($img->path);
                $img->delete();
            });
        }

        foreach ((array) $request->file('gallery', []) as $file) {
            $this->images()->create(['path' => Content::store($file, 'gallery')]);
        }
    }

    public function deleteGallery(): void
    {
        $this->images()->get()->each(function ($img) {
            Content::delete($img->path);
            $img->delete();
        });
    }
}