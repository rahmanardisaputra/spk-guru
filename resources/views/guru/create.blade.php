@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Tambah Data Guru</h4>
                <a href="{{ route('guru.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    
                    <form action="{{ route('guru.store') }}" method="POST">
                        @csrf <div class="mb-3">
                            <label for="nip" class="form-label fw-semibold text-secondary">NIP (Opsional)</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP jika ada">
                            @error('nip') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_guru" class="form-label fw-semibold text-secondary">Nama Lengkap Guru <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}" required placeholder="Contoh: Budi Santoso, S.Pd.">
                            @error('nama_guru') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label fw-semibold text-secondary">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pendidikan_terakhir" class="form-label fw-semibold text-secondary">Pendidikan Terakhir</label>
                            <input type="text" class="form-control @error('pendidikan_terakhir') is-invalid @enderror" id="pendidikan_terakhir" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" placeholder="Contoh: S1 Pendidikan Agama Islam">
                            @error('pendidikan_terakhir') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="no_hp" class="form-label fw-semibold text-secondary">Nomor HP</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890">
                            @error('no_hp') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm" style="background-color: #2c3e50; border: none;">
                                <i class="fa-solid fa-save me-1"></i> Simpan Data Guru
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection