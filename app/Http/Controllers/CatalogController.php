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

        $sort = $request->query('urut', 'popular');
        match ($sort) {
            'price-low'  => $query->orderBy('price'),
            'price-high' => $query->orderByDesc('price'),
            default      => $query->orderBy('popular'),
        };

        return view('pages.catalog.index', [
            'items'      => $query->get(),
            'categories' => $categories,
            'active'     => $active,
            'sort'       => $sort,
        ]);
    }

    public function show(string $slug)
    {
        $item = CatalogItem::published()->where('slug', $slug)->firstOrFail();

        return view('pages.catalog.show', [
            'item'       => $item,
            'categories' => SiteData::catalogCategories(),
            'related'    => CatalogItem::published()->where('slug', '!=', $slug)->orderBy('popular')->take(3)->get(),
        ]);
    }
}