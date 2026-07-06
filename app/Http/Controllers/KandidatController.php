<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Helpers\SemesterHelper;

class KandidatController extends Controller
{
    public function index()
    {
        $semester = session('semester');
        if (!$semester) {
            return redirect()->route('login')->with('error', 'Silakan login ulang untuk memilih semester.');
        }

        $semesterName = SemesterHelper::getName($semester);
        
        $kandidats = Kandidat::where('semester', $semester)->with('guru')->get();
        $gurus = Guru::whereNotIn('id', $kandidats->pluck('guru_id'))->get();

        return view('kandidat.index', compact('kandidats', 'gurus', 'semesterName', 'semester'));
    }

    public function store(Request $request)
    {
        $semester = session('semester');
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
        ]);

        Kandidat::firstOrCreate([
            'guru_id' => $request->guru_id,
            'semester' => $semester
        ]);

        return redirect()->back()->with('success', 'Guru berhasil ditambahkan sebagai kandidat semester ini.');
    }

    public function destroy($id)
    {
        $kandidat = Kandidat::findOrFail($id);
        $kandidat->delete();

        return redirect()->back()->with('success', 'Kandidat berhasil dihapus dari semester ini.');
    }
}
