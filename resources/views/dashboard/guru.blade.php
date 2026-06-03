@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-chalkboard-user text-info me-2"></i>Dashboard Guru</h4>
            <small class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong>. Panel informasi profil & capaian kerja Anda.</small>
        </div>
    </div>

    @if($guru)
        @if($isJuara1)
            <div class="card border-0 shadow-sm bg-gradient text-white p-4 mb-4" style="background: linear-gradient(135deg, #f39c12, #d35400);">
                <div class="row align-items-center">
                    <div class="col-md-1 text-center mb-2 mb-md-0">
                        <i class="fa-solid fa-trophy text-white" style="font-size: 3.5rem;"></i>
                    </div>
                    <div class="col-md-8">
                        <h4 class="fw-bold mb-1">Selamat! Anda Terpilih Sebagai Guru Terbaik Periode Ini</h4>
                        <p class="mb-0 small opacity-90">Berdasarkan kalkulasi matriks profile matching GAP Analysis dari tim supervisi, Anda berhasil menduduki peringkat pertama. Silakan unduh berkas piagam & insentif Anda melalui menu penghargaan.</p>
                    </div>
                    <div class="col-md-3 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('reward.guru') }}" class="btn btn-white bg-white text-dark fw-bold btn-sm shadow">
                            <i class="fa-solid fa-print me-1"></i> Ambil Dokumen Resmi
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-dark text-white fw-bold py-3"><i class="fa-solid fa-address-card me-2"></i>Biodata Pendidik Terdaftar</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6 col-md-4">
                        <span class="text-muted d-block small">Nomor Induk Pegawai (NIP)</span>
                        <strong class="text-dark">{{ $guru->nip ?? '-' }}</strong>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <span class="text-muted d-block small">Nama Lengkap</span>
                        <strong class="text-dark">{{ $guru->nama_guru }}</strong>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <span class="text-muted d-block small">Jenis Kelamin</span>
                        <strong class="text-dark">{{ $guru->jenis_kelamin }}</strong>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <span class="text-muted d-block small">Pendidikan Terakhir</span>
                        <strong class="text-dark">{{ $guru->pendidikan_terakhir ?? '-' }}</strong>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <span class="text-muted d-block small">Kontak Handphone</span>
                        <strong class="text-dark">{{ $guru->no_hp ?? '-' }}</strong>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <span class="text-muted d-block small">Email Akses Sistem</span>
                        <strong class="text-dark text-primary">{{ Auth::user()->email }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-circle-nodes text-info me-2"></i>Transparansi & Akuntabilitas Evaluasi</h5>
                <p class="text-muted small mb-0">Penilaian kinerja Anda dilakukan secara kolaboratif oleh tim Guru Supervisi yang telah didelegasikan oleh Kepala Sekolah. Hasil akhir yang dikeluarkan oleh sistem ini bersifat mutlak, dihitung berdasarkan kecocokan kompetensi aktual Anda terhadap profil standar mutu pendidik di SD Muhammadiyah Sang Pencerah.</p>
            </div>
        </div>
    @else
        <div class="alert alert-warning border-0 shadow-sm">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> Akun pengguna Anda belum terhubung dengan data profil Guru di database. Silakan pastikan nama akun login Anda sama persis dengan nama pengajar yang didaftarkan di menu Data Guru.
        </div>
    @endif
</div>
@endsection