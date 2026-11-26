<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogItem;
use App\Support\Content;
use App\Support\SiteData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CatalogItemController extends Controller
{
    public function index()
    {
        return view('admin.catalog.index', [
            'items' => CatalogItem::orderByDesc('id')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.catalog.form', ['item' => null, 'categories' => SiteData::catalogCategories()]);
    }

    public function store(Request $request)
    {
        $data = $this->payload($request, true);
        $data['slug'] = Content::uniqueSlug(CatalogItem::class, $data['title']);
        $data['image'] = Content::store($request->file('image'), 'catalog');

        $item = CatalogItem::create($data);
        $item->syncGallery($request);

        return redirect()->route('admin.catalog.index')->with('status', 'Layanan berhasil ditambahkan.');
    }

    public function edit(CatalogItem $item)
    {
        return view('admin.catalog.form', ['item' => $item, 'categories' => SiteData::catalogCategories()]);
    }

    public function update(Request $request, CatalogItem $item)
    {
        $data = $this->payload($request, false);

        if ($request->hasFile('image')) {
            Content::delete($item->image);
            $data['image'] = Content::store($request->file('image'), 'catalog');
        }

        $item->update($data);
        $item->syncGallery($request);

        return redirect()->route('admin.catalog.index')->with('status', 'Layanan berhasil diperbarui.');
    }

    public function destroy(CatalogItem $item)
    {
        Content::delete($item->image);
        $item->deleteGallery();
        $item->delete();

        return back()->with('status', 'Layanan dihapus.');
    }

    private function payload(Request $request, bool $imageRequired): array
    {
        $v = $request->validate([
            'title'         => ['required', 'string', 'max:150'],
            'category'      => ['required', Rule::in(array_keys(SiteData::catalogCategories()))],
            'size'          => ['nullable', 'string', 'max:100'],
            'desc'          => ['required', 'string', 'max:500'],
            'long'          => ['nullable', 'string', 'max:5000'],
            'features_text' => ['nullable', 'string', 'max:3000'],
            'specs'         => ['nullable', 'array'],
            'specs.*.label' => ['nullable', 'string', 'max:30'],
            'specs.*.value' => ['nullable', 'string', 'max:50'],
            'price_note'    => ['nullable', 'string', 'max:100'],
            'price_text'    => ['nullable', 'string', 'max:50'],
            'price'         => ['nullable', 'numeric', 'min:0'],
            'loc_name'      => ['nullable', 'string', 'max:150'],
            'loc_address'   => ['nullable', 'string', 'max:255'],
            'loc_point'     => ['nullable', 'regex:/^\s*-?\d{1,3}(\.\d+)?\s*,\s*-?\d{1,3}(\.\d+)?\s*$/'],
            'image'         => [$imageRequired ? 'required' : 'nullable', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gallery'       => ['nullable', 'array', 'max:10'],
            'gallery.*'     => ['mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_images' => ['nullable', 'array'],
        ], [
            'title.required'  => 'Judul wajib diisi.',
            'desc.required'   => 'Deskripsi singkat wajib diisi.',
            'image.required'  => 'Gambar wajib diunggah.',
            'image.mimes'     => 'Gambar harus berformat JPG, PNG, atau WebP.',
            'image.max'       => 'Ukuran gambar maksimal 4 MB.',
            'loc_point.regex' => 'Titik lokasi tidak valid. Pilih ulang di peta.',
        ]);

        $specs = collect($v['specs'] ?? [])
            ->filter(fn ($s) => filled($s['label'] ?? null) && filled($s['value'] ?? null))
            ->map(fn ($s) => [$s['label'], $s['value']])
            ->values()->all();

        $point = filled($v['loc_point'] ?? null) ? str_replace(' ', '', $v['loc_point']) : null;

        return [
            'title'        => $v['title'],
            'category'     => $v['category'],
            'size'         => $v['size'] ?? null,
            'desc'         => $v['desc'],
            'long'         => $v['long'] ?? null,
            'features'     => Content::lines($v['features_text'] ?? ''),
            'specs'        => $specs,
            'price_note'   => $v['price_note'] ?? null,
            'price_text'   => $v['price_text'] ?? null,
            'price'        => $v['price'] ?? 0,
            'location'     => $point ? [
                'name'    => $v['loc_name'] ?: $v['title'],
                'address' => $v['loc_address'] ?: 'Lihat lokasi di peta',
                'query'   => $point,
            ] : null,
            'is_published' => $request->boolean('is_published'),
        ];
    }
}