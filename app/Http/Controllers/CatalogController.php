<?php

namespace App\Http\Controllers;

use App\Models\CatalogItem;
use App\Support\SiteData;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = SiteData::catalogCategories();
        $query = CatalogItem::published();

        $active = $request->query('kategori', 'all');
        if (! array_key_exists($active, $categories)) {
            $active = 'all';
        } else {
            $query->where('category', $active);
        }

        $q = trim((string) $request->query('q', ''));
        if ($q !== '') {
            $like = '%' . addcslashes($q, '%_\\') . '%';
            $query->where(fn ($w) => $w->where('title', 'ilike', $like)->orWhere('desc', 'ilike', $like));
        }

        $sort = $request->query('urut', 'terbaru');
        match ($sort) {
            'price-low'  => $query->orderBy('price'),
            'price-high' => $query->orderByDesc('price'),
            default      => $query->orderByDesc('id'),
        };

        return view('pages.catalog.index', [
            'items'      => $query->paginate(9)->withQueryString(),
            'categories' => $categories,
            'active'     => $active,
            'sort'       => $sort,
            'q'          => $q,
        ]);
    }

    public function show(string $slug)
    {
        $item = CatalogItem::published()->where('slug', $slug)->firstOrFail();

        return view('pages.catalog.show', [
            'item'       => $item,
            'categories' => SiteData::catalogCategories(),
            'related'    => CatalogItem::published()->where('slug', '!=', $slug)->orderByDesc('id')->take(3)->get(),
        ]);
    }
}