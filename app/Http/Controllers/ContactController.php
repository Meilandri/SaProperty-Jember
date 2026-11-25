<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Support\SiteData;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        return view('pages.contact', ['services' => array_values(SiteData::catalogCategories())]);
    }

    public function store(Request $request)
    {
        // Honeypot: kolom "website" disembunyikan, hanya bot yang mengisinya
        if ($request->filled('website')) {
            return back()->with('success', 'Terima kasih, pesan Anda sudah kami terima.');
        }

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'phone'   => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{8,}$/'],
            'email'   => ['nullable', 'email', 'max:150'],
            'service' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'phone.required'   => 'Nomor telepon/WhatsApp wajib diisi.',
            'phone.regex'      => 'Format nomor telepon tidak valid.',
            'email.email'      => 'Format email tidak valid.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        Inquiry::create($data);

        return back()->with('success', 'Terima kasih, pesan Anda sudah kami terima. Tim kami akan segera menghubungi Anda.');
    }
}