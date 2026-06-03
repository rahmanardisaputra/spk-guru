@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold"><i class="fa-solid fa-user-edit me-2"></i>Edit Data Guru</h4>
                <a href="{{ route('guru.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    
                    <form action="{{ route('guru.update', $guru->id) }}" method="POST">
                        @csrf 
                        @method('PUT') <div class="mb-3">
                            <label for="nip" class="form-label fw-semibold text-secondary">NIP</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $guru->nip) }}">
                        </div>

                        <div class="mb-3">
                            <label for="nama_guru" class="form-label fw-semibold text-secondary">Nama Lengkap Guru <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" id="nama_guru" name="nama_guru" value="{{ old('nama_guru', $guru->nama_guru) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label fw-semibold text-secondary">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pendidikan_terakhir" class="form-label fw-semibold text-secondary">Pendidikan Terakhir</label>
                            <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $guru->pendidikan_terakhir) }}">
                        </div>

                        <div class="mb-4">
                            <label for="no_hp" class="form-label fw-semibold text-secondary">Nomor HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning py-2 fw-bold shadow-sm text-dark">
                                <i class="fa-solid fa-save me-1"></i> Perbarui Data
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection