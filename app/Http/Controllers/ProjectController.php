<?php

namespace App\Http\Controllers;

use App\Support\SiteData;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $categories = SiteData::projectCategories();
        $items = SiteData::projects();

        $active = $request->query('kategori', 'all');
        if (! array_key_exists($active, $categories)) {
            $active = 'all';
        } else {
            $items = $items->where('category', $active);
        }

        $sort = $request->query('urut', 'terbaru');
        $items = $sort === 'terpopuler' ? $items->sortBy('popular') : $items->sortByDesc('date');

        $testimonials = [
            ['initial' => 'BW', 'name' => 'Bapak Budi Wijaya',    'role' => 'Pemilik Rumah, BSD City',     'text' => 'RAB sangat transparan sejak awal, tidak ada biaya siluman di tengah jalan. Renovasi rumah kami di BSD selesai tepat 3,5 bulan dengan finishing marmer yang sangat rapi.'],
            ['initial' => 'DR', 'name' => 'Ibu Dewi Rahmawati',   'role' => 'Pemilik Hunian, Cilandak',    'text' => 'Tim arsitek dan sipil SA Properti sangat komunikatif. Laporan progres mingguan selalu lengkap dengan foto, jadi kami tenang meski jarang memantau langsung.'],
            ['initial' => 'HS', 'name' => 'Bapak Hendra Santoso', 'role' => 'Investor Properti, Serpong', 'text' => 'Dari pengurusan PBG hingga pembangunan kost 18 kamar di Serpong berjalan mulus. Desain fasadnya modern dan langsung penuh terisi penyewa begitu serah terima.'],
        ];

        return view('pages.projects.index', [
            'items'        => $items->values(),
            'categories'   => $categories,
            'active'       => $active,
            'sort'         => $sort,
            'testimonials' => $testimonials,
        ]);
    }

    public function show(string $slug)
    {
        $item = SiteData::projects()->firstWhere('slug', $slug);
        abort_if(! $item, 404);

        return view('pages.projects.show', [
            'item'    => $item,
            'related' => SiteData::projects()->where('slug', '!=', $slug)->sortByDesc('date')->take(3)->values(),
        ]);
    }
}