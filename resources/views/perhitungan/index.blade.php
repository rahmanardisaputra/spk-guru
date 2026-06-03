@extends('layouts.app')

@section('content')
    <h4 class="fw-bold mb-4"><i class="fa-solid fa-ranking-star me-2"></i>Hasil Akhir Perangkingan Guru Terbaik</h4>
    
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="10%" class="text-center py-3">Ranking</th>
                        <th>Nama Guru</th>
                        <th width="20%" class="text-center">Skor Akhir SPK</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $index => $res)
                    <tr>
                        <td class="text-center fw-bold">
                            @if($index == 0)
                                <span class="badge bg-warning text-dark px-3 py-2"><i class="fa-solid fa-crown me-1"></i> 1</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="fw-semibold text-dark">{{ $res['nama'] }}</td>
                        <td class="text-center fw-bold text-primary" style="font-size: 1.1rem;">
                            {{ number_format($res['skor'], 2) }}
                        </td>
                        <td class="text-center">
                            @php
                                $guruObj = \App\Models\Guru::where('nama_guru', $res['nama'])->first();
                            @endphp
                            @if($guruObj)
                                <a href="{{ route('perhitungan.detail', $guruObj->id) }}" class="btn btn-sm btn-info text-dark fw-semibold shadow-sm">
                                    <i class="fa-solid fa-eye me-1"></i> Rincian Nilai
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection