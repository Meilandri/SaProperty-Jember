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
            'items' => CatalogItem::orderBy('popular')->latest()->paginate(15),
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

        CatalogItem::create($data);

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

        return redirect()->route('admin.catalog.index')->with('status', 'Layanan berhasil diperbarui.');
    }

    public function destroy(CatalogItem $item)
    {
        Content::delete($item->image);
        $item->delete();

        return back()->with('status', 'Layanan dihapus.');
    }

    private function payload(Request $request, bool $imageRequired): array
    {
        $v = $request->validate([
            'title'          => ['required', 'string', 'max:150'],
            'category'       => ['required', Rule::in(array_keys(SiteData::catalogCategories()))],
            'size'           => ['nullable', 'string', 'max:100'],
            'desc'           => ['required', 'string', 'max:500'],
            'long'           => ['nullable', 'string', 'max:5000'],
            'features_text'  => ['nullable', 'string', 'max:3000'],
            'specs'          => ['nullable', 'array'],
            'specs.*.label'  => ['nullable', 'string', 'max:30'],
            'specs.*.value'  => ['nullable', 'string', 'max:50'],
            'price_note'     => ['nullable', 'string', 'max:100'],
            'price_text'     => ['nullable', 'string', 'max:50'],
            'price'          => ['nullable', 'numeric', 'min:0'],
            'popular'        => ['nullable', 'integer', 'min:1'],
            'loc_name'       => ['nullable', 'string', 'max:150'],
            'loc_address'    => ['nullable', 'string', 'max:255'],
            'loc_query'      => ['nullable', 'string', 'max:255'],
            'image'          => [$imageRequired ? 'required' : 'nullable', 'image', 'max:4096'],
        ], [
            'title.required' => 'Judul wajib diisi.',
            'desc.required'  => 'Deskripsi singkat wajib diisi.',
            'image.required' => 'Gambar wajib diunggah.',
            'image.image'    => 'File harus berupa gambar.',
            'image.max'      => 'Ukuran gambar maksimal 4 MB.',
        ]);

        $specs = collect($v['specs'] ?? [])
            ->filter(fn ($s) => filled($s['label'] ?? null) && filled($s['value'] ?? null))
            ->map(fn ($s) => [$s['label'], $s['value']])
            ->values()->all();

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
            'popular'      => $v['popular'] ?? 99,
            'location'     => filled($v['loc_query'] ?? null) ? [
                'name'    => $v['loc_name'] ?: $v['title'],
                'address' => $v['loc_address'] ?: $v['loc_query'],
                'query'   => $v['loc_query'],
            ] : null,
            'is_published' => $request->boolean('is_published'),
        ];
    }
}