<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2, .header h3, .header p { margin: 0; padding: 2px; }
        .info-table { margin-bottom: 20px; }
        .info-table td { padding: 3px 10px 3px 0; font-weight: bold; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 8px; text-align: center; }
        .data-table th { background-color: #f2f2f2; }
        .ttd-container { width: 100%; margin-top: 50px; text-align: right; }
    </style>
</head>
<body>

    <!-- KOP SURAT (Silakan disesuaikan) -->
    <div class="header">
        <h2>YAYASAN HASNUR CENTRE</h2>
        <h3>LAPORAN PRESENSI SISWA MAGANG / TENDIK</h3>
        <p>Jl. Contoh Alamat No. 123, Kalimantan Selatan</p>
    </div>

    <!-- INFO PROFIL -->
    <table class="info-table">
        <tr>
            <td>Nama Lengkap</td>
            <td>: {{ $siswa->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Instansi Asal</td>
            <td>: {{ $siswa->sekolah_asal ?? '-' }}</td>
        </tr>
    </table>

    <!-- TABEL RIWAYAT -->
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $r->jam_masuk ?? '-' }}</td>
                    <td>{{ $r->jam_pulang ?? '-' }}</td>
                    <td>
                        CI: {{ $r->statusCi->name ?? 'Alfa' }} <br>
                        CO: {{ $r->statusCo ? $r->statusCo->name : 'Belum' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada riwayat presensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="ttd-container">
        <p>Banjarbaru, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <br><br><br>
        <p><strong>Admin Presensi</strong></p>
    </div>

</body>
</html>
