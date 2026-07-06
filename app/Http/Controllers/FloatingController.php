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
        $semester = session('semester');
        if (!$semester) {
            return redirect()->route('login')->with('error', 'Silakan login ulang untuk memilih semester.');
        }

        $supervisis = User::where('role', 'guru_supervisi')->get();
        // Hanya ambil kandidat pada semester ini
        $kandidatIds = \App\Models\Kandidat::where('semester', $semester)->pluck('guru_id');
        $gurus = Guru::whereIn('id', $kandidatIds)->get();
        
        $floatings = FloatingSupervisi::with(['supervisi', 'guru'])
                        ->where('semester', $semester)
                        ->get();

        $semesterName = \App\Helpers\SemesterHelper::getName($semester);

        return view('floating.index', compact('supervisis', 'gurus', 'floatings', 'semesterName'));
    }

    public function store(Request $request)
    {
        $semester = session('semester');
        $request->validate([
            'supervisi_id' => 'required|exists:users,id',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        $exists = FloatingSupervisi::where('supervisi_id', $request->supervisi_id)
                                    ->where('guru_id', $request->guru_id)
                                    ->where('semester', $semester)
                                    ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Guru Supervisi tersebut sudah ter-floating untuk kandidat ini di semester aktif!');
        }

        FloatingSupervisi::create([
            'supervisi_id' => $request->supervisi_id,
            'guru_id' => $request->guru_id,
            'semester' => $semester,
        ]);

        return redirect()->route('floating.index')->with('success', 'Berhasil melakukan floating tugas supervisi pada semester ini!');
    }

    public function destroy($id)
    {
        $floating = FloatingSupervisi::findOrFail($id);
        $floating->delete();

        return redirect()->route('floating.index')->with('success', 'Floating tugas berhasil dihapus!');
    }

    public function cetakSuratTugas($supervisi_id)
    {
        $semester = session('semester');
        $supervisi = User::findOrFail($supervisi_id);

        $floatings = FloatingSupervisi::where('supervisi_id', $supervisi_id)
                                      ->where('semester', $semester)
                                      ->with('guru')
                                      ->get();

        // Jika supervisi belum punya tugas floating sama sekali
        if ($floatings->isEmpty()) {
            return redirect()->back()->with('error', 'Guru Supervisi ini belum memiliki tugas floating guru!');
        }

        return view('floating.cetak_surat', compact('supervisi', 'floatings'));
    }
}