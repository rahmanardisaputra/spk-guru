<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Kepala Sekolah & Guru Supervisi (Admin/Staff)
        User::create([
            'name' => 'Kepala Sekolah', 
            'email' => 'kepsek@sdmuhammadiyah.com', 
            'password' => Hash::make('password123'), 
            'role' => 'kepala_sekolah'
        ]);
        
        $supervisis = ['Supervisi 1', 'Supervisi 2', 'Supervisi 3'];
        foreach ($supervisis as $s) {
            User::create([
                'name' => $s, 
                'email' => strtolower(str_replace(' ', '', $s)) . '@sdmuhammadiyah.com', 
                'password' => Hash::make('password123'), 
                'role' => 'guru_supervisi'
            ]);
        }

        // 2. Buat Data Guru sekaligus Akun User-nya (Role: guru)
        for ($i = 1; $i <= 5; $i++) {
            $namaGuru = 'Guru Ke-' . $i;
            $nip = '1990010' . $i;

            // Buat Profil Guru
            Guru::create([
                'nip' => $nip,
                'nama_guru' => $namaGuru,
                'jenis_kelamin' => ($i % 2 == 0) ? 'Laki-laki' : 'Perempuan',
                'pendidikan_terakhir' => 'S1 Pendidikan',
                'no_hp' => '08123456780' . $i
            ]);

            // Buat Akun Login Guru
            User::create([
                'name' => $namaGuru,
                'email' => $nip . '@sdmuhammadiyah.com',
                'password' => Hash::make('password123'),
                'role' => 'guru'
            ]);
        }

        // 3. Data Kriteria & Sub Kriteria Lengkap dengan Faktor GAP
        $kriterias = [
            ['kode' => 'K1', 'nama' => 'Kompetensi Pedagogik', 'bobot' => 25, 'subs' => [
                ['nama' => 'Penguasaan Kelas', 'target' => 5, 'faktor' => 'core'],
                ['nama' => 'Metode Mengajar', 'target' => 4, 'faktor' => 'core']
            ]],
            ['kode' => 'K2', 'nama' => 'Kompetensi Profesional', 'bobot' => 25, 'subs' => [
                ['nama' => 'Penguasaan Materi', 'target' => 5, 'faktor' => 'core'],
                ['nama' => 'Pengembangan Kurikulum', 'target' => 4, 'faktor' => 'secondary']
            ]],
            ['kode' => 'K3', 'nama' => 'Kompetensi Sosial', 'bobot' => 15, 'subs' => [
                ['nama' => 'Hubungan Guru-Siswa', 'target' => 4, 'faktor' => 'secondary'],
                ['nama' => 'Hubungan Rekan Kerja', 'target' => 4, 'faktor' => 'secondary']
            ]],
            ['kode' => 'K4', 'nama' => 'Kompetensi Kepribadian', 'bobot' => 15, 'subs' => [
                ['nama' => 'Kedisiplinan', 'target' => 5, 'faktor' => 'core'],
                ['nama' => 'Etika', 'target' => 4, 'faktor' => 'secondary']
            ]],
            ['kode' => 'K5', 'nama' => 'Absensi Kehadiran Guru', 'bobot' => 10, 'subs' => [
                ['nama' => 'Persentase Kehadiran', 'target' => 5, 'faktor' => 'secondary']
            ]],
            ['kode' => 'K6', 'nama' => 'Prestasi Guru', 'bobot' => 10, 'subs' => [
                ['nama' => 'Prestasi Akademik/Non-Akademik', 'target' => 4, 'faktor' => 'secondary']
            ]],
        ];

        foreach ($kriterias as $k) {
            $kriteria = Kriteria::create([
                'kode_kriteria' => $k['kode'],
                'nama_kriteria' => $k['nama'],
                'bobot_persen' => $k['bobot']
            ]);

            foreach ($k['subs'] as $sub) {
                SubKriteria::create([
                    'kriteria_id' => $kriteria->id,
                    'nama_sub_kriteria' => $sub['nama'],
                    'nilai_ideal' => $sub['target'],
                    'jenis_faktor' => $sub['faktor']
                ]);
            }
        }

        // 4. Seeder untuk User TU
        $this->call([
            TuSeeder::class
        ]);
    }
}