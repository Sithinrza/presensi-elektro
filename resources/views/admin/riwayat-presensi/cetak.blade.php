<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi - {{ $siswa->nama_lengkap }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #333; }

        /* Kop Surat Resmi */
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 25px; }
        .header h1 { margin: 0 0 5px 0; font-size: 18px; text-transform: uppercase; color: #000; letter-spacing: 1px; }
        .header h2 { margin: 0 0 5px 0; font-size: 16px; font-weight: normal; color: #000; }
        .header h3 { margin: 15px 0 5px 0; font-size: 14px; text-decoration: underline; color: #000; }
        .header p { margin: 0; font-size: 12px; font-style: italic; color: #555; }

        /* Tabel Informasi Personel */
        .info-table { margin-bottom: 20px; width: 100%; border: none; }
        .info-table td { padding: 4px 10px 4px 0; font-size: 12px; color: #000; }
        .info-table .label { width: 140px; font-weight: bold; }

        /* Tabel Data Presensi */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 6px; }
        .data-table th { background-color: #e2e8f0; text-align: center; font-weight: bold; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #000; }
        .data-table td { text-align: center; }
        .data-table td.date-col { text-align: left; padding-left: 10px; }

        /* Styling Badge Status */
        .status-container { display: inline-block; text-align: left; margin: 0 auto; line-height: 1.5; }

        /* Tanda Tangan */
        .ttd-container { width: 100%; margin-top: 50px; text-align: right; }
        .ttd-container p { margin: 5px 0; font-size: 12px; color: #000; }
        .ttd-space { height: 70px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>JURUSAN TEKNIK ELEKTRO</h1>
        <h2>POLITEKNIK NEGERI BANJARMASIN</h2>
        <h3>LAPORAN REKAPITULASI PRESENSI INDIVIDU</h3>
        <p>Periode: <strong>{{ strtoupper($periode) }}</strong></p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>: <strong>{{ $siswa->nama_lengkap }}</strong></td>
        </tr>
        <tr>
            <td class="label">Status Personel</td>
            <td>: {{ $siswa->role }}</td>
        </tr>
        <tr>
            <td class="label">Instansi / Unit Kerja</td>
            <td>: {{ $siswa->sekolah_asal ?? '-' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Hari, Tanggal</th>
                <th style="width: 15%;">Jam Masuk</th>
                <th style="width: 15%;">Jam Pulang</th>
                <th style="width: 35%;">Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="date-col">{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $r->jam_masuk ?? '-' }}</td>
                    <td>{{ $r->jam_pulang ?? '-' }}</td>
                    <td>
                        <div class="status-container">
                            <strong>IN :</strong> {{ $r->statusCi->name ?? 'Alfa' }} <br>
                            <strong>OUT:</strong> {{ $r->statusCo ? $r->statusCo->name : 'Belum CO' }}
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 20px; font-style: italic; color: #666;">Belum ada riwayat presensi yang tercatat di bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Mengetahui,</p>
        <div class="ttd-space"></div>
        <p><strong>_________________________</strong></p>
        <p>Admin Presensi Elektro</p>
    </div>

</body>
</html>
