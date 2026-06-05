<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Magang - {{ $siswa->nama_lengkap }}</title>
    <style>
        /* Margin kertas 0 agar background full mentok ujung */
        @page { margin: 0px; }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #1b365d;
            line-height: 1.2;

            /* Gambar Background */
            background-image: url('{{ public_path("img/sertif.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* BANTALAN KHUSUS HALAMAN 1 (Padding atas dikurangi drastis biar logo naik) */
        .page-front {
            padding: 45px 140px 40px 140px;
        }

        /* BANTALAN KHUSUS HALAMAN 2 (Tetap aman sesuai sebelumnya) */
        .page-back {
            padding: 120px 140px 80px 140px;
        }

        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .page-break { page-break-before: always; }
        p { margin: 0; padding: 0; }

        /* --- TEMA NAVY BLUE --- */
        .header-title {
            color: #1b365d;
            letter-spacing: 5px;
            font-weight: 900;
        }

        .cursive-name {
            font-family: 'Georgia', serif;
            color: #1b365d;
            border-bottom: 1px solid #1b365d;
            display: inline-block;
            padding: 0 40px 5px 40px;
            font-style: italic;
            font-weight: bold;
        }

        /* Tabel Transkrip Halaman 2 */
        .tabel-nilai { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabel-nilai th {
            border: 1px solid #1b365d;
            padding: 5px;
            background-color: #f1f5f9;
            color: #1b365d;
            font-size: 11px;
        }
        .tabel-nilai td {
            border: 1px solid #1b365d;
            padding: 4px 6px;
            font-size: 11px;
        }

        /* Tabel Keterangan & Absen */
        .tabel-info { border-collapse: collapse; text-align: center; font-size: 10px; }
        .tabel-info th, .tabel-info td { border: 1px solid #1b365d; padding: 2px 4px; }
    </style>
</head>
<body>

    @php
        function getGrade($score) {
            if ($score >= 8.50) return 'A';
            if ($score >= 7.50) return 'B';
            if ($score >= 6.00) return 'C';
            return 'D';
        }
    @endphp

    <!-- ================= HALAMAN 1 : DEPAN ================= -->
    <div class="page-front text-center">

        <!-- LOGO NAIK KE ATAS -->
        <img src="{{ public_path('img/logo-sertif.png') }}" alt="Logo" style="height: 80px; margin-bottom: 5px;">

        <h1 class="header-title" style="font-size: 38px; margin-bottom: 5px;">SERTIFIKAT</h1>

        <p style="font-size: 13px; color: #475569; margin-bottom: 25px;">NOMOR : {{ $nomor_sertifikat }}</p>

        <p style="font-size: 15px; margin-bottom: 5px;">Diberikan kepada :</p>

        <!-- Margin nama dirapatkan sedikit -->
        <div class="cursive-name" style="font-size: 44px; margin: 5px 0;">{{ $siswa->nama_lengkap }}</div>

        <p style="font-size: 15px; margin-top: 20px;">Asal Sekolah :</p>
        <p class="text-bold" style="font-size: 17px; margin-bottom: 25px;">{{ $siswa->sekolah_asal }}</p>

        <p style="font-size: 15px; line-height: 1.6; margin-bottom: 20px;">
            Yang Telah Melakukan Praktik Kerja Industri (Prakerin)<br>
            Di<br>
            Jurusan Teknik Elektro Politeknik Negeri Banjarmasin<br>
            Tanggal {{ \Carbon\Carbon::parse($siswa->tanggal_mulai)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($siswa->tanggal_selesai)->translatedFormat('d F Y') }}
        </p>

        <!-- TTD KAJUR DITENGAH (Aman di Halaman 1) -->
        <table style="width: 100%; margin-top: 15px; font-size: 14px;">
            <tr>
                <td style="text-align: center;">
                    <p style="margin-bottom: 5px;">Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Ketua Jurusan Teknik Elektro</p>
                    <div style="height: 80px;"></div>
                    <p class="text-bold" style="text-decoration: underline;">{{ $kajur_nama }}</p>
                    <p>NIP {{ $kajur_nip }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- PISAH HALAMAN -->
    <div class="page-break"></div>

    <!-- ================= HALAMAN 2 : BELAKANG ================= -->
    <div class="page-back">

        <table style="width: 100%; border: none; margin-bottom: 15px;">
            <tr>
                <td style="width: 70%; vertical-align: top; line-height: 1.4;">
                    <span class="text-bold" style="font-size: 12px;">Nama : {{ $siswa->nama_lengkap }}</span><br>
                    <span class="text-bold" style="font-size: 12px;">Nomor Induk : {{ $siswa->nis }}</span><br>
                    <span class="text-bold" style="font-size: 12px;">Asal Sekolah : {{ $siswa->sekolah_asal }}</span>
                </td>
                <td style="width: 30%; vertical-align: top; text-align: right;">
                    <table class="tabel-info" style="float: right; width: 120px;">
                        <tr>
                            <td style="text-align: left; background-color: #f1f5f9; font-weight: bold;">Ketidakhadiran (Alfa)</td>
                            <td style="font-weight: bold;">: {{ $alpa ?? '0' }} Hari</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <h3 class="text-center" style="margin: 5px 0 8px 0; font-size: 13px;">Aspek Komponen yang dinilai :</h3>

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

        <table style="width: 100%; margin-top: 15px; border: none;">
            <tr>
                <td style="width: 45%; vertical-align: top;">
                    <p class="text-bold" style="margin-bottom: 4px; font-size: 10px;">Keterangan Nilai (Angka dan Huruf) :</p>
                    <table class="tabel-info" style="width: 100%;">
                        <tr><td width="40%">8,50 - 10,00</td><td>A (Lulus Istimewa)</td></tr>
                        <tr><td>7,50 - 8,49</td><td>B (Lulus Baik Sekali)</td></tr>
                        <tr><td>6,00 - 7,49</td><td>C (Lulus Baik)</td></tr>
                        <tr><td>0,00 - 5,99</td><td>D (Belum Lulus)</td></tr>
                    </table>
                </td>
                <td style="width: 55%; vertical-align: top; text-align: center;">
                    <p>Ketua Jurusan Teknik Elektro</p>
                    <div style="height: 80px;"></div>
                    <p class="text-bold" style="text-decoration: underline;">{{ $kajur_nama }}</p>
                    <p>NIP {{ $kajur_nip }}</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
