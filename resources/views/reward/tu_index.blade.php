@extends('layouts.app')

@section('page-title', 'Sertifikat Penghargaan')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h4 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-certificate text-warning me-2"></i>Sertifikat Guru Terbaik (Top 3)</h4>
        <small class="text-muted d-block">Manajemen dan pembuatan sertifikat penghargaan untuk guru peringkat 1, 2, dan 3.</small>
    </div>
</div>

@if(!$validasi || !$validasi->is_validated)
    <div class="alert alert-warning shadow-sm border-0 border-start border-warning border-4">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <strong>Akses Dibatasi:</strong> Kepala Sekolah belum memvalidasi hasil perankingan SPK untuk semester ini. Anda baru dapat mencetak sertifikat penghargaan setelah validasi dilakukan.
    </div>
@else
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 px-4">Peringkat</th>
                        <th class="py-3">NIP</th>
                        <th class="py-3">Nama Guru</th>
                        <th class="py-3">Skor GAP</th>
                        <th class="py-3 px-4 text-end">Aksi (Cetak Template)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($top3 as $index => $data)
                        <tr>
                            <td class="px-4">
                                @if($index == 0)
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-trophy me-1"></i> Juara 1</span>
                                @elseif($index == 1)
                                    <span class="badge bg-secondary"><i class="fa-solid fa-medal me-1"></i> Juara 2</span>
                                @else
                                    <span class="badge" style="background-color: #cd7f32;"><i class="fa-solid fa-award me-1"></i> Juara 3</span>
                                @endif
                            </td>
                            <td>{{ $data['guru']->nip ?? '-' }}</td>
                            <td class="fw-bold">{{ $data['guru']->nama_guru }}</td>
                            <td>{{ number_format($data['skor'], 2) }}</td>
                            <td class="px-4 text-end">
                                <a href="{{ route('reward.cetak_pengumuman', ['guru_id' => $data['guru']->id, 'peringkat' => $index + 1]) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold shadow-sm me-1 mb-1">
                                    <i class="fa-solid fa-file-pdf"></i> Pengumuman
                                </a>
                                <a href="{{ route('reward.cetak_insentif', ['guru_id' => $data['guru']->id, 'peringkat' => $index + 1]) }}" target="_blank" class="btn btn-sm btn-outline-success fw-bold shadow-sm me-1 mb-1">
                                    <i class="fa-solid fa-receipt"></i> Insentif
                                </a>
                                <a href="{{ route('reward.cetak_sertifikat', ['guru_id' => $data['guru']->id, 'peringkat' => $index + 1]) }}" target="_blank" class="btn btn-sm btn-outline-warning text-dark fw-bold shadow-sm mb-1">
                                    <i class="fa-solid fa-certificate"></i> Sertifikat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data penilaian guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
