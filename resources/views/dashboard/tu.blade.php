@extends('layouts.app')

@section('page-title', 'Dashboard Tata Usaha')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-gauge-high text-primary me-2"></i>Dashboard TU</h4>
        <div class="badge bg-primary mb-2">Periode Aktif: {{ $periode_penilaian }}</div>
        <small class="text-muted d-block">Selamat datang, <strong>{{ Auth::user()->name }}</strong>. Anda login sebagai Tata Usaha.</small>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card bg-white border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="text-muted fw-bold mb-1">Total Guru Terdaftar</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $total_guru }} <span class="fs-6 text-muted fw-normal">Orang</span></h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-chalkboard-user fs-4"></i>
                    </div>
                </div>
                <a href="{{ route('guru.index') }}" class="text-decoration-none fw-bold small text-primary">Kelola Data Guru <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background-color: var(--bs-primary);"></div>
        </div>
    </div>
</div>
@endsection
