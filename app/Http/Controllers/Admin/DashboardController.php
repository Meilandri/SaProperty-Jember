<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Support\SiteData;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                ['Total Pesan',  Inquiry::count(),                            'fa-inbox',        'bg-blue-50 text-blue-600'],
                ['Belum Dibaca', Inquiry::whereNull('read_at')->count(),      'fa-envelope',     'bg-red-50 text-primary-container'],
                ['Proyek',       SiteData::projects()->count(),               'fa-building',     'bg-green-50 text-secondary'],
                ['Layanan Katalog', SiteData::catalog()->count(),             'fa-book-open',    'bg-amber-50 text-amber-600'],
            ],
            'latest' => Inquiry::latest()->take(5)->get(),
        ]);
    }
}