<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account', ['admins' => User::orderBy('id')->get()]);
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'current_password.required'         => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini salah.',
            'password.required'                 => 'Password baru wajib diisi.',
            'password.confirmed'                => 'Konfirmasi password baru tidak sama.',
            'password.min'                      => 'Password baru minimal 8 karakter.',
            'password.letters'                  => 'Password baru harus mengandung huruf.',
            'password.numbers'                  => 'Password baru harus mengandung angka.',
        ]);

        $request->user()->update(['password' => Hash::make($request->password)]);

        return back()->with('status', 'Password berhasil diganti.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
        ], [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.letters'  => 'Password harus mengandung huruf.',
            'password.numbers'  => 'Password harus mengandung angka.',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('status', 'Admin baru ditambahkan.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->withErrors(['user' => 'Anda tidak bisa menghapus akun yang sedang dipakai.']);
        }

        if (User::count() <= 1) {
            return back()->withErrors(['user' => 'Minimal harus ada satu admin.']);
        }

        $user->delete();

        return back()->with('status', 'Admin dihapus.');
    }
}