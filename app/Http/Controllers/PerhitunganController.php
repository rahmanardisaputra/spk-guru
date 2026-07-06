<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function index()
    {
        $semester = session('semester');
        if (!$semester) return redirect()->route('login');

        // Ambil ID kandidat pada semester ini
        $kandidatIds = \App\Models\Kandidat::where('semester', $semester)->pluck('guru_id');
        $gurus = Guru::whereIn('id', $kandidatIds)->get();
        
        $kriterias = Kriteria::with('subKriterias')->get();
        $hasil_akhir = [];

        foreach ($gurus as $guru) {
            $total_nilai_guru = 0;
            $rincian = [];

            foreach ($kriterias as $kriteria) {
                $total_core = 0;
                $total_secondary = 0;
                $count_core = 0;
                $count_secondary = 0;

                foreach ($kriteria->subKriterias as $sub) {
                    $penilaian = Penilaian::where('guru_id', $guru->id)
                                          ->where('sub_kriteria_id', $sub->id)
                                          ->where('semester', $semester)
                                          ->first();
                    
                    if ($penilaian) {
                        $nilai_aktual = $penilaian->nilai_aktual;
                        $nilai_ideal = $sub->nilai_ideal;
                        $gap = $nilai_aktual - $nilai_ideal;
                        $bobot_gap = $this->getBobot($gap);

                        if ($sub->jenis_faktor == 'core') {
                            $total_core += $bobot_gap;
                            $count_core++;
                        } else {
                            $total_secondary += $bobot_gap;
                            $count_secondary++;
                        }
                    }
                }

                $nc = $count_core > 0 ? ($total_core / $count_core) : 0;
                $ns = $count_secondary > 0 ? ($total_secondary / $count_secondary) : 0;
                
                $nilai_total_kriteria = (0.6 * $nc) + (0.4 * $ns);
                $total_nilai_guru += ($nilai_total_kriteria * ($kriteria->bobot_persen / 100));

                $rincian[$kriteria->kode_kriteria] = round($nilai_total_kriteria, 2);
            }

            $hasil_akhir[] = [
                'guru' => $guru,
                'rincian' => $rincian,
                'total' => round($total_nilai_guru, 4)
            ];
        }

        // Urutkan berdasarkan total tertinggi
        usort($hasil_akhir, function($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        // Cek status validasi
        $validasi = \App\Models\ValidasiKepsek::where('semester', $semester)->first();

        return view('perhitungan.index', compact('hasil_akhir', 'kriterias', 'validasi'));
    }

    public function validasi()
    {
        $semester = session('semester');
        if (!$semester) return redirect()->route('login');

        \App\Models\ValidasiKepsek::updateOrCreate(
            ['semester' => $semester],
            [
                'is_validated' => true,
                'validated_by' => \Illuminate\Support\Facades\Auth::id(),
                'validated_at' => now(),
            ]
        );

        return redirect()->route('perhitungan.index')->with('success', 'Hasil perankingan berhasil divalidasi!');
    }

    public function cetakRekap()
    {
        $semester = session('semester');
        if (!$semester) return redirect()->route('login');
        
        $validasi = \App\Models\ValidasiKepsek::where('semester', $semester)->first();
        if (!$validasi || !$validasi->is_validated) {
            return redirect()->route('perhitungan.index')->with('error', 'Ranking belum divalidasi!');
        }

        $kandidatIds = \App\Models\Kandidat::where('semester', $semester)->pluck('guru_id');
        $gurus = Guru::whereIn('id', $kandidatIds)->get();
        $kriterias = Kriteria::with('subKriterias')->get();
        $hasil_akhir = [];

        foreach ($gurus as $guru) {
            $total_nilai_guru = 0;
            $rincian = [];

            foreach ($kriterias as $kriteria) {
                $total_core = 0;
                $total_secondary = 0;
                $count_core = 0;
                $count_secondary = 0;

                foreach ($kriteria->subKriterias as $sub) {
                    $penilaian = Penilaian::where('guru_id', $guru->id)
                                          ->where('sub_kriteria_id', $sub->id)
                                          ->where('semester', $semester)
                                          ->first();
                    
                    if ($penilaian) {
                        $nilai_aktual = $penilaian->nilai_aktual;
                        $nilai_ideal = $sub->nilai_ideal;
                        $gap = $nilai_aktual - $nilai_ideal;
                        $bobot_gap = $this->getBobot($gap);

                        if ($sub->jenis_faktor == 'core') {
                            $total_core += $bobot_gap;
                            $count_core++;
                        } else {
                            $total_secondary += $bobot_gap;
                            $count_secondary++;
                        }
                    }
                }

                $nc = $count_core > 0 ? ($total_core / $count_core) : 0;
                $ns = $count_secondary > 0 ? ($total_secondary / $count_secondary) : 0;
                
                $nilai_total_kriteria = (0.6 * $nc) + (0.4 * $ns);
                $total_nilai_guru += ($nilai_total_kriteria * ($kriteria->bobot_persen / 100));

                $rincian[$kriteria->kode_kriteria] = round($nilai_total_kriteria, 2);
            }

            $hasil_akhir[] = [
                'guru' => $guru,
                'rincian' => $rincian,
                'total' => round($total_nilai_guru, 4)
            ];
        }

        usort($hasil_akhir, function($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        // Ambil penilai (supervisi) di semester aktif untuk TTD
        $supervisis = \App\Models\User::where('role', 'guru_supervisi')
            ->whereIn('id', function($q) use ($semester) {
                $q->select('supervisi_id')->from('floating_supervisis')->where('semester', $semester);
            })->get();

        return view('perhitungan.cetak_rekap', compact('hasil_akhir', 'kriterias', 'validasi', 'supervisis'));
    }

    // Fungsi Menampilkan Detail Penilaian 1 Guru Spesifik
    public function detail($guru_id)
    {
        $semester = session('semester');
        $guru = Guru::findOrFail($guru_id);
        $kriterias = Kriteria::with('subKriterias')->get();
        $penilaians = Penilaian::where('guru_id', $guru_id)
                               ->where('semester', $semester)
                               ->get();
        
        // Cari tahu siapa saja Guru Supervisi yang sudah memberikan nilai untuk guru ini
        $supervisis = \App\Models\User::whereIn('id', $penilaians->pluck('user_id'))->get();

        // Mapping nilai ke dalam array matriks [$sub_kriteria_id][$user_id] = nilai
        $matriks_nilai = [];
        foreach ($penilaians as $p) {
            $matriks_nilai[$p->sub_kriteria_id][$p->user_id] = $p->nilai_aktual;
        }

        return view('perhitungan.detail', compact('guru', 'kriterias', 'supervisis', 'matriks_nilai'));
    }

    // Fungsi pembantu pembobotan GAP (Gunakan fungsi getBobot yang sudah ada sebelumnya)
    private function getBobot($gap) {
        $map = [0 => 5, 1 => 4.5, -1 => 4, 2 => 3.5, -2 => 3, 3 => 2.5, -3 => 2, 4 => 1.5, -4 => 1];
        return $map[$gap] ?? 0;
    }

}