<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas Supervisi - {{ $supervisi->name }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #ffffff;
            color: #000000;
            margin: 40px;
            line-height: 1.5;
        }
        /* Desain Kop Surat */
        .kop-surat {
            border-bottom: 3px double #000000;
            padding-bottom: 10px;
            margin-bottom: 25px;
            text-align: center;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }
        .kop-surat h1 {
            margin: 5px 0;
            font-size: 22pt;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .kop-surat p {
            margin: 0;
            font-size: 11pt;
            font-style: italic;
        }
        
        /* Isi Dokumen */
        .judul-surat {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 25px;
        }
        .judul-surat span {
            border-bottom: 2px solid #000000;
            font-size: 14pt;
            display: inline-block;
            padding-bottom: 2px;
        }
        .judul-surat p {
            margin: 5px 0 0 0;
            font-weight: normal;
            font-size: 11pt;
        }
        
        .paragraf {
            text-align: justify;
            text-indent: 40px;
            margin-bottom: 15px;
            font-size: 12pt;
        }
        
        /* Tabel Daftar Tugas */
        .tabel-tugas {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            font-size: 12pt;
        }
        .tabel-tugas th, .tabel-tugas td {
            border: 1px solid #000000;
            padding: 8px 12px;
        }
        .tabel-tugas th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        /* Bagian Tanda Tangan */
        .ttd-container {
            margin-top: 50px;
            width: 100%;
            font-size: 12pt;
        }
        .ttd-box {
            float: right;
            width: 250px;
            text-align: left;
        }
        .ttd-space {
            height: 80px;
        }
        
        /* Pengaturan Media Print Browser */
        @media print {
            body { margin: 20px; }
            @page { size: A4; margin: 2cm; }
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>PIMPINAN DAERAH MUHAMMADIYAH KOTA METRO</h2>
        <h1>SD MUHAMMADIYAH SANG PENCERAH</h1>
        <p>Alamat: Jl. KH. Ahmad Dahlan No.1, Imopuro, Kec. Metro Pusat, Kota Metro, Lampung 34124</p>
    </div>

    <div class="judul-surat">
        <span>SURAT TUGAS SUPERVISI</span>
        <p>Nomor: {{ rand(100,999) }}/ST/SDM-SP/{{ date('m') }}/{{ date('Y') }}</p>
    </div>

    <p class="paragraf">Yang bertanda tangan di bawah ini, Kepala Sekolah SD Muhammadiyah Sang Pencerah Kota Metro dengan ini memberikan tugas penuh kepada Guru Supervisi yang namanya tertera di bawah ini:</p>

    <table style="width: 85%; margin-left: 40px; font-size: 12pt; mb-3;">
        <tr>
            <td style="width: 150px; vertical-align: top;">Nama Lengkap</td>
            <td style="width: 15px; vertical-align: top;">:</td>
            <td style="font-weight: bold; vertical-align: top;">{{ $supervisi->name }}</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Jabatan / Peran</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;">Tim Evaluator / Guru Supervisi</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Instansi</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;">SD Muhammadiyah Sang Pencerah Kota Metro</td>
        </tr>
    </table>

    <p class="paragraf" style="margin-top: 20px;">Untuk melaksanakan penilaian instrumen kinerja, rekapitulasi kehadiran (absensi), serta pencatatan prestasi terhadap guru-guru di bawah ini dalam rangka penentuan predikat Guru Terbaik periode tahun {{ date('Y') }} menggunakan metode <strong>GAP Analysis</strong>:</p>

    <table class="tabel-tugas">
        <thead>
            <tr>
                <th style="width: 8%; text-align: center;">No</th>
                <th style="width: 30%;">NIP</th>
                <th>Nama Guru Target Evaluasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($floatings as $idx => $f)
            <tr>
                <td style="text-align: center;">{{ $idx + 1 }}</td>
                <td>{{ $f->guru->nip ?? '-' }}</td>
                <td style="font-weight: bold;">{{ $f->guru->nama_guru }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="paragraf">Demikian surat tugas ini dibuat agar dapat dilaksanakan dengan penuh tanggung jawab, serta melaporkan hasil penilaian instrumen SPK secara objektif ke dalam sistem.</p>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Metro, {{ date('d F Y') }}</p>
            <p>Kepala Sekolah,</p>
            <div class="ttd-space"></div>
            <p style="font-weight: bold; text-decoration: underline;">Bapak Kepala Sekolah, M.Pd.</p>
            <p>NIP. 19780512 200501 1 002</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>
</html>