@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-user-shield text-success me-2"></i>Dashboard Guru Supervisi</h4>
            <div class="badge bg-success mb-2">Periode Aktif: {{ $periode_penilaian }}</div>
            <small class="text-muted d-block">Halo, <strong>{{ Auth::user()->name }}</strong>. Panel ini khusus untuk mengevaluasi kinerja pendidik.</small>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 bg-success bg-gradient p-3 text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 small mb-1">Target Guru yang Harus Anda Nilai</h6>
                        <h2 class="fw-bold mb-0">{{ $totalTugasGuru }} Pengajar</h2>
                    </div>
                    <i class="fa-solid fa-clipboard-user" style="font-size: 2.5rem; opacity: 0.4;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 bg-secondary bg-gradient p-3 text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 small mb-1">Guru yang Selesai Anda Evaluasi</h6>
                        <h2 class="fw-bold mb-0">{{ $totalSelesaiDinilai }} Pengajar</h2>
                    </div>
                    <i class="fa-solid fa-circle-check" style="font-size: 2.5rem; opacity: 0.4;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4 text-center bg-light">
            <i class="fa-solid fa-pen-to-square text-success mb-3" style="font-size: 3rem;"></i>
            <h5 class="fw-bold text-dark">Mulai Mengisi Instrumen Penilaian Kinerja</h5>
            <p class="text-muted small mx-auto" style="max-width: 600px;">Sistem akan menyaring secara otomatis daftar guru yang di-floating oleh Kepala Sekolah kepada Anda. Pastikan memberikan nilai aktual yang objektif demi validitas hasil SPK.</p>
            <a href="{{ route('penilaian.index') }}" class="btn btn-success fw-bold px-4 py-2 mt-2 shadow-sm">
                <i class="fa-solid fa-arrow-right me-1"></i> Masuk Menu Penilaian
            </a>
        </div>
    </div>
</div>
@endsection