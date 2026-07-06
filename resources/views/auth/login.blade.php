@extends('layouts.app')

@section('content')

    <div class="row justify-content-center align-items-center" style="min-vh: 75vh; margin-top: 5vh;">
        <div class="col-md-5">
            
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark mb-1">SD Muhammadiyah Sang Pencerah</h4>
                <p class="text-muted small">Kota Metro</p>
            </div>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary text-white d-inline-block p-3 rounded-circle mb-3 shadow-sm" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-lock fs-4"></i>
                        </div>
                        <h5 class="fw-bold">Sistem Keputusan (SPK)</h5>
                        <p class="text-muted small">Silakan masuk untuk mengakses sistem</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary small fw-semibold">Alamat E-Mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@email.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label text-secondary small fw-semibold">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-key text-muted"></i></span>
                                <input id="password" type="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="semester" class="form-label text-secondary small fw-semibold">Pilih Semester</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-calendar text-muted"></i></span>
                                <select id="semester" class="form-select bg-light border-start-0 @error('semester') is-invalid @enderror" name="semester" required>
                                    <option value="">-- Pilih Semester Aktif --</option>
                                    @foreach($semesters as $key => $val)
                                        <option value="{{ $key }}" {{ old('semester') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                                @error('semester')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted small" models for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm py-2" style="background-color: #2c3e50; border: none;">
                                Masuk <i class="fa-solid fa-arrow-right ms-2 fs-6"></i>
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">Penilaian Kinerja Guru Terbaik Menggunakan Metode <span class="fw-semibold">GAP Analysis</span></p>
            </div>

        </div>
    </div>
</div>
@endsection