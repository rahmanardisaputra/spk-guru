@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Indikator</h4>
                <a href="{{ route('subkriteria.index', $subKriteria->kriteria_id) }}" class="btn btn-secondary btn-sm shadow-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('subkriteria.update', $subKriteria->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Nama Indikator</label>
                            <input type="text" name="nama_sub_kriteria" class="form-control" value="{{ old('nama_sub_kriteria', $subKriteria->nama_sub_kriteria) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Nilai Ideal (Target)</label>
                            <select name="nilai_ideal" class="form-select" required>
                                <option value="5" {{ $subKriteria->nilai_ideal == 5 ? 'selected' : '' }}>5 - Sangat Baik</option>
                                <option value="4" {{ $subKriteria->nilai_ideal == 4 ? 'selected' : '' }}>4 - Baik</option>
                                <option value="3" {{ $subKriteria->nilai_ideal == 3 ? 'selected' : '' }}>3 - Cukup</option>
                                <option value="2" {{ $subKriteria->nilai_ideal == 2 ? 'selected' : '' }}>2 - Kurang</option>
                                <option value="1" {{ $subKriteria->nilai_ideal == 1 ? 'selected' : '' }}>1 - Sangat Kurang</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary">Jenis Faktor (GAP)</label>
                            <select name="jenis_faktor" class="form-select" required>
                                <option value="core" {{ $subKriteria->jenis_faktor == 'core' ? 'selected' : '' }}>Core Factor (Utama)</option>
                                <option value="secondary" {{ $subKriteria->jenis_faktor == 'secondary' ? 'selected' : '' }}>Secondary Factor (Pendukung)</option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning fw-bold text-dark py-2 shadow-sm">
                                <i class="fa-solid fa-save me-1"></i> Perbarui Indikator
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection