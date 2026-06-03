@extends('layouts.app')

@section('content')
    <h4 class="fw-bold mb-4"><i class="fa-solid fa-trophy text-warning me-2"></i>Halaman Penghargaan Guru</h4>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3">{{ session('success') }}</div>
    @endif

    @if(!$isJuara)
        <div class="card border-0 shadow-sm p-4 text-center">
            <div class="py-4">
                <i class="fa-solid fa-star-half-stroke text-muted mb-3" style="font-size: 3rem;"></i>
                <h5>Terima kasih atas dedikasi Anda, {{ Auth::user()->name }}!</h5>
                <p class="text-muted small">Periode perhitungan penilaian kinerja berbasis SPK GAP Analysis belum menempatkan Anda di peringkat pertama. Tetap semangat dalam mengajar dan meningkatkan kompetensi!</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm bg-gradient text-white p-4 mb-4" style="background: linear-gradient(135deg, #2c3e50, #16a085);">
            <div class="row align-items-center">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <i class="fa-solid fa-medal text-warning animate-bounce" style="font-size: 5rem;"></i>
                </div>
                <div class="col-md-10">
                    <h3 class="fw-bold text-warning">Selamat! Anda Terpilih Sebagai Guru Terbaik</h3>
                    <p class="mb-0">Berdasarkan hasil kalkulasi objektif sistem pendukung keputusan metode <strong>GAP Analysis</strong>, Anda berhasil meraih predikat <strong>Peringkat 1 Kinerja Guru Terbaik</strong> periode tahun ini. Terima kasih atas kontribusi luar biasa Anda bagi sekolah!</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 rounded-3">
                    <div class="card-header bg-dark text-white fw-bold"><i class="fa-solid fa-print me-2"></i>1. Cetak Dokumen Resmi</div>
                    <div class="card-body">
                        <p class="small text-secondary mb-4">Silakan cetak dokumen resmi di bawah ini, lalu mintalah tanda tangan fisik dan stempel kepada Kepala Sekolah sebagai dokumen bukti administrasi resmi.</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('reward.cetak_pengumuman', $guru->id) }}" target="_blank" class="btn btn-primary text-start fw-semibold py-2">
                                <i class="fa-solid fa-file-pdf me-2"></i> Cetak Surat Pengumuman Sekolah
                            </a>
                            <a href="{{ route('reward.cetak_insentif', $guru->id) }}" target="_blank" class="btn btn-success text-start fw-semibold py-2">
                                <i class="fa-solid fa-receipt me-2"></i> Cetak Surat Pemberian Insentif
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 rounded-3">
                    <div class="card-header bg-dark text-white fw-bold"><i class="fa-solid fa-upload me-2"></i>2. Upload Berkas yang Sudah Ditandatangani</div>
                    <div class="card-body">
                        <form action="{{ route('reward.upload', $guru->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Scan Surat Pengumuman</label>
                                <input type="file" name="file_pengumuman" class="form-control form-control-sm">
                                @if($arsip && $arsip->file_pengumuman)
                                    <small class="text-success d-block mt-1"><i class="fa-solid fa-check-double"></i> Berkas Pengumuman Sudah Terunggah</small>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label small Bars form-label fw-bold">Scan Surat Pemberian Insentif</label>
                                <input type="file" name="file_insentif" class="form-control form-control-sm">
                                @if($arsip && $arsip->file_insentif)
                                    <small class="text-success d-block mt-1"><i class="fa-solid fa-check-double"></i> Berkas Insentif Sudah Terunggah</small>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-dark w-100 fw-bold mt-2 shadow-sm">Simpan & Unggah Arsip Berkas</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection