<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogItem;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $get = fn ($type) => Category::where('type', $type)->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.categories', [
            'sections' => [
                'catalog' => ['Kategori Katalog', $get('catalog'),
                    CatalogItem::selectRaw('category, count(*) as n')->groupBy('category')->pluck('n', 'category')],
                'project' => ['Kategori Proyek', $get('project'),
                    Project::selectRaw('category, count(*) as n')->groupBy('category')->pluck('n', 'category')],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['catalog', 'project'])],
            'name' => ['required', 'string', 'max:60'],
        ], ['name.required' => 'Nama kategori wajib diisi.']);

        // Key dibuat dari nama dan tidak berubah saat nama diedit,
        // sehingga item yang sudah memakai kategori ini tetap terhubung.
        $base = Str::slug($data['name']) ?: 'kategori';
        $key = $base;
        $i = 2;
        while (Category::where('type', $data['type'])->where('key', $key)->exists()) {
            $key = $base . '-' . $i++;
        }

        Category::create([
            'type'       => $data['type'],
            'key'        => $key,
            'name'       => $data['name'],
            'sort_order' => (Category::where('type', $data['type'])->max('sort_order') ?? 0) + 1,
        ]);

        return back()->with('status', 'Kategori ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:60'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], ['name.required' => 'Nama kategori wajib diisi.']);

        $category->update([
            'name'       => $data['name'],
            'sort_order' => $data['sort_order'] ?? $category->sort_order,
        ]);

        return back()->with('status', 'Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        $used = $category->type === 'catalog'
            ? CatalogItem::where('category', $category->key)->count()
            : Project::where('category', $category->key)->count();

        if ($used > 0) {
            return back()->withErrors([
                'category' => "Kategori \"{$category->name}\" masih dipakai {$used} item. Pindahkan atau hapus item tersebut dulu.",
            ]);
        }

        $category->delete();

        return back()->with('status', 'Kategori dihapus.');
    }
}