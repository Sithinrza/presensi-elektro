<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Magang - {{ $siswa->nama_lengkap }}</title>
    <!-- Import Font Eksklusif untuk Sertifikat -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Times+New+Roman&family=Arial&display=swap" rel="stylesheet">
    
    <style>
        /* ================= RESET & DASAR ================= */
        body { 
            font-family: 'Times New Roman', Times, serif; 
            color: #000; 
            margin: 0; 
            padding: 0;
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        
        /* Memisahkan halaman 1 (Sertifikat) dan halaman 2 (Transkrip) */
        .page-break { page-break-before: always; }

        /* ================= HALAMAN 1: DESAIN SERTIFIKAT (LANKSAP) ================= */
        /* Catatan: Untuk hasil PDF lanskap, atur ukuran kertas di controller DOMPDF: 
           $pdf->setPaper('A4', 'landscape'); 
        */
        .cert-container {
            border: 15px solid #2f5597; /* Biru mirip referensi */
            padding: 5px;
            margin: 20px;
            box-sizing: border-box;
            height: 650px; /* Asumsi A4 Landscape */
            position: relative;
        }
        .cert-inner {
            border: 3px solid #d97706; /* Oranye/Emas mirip referensi */
            height: 100%;
            padding: 40px 60px;
            box-sizing: border-box;
            text-align: center;
        }
        .cert-logo {
            width: 80px;
            margin-bottom: 10px;
        }
        .cert-title {
            font-family: 'Times New Roman', serif;
            font-size: 45px;
            color: #1e3a8a;
            letter-spacing: 5px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .cert-number {
            font-size: 14px;
            margin: 0 0 30px 0;
        }
        .cert-given-to {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .cert-name {
            font-family: 'Great Vibes', cursive;
            font-size: 65px;
            color: #1e3a8a;
            margin: 0;
            line-height: 1;
            font-weight: normal;
        }
        .cert-school {
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            margin: 10px 0 30px 0;
            text-transform: uppercase;
        }
        .cert-body-text {
            font-size: 16px;
            line-height: 1.6;
            margin: 0 auto;
            width: 80%;
            text-align: center;
        }
        .cert-signature-area {
            margin-top: 50px;
            width: 100%;
        }
        .cert-signature-area td {
            width: 50%;
            vertical-align: bottom;
        }
        .cert-signature-right {
            text-align: left;
            padding-left: 20%; /* Mendorong tanda tangan agak ke tengah kanan */
        }
        .sign-name {
            text-decoration: underline;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 2px;
        }

        /* ================= HALAMAN 2: TRANSKRIP NILAI (PORTRAIT) ================= */
        /* Catatan: Di DOMPDF, ganti orientasi halaman 2 agak sulit. 
           Bisa disiasati dengan me-render 2 view PDF yang berbeda (1 landscape, 1 portrait) 
           lalu digabung (merge) pakai library tambahan, ATAU buat semuanya Portrait.
           Di sini, saya mendesain transkrip dalam mode Portrait.
        */
        .transcript-wrapper {
            padding: 30px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 13px;
        }
        
        /* Tabel Rekap Absen di pojok kiri atas */
        .table-absensi {
            border-collapse: collapse;
            width: 150px;
            font-size: 12px;
            margin-bottom: 20px;
        }
        .table-absensi th, .table-absensi td {
            border: 1px solid #000;
            padding: 4px;
        }

        /* Identitas Siswa di Kanan Atas (Sejajar dengan tabel absen) */
        .identity-wrapper {
            width: 100%;
            margin-bottom: 20px;
        }
        .identity-table {
            font-size: 14px;
            margin-left: auto;
        }
        .identity-table td { padding: 3px 0; }

        .transcript-heading {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        /* Tabel Nilai Utama */
        .grade-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .grade-table th, .grade-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: middle;
        }
        .grade-table th {
            background-color: #f0f0f0;
            text-align: center;
        }
        
        .section-header {
            font-weight: bold;
            font-style: italic;
        }

        /* Keterangan Skala Nilai & Tanda Tangan */
        .footer-wrapper {
            width: 100%;
            margin-top: 30px;
            font-size: 12px;
        }
        .footer-wrapper td {
            vertical-align: top;
        }
        .scale-table {
            border-collapse: collapse;
            width: 90%;
        }
        .scale-table th, .scale-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Helper PHP untuk Konversi Huruf -->
    @php
        function getGrade($score) {
            if ($score >= 8.50) return 'A';
            if ($score >= 7.50) return 'B';
            if ($score >= 6.00) return 'C';
            return 'D';
        }

        function terbilang($nilai) {
            // Logika terbilang sederhana (bisa disesuaikan dengan fungsi helper Laravel Anda)
            // Contoh output: "Sembilan Koma Delapan Nol"
            return "Sembilan Koma Lima Nol"; // Placeholder
        }
    @endphp

    <!-- ==========================================
         HALAMAN 1: DEPAN (SERTIFIKAT LANSKAP) 
         ========================================== -->
    <div class="cert-container">
        <div class="cert-inner">
            
            <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo Poliban" class="cert-logo">

            <h1 class="cert-title">Sertifikat</h1>
            <p class="cert-number">NOMOR : 004/PL18.3/LL/{{ date('Y') }}</p>

            <p class="cert-given-to">Diberikan kepada :</p>

            <h2 class="cert-name">{{ $siswa->nama_lengkap }}</h2>
            
            <p class="cert-school">Asal Sekolah: <strong>{{ $siswa->sekolah_asal }}</strong></p>

            <p class="cert-body-text">
                Yang Telah Melakukan Praktik Kerja Industri (Prakerin) <br>
                Di <br>
                Jurusan Teknik Elektro Politeknik Negeri Banjarmasin <br>
                Tanggal {{ \Carbon\Carbon::parse($siswa->tanggal_mulai)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($siswa->tanggal_selesai)->translatedFormat('d F Y') }}
            </p>

            <table class="cert-signature-area">
                <tr>
                    <td></td> <!-- Kiri Kosong -->
                    <td class="cert-signature-right">
                        <p style="margin-bottom: 5px;">
                            Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                            Ketua Jurusan Teknik Elektro
                        </p>
                        <!-- Area Tanda Tangan & Stempel (Statis 80px) -->
                        <div style="height: 80px;"></div> 
                        <p class="sign-name">{{ $kajur_nama ?? 'M. Helmy Noor, S.ST., M.T.' }}</p>
                        <p style="margin: 0;">NIP. {{ $kajur_nip ?? '19750507 200012 1 001' }}</p>
                    </td>
                </tr>
            </table>

        </div>
    </div>

    <!-- Pindah Halaman untuk DOMPDF -->
    <div class="page-break"></div>

    <!-- ==========================================
         HALAMAN 2: BELAKANG (TRANSKRIP POTRAIT) 
         ========================================== -->
    <div class="transcript-wrapper">

        <!-- Header Transkrip: Tabel Absen (Kiri) dan Identitas (Kanan) -->
        <table class="identity-wrapper">
            <tr>
                <td style="width: 40%; vertical-align: top;">
                    <table class="table-absensi">
                        <tr><td>Sakit</td><td class="text-center">: {{ $absensi['sakit'] ?? 0 }}</td></tr>
                        <tr><td>Izin</td><td class="text-center">: {{ $absensi['izin'] ?? 0 }}</td></tr>
                        <tr><td>Alpa</td><td class="text-center">: {{ $absensi['alpa'] ?? 0 }}</td></tr>
                    </table>
                </td>
                <td style="width: 60%; vertical-align: top;">
                    <table class="identity-table">
                        <tr>
                            <td>Nama</td>
                            <td>: {{ $siswa->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Induk</td>
                            <td>: {{ $siswa->nis }}</td>
                        </tr>
                        <tr>
                            <td>Asal Sekolah</td>
                            <td>: {{ $siswa->sekolah_asal }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <p class="transcript-heading">Aspek Komponen yang dinilai :</p>

        <!-- Tabel Nilai Mirip Referensi -->
        <table class="grade-table">
            <thead>
                <tr>
                    <th rowspan="2" width="5%">No.</th>
                    <th rowspan="2" width="45%">Sikap dan Perilaku</th>
                    <th colspan="2">Angka</th>
                </tr>
                <tr>
                    <th width="25%">Angka</th>
                    <th width="25%">Huruf</th>
                </tr>
            </thead>
            <tbody>
                <!-- BAGIAN 1: Sikap & Perilaku -->
                <tr>
                    <td class="text-center">1</td>
                    <td>Kecakapan kerja</td>
                    <td class="text-center">{{ number_format($nilai->kecakapan_kerja ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->kecakapan_kerja ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Kemampuan menerima perintah</td>
                    <td class="text-center">{{ number_format($nilai->menerima_perintah ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->menerima_perintah ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Sikap / perilaku</td>
                    <td class="text-center">{{ number_format($nilai->sikap_perilaku ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->sikap_perilaku ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>Inisiatif dan kreatifitas</td>
                    <td class="text-center">{{ number_format($nilai->inisiatif_kreatifitas ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->inisiatif_kreatifitas ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-center">5</td>
                    <td>Disiplin dan Kehadiran</td>
                    <td class="text-center">{{ number_format($nilai->disiplin_kehadiran ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->disiplin_kehadiran ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-center">6</td>
                    <td>Tanggung jawab</td>
                    <td class="text-center">{{ number_format($nilai->tanggung_jawab ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->tanggung_jawab ?? 0) }}</td>
                </tr>

                <!-- BAGIAN 2: Keterampilan -->
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Keterampilan</th>
                    <th class="text-center">Angka</th>
                    <th class="text-center">Huruf</th>
                </tr>
                <tr>
                    <td class="text-center">1</td>
                    <td>Pemahaman Teknis</td>
                    <td class="text-center">{{ number_format($nilai->pemahaman_teknis ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->pemahaman_teknis ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Persiapan dan Pengoperasian</td>
                    <td class="text-center">{{ number_format($nilai->persiapan_kerja ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->persiapan_kerja ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Kerjasama</td>
                    <td class="text-center">{{ number_format($nilai->kerjasama_team ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->kerjasama_team ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>Mutu Kerja</td>
                    <td class="text-center">{{ number_format($nilai->mutu_hasil_kerja ?? 0, 1, ',', '') }}</td>
                    <td class="text-center">{{ getGrade($nilai->mutu_hasil_kerja ?? 0) }}</td>
                </tr>

                <!-- REKAP RATA-RATA -->
                <tr>
                    <td colspan="2" class="text-bold" style="padding-left: 20px;">
                        Nilai Rata-Rata
                    </td>
                    <td class="text-center text-bold">{{ number_format($rataRata ?? 0, 2, ',', '') }}</td>
                    <td class="text-center text-bold">{{ $huruf ?? 'D' }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-bold" style="padding-left: 20px;">
                        Keterangan
                    </td>
                    <td colspan="2" class="text-center text-bold" style="text-transform: uppercase;">
                        -- {{ $keterangan ?? 'LULUS' }} --
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- FOOTER: Skala Nilai & Tanda Tangan -->
        <table class="footer-wrapper">
            <tr>
                <td style="width: 50%;">
                    <p style="margin: 0 0 5px 0;">Keterangan Nilai (Angka dan Huruf) :</p>
                    <table class="scale-table">
                        <tr>
                            <td>8,50 - 10,00</td>
                            <td>A ( Lulus Istimewa )</td>
                        </tr>
                        <tr>
                            <td>7,50 - 8,49</td>
                            <td>B ( Lulus Baik Sekali )</td>
                        </tr>
                        <tr>
                            <td>6,00 - 7,49</td>
                            <td>C ( Lulus Baik )</td>
                        </tr>
                        <tr>
                            <td>0,00 - 5,99</td>
                            <td>D ( Belum Lulus )</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; text-align: left; padding-left: 40px;">
                    <div style="position: relative;">
                        <!-- Tempat Stempel & TTD -->
                        <!-- <img src="URL_STEMPEL" style="position: absolute; left: -20px; top: -10px; width: 100px; opacity: 0.8; z-index: -1;"> -->
                        <p style="margin-bottom: 5px;">Ketua Jurusan Teknik Elektro</p>
                        <div style="height: 70px;"></div> <!-- Spasi TTD -->
                        <p class="sign-name">{{ $kajur_nama ?? 'M. Helmy Noor, S.ST., M.T.' }}</p>
                        <p style="margin: 0;">NIP {{ $kajur_nip ?? '19750507 200012 1 001' }}</p>
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>