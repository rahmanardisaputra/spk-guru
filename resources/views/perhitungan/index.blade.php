@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="fa-solid fa-ranking-star me-2"></i>Hasil Akhir Perangkingan Guru Terbaik</h4>
        <div>
            @if(Auth::user()->role == 'kepala_sekolah')
                @if(!$validasi || !$validasi->is_validated)
                    <form id="form-validasi" action="{{ route('perhitungan.validasi') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="button" onclick="confirmValidasi()" class="btn btn-primary fw-bold shadow-sm"><i class="fa-solid fa-check-double me-1"></i> Validasi Ranking</button>
                    </form>
                @else
                    <span class="badge bg-success py-2 px-3 me-2"><i class="fa-solid fa-check-circle me-1"></i> Telah Divalidasi</span>
                    <form id="form-unvalidasi" action="{{ route('perhitungan.unvalidasi') }}" method="POST" class="d-inline me-2">
                        @csrf
                        <button type="button" onclick="confirmUnvalidasi()" class="btn btn-danger fw-bold shadow-sm"><i class="fa-solid fa-times-circle me-1"></i> Batalkan Validasi</button>
                    </form>
                    <a href="{{ route('perhitungan.cetak_rekap') }}" target="_blank" class="btn btn-success fw-bold shadow-sm"><i class="fa-solid fa-print me-1"></i> Cetak Rekapitulasi</a>
                @endif
            @else
                @if($validasi && $validasi->is_validated)
                    <span class="badge bg-success py-2 px-3"><i class="fa-solid fa-check-circle me-1"></i> Telah Divalidasi Kepsek</span>
                @else
                    <span class="badge bg-warning text-dark py-2 px-3"><i class="fa-solid fa-clock me-1"></i> Menunggu Validasi Kepsek</span>
                @endif
            @endif
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
    @endif
    
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
                    @foreach ($hasil_akhir as $index => $res)
                    <tr>
                        <td class="text-center fw-bold">
                            @if($index == 0)
                                <span class="badge bg-warning text-dark px-3 py-2"><i class="fa-solid fa-crown me-1"></i> 1</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="fw-semibold text-dark">{{ $res['guru']->nama_guru }}</td>
                        <td class="text-center fw-bold text-primary" style="font-size: 1.1rem;">
                            {{ number_format($res['total'], 4) }}
                        </td>
                        <td class="text-center">
                            @if($res['guru'])
                                <a href="{{ route('perhitungan.detail', $res['guru']->id) }}" class="btn btn-sm btn-info text-dark fw-semibold shadow-sm">
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

<script>
    function confirmValidasi() {
        Swal.fire({
            title: 'Validasi Ranking?',
            text: "Apakah Anda yakin ingin memvalidasi hasil perankingan semester ini? Setelah divalidasi, hasil akan dapat dilihat oleh Guru dan bagian Tata Usaha.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a7a5c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Validasi Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-validasi').submit();
            }
        });
    }

    function confirmUnvalidasi() {
        Swal.fire({
            title: 'Batalkan Validasi?',
            text: "Apakah Anda yakin ingin membatalkan validasi hasil perankingan? Hasil tidak akan dapat dilihat oleh Guru dan Tata Usaha sampai divalidasi kembali.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-unvalidasi').submit();
            }
        });
    }
</script>
@endsection