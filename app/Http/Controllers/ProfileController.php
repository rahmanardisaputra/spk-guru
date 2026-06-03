<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Menampilkan halaman edit profile
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Memproses update data dan ganti password
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'current_password.current_password' => 'Password lama yang Anda masukkan salah.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.'
        ]);

        // Update Nama & Email
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika form password diisi, berarti dia mau ganti password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil dan keamanan akun berhasil diperbarui!');
    }
}