<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar user selain Kepala Sekolah
    public function index()
    {
        $users = User::where('role', '!=', 'kepala_sekolah')->orderBy('role', 'asc')->get();
        return view('users.index', compact('users'));
    }

    // Menyimpan akun khusus Guru Supervisi baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru_supervisi' // Paksa role jadi guru_supervisi
        ]);

        return redirect()->back()->with('success', 'Akun Guru Supervisi berhasil ditambahkan!');
    }

    // Fungsi Reset Password ke default "password123"
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make('password123')
        ]);

        return redirect()->back()->with('success', 'Password untuk akun ' . $user->name . ' berhasil direset menjadi: password123');
    }

    // Menghapus akun user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Peringatan: Jika menghapus akun Guru, data profil di tabel gurus tidak ikut terhapus.
        // Hapus profil guru disarankan melalui menu Data Guru.
        $user->delete();

        return redirect()->back()->with('success', 'Akun pengguna berhasil dihapus!');
    }
}