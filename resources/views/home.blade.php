@extends('layouts.app')

@section('content')

    <h3 class="fw-bold mb-4">Dashboard Sistem SPK</h3>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa-solid fa-users"></i> Total Guru</h5>
                    <h2 class="fw-bold">{{ $totalGuru }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-success text-white border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa-solid fa-check-circle"></i> Sudah Dinilai</h5>
                    <h2 class="fw-bold">{{ $totalDinilai }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 p-4 bg-white rounded shadow-sm">
        <h5 class="fw-bold">Selamat Datang di Sistem Pendukung Keputusan</h5>
        <p class="text-muted">Aplikasi ini membantu Kepala Sekolah SD Muhammadiyah Sang Pencerah dalam menentukan Guru Terbaik menggunakan metode <strong>GAP Analysis</strong>. Silakan gunakan menu di atas untuk mulai mengelola data atau melihat hasil perangkingan.</p>
    </div>
</div>
@endsection