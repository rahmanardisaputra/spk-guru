<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\FloatingSupervisi;
use App\Models\SuratPenghargaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        
        // --- LOGIKA DASHBOARD KEPALA SEKOLAH ---
        if ($role == 'kepala_sekolah') {
            $totalGuru = Guru::count();
            $totalSupervisi = User::where('role', 'guru_supervisi')->count();
            $totalKriteria = Kriteria::count();
            
            // Mencari Guru Terbaik (Peringkat 1) Secara Real-Time dari Database
            $gurus = Guru::all();
            $topSkor = -1;
            $guruTerbaik = "Belum ada penilaian";

            foreach ($gurus as $g) {
                $total_nilai = 0;
                $penilaians = Penilaian::where('guru_id', $g->id)
                    ->select('sub_kriteria_id', \DB::raw('AVG(nilai_aktual) as rata_nilai'))
                    ->groupBy('sub_kriteria_id')
                    ->get();

                if ($penilaians->isEmpty()) continue;

                foreach ($penilaians as $p) {
                    $gap = $p->rata_nilai - $p->subKriteria->nilai_ideal;
                    $map = [0 => 5, 1 => 4.5, -1 => 4, 2 => 3.5, -2 => 3, 3 => 2.5, -3 => 2, 4 => 1.5, -4 => 1];
                    $bobot = $map[round($gap)] ?? 0;

                    if ($p->subKriteria->jenis_faktor == 'core') {
                        $total_nilai += ($bobot * 0.6);
                    } else {
                        $total_nilai += ($bobot * 0.4);
                    }
                }

                if ($total_nilai > $topSkor) {
                    $topSkor = $total_nilai;
                    $guruTerbaik = $g->nama_guru;
                }
            }

            return view('dashboard.kepsek', compact('totalGuru', 'totalSupervisi', 'totalKriteria', 'guruTerbaik'));
        } 
        
        // --- LOGIKA DASHBOARD GURU SUPERVISI ---
        elseif ($role == 'guru_supervisi') {
            // Hitung jumlah guru yang ditugaskan kepada supervisi ini oleh Kepsek
            $totalTugasGuru = FloatingSupervisi::where('supervisi_id', $user->id)->count();
            
            // Hitung berapa guru yang sudah selesai dinilai oleh supervisi ini
            $totalSelesaiDinilai = Penilaian::where('user_id', $user->id)
                ->distinct('guru_id')
                ->count('guru_id');

            return view('dashboard.supervisi', compact('totalTugasGuru', 'totalSelesaiDinilai'));
        } 
        
        // --- LOGIKA DASHBOARD GURU BIASA ---
        else {
            // Cari data profil guru berdasarkan kesamaan nama user yang login
            $guru = Guru::where('nama_guru', $user->name)->first();
            
            // Cek apakah guru ini memenangkan peringkat 1
            $idJuara1 = null;
            $gurus = Guru::all();
            $topSkor = -1;
            foreach ($gurus as $g) {
                $total_nilai = 0;
                $penilaians = Penilaian::where('guru_id', $g->id)->select('sub_kriteria_id', \DB::raw('AVG(nilai_aktual) as rata_nilai'))->groupBy('sub_kriteria_id')->get();
                if ($penilaians->isEmpty()) continue;
                foreach ($penilaians as $p) {
                    $gap = $p->rata_nilai - $p->subKriteria->nilai_ideal;
                    $map = [0 => 5, 1 => 4.5, -1 => 4, 2 => 3.5, -2 => 3, 3 => 2.5, -3 => 2, 4 => 1.5, -4 => 1];
                    $bobot = $map[round($gap)] ?? 0;
                    if ($p->subKriteria->jenis_faktor == 'core') { $total_nilai += ($bobot * 0.6); } else { $total_nilai += ($bobot * 0.4); }
                }
                if ($total_nilai > $topSkor) { $topSkor = $total_nilai; $idJuara1 = $g->id; }
            }

            $isJuara1 = ($guru && $guru->id == $idJuara1);
            $arsip = $guru ? SuratPenghargaan::where('guru_id', $guru->id)->first() : null;

            return view('dashboard.guru', compact('guru', 'isJuara1', 'arsip'));
        }
    }
}