@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-chart-pie text-primary me-2"></i>Dashboard Kepala Sekolah</h4>
            <div class="badge bg-primary mb-2">Periode Penilaian: {{ $periode_penilaian }}</div>
            <small class="text-muted d-block">Selamat datang kembali, Pimpinan SD Muhammadiyah Sang Pencerah.</small>
        </div>
        <div class="col-md-6 text-md-end mt-2 mt-md-0">
            <span class="badge bg-dark py-2 px-3 shadow-sm"><i class="fa-solid fa-calendar-day me-1"></i> Tahun Aktif: {{ date('Y') }}</span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 bg-primary text-white h-100">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 small mb-1">Total Guru</h6>
                        <h3 class="fw-bold mb-0">{{ $totalGuru }}</h3>
                    </div>
                    <i class="fa-solid fa-users text-white-50" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 bg-success text-white h-100">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 small mb-1">Tim Supervisi</h6>
                        <h3 class="fw-bold mb-0">{{ $totalSupervisi }}</h3>
                    </div>
                    <i class="fa-solid fa-user-shield text-white-50" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 bg-warning text-dark h-100">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-dark-50 small mb-1">Kriteria SPK</h6>
                        <h3 class="fw-bold mb-0">{{ $totalKriteria }}</h3>
                    </div>
                    <i class="fa-solid fa-list-check text-dark-50" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 bg-danger text-white h-100">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 small mb-1">Metode SPK</h6>
                        <h5 class="fw-bold mb-0 pt-1">GAP Analysis</h5>
                    </div>
                    <i class="fa-solid fa-calculator text-white-50" style="font-size: 1.8rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
        <div class="card-body bg-light p-4 position-relative">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="badge bg-warning text-dark mb-2 fw-bold"><i class="fa-solid fa-crown me-1"></i> Skor Tertinggi Saat Ini</span>
                    <h3 class="fw-bold text-dark mb-1">{{ $guruTerbaik }}</h3>
                    <p class="text-muted small mb-0">Nilai terhitung secara objektif berdasarkan akumulasi rata-rata penilaian instrumen dari seluruh tim supervisi.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('perhitungan.index') }}" class="btn btn-dark fw-bold px-4 shadow-sm py-2">
                        <i class="fa-solid fa-ranking-star me-2"></i> Lihat Hasil Perangkingan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-route text-primary me-2"></i>Alur Manajemen Sistem SPK Anda</div>
        <div class="card-body">
            <div class="row g-3 text-center small">
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-light rounded-3 h-100 border">
                        <span class="badge bg-secondary mb-2">Langkah 1</span>
                        <h6 class="fw-bold mb-1">Data Guru & Kriteria</h6>
                        <p class="text-muted mb-0 xs-text">Kelola master data pendidik & bobot indikator.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-light rounded-3 h-100 border">
                        <span class="badge bg-secondary mb-2">Langkah 2</span>
                        <h6 class="fw-bold mb-1">Floating Tugas</h6>
                        <p class="text-muted mb-0 xs-text">Plotting tim penilai supervisi ke target guru.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-light rounded-3 h-100 border">
                        <span class="badge bg-secondary mb-2">Langkah 3</span>
                        <h6 class="fw-bold mb-1">Operasional Nilai</h6>
                        <p class="text-muted mb-0 xs-text">Supervisi menginputkan nilai aktual kinerja.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-light rounded-3 h-100 border">
                        <span class="badge bg-success mb-2">Langkah 4</span>
                        <h6 class="fw-bold mb-1">Hasil & Cetak</h6>
                        <p class="text-muted mb-0 xs-text">Lihat detail GAP, perangkingan, dan berkas award.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection