@extends('layouts.app')

@section('content')

    <h4 class="fw-bold mb-4"><i class="fa-solid fa-clipboard-check me-2"></i>Penilaian Kinerja Guru</h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        <th width="20%" class="text-center">Aksi Penilaian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gurus as $index => $guru)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $guru->nip ?? '-' }}</td>
                        <td class="fw-semibold">{{ $guru->nama_guru }}</td>
                        <td class="text-center">
                            <a href="{{ route('penilaian.create', $guru->id) }}" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Input / Edit Nilai
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection