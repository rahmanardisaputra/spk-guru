@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold"><i class="fa-solid fa-user-check me-2"></i>Input / Edit Nilai: {{ $guru->nama_guru }}</h4>
        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary btn-sm shadow-sm">Kembali</a>
    </div>

    <form action="{{ route('penilaian.store', $guru->id) }}" method="POST">
        @csrf
        
        <div class="row">
            @foreach ($kriterias as $kriteria)
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-dark text-white fw-bold">
                        {{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }}
                    </div>
                    <div class="card-body">
                        @forelse ($kriteria->subKriterias as $sub)
                            
                            @if ($kriteria->kode_kriteria == 'K5')
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-primary mb-1">{{ $sub->nama_sub_kriteria }} (Hitung Otomatis)</label>
                                    
                                    @if(isset($penilaian_sebelumnya[$sub->id]))
                                        <div class="mb-2">
                                            <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i> Skor Tersimpan: Skala {{ $penilaian_sebelumnya[$sub->id] }}</span>
                                            <small class="text-secondary d-block mt-1" style="font-size: 0.75rem;">*Kosongkan form di bawah jika tidak ingin mengubah data absensi lama.</small>
                                        </div>
                                    @endif

                                    <div class="row g-2">
                                        <div class="col-6 col-md-3">
                                            <label class="small text-secondary">Hari Aktif</label>
                                            <input type="number" name="absensi[{{ $sub->id }}][total_hari]" class="form-control form-control-sm" {{ isset($penilaian_sebelumnya[$sub->id]) ? '' : 'required' }} min="1" placeholder="Mis: 24">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="small text-secondary">Sakit</label>
                                            <input type="number" name="absensi[{{ $sub->id }}][sakit]" class="form-control form-control-sm" {{ isset($penilaian_sebelumnya[$sub->id]) ? '' : 'required' }} min="0" value="0">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="small text-secondary">Izin</label>
                                            <input type="number" name="absensi[{{ $sub->id }}][izin]" class="form-control form-control-sm" {{ isset($penilaian_sebelumnya[$sub->id]) ? '' : 'required' }} min="0" value="0">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="small text-secondary">Alfa</label>
                                            <input type="number" name="absensi[{{ $sub->id }}][alfa]" class="form-control form-control-sm" {{ isset($penilaian_sebelumnya[$sub->id]) ? '' : 'required' }} min="0" value="0">
                                        </div>
                                    </div>
                                </div>

                            @elseif ($kriteria->kode_kriteria == 'K6')
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-primary">{{ $sub->nama_sub_kriteria }}</label>
                                    <select name="prestasi[{{ $sub->id }}]" class="form-select" required>
                                        <option value="" disabled {{ !isset($penilaian_sebelumnya[$sub->id]) ? 'selected' : '' }}>-- Pilih Tingkat Prestasi --</option>
                                        <option value="nasional" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 5) ? 'selected' : '' }}>Tingkat Nasional / Internasional</option>
                                        <option value="provinsi" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 4) ? 'selected' : '' }}>Tingkat Provinsi</option>
                                        <option value="kota" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 3) ? 'selected' : '' }}>Tingkat Kota / Kabupaten</option>
                                        <option value="sekolah" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 2) ? 'selected' : '' }}>Tingkat Sekolah</option>
                                        <option value="tidak_ada" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 1) ? 'selected' : '' }}>Tidak Ada Prestasi</option>
                                    </select>
                                </div>

                            @else
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-secondary">{{ $sub->nama_sub_kriteria }}</label>
                                    <select name="nilai_aktual[{{ $sub->id }}]" class="form-select" required>
                                        <option value="" disabled {{ !isset($penilaian_sebelumnya[$sub->id]) ? 'selected' : '' }}>-- Pilih Nilai --</option>
                                        <option value="5" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 5) ? 'selected' : '' }}>5 - Sangat Baik</option>
                                        <option value="4" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 4) ? 'selected' : '' }}>4 - Baik</option>
                                        <option value="3" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 3) ? 'selected' : '' }}>3 - Cukup</option>
                                        <option value="2" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 2) ? 'selected' : '' }}>2 - Kurang</option>
                                        <option value="1" {{ (isset($penilaian_sebelumnya[$sub->id]) && $penilaian_sebelumnya[$sub->id] == 1) ? 'selected' : '' }}>1 - Sangat Kurang</option>
                                    </select>
                                </div>
                            @endif

                        @empty
                            <p class="text-muted small">Belum ada indikator (Sub Kriteria) untuk kriteria ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-grid mb-5">
            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                <i class="fa-solid fa-save me-2"></i> Simpan Hasil Pembaruan Penilaian
            </button>
        </div>
    </form>
</div>
@endsection