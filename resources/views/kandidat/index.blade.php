@extends('layouts.app')

@section('page-title', 'Kandidat Penilaian')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-users text-primary me-2"></i>Kandidat Penilaian</h4>
        <small class="text-muted">Periode: <strong>{{ $semesterName }}</strong></small>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
@endif

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100 rounded-3">
            <div class="card-header bg-dark text-white fw-bold"><i class="fa-solid fa-plus me-2"></i>Tambah Kandidat</div>
            <div class="card-body">
                <form action="{{ route('kandidat.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Guru dari Master Data</label>
                        <select name="guru_id" class="form-select" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->nama_guru }} ({{ $guru->nip ?? '-' }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-2">Guru yang dipilih akan menjadi kandidat untuk dievaluasi pada semester <strong>{{ $semesterName }}</strong>.</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="fa-solid fa-user-plus me-2"></i> Tambahkan</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm h-100 rounded-3">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="fw-bold text-dark"><i class="fa-solid fa-list text-secondary me-2"></i>Daftar Kandidat ({{ $semesterName }})</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama Guru</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kandidats as $idx => $k)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $k->guru->nip ?? '-' }}</td>
                                    <td class="fw-bold">{{ $k->guru->nama_guru }}</td>
                                    <td>
                                        <form action="{{ route('kandidat.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kandidat ini dari periode sekarang?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada kandidat di semester ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
