<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\Content;
use App\Support\SiteData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.projects.index', [
            'items' => Project::orderByDesc('completed_at')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.projects.form', ['item' => null, 'categories' => SiteData::projectCategories()]);
    }

    public function store(Request $request)
    {
        $data = $this->payload($request, true);
        $data['slug'] = Content::uniqueSlug(Project::class, $data['title']);
        $data['image'] = Content::store($request->file('image'), 'projects');

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('status', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', ['item' => $project, 'categories' => SiteData::projectCategories()]);
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->payload($request, false);

        if ($request->hasFile('image')) {
            Content::delete($project->image);
            $data['image'] = Content::store($request->file('image'), 'projects');
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('status', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        Content::delete($project->image);
        $project->delete();

        return back()->with('status', 'Proyek dihapus.');
    }

    private function payload(Request $request, bool $imageRequired): array
    {
        $v = $request->validate([
            'title'          => ['required', 'string', 'max:200'],
            'category'       => ['required', Rule::in(array_keys(SiteData::projectCategories()))],
            'location'       => ['nullable', 'string', 'max:150'],
            'lt'             => ['nullable', 'string', 'max:30'],
            'lb'             => ['nullable', 'string', 'max:30'],
            'duration'       => ['nullable', 'string', 'max:50'],
            'badge'          => ['nullable', 'string', 'max:50'],
            'badge_style'    => ['required', Rule::in(['green', 'dark', 'red'])],
            'completed_at'   => ['nullable', 'date'],
            'popular'        => ['nullable', 'integer', 'min:1'],
            'desc'           => ['required', 'string', 'max:2000'],
            'highlights_text' => ['nullable', 'string', 'max:2000'],
            'image'          => [$imageRequired ? 'required' : 'nullable', 'image', 'max:4096'],
        ], [
            'title.required' => 'Judul wajib diisi.',
            'desc.required'  => 'Deskripsi wajib diisi.',
            'image.required' => 'Gambar wajib diunggah.',
            'image.image'    => 'File harus berupa gambar.',
            'image.max'      => 'Ukuran gambar maksimal 4 MB.',
        ]);

        return [
            'title'        => $v['title'],
            'category'     => $v['category'],
            'location'     => $v['location'] ?? null,
            'lt'           => $v['lt'] ?? null,
            'lb'           => $v['lb'] ?? null,
            'duration'     => $v['duration'] ?? null,
            'badge'        => $v['badge'] ?? null,
            'badge_style'  => $v['badge_style'],
            'completed_at' => $v['completed_at'] ?? null,
            'popular'      => $v['popular'] ?? 99,
            'desc'         => $v['desc'],
            'highlights'   => Content::lines($v['highlights_text'] ?? ''),
            'is_published' => $request->boolean('is_published'),
        ];
    }
}