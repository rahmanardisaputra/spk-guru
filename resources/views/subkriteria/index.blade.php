@extends('layouts.app')

@section('content')

    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">
            <i class="fa-solid fa-list-check me-2"></i> Indikator: {{ $kriteria->nama_kriteria }}
        </h4>
        <a href="{{ route('kriteria.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Kriteria
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fa-solid fa-plus-circle text-primary me-1"></i> Tambah Indikator
                </div>
                <div class="card-body">
                    <form action="{{ route('subkriteria.store', $kriteria->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama Indikator</label>
                            <input type="text" name="nama_sub_kriteria" class="form-control" required placeholder="Contoh: Penguasaan Materi">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nilai Ideal (Target)</label>
                            <select name="nilai_ideal" class="form-select" required>
                                <option value="5">5 - Sangat Baik</option>
                                <option value="4">4 - Baik</option>
                                <option value="3">3 - Cukup</option>
                                <option value="2">2 - Kurang</option>
                                <option value="1">1 - Sangat Kurang</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Jenis Faktor (GAP)</label>
                            <select name="jenis_faktor" class="form-select" required>
                                <option value="core">Core Factor (Utama)</option>
                                <option value="secondary">Secondary Factor (Pendukung)</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold">Simpan Indikator</button>
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
                                <th width="5%" class="text-center py-3">No</th>
                                <th>Nama Indikator</th>
                                <th class="text-center">Nilai Ideal</th>
                                <th class="text-center">Jenis Faktor</th>
                                <th width="10%" class="text-center">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kriteria->subKriterias as $index => $sub)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $sub->nama_sub_kriteria }}</td>
                                <td class="text-center fw-bold text-success">{{ $sub->nilai_ideal }}</td>
                                <td class="text-center">
                                    @if ($sub->jenis_faktor == 'core')
                                        <span class="badge bg-primary">Core (CF)</span>
                                    @else
                                        <span class="badge bg-info text-dark">Secondary (SF)</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('subkriteria.edit', $sub->id) }}" class="btn btn-sm btn-warning text-dark">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('subkriteria.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Hapus indikator ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada indikator untuk kriteria ini.</td>
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