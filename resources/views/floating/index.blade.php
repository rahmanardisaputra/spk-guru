@extends('layouts.app')

@section('content')

    <h4 class="fw-bold mb-3"><i class="fa-solid fa-network-wired me-2"></i>Floating Guru Supervisi</h4>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fa-solid fa-user-plus text-primary me-1"></i> Plotting Penilai
                </div>
                <div class="card-body">
                    <form action="{{ route('floating.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Pilih Guru Supervisi (Penilai)</label>
                            <select name="supervisi_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Penilai --</option>
                                @foreach($supervisis as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary">Pilih Guru yang Akan Dinilai</label>
                            <select name="guru_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Target Guru --</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama_guru }} (NIP: {{ $guru->nip ?? '-' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold text-white shadow-sm" style="background-color: #2c3e50; border: none;">
                                <i class="fa-solid fa-link me-1"></i> Hubungkan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="8%" class="text-center py-3">No</th>
                                <th>Guru Supervisi (Penilai)</th>
                                <th>Mengevaluasi Guru</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($supervisis as $index => $sup)
                                @php
                                    // Ambil tugas floating khusus untuk supervisi ini
                                    $tugas_guru = $floatings->where('supervisi_id', $sup->id);
                                @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">
                                    <i class="fa-solid fa-user-shield text-primary me-1"></i> {{ $sup->name }}
                                    <br>
                                    <small class="text-muted fw-normal">{{ $sup->email }}</small>
                                </td>
                                <td>
                                    @if($tugas_guru->isEmpty())
                                        <span class="text-muted italic small">Belum ada tugas penilaian.</span>
                                    @else
                                        <ol class="ps-3 mb-0">
                                            @foreach($tugas_guru as $tugas)
                                                <li class="mb-1">
                                                    {{ $tugas->guru->nama_guru }} 
                                                    <form action="{{ route('floating.destroy', $tugas->id) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Hapus penugasan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger fw-semibold shadow-sm" style="font-size: 0.75rem;">
                                                             <i class="fa-solid fa-unlink"></i> Putus
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($tugas_guru->isNotEmpty())
                                        <a href="{{ route('floating.cetak', $sup->id) }}" target="_blank" class="btn btn-sm btn-success fw-semibold shadow-sm">
                                            <i class="fa-solid fa-print me-1"></i> Cetak Surat
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-secondary opacity-50" disabled>
                                            <i class="fa-solid fa-print me-1"></i> Cetak Surat
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada data Guru Supervisi.</td>
                            </tr>
                            @endempty
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection