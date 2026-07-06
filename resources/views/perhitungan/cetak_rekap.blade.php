<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Hasil Penilaian</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-left {
            text-align: left;
        }
        .signatures {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 30%;
            display: inline-block;
            text-align: center;
            vertical-align: top;
            margin: 0 1%;
        }
        .signature-line {
            margin-top: 70px;
            border-bottom: 1px solid #000;
            width: 80%;
            display: inline-block;
        }
        @media print {
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        REKAPITULASI HASIL PENILAIAN<br>
        KINERJA GURU SD MUHAMMADIYAH SANG PENCERAH KOTA METRO<br>
        SEMESTER {{ \App\Helpers\SemesterHelper::getName(session('semester')) }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th class="text-left" width="20%">Nama Guru</th>
                @foreach($kriterias as $k)
                    <th>{{ $k->nama_kriteria }}</th>
                @endforeach
                <th width="10%">Nilai Total</th>
                <th width="10%">Rangking</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil_akhir as $index => $res)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $res['guru']->nama_guru }}</td>
                @foreach($kriterias as $k)
                    <td>{{ isset($res['rincian'][$k->kode_kriteria]) ? number_format($res['rincian'][$k->kode_kriteria], 2) : '0' }}</td>
                @endforeach
                <td><b>{{ number_format($res['total'], 4) }}</b></td>
                <td><b>{{ $index + 1 }}</b></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signatures">
        @if($supervisis->count() > 0)
            @foreach($supervisis as $idx => $sup)
                <div class="signature-box">
                    <div>Ttd Supervisi {{ $idx + 1 }}</div>
                    <div style="height: 70px;"></div>
                    <div>( <b>{{ $sup->name }}</b> )</div>
                </div>
            @endforeach
        @else
            <div class="signature-box">
                <div>Ttd Supervisi 1</div>
                <div style="height: 70px;"></div>
                <div>( ......................................... )</div>
            </div>
            <div class="signature-box">
                <div>Ttd Supervisi 2</div>
                <div style="height: 70px;"></div>
                <div>( ......................................... )</div>
            </div>
            <div class="signature-box">
                <div>Ttd Supervisi 3</div>
                <div style="height: 70px;"></div>
                <div>( ......................................... )</div>
            </div>
        @endif
    </div>
</body>
</html>
