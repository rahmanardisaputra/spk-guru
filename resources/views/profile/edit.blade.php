@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="fw-bold mb-4"><i class="fa-solid fa-user-gear text-primary me-2"></i>Pengaturan Akun & Profil</h4>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Informasi Dasar</h6>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control bg-light" value="{{ old('name', $user->name) }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Alamat Email (Digunakan untuk Login)</label>
                            <input type="email" name="email" class="form-control bg-light" value="{{ old('email', $user->email) }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <h6 class="fw-bold text-secondary mb-3 mt-5 border-bottom pb-2">Ubah Password Keamanan</h6>
                        <div class="alert alert-warning small border-0 py-2">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Kosongkan ketiga kolom password di bawah ini jika Anda <strong>tidak ingin</strong> mengubah password saat ini.
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Masukkan password lama">
                            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label small fw-semibold">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password baru">
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                                <i class="fa-solid fa-save me-1"></i> Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection