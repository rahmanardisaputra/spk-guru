@extends('layouts.app')

@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="mb-0 text-primary fw-bold"><i class="fa-solid fa-gear me-2"></i> Pengaturan Periode Penilaian</h6>
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="periode_penilaian" class="form-label fw-semibold">Periode Penilaian Aktif</label>
                        <input type="text" class="form-control" id="periode_penilaian" name="periode_penilaian" 
                               value="{{ $periode_penilaian ?? '' }}" placeholder="Contoh: Ganjil - 2024/2025" required>
                        <div class="form-text">Periode ini akan ditampilkan pada Dashboard Guru. Format yang disarankan: Semester - Tahun Ajaran.</div>
                    </div>

                    <div class="mb-4">
                        <label for="nama_kepsek" class="form-label fw-semibold">Nama Kepala Sekolah</label>
                        <input type="text" class="form-control" id="nama_kepsek" name="nama_kepsek" 
                               value="{{ $nama_kepsek ?? '' }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="nip_kepsek" class="form-label fw-semibold">NIP Kepala Sekolah</label>
                        <input type="text" class="form-control" id="nip_kepsek" name="nip_kepsek" 
                               value="{{ $nip_kepsek ?? '' }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="no_surat" class="form-label fw-semibold">Format Nomor Surat (Prefix)</label>
                        <input type="text" class="form-control" id="no_surat" name="no_surat" 
                               value="{{ $no_surat ?? '' }}" placeholder="Contoh: 2024/SPK-GURU/" required>
                        <div class="form-text">Format ini akan digunakan untuk nomor surat penghargaan. Peringkat guru akan ditambahkan di bagian akhir (contoh: .../001).</div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-save me-2"></i> Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
