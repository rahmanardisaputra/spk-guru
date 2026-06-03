@extends('layouts.app')

@section('content')
    <h4 class="fw-bold mb-4"><i class="fa-solid fa-users-gear me-2"></i>Manajemen Akun Pengguna</h4>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fa-solid fa-user-plus text-primary me-1"></i> Tambah Guru Supervisi
                </div>
                <div class="card-body">
                    <div class="alert alert-info py-2 small border-0">
                        <i class="fa-solid fa-circle-info me-1"></i> Akun <strong>Guru</strong> dibuat otomatis dari menu Data Guru. Form ini khusus menambah Penilai (Supervisi).
                    </div>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-sm" required placeholder="Contoh: Budi Santoso, M.Pd">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Alamat Email</label>
                            <input type="email" name="email" class="form-control form-control-sm" required placeholder="supervisi@sekolah.com">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary">Password Awal</label>
                            <input type="password" name="password" class="form-control form-control-sm" required minlength="6" placeholder="Minimal 6 karakter">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold shadow-sm">
                                <i class="fa-solid fa-save me-1"></i> Simpan Akun
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
                                <th width="5%" class="text-center py-3">No</th>
                                <th>Nama Pengguna</th>
                                <th>Email Akses</th>
                                <th class="text-center">Role / Hak Akses</th>
                                <th width="25%" class="text-center">Aksi Keamanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $u)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td class="text-center">
                                    @if ($u->role == 'guru_supervisi')
                                        <span class="badge bg-primary">Guru Supervisi (Penilai)</span>
                                    @else
                                        <span class="badge bg-secondary">Guru (Dinilai)</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('users.reset_password', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset password akun ini menjadi: password123 ?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning text-dark shadow-sm" title="Reset Password">
                                                <i class="fa-solid fa-key"></i> Reset
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini secara permanen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Hapus Akun">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data pengguna yang terdaftar.</td>
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