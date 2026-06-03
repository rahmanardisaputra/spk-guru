@extends('layouts.app')

@section('content')
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold"><i class="fa-solid fa-circle-info text-primary me-2"></i>Rincian Penilaian & GAP: {{ $guru->nama_guru }}</h4>
        <a href="{{ route('perhitungan.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Ranking
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 mb-4 bg-light">
        <div class="card-body py-3">
            <div class="row text-secondary small">
                <div class="col-md-3"><strong>NIP:</strong> {{ $guru->nip ?? '-' }}</div>
                <div class="col-md-3"><strong>Jenis Kelamin:</strong> {{ $guru->jenis_kelamin }}</div>
                <div class="col-md-3"><strong>Pendidikan:</strong> {{ $guru->pendidikan_terakhir ?? '-' }}</div>
                <div class="col-md-3 text-end"><span class="badge bg-dark">Total Penilai: {{ $supervisis->count() }} Orang</span></div>
            </div>
        </div>
    </div>

    @foreach ($kriterias as $kriteria)
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-dark text-white fw-bold py-3">
            {{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }} (Bobot Kriteria: {{ $kriteria->bobot_persen }}%)
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th class="text-start" width="25%">Indikator / Sub Kriteria</th>
                        
                        @foreach($supervisis as $sup)
                            <th>{{ $sup->name }}</th>
                        @endforeach
                        
                        <th class="table-info text-dark">Rata-Rata (Aktual)</th>
                        <th class="table-success text-dark">Target (Ideal)</th>
                        <th class="table-warning text-dark">Nilai GAP</th>
                        <th class="table-primary text-dark">Bobot GAP</th>
                        <th>Jenis Faktor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kriteria->subKriterias as $idx => $sub)
                        @php
                            // Ambil semua nilai dari para penilai untuk sub kriteria ini
                            $total_nilai_aktual = 0;
                            $jumlah_penilai = 0;
                            
                            foreach($supervisis as $sup) {
                                $nilai = $matriks_nilai[$sub->id][$sup->id] ?? 0;
                                if($nilai > 0) {
                                    $total_nilai_aktual += $nilai;
                                    $jumlah_penilai++;
                                }
                            }
                            
                            // Hitung rata-rata aktual
                            $rata_aktual = ($jumlah_penilai > 0) ? ($total_nilai_aktual / $jumlah_penilai) : 0;
                            
                            // Hitung GAP & Bobot GAP
                            $gap = $rata_aktual - $sub->nilai_ideal;
                            
                            // Logika mengambil bobot GAP
                            $mapBobot = [0 => 5, 1 => 4.5, -1 => 4, 2 => 3.5, -2 => 3, 3 => 2.5, -3 => 2, 4 => 1.5, -4 => 1];
                            // Karena rata-rata bisa desimal, kita bulatkan gap terdekat untuk mencari sampel bobot di tabel formal
                            $bobot_gap = $mapBobot[round($gap)] ?? 0;
                        @endphp
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td class="text-start fw-semibold">{{ $sub->nama_sub_kriteria }}</td>
                        
                        @foreach($supervisis as $sup)
                            <td>{{ $matriks_nilai[$sub->id][$sup->id] ?? '-' }}</td>
                        @endforeach
                        
                        <td class="table-info fw-bold text-dark">{{ number_format($rata_aktual, 2) }}</td>
                        <td class="table-success fw-bold text-dark">{{ $sub->nilai_ideal }}</td>
                        <td class="table-warning fw-bold text-danger">{{ number_format($gap, 2) }}</td>
                        <td class="table-primary fw-bold text-dark">{{ $bobot_gap }}</td>
                        <td>
                            @if($sub->jenis_faktor == 'core')
                                <span class="badge bg-primary">Core (CF)</span>
                            @else
                                <span class="badge bg-secondary">Secondary (SF)</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ 7 + $supervisis->count() }}" class="text-center text-muted py-3">Belum ada indikator untuk kriteria ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

</div>
@endsection