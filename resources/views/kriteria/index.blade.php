@extends('layouts.app')

@section('content')

    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="fw-bold"><i class="fa-solid fa-list-check me-2"></i>Data Kriteria & Bobot</h4>
        </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm">
        <i class="fa-solid fa-circle-info me-2"></i> Kriteria di bawah ini adalah acuan utama dalam perhitungan <strong>GAP Analysis</strong>. Anda dapat mengelola indikator (Sub Kriteria) beserta nilai ideal dan jenis faktornya (Core/Secondary) dengan menekan tombol kelola.
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body">
            <table class="table table-hover table-bordered mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="10%" class="text-center">Kode</th>
                        <th>Nama Kriteria</th>
                        <th width="15%" class="text-center">Bobot (%)</th>
                        <th width="15%" class="text-center">Jml Sub Kriteria</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kriterias as $index => $kriteria)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center fw-bold">{{ $kriteria->kode_kriteria }}</td>
                        <td>{{ $kriteria->nama_kriteria }}</td>
                        <td class="text-center">{{ $kriteria->bobot_persen }}%</td>
                        <td class="text-center">
                            <span class="badge bg-secondary rounded-pill">
                                {{ $kriteria->subKriterias->count() }} Indikator
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('subkriteria.index', $kriteria->id) }}" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fa-solid fa-gear me-1"></i> Kelola Sub Kriteria
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