<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('admin.testimonials', ['items' => Testimonial::orderByDesc('id')->get()]);
    }

    public function store(Request $request)
    {
        Testimonial::create($this->data($request));

        return back()->with('status', 'Testimoni ditambahkan.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($this->data($request));

        return back()->with('status', 'Testimoni diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('status', 'Testimoni dihapus.');
    }

    private function data(Request $request): array
    {
        $v = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'role' => ['nullable', 'string', 'max:120'],
            'text' => ['required', 'string', 'max:600'],
        ], [
            'name.required' => 'Nama klien wajib diisi.',
            'text.required' => 'Isi testimoni wajib diisi.',
        ]);

        return $v + ['is_published' => $request->boolean('is_published')];
    }
}