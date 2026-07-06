<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\FloatingSupervisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function index()
    {
        $semester = session('semester');
        if (!$semester) return redirect()->route('login')->with('error', 'Silakan pilih semester.');

        $userLogedIn = Auth::user();

        if ($userLogedIn->role == 'kepala_sekolah') {
            $kandidatIds = \App\Models\Kandidat::where('semester', $semester)->pluck('guru_id');
            $gurus = Guru::whereIn('id', $kandidatIds)->get();
        } else {
            $gurus = Guru::whereIn('id', function($query) use ($userLogedIn, $semester) {
                $query->select('guru_id')
                      ->from('floating_supervisis')
                      ->where('supervisi_id', $userLogedIn->id)
                      ->where('semester', $semester);
            })->get();
        }

        $totalSubKriteria = Kriteria::withCount('subKriterias')->get()->sum('sub_kriterias_count');
        foreach ($gurus as $guru) {
            $dinilai = Penilaian::where('guru_id', $guru->id)
                                ->where('semester', $semester)
                                ->count();
            
            $persentase = $totalSubKriteria > 0 ? round(($dinilai / $totalSubKriteria) * 100) : 0;
            
            $guru->status_penilaian = $persentase >= 100 ? 'Selesai' : 'Belum Selesai';
            $guru->persentase_penilaian = $persentase;
        }

        return view('penilaian.index', compact('gurus'));
    }

    public function create($guru_id)
    {
        $semester = session('semester');
        $guru = Guru::findOrFail($guru_id);
        $kriterias = Kriteria::with('subKriterias')->get();
        
        $penilaians = Penilaian::where('guru_id', $guru_id)
                               ->where('semester', $semester)
                               ->get()
                               ->keyBy('sub_kriteria_id');

        return view('penilaian.create', compact('guru', 'kriterias', 'penilaians'));
    }

    public function store(Request $request, $guru_id)
    {
        $semester = session('semester');
        $userLogedIn = Auth::user();

        // 1. PROSES PENILAIAN STANDAR (K1 - K4)
        if ($request->has('nilai_aktual')) {
            foreach ($request->nilai_aktual as $sub_kriteria_id => $nilai) {
                Penilaian::updateOrCreate(
                    [
                        'user_id' => $userLogedIn->id, 
                        'guru_id' => $guru_id, 
                        'sub_kriteria_id' => $sub_kriteria_id,
                        'semester' => $semester
                    ],
                    ['nilai_aktual' => $nilai]
                );
            }
        }

        // 2. PROSES PENILAIAN ABSENSI (K5)
        if ($request->has('absensi')) {
            foreach ($request->absensi as $sub_kriteria_id => $data_absen) {
                if (empty($data_absen['total_hari'])) continue;

                $total_hari = $data_absen['total_hari'];
                $sakit = $data_absen['sakit'] ?? 0;
                $izin = $data_absen['izin'] ?? 0;
                $alfa = $data_absen['alfa'] ?? 0;

                $hadir = $total_hari - ($sakit + $izin + $alfa);
                $persentase = ($total_hari > 0) ? ($hadir / $total_hari) * 100 : 0;

                $nilai_absensi = 1;
                if ($persentase >= 96) $nilai_absensi = 5;
                elseif ($persentase >= 91) $nilai_absensi = 4;
                elseif ($persentase >= 81) $nilai_absensi = 3;
                elseif ($persentase >= 71) $nilai_absensi = 2;

                Penilaian::updateOrCreate(
                    [
                        'user_id' => $userLogedIn->id, 
                        'guru_id' => $guru_id, 
                        'sub_kriteria_id' => $sub_kriteria_id,
                        'semester' => $semester
                    ],
                    ['nilai_aktual' => $nilai_absensi]
                );
            }
        }

        // 3. PROSES PENILAIAN PRESTASI (K6)
        if ($request->has('prestasi')) {
            foreach ($request->prestasi as $sub_kriteria_id => $level_prestasi) {
                $nilai_prestasi = 1;
                if ($level_prestasi == 'nasional') $nilai_prestasi = 5;
                elseif ($level_prestasi == 'provinsi') $nilai_prestasi = 4;
                elseif ($level_prestasi == 'kota') $nilai_prestasi = 3;
                elseif ($level_prestasi == 'sekolah') $nilai_prestasi = 2;

                Penilaian::updateOrCreate(
                    [
                        'user_id' => $userLogedIn->id, 
                        'guru_id' => $guru_id, 
                        'sub_kriteria_id' => $sub_kriteria_id,
                        'semester' => $semester
                    ],
                    ['nilai_aktual' => $nilai_prestasi]
                );
            }
        }

        return redirect()->route('penilaian.index')->with('success', 'Data berhasil diproses! Sistem telah mengkalkulasi absensi dan prestasi secara otomatis.');
    }
}