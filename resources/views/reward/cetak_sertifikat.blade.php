<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Penghargaan - {{ $guru->nama_guru }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background-color: #fcfcfc;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .certificate-container {
            width: 277mm; /* A4 landscape width minus some margin */
            height: 190mm; /* A4 landscape height minus some margin */
            position: relative;
            background: #ffffff;
            border: 15px solid #0e305a; /* Dark Blue Border */
            outline: 5px solid #d4af37; /* Gold Inner Border */
            outline-offset: -10px;
            box-sizing: border-box;
            padding: 40px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            margin-top: 10px;
        }
        .school-name {
            font-family: 'Arial', sans-serif;
            font-size: 22px;
            font-weight: bold;
            color: #0e305a;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .title {
            font-size: 48px;
            font-weight: bold;
            color: #d4af37; /* Gold */
            text-transform: uppercase;
            letter-spacing: 5px;
            margin: 15px 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        .subtitle {
            font-size: 18px;
            font-style: italic;
            color: #555;
            margin-bottom: 30px;
        }
        .presented-to {
            font-size: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0e305a;
        }
        .name {
            font-family: 'Brush Script MT', 'Great Vibes', 'cursive', serif;
            font-size: 55px;
            font-weight: bold;
            color: #000;
            margin: 10px 0;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            padding-bottom: 5px;
            min-width: 60%;
        }
        .nip {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }
        .description {
            font-size: 18px;
            line-height: 1.6;
            margin: 0 auto 20px auto;
            width: 80%;
            color: #333;
        }
        .achievement {
            font-size: 24px;
            font-weight: bold;
            color: #0e305a;
            text-transform: uppercase;
            margin: 15px 0;
        }
        .footer {
            position: absolute;
            bottom: 40px;
            width: calc(100% - 80px);
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .seal {
            width: 120px;
            height: 120px;
            background: #d4af37;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
            border: 3px dashed #fff;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
            margin-left: 50px;
        }
        .signature-block {
            text-align: center;
            width: 250px;
            margin-right: 50px;
        }
        .date {
            font-size: 16px;
            margin-bottom: 60px;
            font-style: italic;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-bottom: 5px;
        }
        .headmaster-name {
            font-weight: bold;
            font-size: 16px;
        }
        .headmaster-title {
            font-size: 14px;
            color: #555;
        }

        @media print {
            body {
                background-color: white;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .certificate-container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="certificate-container">
        <div class="header">
            <div class="school-name">SD Muhammadiyah Sang Pencerah</div>
            <div class="title">Sertifikat Penghargaan</div>
            <div class="subtitle">Nomor: {{ \App\Models\Setting::where('key', 'no_surat')->value('value') ?? date('Y') . '/SPK-GURU/' }}{{ str_pad($peringkat, 3, '0', STR_PAD_LEFT) }}</div>
        </div>

        <div class="presented-to">Diberikan Dengan Penuh Rasa Bangga Kepada:</div>
        
        <div class="name">{{ $guru->nama_guru }}</div>
        <div class="nip">NIP. {{ $guru->nip ?? '-' }}</div>

        <div class="description">
            Atas dedikasi, komitmen, dan kinerja yang luar biasa dalam mendidik dan membimbing siswa-siswi, sehingga berhasil meraih predikat sebagai:
        </div>

        <div class="achievement">
            GURU TERBAIK PERINGKAT {{ $peringkat }}
        </div>

        <div class="description" style="font-size: 14px;">
            Berdasarkan Evaluasi Kinerja Sistem Pendukung Keputusan (SPK) Metode GAP Analysis <br>
            Periode Penilaian {{ \App\Helpers\SemesterHelper::getName(session('semester')) }}
        </div>

        <div class="footer">
            <div class="seal">
                <div style="border: 1px solid #fff; border-radius: 50%; padding: 15px; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                    AWARD<br>{{ date('Y') }}
                </div>
            </div>
            
            <div class="signature-block">
                <div class="date">Kota Metro, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="signature-line"></div>
                <div class="headmaster-name">{{ \App\Models\Setting::where('key', 'nama_kepsek')->value('value') ?? 'Kepala Sekolah' }}</div>
                <div class="headmaster-title">NIP. {{ \App\Models\Setting::where('key', 'nip_kepsek')->value('value') ?? '-' }}</div>
            </div>
        </div>
    </div>

</body>
</html>
