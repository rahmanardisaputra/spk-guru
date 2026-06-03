@extends('layouts.app')

@section('content')
    <h4 class="fw-bold mb-4"><i class="fa-solid fa-shield-halved text-primary me-2"></i>Monitoring & Audit Berkas Penghargaan</h4>

    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">
            <h5>Informasi Guru Terbaik Periode Ini</h5>
            <hr>
            @if($guruTerbaik)
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="fw-bold text-success">{{ $guruTerbaik->nama_guru }}</h4>
                        <p class="text-muted mb-0">NIP: {{ $guruTerbaik->nip ?? '-' }} | Pendidikan: {{ $guruTerbaik->pendidikan_terakhir }}</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-warning text-dark px-3 py-2 fw-bold"><i class="fa-solid fa-crown me-1"></i> Juara 1 Sistem SPK</span>
                    </div>
                </div>
            @else
                <p class="text-muted">Belum ada data kalkulasi pemenang saat ini.</p>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-dark text-white fw-bold"><i class="fa-solid fa-folder-open me-2"></i>Status Berkas Arsip yang Diupload Guru</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Jenis Berkas Penghargaan</th>
                        <th>Status Unggahan</th>
                        <th>Aksi Tinjauan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start ps-4 fw-semibold">Scan Dokumen Surat Pengumuman Resmi</td>
                        <td>
                            @if($arsip && $arsip->file_pengumuman)
                                <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i> Sudah Diupload</span>
                            @else
                                <span class="badge bg-danger"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Diupload</span>
                            @endif
                        </td>
                        <td>
                            @if($arsip && $arsip->file_pengumuman)
                                <a href="{{ asset('storage/' . $arsip->file_pengumuman) }}" target="_blank" class="btn btn-sm btn-info text-dark fw-bold">
                                    <i class="fa-solid fa-file-eye"></i> Buka File
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start ps-4 fw-semibold">Scan Dokumen Surat Pemberian Insentif Finansial</td>
                        <td>
                            @if($arsip && $arsip->file_insentif)
                                <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i> Sudah Diupload</span>
                            @else
                                <span class="badge bg-danger"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Diupload</span>
                            @endif
                        </td>
                        <td>
                            @if($arsip && $arsip->file_insentif)
                                <a href="{{ asset('storage/' . $arsip->file_insentif) }}" target="_blank" class="btn btn-sm btn-info text-dark fw-bold">
                                    <i class="fa-solid fa-file-eye"></i> Buka File
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection