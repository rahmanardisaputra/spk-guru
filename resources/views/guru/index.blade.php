@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="fw-bold"><i class="fa-solid fa-users me-2"></i>Data Guru</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('guru.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Tambah Data Guru
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="alert alert-info border-0 shadow-sm mb-4" role="alert">
        <h6 class="fw-bold mb-1"><i class="fa-solid fa-circle-info me-2"></i>Informasi Pembuatan Akun Otomatis</h6>
        <p class="mb-0 small text-dark">Setiap kali Anda menambahkan data guru baru, sistem akan otomatis membuatkan akun untuk guru tersebut agar dapat masuk ke dalam sistem. <br>
        <span class="fw-semibold">Format Email:</span> [NIP_GURU]@sekolah.com <span class="mx-2">|</span> 
        <span class="fw-semibold">Password Default:</span> password123</p>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        <th>L/P</th>
                        <th>Pendidikan</th>
                        <th>No HP</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gurus as $index => $guru)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $guru->nip ?? '-' }}</td>
                        <td class="fw-semibold">{{ $guru->nama_guru }}</td>
                        <td class="text-center">{{ $guru->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                        <td>{{ $guru->pendidikan_terakhir ?? '-' }}</td>
                        <td>{{ $guru->no_hp ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-sm btn-warning text-dark shadow-sm">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini beserta akun loginnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger text-white shadow-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data guru yang terdaftar.</td>
                    </tr>
                    @endempty
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection