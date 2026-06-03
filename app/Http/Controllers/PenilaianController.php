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
    // Menampilkan daftar guru YANG HANYA DI-FLOATING ke Supervisi yang sedang login
    public function index()
    {
        $userLogedIn = Auth::user();

        if ($userLogedIn->role == 'kepala_sekolah') {
            // Kalau Kepala Sekolah yang buka, dia bisa melihat semua guru
            $gurus = Guru::all();
        } else {
            // Kalau Guru Supervisi yang buka, filter lewat tabel floating_supervisis
            $gurus = Guru::whereIn('id', function($query) use ($userLogedIn) {
                $query->select('guru_id')
                      ->from('floating_supervisis')
                      ->where('supervisi_id', $userLogedIn->id);
            })->get();
        }

        return view('penilaian.index', compact('gurus'));
    }

    // Menampilkan form input nilai untuk 1 guru
    public function create($guru_id)
    {
        $userLogedIn = Auth::user();
        $guru = Guru::findOrFail($guru_id);
        
        // Pastikan Guru Supervisi tidak menembak URL manual untuk menilai guru yang bukan haknya
        if ($userLogedIn->role != 'kepala_sekolah') {
            $isAssigned = FloatingSupervisi::where('supervisi_id', $userLogedIn->id)
                                           ->where('guru_id', $guru_id)
                                           ->exists();
            if (!$isAssigned) {
                return redirect()->route('penilaian.index')->with('error', 'Anda tidak ditugaskan untuk menilai guru ini!');
            }
        }

        $kriterias = Kriteria::with('subKriterias')->get();
        
        // Ambil nilai yang pernah diinput OLEH SUPERVISI YANG SEDANG LOGIN SAJA
        $penilaian_sebelumnya = Penilaian::where('guru_id', $guru_id)
            ->where('user_id', $userLogedIn->id)
            ->pluck('nilai_aktual', 'sub_kriteria_id')
            ->toArray();

        return view('penilaian.create', compact('guru', 'kriterias', 'penilaian_sebelumnya'));
    }

    // Menyimpan nilai ke database dengan mencatat ID Supervisi penilai
    public function store(Request $request, $guru_id)
    {
        $userLogedIn = Auth::user();

        // 1. PROSES PENILAIAN STANDAR (K1 - K4)
        if ($request->has('nilai_aktual')) {
            foreach ($request->nilai_aktual as $sub_kriteria_id => $nilai) {
                Penilaian::updateOrCreate(
                    [
                        'user_id' => $userLogedIn->id, 
                        'guru_id' => $guru_id, 
                        'sub_kriteria_id' => $sub_kriteria_id
                    ],
                    ['nilai_aktual' => $nilai]
                );
            }
        }

        // 2. PROSES PENILAIAN ABSENSI (K5) - Konversi Hari ke Skala 1-5
        if ($request->has('absensi')) {
            foreach ($request->absensi as $sub_kriteria_id => $data_absen) {
                
                // JIKA INPUTAN HARI KOSONG (SAAT EDIT), ABAIKAN DAN JANGAN TIMPA DATA LAMA
                if (empty($data_absen['total_hari'])) {
                    continue;
                }

                $total_hari = $data_absen['total_hari'];
                $sakit = $data_absen['sakit'] ?? 0;
                $izin = $data_absen['izin'] ?? 0;
                $alfa = $data_absen['alfa'] ?? 0;

                // Hitung total hadir
                $tidak_hadir = $sakit + $izin + $alfa;
                $hadir = $total_hari - $tidak_hadir;

                // Hitung persentase kehadiran
                $persentase = ($total_hari > 0) ? ($hadir / $total_hari) * 100 : 0;

                // Mapping ke skala 1-5 berdasarkan persentase
                $nilai_absensi = 1;
                if ($persentase >= 96) {
                    $nilai_absensi = 5;
                } elseif ($persentase >= 91) {
                    $nilai_absensi = 4;
                } elseif ($persentase >= 81) {
                    $nilai_absensi = 3;
                } elseif ($persentase >= 71) {
                    $nilai_absensi = 2;
                } else {
                    $nilai_absensi = 1;
                }

                // Simpan ke database
                Penilaian::updateOrCreate(
                    [
                        'user_id' => $userLogedIn->id, 
                        'guru_id' => $guru_id, 
                        'sub_kriteria_id' => $sub_kriteria_id
                    ],
                    ['nilai_aktual' => $nilai_absensi]
                );
            }
        }

        // 3. PROSES PENILAIAN PRESTASI (K6) - Konversi Teks ke Skala 1-5
        if ($request->has('prestasi')) {
            foreach ($request->prestasi as $sub_kriteria_id => $level_prestasi) {
                // Mapping tingkat prestasi ke angka
                $nilai_prestasi = 1;
                if ($level_prestasi == 'nasional') {
                    $nilai_prestasi = 5;
                } elseif ($level_prestasi == 'provinsi') {
                    $nilai_prestasi = 4;
                } elseif ($level_prestasi == 'kota') {
                    $nilai_prestasi = 3;
                } elseif ($level_prestasi == 'sekolah') {
                    $nilai_prestasi = 2;
                } elseif ($level_prestasi == 'tidak_ada') {
                    $nilai_prestasi = 1;
                }

                // Simpan ke database
                Penilaian::updateOrCreate(
                    [
                        'user_id' => $userLogedIn->id, 
                        'guru_id' => $guru_id, 
                        'sub_kriteria_id' => $sub_kriteria_id
                    ],
                    ['nilai_aktual' => $nilai_prestasi]
                );
            }
        }

        return redirect()->route('penilaian.index')->with('success', 'Data berhasil diproses! Sistem telah mengkalkulasi absensi dan prestasi secara otomatis.');
    }
}