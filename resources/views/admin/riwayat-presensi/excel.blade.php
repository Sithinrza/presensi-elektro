<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table>
        <tr>
            <td colspan="5"><strong>YAYASAN HASNUR CENTRE</strong></td>
        </tr>
        <tr>
            <td colspan="5"><strong>REKAPITULASI PRESENSI {{ strtoupper($kategori) }}</strong></td>
        </tr>
        <tr>
            <td colspan="5">Periode: {{ Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}</td>
        </tr>
        <tr></tr> </table>

    <table border="1">
        <thead>
            <tr style="background-color: #d1d5db; font-weight: bold;">
                <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Lengkap</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">{{ $kategori == 'siswa' ? 'NIS' : 'NIP' }}</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">{{ $kategori == 'siswa' ? 'Asal Sekolah' : 'Unit Kerja' }}</th>
                <th colspan="{{ count($hariInMonth) }}" style="text-align: center;">Tanggal</th>
                <th colspan="4" style="text-align: center;">Total</th>
            </tr>
            <tr style="background-color: #d1d5db; font-weight: bold;">
                @foreach($hariInMonth as $date)
                    <th style="text-align: center; width: 30px;">{{ $date->format('d') }}</th>
                @endforeach
                <th style="text-align: center;">Hadir</th>
                <th style="text-align: center;">Telat</th>
                <th style="text-align: center;">Alfa</th>
                <th style="text-align: center;">Libur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $row)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $row['nama'] }}</td>
                <td style="text-align: center;">{{ $row['identitas'] }}</td>
                <td>{{ $row['instansi'] }}</td>

                @foreach($hariInMonth as $date)
                    @php
                        $simbol = $row['rekap'][$date->format('Y-m-d')];
                        $bgColor = '';
                        if($simbol == 'H') $bgColor = '#a7f3d0'; // Hijau
                        if($simbol == 'T') $bgColor = '#fde68a'; // Kuning
                        if($simbol == 'A') $bgColor = '#fecaca'; // Merah
                        if($simbol == 'L') $bgColor = '#bfdbfe'; // Biru
                    @endphp
                    <td style="text-align: center; background-color: {{ $bgColor }};">
                        {{ $simbol }}
                    </td>
                @endforeach

                <td style="text-align: center; font-weight: bold;">{{ $row['hadir'] }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $row['telat'] }}</td>
                <td style="text-align: center; font-weight: bold; color: red;">{{ $row['alfa'] }}</td>
                <td style="text-align: center; font-weight: bold; color: blue;">{{ $row['libur'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
