<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Surat Pengumuman Guru Terbaik - {{ $guru->nama_guru }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; margin: 40px; line-height: 1.6; color: #000; }
        .kop { border-bottom: 3px double #000; padding-bottom: 10px; text-align: center; margin-bottom: 25px; }
        .kop h2 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .kop h1 { margin: 5px 0; font-size: 20pt; text-transform: uppercase; }
        .kop p { margin: 0; font-size: 11pt; font-style: italic; }
        .judul { text-align: center; font-weight: bold; margin-bottom: 25px; text-transform: uppercase; }
        .judul span { border-bottom: 2px solid #000; font-size: 14pt; padding-bottom: 2px; display: inline-block; }
        .paragraf { text-align: justify; text-indent: 40px; font-size: 12pt; margin-bottom: 15px; }
        .box-juara { border: 2px solid #000; width: 70%; margin: 20px auto; padding: 15px; text-align: center; font-size: 13pt; font-weight: bold; background-color: #f9f9f9; }
        .ttd { margin-top: 50px; float: right; width: 250px; font-size: 12pt; }
        @media print { @page { size: A4; margin: 2cm; } }
    </style>
</head>
<body onload="window.print()">
    <div class="kop">
        <h2>PIMPINAN DAERAH MUHAMMADIYAH KOTA METRO</h2>
        <h1>SD MUHAMMADIYAH SANG PENCERAH</h1>
        <p>Alamat: Jl. KH. Ahmad Dahlan No.1, Imopuro, Kec. Metro Pusat, Kota Metro, Lampung 34124</p>
    </div>
    <div class="judul">
        <span>SURAT PENGUMUMAN PENGHARGANA KINERJA</span>
        <p>Nomor: {{ rand(100,999) }}/SK-GT/SDM-SP/{{ date('Y') }}</p>
    </div>
    <p class="paragraf">Berdasarkan hasil penilaian kinerja guru akhir tahun menggunakan sistem penunjang keputusan komputer terintegrasi melalui metode <strong>GAP Analysis (Profile Matching)</strong>, pihak jajaran manajemen sekolah dengan bangga memutuskan menetapkan bahwa predikat penghargaan tertinggi diberikan kepada:</p>
    
    <div class="box-juara">
        NAMA GURU: {{ $guru->nama_guru }}<br>
        NIP: {{ $guru->nip ?? '-' }}<br>
        PREDIKAT: GURU TERBAIK PERINGKAT I
    </div>

    <p class="paragraf">Dinyatakan sebagai Guru Terbaik karena pemenuhan instrumen kompetensi pedagogik, profesional, sosial, kepribadian, serta keandalan tingkat kehadiran dan capaian prestasi yang paling mendekati profil ideal instansi sekolah.</p>
    
    <div class="ttd">
        <p>Metro, {{ date('d F Y') }}</p>
        <p>Kepala Sekolah,</p>
        <div style="height: 70px;"></div>
        <p style="font-weight: bold; text-decoration: underline;">Bapak Kepala Sekolah, M.Pd.</p>
        <p>NIP. 19780512 200501 1 002</p>
    </div>
</body>
</html>