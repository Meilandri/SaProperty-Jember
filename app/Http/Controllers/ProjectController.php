<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\SiteData;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $categories = SiteData::projectCategories();
        $query = Project::published();

        $active = $request->query('kategori', 'all');
        if (! array_key_exists($active, $categories)) {
            $active = 'all';
        } else {
            $query->where('category', $active);
        }

        $sort = $request->query('urut', 'terbaru');
        $sort === 'terpopuler' ? $query->orderBy('popular') : $query->orderByDesc('completed_at');

        $testimonials = [
            ['initial' => 'BW', 'name' => 'Bapak Budi Wijaya',    'role' => 'Pemilik Rumah, BSD City',     'text' => 'RAB sangat transparan sejak awal, tidak ada biaya siluman di tengah jalan. Renovasi rumah kami di BSD selesai tepat 3,5 bulan dengan finishing marmer yang sangat rapi.'],
            ['initial' => 'DR', 'name' => 'Ibu Dewi Rahmawati',   'role' => 'Pemilik Hunian, Cilandak',    'text' => 'Tim arsitek dan sipil SA Properti sangat komunikatif. Laporan progres mingguan selalu lengkap dengan foto, jadi kami tenang meski jarang memantau langsung.'],
            ['initial' => 'HS', 'name' => 'Bapak Hendra Santoso', 'role' => 'Investor Properti, Serpong', 'text' => 'Dari pengurusan PBG hingga pembangunan kost 18 kamar di Serpong berjalan mulus. Desain fasadnya modern dan langsung penuh terisi penyewa begitu serah terima.'],
        ];

        return view('pages.projects.index', [
            'items'        => $query->get(),
            'categories'   => $categories,
            'active'       => $active,
            'sort'         => $sort,
            'testimonials' => $testimonials,
        ]);
    }

    public function show(string $slug)
    {
        $item = Project::published()->where('slug', $slug)->firstOrFail();

        return view('pages.projects.show', [
            'item'    => $item,
            'related' => Project::published()->where('slug', '!=', $slug)->orderByDesc('completed_at')->take(3)->get(),
        ]);
    }
}