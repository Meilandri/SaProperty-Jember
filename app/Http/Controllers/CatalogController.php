<?php

namespace App\Http\Controllers;

use App\Support\SiteData;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = SiteData::catalogCategories();
        $items = SiteData::catalog();

        $active = $request->query('kategori', 'all');
        if (! array_key_exists($active, $categories)) {
            $active = 'all';
        } else {
            $items = $items->where('category', $active);
        }

        $sort = $request->query('urut', 'popular');
        $items = match ($sort) {
            'price-low'  => $items->sortBy('price'),
            'price-high' => $items->sortByDesc('price'),
            default      => $items->sortBy('popular'),
        };

        return view('pages.catalog.index', [
            'items'      => $items->values(),
            'categories' => $categories,
            'active'     => $active,
            'sort'       => $sort,
        ]);
    }

    public function show(string $slug)
    {
        $item = SiteData::catalog()->firstWhere('slug', $slug);
        abort_if(! $item, 404);

        return view('pages.catalog.show', [
            'item'       => $item,
            'categories' => SiteData::catalogCategories(),
            'related'    => SiteData::catalog()->where('slug', '!=', $slug)->take(3)->values(),
        ]);
    }
}