<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: 'Calibri', Arial, sans-serif; color: #000000;">

    <table>
        <tr>
            <td colspan="5" style="font-size: 16px; font-weight: bold;">JURUSAN TEKNIK ELEKTRO</td>
        </tr>
        <tr>
            <td colspan="5" style="font-size: 16px; font-weight: bold;">POLITEKNIK NEGERI BANJARMASIN</td>
        </tr>
        <tr>
            <td colspan="5" style="font-size: 14px; font-weight: bold; text-decoration: underline;">REKAPITULASI PRESENSI KOLEKTIF {{ strtoupper($kategori) }}</td>
        </tr>
        <tr>
            <td colspan="5" style="font-size: 11px; font-style: italic;">Periode Laporan: {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}</td>
        </tr>
        <tr></tr>
    </table>

    <table border="1" style="border-collapse: collapse; margin-bottom: 20px; width: 350px;">
        <thead>
            <tr style="font-weight: bold; font-size: 11px;">
                <th colspan="2" style="background-color: #800000; color: #ffffff; text-align: center; padding: 6px;">KETERANGAN STATUS PRESENSI</th>
            </tr>
        </thead>
        <tbody style="font-size: 11px;">
            <tr>
                <td style="background-color: #c6efce; color: #006100; font-weight: bold; text-align: center; width: 50px; padding: 4px;">TW</td>
                <td style="padding-left: 8px;">Tepat Waktu (Masuk)</td>
            </tr>
            <tr>
                <td style="background-color: #c6efce; color: #006100; font-weight: bold; text-align: center; padding: 4px;">CO</td>
                <td style="padding-left: 8px;">Check-Out / Pulang Normal</td>
            </tr>
            <tr>
                <td style="background-color: #ffeb9c; color: #9c6500; font-weight: bold; text-align: center; padding: 4px;">T</td>
                <td style="padding-left: 8px;">Terlambat Masuk</td>
            </tr>
            <tr>
                <td style="background-color: #ffeb9c; color: #9c6500; font-weight: bold; text-align: center; padding: 4px;">TC</td>
                <td style="padding-left: 8px;">Terlambat Check-Out (Sore)</td>
            </tr>
            <tr>
                <td style="background-color: #ffc7ce; color: #9c0006; font-weight: bold; text-align: center; padding: 4px;">LC</td>
                <td style="padding-left: 8px;">Lupa Check-Out</td>
            </tr>
            <tr>
                <td style="background-color: #ffc7ce; color: #9c0006; font-weight: bold; text-align: center; padding: 4px;">A</td>
                <td style="padding-left: 8px;">Alpa / Tanpa Keterangan</td>
            </tr>
            <tr>
                <td style="background-color: #e2e8f0; color: #475569; font-weight: bold; text-align: center; padding: 4px;">L</td>
                <td style="padding-left: 8px;">Hari Libur / Minggu</td>
            </tr>
        </tbody>
    </table>

    <table><tr></tr></table>

    <table border="1" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th colspan="{{ count($hariInMonth) + 8 }}" style="background-color: #800000; color: #ffffff; font-size: 13px; font-weight: bold; text-align: left; padding: 6px;">
                    I. LAPORAN CHECK-IN (SESI MASUK)
                </th>
            </tr>
            <tr style="background-color: #d1d5db; font-weight: bold; font-size: 11px;">
                <th rowspan="2" style="text-align: center; vertical-align: middle; width: 40px;">No</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle; width: 220px;">Nama Lengkap</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle; width: 120px;">{{ $kategori == 'siswa' ? 'NIS' : 'NIP' }}</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle; width: 180px;">{{ $kategori == 'siswa' ? 'Asal Sekolah' : 'Unit Kerja' }}</th>
                <th colspan="{{ count($hariInMonth) }}" style="text-align: center;">Tanggal Sesi Masuk (Check-In)</th>
                <th colspan="4" style="text-align: center;">Total Per Status</th>
            </tr>
            <tr style="background-color: #f3f4f6; font-weight: bold; font-size: 11px;">
                @foreach($hariInMonth as $date)
                    <th style="text-align: center; width: 35px;">{{ $date->format('d') }}</th>
                @endforeach
                <th style="background-color: #a7f3d0; text-align: center; width: 60px;">Tepat</th>
                <th style="background-color: #fde68a; text-align: center; width: 60px;">Terlambat</th>
                <th style="background-color: #fecaca; text-align: center; width: 60px;">Alpa</th>
                <th style="background-color: #bfdbfe; text-align: center; width: 60px;">Libur</th>
            </tr>
        </thead>
        <tbody style="font-size: 11px;">
            @foreach($laporan as $index => $row)
            <tr>
                <td style="text-align: center; vertical-align: middle;">{{ $index + 1 }}</td>
                <td style="vertical-align: middle;">{{ $row['nama'] }}</td>
                <td style="text-align: center; vertical-align: middle; font-family: monospace;">{{ $row['identitas'] }}</td>
                <td style="vertical-align: middle;">{{ $row['instansi'] }}</td>

                @foreach($hariInMonth as $date)
                    @php
                        $simbol = $row['rekap_ci'][$date->format('Y-m-d')] ?? '';
                        $bgColor = match($simbol) {
                            'TW' => '#c6efce',
                            'T'  => '#ffeb9c',
                            'A'  => '#ffc7ce',
                            'L'  => '#e2e8f0',
                            default => '#ffffff'
                        };
                        $textColor = match($simbol) {
                            'TW' => '#006100',
                            'T'  => '#9c6500',
                            'A'  => '#9c0006',
                            'L'  => '#475569',
                            default => '#000000'
                        };
                    @endphp
                    <td style="text-align: center; vertical-align: middle; background-color: {{ $bgColor }}; color: {{ $textColor }}; font-weight: bold;">
                        {{ $simbol }}
                    </td>
                @endforeach

                <td style="text-align: center; vertical-align: middle; font-weight: bold; background-color: #f0fdf4; color: #166534;">{{ $row['ci_tepat'] }}</td>
                <td style="text-align: center; vertical-align: middle; font-weight: bold; background-color: #fffbeb; color: #b45309;">{{ $row['ci_telat'] }}</td>
                <td style="text-align: center; vertical-align: middle; font-weight: bold; background-color: #fef2f2; color: #b91c1c;">{{ $row['ci_alpa'] }}</td>
                <td style="text-align: center; vertical-align: middle; font-weight: bold; background-color: #f8fafc; color: #475569;">{{ $row['ci_libur'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table><tr></tr><tr></tr><tr></tr></table><br>

    <table border="1" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th colspan="{{ count($hariInMonth) + 8 }}" style="background-color: #1e3a8a; color: #ffffff; font-size: 13px; font-weight: bold; text-align: left; padding: 6px;">
                    II. LAPORAN CHECK-OUT (SESI PULANG)
                </th>
            </tr>
            <tr style="background-color: #d1d5db; font-weight: bold; font-size: 11px;">
                <th rowspan="2" style="text-align: center; vertical-align: middle; width: 40px;">No</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle; width: 220px;">Nama Lengkap</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle; width: 120px;">{{ $kategori == 'siswa' ? 'NIS' : 'NIP' }}</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle; width: 180px;">{{ $kategori == 'siswa' ? 'Asal Sekolah' : 'Unit Kerja' }}</th>
                <th colspan="{{ count($hariInMonth) }}" style="text-align: center;">Tanggal Sesi Pulang (Check-Out)</th>
                <th colspan="4" style="text-align: center;">Total Per Status</th>
            </tr>
            <tr style="background-color: #f3f4f6; font-weight: bold; font-size: 11px;">
                @foreach($hariInMonth as $date)
                    <th style="text-align: center; width: 35px;">{{ $date->format('d') }}</th>
                @endforeach
                <th style="background-color: #a7f3d0; text-align: center; width: 60px;">Normal</th>
                <th style="background-color: #fde68a; text-align: center; width: 60px;">Terlambat CO</th>
                <th style="background-color: #fecaca; text-align: center; width: 60px;">Lupa CO</th>
                <th style="background-color: #fecaca; text-align: center; width: 60px;">Alpa</th>
            </tr>
        </thead>
        <tbody style="font-size: 11px;">
            @foreach($laporan as $index => $row)
            <tr>
                <td style="text-align: center; vertical-align: middle;">{{ $index + 1 }}</td>
                <td style="vertical-align: middle;">{{ $row['nama'] }}</td>
                <td style="text-align: center; vertical-align: middle; font-family: monospace;">{{ $row['identitas'] }}</td>
                <td style="vertical-align: middle;">{{ $row['instansi'] }}</td>

                @foreach($hariInMonth as $date)
                    @php
                        $simbol = $row['rekap_co'][$date->format('Y-m-d')] ?? '';
                        $bgColor = match($simbol) {
                            'CO' => '#c6efce',
                            'TC' => '#ffeb9c',
                            'LC', 'A' => '#ffc7ce',
                            'L'  => '#e2e8f0',
                            default => '#ffffff'
                        };
                        $textColor = match($simbol) {
                            'CO' => '#006100',
                            'TC' => '#9c6500',
                            'LC', 'A' => '#9c0006',
                            'L'  => '#475569',
                            default => '#000000'
                        };
                    @endphp
                    <td style="text-align: center; vertical-align: middle; background-color: {{ $bgColor }}; color: {{ $textColor }}; font-weight: bold;">
                        {{ $simbol }}
                    </td>
                @endforeach

                <td style="text-align: center; vertical-align: middle; font-weight: bold; background-color: #f0fdf4; color: #166534;">{{ $row['co_tepat'] }}</td>
                <td style="text-align: center; vertical-align: middle; font-weight: bold; background-color: #fffbeb; color: #b45309;">{{ $row['co_telat'] }}</td>
                <td style="text-align: center; vertical-align: middle; font-weight: bold; background-color: #fef2f2; color: #b91c1c;">{{ $row['co_lupa'] }}</td>
                <td style="text-align: center; vertical-align: middle; font-weight: bold; background-color: #fef2f2; color: #b91c1c;">{{ $row['co_alpa'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
