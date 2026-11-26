<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Content;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit(string $group)
    {
        $groups = Setting::groups();
        abort_unless(isset($groups[$group]), 404);

        return view('admin.settings', ['group' => $group, 'def' => $groups[$group]]);
    }

    public function update(Request $request, string $group)
    {
        $groups = Setting::groups();
        abort_unless(isset($groups[$group]), 404);

        $fields = $groups[$group]['fields'];

        $rules = [];
        foreach ($fields as $key => $f) {
            $rules[$key] = $f[1] === 'image'
                ? ['nullable', 'mimes:jpg,jpeg,png,webp', 'max:4096']
                : ['nullable', 'string', 'max:5000'];
        }
        $request->validate($rules, [
            '*.mimes' => 'Gambar harus berformat JPG, PNG, atau WebP.',
            '*.max'   => 'Ukuran/panjang isian melebihi batas.',
        ]);

        foreach ($fields as $key => $f) {
            if ($f[1] === 'image') {
                if ($request->hasFile($key)) {
                    Content::delete(Setting::get($key));
                    Setting::put($key, Content::store($request->file($key), 'site'));
                }
            } else {
                Setting::put($key, $request->input($key));
            }
        }

        return back()->with('status', 'Pengaturan "' . $groups[$group]['label'] . '" disimpan.');
    }
}