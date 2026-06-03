<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Surat Keterangan Pemberian Insentif - {{ $guru->nama_guru }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; margin: 40px; line-height: 1.6; color: #000; }
        .kop { border-bottom: 3px double #000; padding-bottom: 10px; text-align: center; margin-bottom: 25px; }
        .kop h1 { margin: 5px 0; font-size: 20pt; text-transform: uppercase; }
        .judul { text-align: center; font-weight: bold; margin-bottom: 25px; text-transform: uppercase; }
        .judul span { border-bottom: 2px solid #000; font-size: 14pt; padding-bottom: 2px; display: inline-block; }
        .paragraf { text-align: justify; text-indent: 40px; font-size: 12pt; margin-bottom: 15px; }
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
        <span>SURAT KETERANGAN PEMBERIAN INSENTIF</span>
        <p>Nomor: {{ rand(100,999) }}/SI-GT/SDM-SP/{{ date('Y') }}</p>
    </div>
    <p class="paragraf">Menimbang hasil capaian skor tertinggi pada sistem pendukung keputusan evaluasi kinerja metode GAP Analysis, Kepala Sekolah SD Muhammadiyah Sang Pencerah memberikan penghargaan finansial berupa **Tunjangan Insentif Prestasi Kinerja Khusus** kepada:</p>
    
    <table style="margin-left: 40px; font-size: 12pt; margin-bottom: 20px;">
        <tr><td>Nama Lengkap</td><td>:</td><td style="font-weight: bold;">{{ $guru->nama_guru }}</td></tr>
        <tr><td>NIP</td><td>:</td><td>{{ $guru->nip ?? '-' }}</td></tr>
        <tr><td>Capaian Penghargaan</td><td>:</td><td>Guru Terbaik Periode Utama</td></tr>
    </table>

    <p class="paragraf">Insentif ini diserahkan sebagai bentuk apresiasi nyata atas integritas, dedikasi kerja tinggi, serta loyalitas penuh yang telah ditunjukkan dalam memajukan mutu pendidikan di lingkungan SD Muhammadiyah Sang Pencerah.</p>
    
    <div class="ttd">
        <p>Metro, {{ date('d F Y') }}</p>
        <p>Kepala Sekolah,</p>
        <div style="height: 70px;"></div>
        <p style="font-weight: bold; text-decoration: underline;">Bapak Kepala Sekolah, M.Pd.</p>
    </div>
</body>
</html>