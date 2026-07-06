<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SuratPenghargaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuruRewardController extends Controller
{
    // Fungsi internal untuk mendapatkan peringkat guru beserta nilainya
    private function getTopGurus()
    {
        $semester = session('semester');
        $kandidatIds = \App\Models\Kandidat::where('semester', $semester)->pluck('guru_id');
        $gurus = Guru::whereIn('id', $kandidatIds)->get();
        $hasil = [];

        foreach ($gurus as $guru) {
            $total_nilai = 0;
            $penilaians = Penilaian::where('guru_id', $guru->id)
                ->where('semester', $semester)
                ->select('sub_kriteria_id', \DB::raw('AVG(nilai_aktual) as rata_nilai'))
                ->groupBy('sub_kriteria_id')
                ->get();

            if ($penilaians->isEmpty()) continue;

            foreach ($penilaians as $p) {
                $gap = $p->rata_nilai - $p->subKriteria->nilai_ideal;
                
                // Pembobotan GAP
                $map = [0 => 5, 1 => 4.5, -1 => 4, 2 => 3.5, -2 => 3, 3 => 2.5, -3 => 2, 4 => 1.5, -4 => 1];
                $bobot = $map[round($gap)] ?? 0;

                if ($p->subKriteria->jenis_faktor == 'core') {
                    $total_nilai += ($bobot * 0.6);
                } else {
                    $total_nilai += ($bobot * 0.4);
                }
            }

            $hasil[] = [
                'guru' => $guru,
                'skor' => $total_nilai
            ];
        }

        // Urutkan dari skor tertinggi
        usort($hasil, function($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        return $hasil;
    }

    private function getGuruTerbaikId()
    {
        $top = $this->getTopGurus();
        return !empty($top) ? $top[0]['guru']->id : null;
    }

    // Halaman Penghargaan untuk Akun Guru yang Login
    public function halamanGuru()
    {
        $user = Auth::user();
        $semester = session('semester');
        
        $guru = Guru::where('nama_guru', $user->name)
                    ->orWhere('email', $user->email)
                    ->first();

        if (!$guru) {
            return view('reward.guru_index', ['isJuara' => false, 'pesan' => 'Data Guru Anda tidak ditemukan di sistem master.']);
        }

        $validasi = \App\Models\ValidasiKepsek::where('semester', $semester)->first();
        if (!$validasi || !$validasi->is_validated) {
            return view('reward.guru_index', [
                'isJuara' => false, 
                'pesan' => 'Menunggu validasi hasil penilaian dari Kepala Sekolah untuk semester aktif.',
                'guru' => $guru,
                'arsip' => null
            ]);
        }

        $idJuara1 = $this->getGuruTerbaikId();
        $isJuara = ($guru->id == $idJuara1);
        
        $arsip = SuratPenghargaan::where('guru_id', $guru->id)->first();

        return view('reward.guru_index', compact('isJuara', 'guru', 'arsip'));
    }

    // Cetak Surat Pengumuman Juara 1, 2, 3
    public function cetakPengumuman($guru_id, $peringkat)
    {
        $guru = Guru::findOrFail($guru_id);
        return view('reward.cetak_pengumuman', compact('guru', 'peringkat'));
    }

    // Cetak Surat Pemberian Insentif
    public function cetakInsentif($guru_id, $peringkat)
    {
        $guru = Guru::findOrFail($guru_id);
        return view('reward.cetak_insentif', compact('guru', 'peringkat'));
    }

    // Proses Upload Dokumen yang Sudah Ditandatangani oleh Guru Terbaik
    public function uploadSurat(Request $request, $guru_id)
    {
        $request->validate([
            'file_pengumuman' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_insentif' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $arsip = SuratPenghargaan::firstOrNew(['guru_id' => $guru_id]);

        if ($request->hasFile('file_pengumuman')) {
            if ($arsip->file_pengumuman) Storage::delete('public/' . $arsip->file_pengumuman);
            $arsip->file_pengumuman = $request->file('file_pengumuman')->store('surat_arsip', 'public');
        }

        if ($request->hasFile('file_insentif')) {
            if ($arsip->file_insentif) Storage::delete('public/' . $arsip->file_insentif);
            $arsip->file_insentif = $request->file('file_insentif')->store('surat_arsip', 'public');
        }

        $arsip->save();
        return redirect()->back()->with('success', 'Berhasil mengunggah dokumen arsip penghargaan resmi!');
    }

    // Halaman Monitoring / Audit untuk Kepala Sekolah / Admin
    public function halamanAdmin()
    {
        $idJuara1 = $this->getGuruTerbaikId();
        $guruTerbaik = Guru::find($idJuara1);
        $arsip = $guruTerbaik ? SuratPenghargaan::where('guru_id', $guruTerbaik->id)->first() : null;

        return view('reward.admin_index', compact('guruTerbaik', 'arsip'));
    }

    // Halaman Manajemen Sertifikat untuk TU
    public function halamanTu()
    {
        $semester = session('semester');
        $validasi = \App\Models\ValidasiKepsek::where('semester', $semester)->first();
        
        $top3 = [];
        if ($validasi && $validasi->is_validated) {
            $topGurusData = $this->getTopGurus();
            $top3 = array_slice($topGurusData, 0, 3);
        }
        
        return view('reward.tu_index', compact('top3', 'validasi'));
    }
}