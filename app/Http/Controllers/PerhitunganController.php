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
        $gurus = Guru::all();
        $results = [];

        foreach ($gurus as $guru) {
            $total_nilai = 0;
            
            // AMBIL RATA-RATA NILAI AKTUAL dari semua supervisi yang menilai guru ini, dikelompokkan per sub kriteria
            $penilaians = Penilaian::where('guru_id', $guru->id)
                ->select('sub_kriteria_id', \DB::raw('AVG(nilai_aktual) as rata_nilai'))
                ->groupBy('sub_kriteria_id')
                ->with('subKriteria')
                ->get();

            // Jika guru ini belum dinilai sama sekali oleh siapapun, lewatkan atau beri skor 0
            if ($penilaians->isEmpty()) {
                $results[] = ['nama' => $guru->nama_guru, 'skor' => 0];
                continue;
            }

            foreach ($penilaians as $p) {
                // 1. Hitung GAP menggunakan nilai rata-rata aktual: Rata-Rata Nilai - Nilai Ideal
                $gap = $p->rata_nilai - $p->subKriteria->nilai_ideal;

                // 2. Pembobotan GAP
                $bobot = $this->getBobot($gap);

                // 3. Hitung Kore & Secondary Factor
                if ($p->subKriteria->jenis_faktor == 'core') {
                    $total_nilai += ($bobot * 0.6); // Bobot Core Factor 60%
                } else {
                    $total_nilai += ($bobot * 0.4); // Bobot Secondary Factor 40%
                }
            }

            $results[] = [
                'nama' => $guru->nama_guru,
                'skor' => $total_nilai
            ];
        }

        // Urutkan ranking dari nilai tertinggi ke terendah
        usort($results, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return view('perhitungan.index', compact('results'));
    }

    // Fungsi Menampilkan Detail Penilaian 1 Guru Spesifik
    public function detail($guru_id)
    {
        $guru = Guru::findOrFail($guru_id);
        $kriterias = Kriteria::with('subKriterias')->get();
        
        // Ambil semua penilaian untuk guru ini
        $penilaians = Penilaian::where('guru_id', $guru_id)->with('user')->get();
        
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