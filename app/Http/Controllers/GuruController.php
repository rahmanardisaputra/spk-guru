<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User; // Wajib di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Wajib di-import untuk password

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip',
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'pendidikan_terakhir' => 'required',
            'no_hp' => 'required',
        ]);

        // 1. Buat Akun Login Otomatis untuk Guru
        // Kita gunakan NIP sebagai email agar unik
        $email_guru = $request->nip . '@sekolah.com'; 
        
        User::create([
            'name' => $request->nama_guru,
            'email' => $email_guru,
            'password' => Hash::make('password123'), // Password bawaan
            'role' => 'guru'
        ]);

        // 2. Simpan Data Profil Guru
        Guru::create($request->all());

        return redirect()->route('guru.index')->with('success', 'Data Guru dan Akun Login otomatis berhasil dibuat!');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip,'.$id,
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'pendidikan_terakhir' => 'required',
            'no_hp' => 'required',
        ]);

        $guru = Guru::findOrFail($id);
        $nama_lama = $guru->nama_guru; // Simpan nama lama untuk mencari user di database

        // Update data guru
        $guru->update($request->all());

        // Update akun user yang terhubung (Sinkronisasi Nama dan NIP/Email)
        $user = User::where('name', $nama_lama)->where('role', 'guru')->first();
        if ($user) {
            $user->update([
                'name' => $request->nama_guru,
                'email' => $request->nip . '@sekolah.com'
            ]);
        }

        return redirect()->route('guru.index')->with('success', 'Data Guru dan Akun Login berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        // Cari dan hapus juga akun login user-nya agar tidak menjadi data sampah (orphan data)
        $user = User::where('name', $guru->nama_guru)->where('role', 'guru')->first();
        if ($user) {
            $user->delete();
        }

        // Hapus data profil gurunya
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data Guru beserta Akun Login berhasil dihapus!');
    }
}