<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogItem;
use App\Models\Category;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                ['Proyek',          Project::count(),                              'fa-building',  'bg-green-50 text-secondary'],
                ['Layanan Katalog', CatalogItem::count(),                          'fa-book-open', 'bg-amber-50 text-amber-600'],
                ['Kategori',        Category::count(),                             'fa-tags',      'bg-blue-50 text-blue-600'],
                ['Draf (belum tayang)', Project::where('is_published', false)->count()
                                        + CatalogItem::where('is_published', false)->count(), 'fa-eye-slash', 'bg-gray-100 text-gray-600'],
            ],
        ]);
    }
}