<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\FloatingSupervisi;
use Illuminate\Http\Request;

class FloatingController extends Controller
{
    public function index()
    {
        // Ambil semua user yang rolenya guru_supervisi
        $supervisis = User::where('role', 'guru_supervisi')->get();
        // Ambil semua data guru
        $gurus = Guru::all();
        // Ambil data floating yang sudah ada saat ini
        $floatings = FloatingSupervisi::with(['supervisi', 'guru'])->get();

        return view('floating.index', compact('supervisis', 'gurus', 'floatings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supervisi_id' => 'required|exists:users,id',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        // Cek apakah kombinasi floating ini sudah pernah dibuat sebelumnya
        $exists = FloatingSupervisi::where('supervisi_id', $request->supervisi_id)
                                    ->where('guru_id', $request->guru_id)
                                    ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Guru Supervisi tersebut sudah ter-floating untuk guru ini!');
        }

        FloatingSupervisi::create([
            'supervisi_id' => $request->supervisi_id,
            'guru_id' => $request->guru_id,
        ]);

        return redirect()->route('floating.index')->with('success', 'Berhasil melakukan floating tugas supervisi!');
    }

    public function destroy($id)
    {
        $floating = FloatingSupervisi::findOrFail($id);
        $floating->delete();

        return redirect()->route('floating.index')->with('success', 'Floating tugas berhasil dihapus!');
    }

    public function cetakSuratTugas($supervisi_id)
    {
        // Ambil data user supervisi
        $supervisi = User::findOrFail($supervisi_id);

        // Ambil semua daftar guru yang di-floating ke supervisi ini
        $floatings = FloatingSupervisi::where('supervisi_id', $supervisi_id)
                                      ->with('guru')
                                      ->get();

        // Jika supervisi belum punya tugas floating sama sekali
        if ($floatings->isEmpty()) {
            return redirect()->back()->with('error', 'Guru Supervisi ini belum memiliki tugas floating guru!');
        }

        return view('floating.cetak_surat', compact('supervisi', 'floatings'));
    }
}