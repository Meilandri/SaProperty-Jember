<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function index()
    {
        return view('admin.inquiries', [
            'inquiries' => Inquiry::latest()->paginate(15),
        ]);
    }

    public function markRead(Inquiry $inquiry)
    {
        $inquiry->update(['read_at' => now()]);
        return back();
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return back()->with('status', 'Pesan dihapus.');
    }
}