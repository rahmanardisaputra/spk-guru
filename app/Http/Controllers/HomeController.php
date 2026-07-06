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
        $userLogedIn = Auth::user();
        $semester = session('semester');
        if (!$semester) return redirect()->route('login');

        $periode_penilaian = \App\Helpers\SemesterHelper::getName($semester);

        if ($userLogedIn->role == 'kepala_sekolah' || $userLogedIn->role == 'guru_supervisi') {
            // Dashboard Admin/Kepsek/Supervisi
            $total_guru = Guru::count();
            // Ambil kriteria beserta sub kriterianya
            $kriterias = Kriteria::with('subKriterias')->get();
            
            // Hitung kandidat aktif semester ini
            $total_kandidat = \App\Models\Kandidat::where('semester', $semester)->count();

            // Hitung total nilai per kriteria untuk chart radar pada SEMESTER AKTIF
            $labels = [];
            $data_rata_rata = [];

            foreach ($kriterias as $kriteria) {
                $labels[] = $kriteria->nama_kriteria;
                $rata_rata_kriteria = 0;
                $jumlah_sub = $kriteria->subKriterias->count();
                
                if ($jumlah_sub > 0) {
                    $total_nilai_all_sub = 0;
                    foreach ($kriteria->subKriterias as $sub) {
                        $avg = Penilaian::where('sub_kriteria_id', $sub->id)
                                        ->where('semester', $semester)
                                        ->avg('nilai_aktual') ?? 0;
                        $total_nilai_all_sub += $avg;
                    }
                    $rata_rata_kriteria = $total_nilai_all_sub / $jumlah_sub;
                }
                
                $data_rata_rata[] = round($rata_rata_kriteria, 2);
            }

            $totalKriteria = Kriteria::count();
            $totalSupervisi = User::where('role', 'guru_supervisi')->count();

            // Ambil ID Juara 1 dari controller GuruReward
            $rewardController = new GuruRewardController();
            $method = new \ReflectionMethod(GuruRewardController::class, 'getGuruTerbaikId');
            $method->setAccessible(true);
            $idJuara1 = $method->invoke($rewardController);

            $guruObj = $idJuara1 ? Guru::find($idJuara1) : null;
            $guruTerbaik = $guruObj ? $guruObj->nama_guru : "Belum ada penilaian";

            if ($userLogedIn->role == 'kepala_sekolah') {
                $totalGuru = $total_guru;
                return view('dashboard.kepsek', compact('totalGuru', 'totalSupervisi', 'totalKriteria', 'guruTerbaik', 'periode_penilaian'));
            } else {
                // Dashboard Guru Supervisi
                $totalTugasGuru = FloatingSupervisi::where('supervisi_id', $userLogedIn->id)
                    ->where('semester', $semester)->count();
                $totalSelesaiDinilai = Penilaian::where('user_id', $userLogedIn->id)
                    ->where('semester', $semester)
                    ->distinct('guru_id')
                    ->count('guru_id');

                return view('dashboard.supervisi', compact('totalTugasGuru', 'totalSelesaiDinilai', 'periode_penilaian'));
            }
            
        } elseif ($userLogedIn->role == 'tu') {
            $total_guru = Guru::count();
            return view('dashboard.tu', compact('total_guru', 'periode_penilaian'));
        } else {
            // Dashboard Guru
            $guru = Guru::where('nama_guru', $userLogedIn->name)
                        ->orWhere('email', $userLogedIn->email)
                        ->first();
            
            $rewardController = new GuruRewardController();
            $method = new \ReflectionMethod(GuruRewardController::class, 'getGuruTerbaikId');
            $method->setAccessible(true);
            $idJuara1 = $method->invoke($rewardController);

            $validasi = \App\Models\ValidasiKepsek::where('semester', $semester)->first();
            $isJuara1 = ($guru && $guru->id == $idJuara1 && $validasi && $validasi->is_validated);
            $arsip = $guru ? SuratPenghargaan::where('guru_id', $guru->id)->first() : null;

            return view('dashboard.guru', compact('guru', 'isJuara1', 'arsip', 'periode_penilaian'));
        }
    }
}