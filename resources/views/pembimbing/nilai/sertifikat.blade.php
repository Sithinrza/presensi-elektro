<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Magang - {{ $siswa->nama_lengkap }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 14px; color: #000; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .page-break { page-break-after: always; }

        .tabel-nilai { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabel-nilai th, .tabel-nilai td { border: 1px solid black; padding: 6px 8px; }

        .tabel-info { border-collapse: collapse; text-align: center; font-size: 12px; }
        .tabel-info th, .tabel-info td { border: 1px solid black; padding: 4px 8px; }

        .header-title { font-size: 38px; color: #1e3a8a; letter-spacing: 2px; margin-bottom: 5px; }
        .cursive-name {
            font-family: 'Great Vibes', cursive;
            font-size: 52px;
            margin: 15px 0;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding: 0 50px;
            font-weight: normal;
        }
    </style>
</head>
<body>

    <!-- Fungsi PHP kecil untuk mengubah masing-masing angka jadi huruf -->
    @php
        function getGrade($score) {
            if ($score >= 8.50) return 'A';
            if ($score >= 7.50) return 'B';
            if ($score >= 6.00) return 'C';
            return 'D';
        }
    @endphp

    <!-- ================= HALAMAN 1: DEPAN ================= -->
    <div class="text-center" style="padding-top: 100px;">
        <h1 class="header-title">SERTIFIKAT</h1>
        <p style="font-size: 16px;">NOMOR : 004/PL18.3/LL/{{ date('Y') }}</p>

        <p style="margin-top: 50px; font-size: 18px;">Diberikan kepada :</p>

        <div class="cursive-name">{{ $siswa->nama_lengkap }}</div>

        <p style="font-size: 18px; margin-top: 10px;">
            Asal Sekolah :<br>
            <strong>{{ $siswa->sekolah_asal }}</strong>
        </p>

        <p style="margin-top: 40px; font-size: 16px; line-height: 1.6;">
            Yang Telah Melakukan Praktik Kerja Industri (Prakerin)<br>
            Di<br>
            Jurusan Teknik Elektro Politeknik Negeri Banjarmasin<br>
            Tanggal {{ \Carbon\Carbon::parse($siswa->tanggal_mulai)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($siswa->tanggal_selesai)->translatedFormat('d F Y') }}
        </p>

        <table style="width: 100%; margin-top: 80px; text-align: left;">
            <tr>
                <td style="width: 60%;"></td>
                <td style="width: 40%; text-align: left;">
                    <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Ketua Jurusan Teknik Elektro</p>
                    <br><br><br><br>
                    <p class="text-bold" style="text-decoration: underline; margin-bottom: 0;">{{ $kajur_nama }}</p>
                    <p style="margin-top: 2px;">NIP {{ $kajur_nip }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- ================= HALAMAN 2: BELAKANG (TRANSKRIP) ================= -->
    <p class="text-bold" style="font-size: 16px; margin-bottom: 15px;">
        Nama : {{ $siswa->nama_lengkap }}<br>
        Nomor Induk : {{ $siswa->nis }}<br>
        Asal Sekolah : {{ $siswa->sekolah_asal }}
    </p>

    <h3 class="text-center" style="margin-bottom: 5px;">Aspek Komponen yang dinilai :</h3>

    <table class="tabel-nilai">
        <tr>
            <th width="5%" class="text-center">No.</th>
            <th width="65%" class="text-center">Sikap dan Perilaku</th>
            <th width="15%" class="text-center">Angka</th>
            <th width="15%" class="text-center">Huruf</th>
        </tr>
        <tr>
            <td class="text-center">1</td><td>Kecakapan kerja</td>
            <td class="text-center">{{ number_format($nilai->kecakapan_kerja, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->kecakapan_kerja) }}</td>
        </tr>
        <tr>
            <td class="text-center">2</td><td>Kemampuan menerima perintah</td>
            <td class="text-center">{{ number_format($nilai->menerima_perintah, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->menerima_perintah) }}</td>
        </tr>
        <tr>
            <td class="text-center">3</td><td>Sikap / perilaku</td>
            <td class="text-center">{{ number_format($nilai->sikap_perilaku, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->sikap_perilaku) }}</td>
        </tr>
        <tr>
            <td class="text-center">4</td><td>Inisiatif dan kreatifitas</td>
            <td class="text-center">{{ number_format($nilai->inisiatif_kreatifitas, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->inisiatif_kreatifitas) }}</td>
        </tr>
        <tr>
            <td class="text-center">5</td><td>Disiplin dan Kehadiran</td>
            <td class="text-center">{{ number_format($nilai->disiplin_kehadiran, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->disiplin_kehadiran) }}</td>
        </tr>
        <tr>
            <td class="text-center">6</td><td>Tanggung jawab</td>
            <td class="text-center">{{ number_format($nilai->tanggung_jawab, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->tanggung_jawab) }}</td>
        </tr>

        <tr>
            <th class="text-center">No.</th>
            <th class="text-center">Keterampilan</th>
            <th class="text-center">Angka</th>
            <th class="text-center">Huruf</th>
        </tr>
        <tr>
            <td class="text-center">1</td><td>Pemahaman Teknis</td>
            <td class="text-center">{{ number_format($nilai->pemahaman_teknis, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->pemahaman_teknis) }}</td>
        </tr>
        <tr>
            <td class="text-center">2</td><td>Persiapan dan Pengoperasian</td>
            <td class="text-center">{{ number_format($nilai->persiapan_kerja, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->persiapan_kerja) }}</td>
        </tr>
        <tr>
            <td class="text-center">3</td><td>Kerjasama</td>
            <td class="text-center">{{ number_format($nilai->kerjasama_team, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->kerjasama_team) }}</td>
        </tr>
        <tr>
            <td class="text-center">4</td><td>Mutu Kerja</td>
            <td class="text-center">{{ number_format($nilai->mutu_hasil_kerja, 1, ',', '') }}</td>
            <td class="text-center">{{ getGrade($nilai->mutu_hasil_kerja) }}</td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: right; padding-right: 15px;">
                <span class="text-bold">Nilai Rata-Rata</span><br>
                <span class="text-bold">Keterangan</span>
            </td>
            <td class="text-center">
                <span class="text-bold">{{ number_format($rataRata, 2, ',', '') }}</span><br>
                <span class="text-bold">-- {{ strtoupper($keterangan) }} --</span>
            </td>
            <td class="text-center">
                <span class="text-bold">{{ $huruf }}</span><br>
                <span class="text-bold">( {{ str_replace('Lulus ', '', $keterangan) }} )</span>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 30px; border: none;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p class="text-bold" style="margin-bottom: 5px;">Keterangan Nilai (Angka dan Huruf) :</p>
                <table class="tabel-info" style="width: 90%;">
                    <tr><td width="40%">8,50 - 10,00</td><td>A (Lulus Istimewa)</td></tr>
                    <tr><td>7,50 - 8,49</td><td>B (Lulus Baik Sekali)</td></tr>
                    <tr><td>6,00 - 7,49</td><td>C (Lulus Baik)</td></tr>
                    <tr><td>0,00 - 5,99</td><td>D (Belum Lulus)</td></tr>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right; padding-top: 20px;">
                <p>Ketua Jurusan Teknik Elektro</p>
                <br><br><br><br>
                <p class="text-bold" style="text-decoration: underline; margin-bottom: 0;">{{ $kajur_nama }}</p>
                <p style="margin-top: 2px;">NIP {{ $kajur_nip }}</p>
            </td>
        </tr>
    </table>

</body>
</html>
