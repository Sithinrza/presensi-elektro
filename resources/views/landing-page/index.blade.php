<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPETANG | Sistem Presensi Elektro</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            900: '#5B1D2A',
                            800: '#6D2433',
                            700: '#8A3044'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 text-slate-800 scroll-smooth">

    <nav class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-lg border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-black text-maroon-900 tracking-tight">
                    SIPETANG
                </h1>
            </div>
            <div class="hidden md:flex gap-8 font-semibold text-slate-600">
                <a href="#tentang" class="hover:text-maroon-900 transition">Tentang</a>
                <a href="#fitur" class="hover:text-maroon-900 transition">Fitur</a>
                <a href="#elektro" class="hover:text-maroon-900 transition">Jurusan Elektro</a>
            </div>
            <a href="/login" class="bg-maroon-900 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-maroon-800 transition shadow-lg shadow-maroon-900/30">
                Login Sistem
            </a>
        </div>
    </nav>

    <section class="relative overflow-hidden pt-32 pb-24 lg:pt-48 lg:pb-32">
        <div class="absolute inset-0 bg-gradient-to-br from-maroon-900 via-maroon-800 to-slate-900"></div>
        <div class="relative max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">

            <div>
                <span class="bg-white/10 text-white px-4 py-2 rounded-full text-sm font-semibold border border-white/20 backdrop-blur-md">
                    Inovasi Digitalisasi Kampus
                </span>
                <h1 class="mt-6 text-5xl lg:text-7xl font-black text-white leading-tight">
                    Presensi <span class="text-amber-400">Anti-Spoofing</span> <br>Lebih Akurat.
                </h1>
                <p class="mt-6 text-lg text-slate-300 leading-relaxed max-w-xl">
                    SIPETANG memastikan kehadiran fisik secara nyata menggunakan teknologi <b>Face Liveness Detection</b> dan validasi lokasi GPS. Khusus dirancang untuk Tenaga Kependidikan (Tendik) dan Siswa Magang.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="/login" class="bg-white text-maroon-900 px-8 py-4 rounded-2xl font-bold hover:scale-105 transition shadow-xl">
                        Mulai Presensi
                    </a>
                    <a href="#alur" class="border border-white/30 text-white px-8 py-4 rounded-2xl font-bold hover:bg-white/10 transition backdrop-blur-sm">
                        Cara Kerja
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="bg-white/10 backdrop-blur-xl rounded-[3rem] p-8 border border-white/20 shadow-2xl relative z-10 transform hover:-translate-y-2 transition duration-500">
                    <div class="bg-slate-900 rounded-3xl p-8 text-center border-4 border-slate-800">
                        <div class="w-24 h-24 mx-auto border-4 border-amber-400 rounded-full flex items-center justify-center animate-pulse">
                            <span class="text-amber-400 font-bold text-sm">Liveness<br>Scan</span>
                        </div>
                        <h3 class="text-white text-2xl font-black mt-6">Verifikasi Fisik</h3>
                        <p class="text-slate-400 mt-2 text-sm">Sistem mendeteksi kedipan mata untuk mencegah kecurangan menggunakan foto cetak atau layar HP.</p>
                    </div>
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-maroon-600/30 blur-3xl rounded-full z-0"></div>
            </div>
        </div>
    </section>

    <section id="fitur" class="bg-slate-50 py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-4xl font-black text-slate-900">Kenapa Menggunakan SIPETANG?</h2>
                <p class="text-slate-500 mt-4 text-lg">Sistem presensi modern yang memadukan keamanan kecerdasan buatan dan validasi koordinat geografis.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-red-100 text-maroon-900 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h3x"/><path d="M19 12h3"/><path d="M12 2v3"/><path d="M12 19v3"/><path d="M4.93 4.93l2.12 2.12"/><path d="M16.95 16.95l2.12 2.12"/><path d="M4.93 19.07l2.12-2.12"/><path d="M16.95 7.05l2.12-2.12"/><circle cx="12" cy="12" r="4"/></svg>
                    </div>
                    <h3 class="font-black text-xl text-slate-800">Liveness Detection</h3>
                    <p class="mt-3 text-slate-600">Teknologi anti-spoofing yang memastikan pengguna benar-benar hadir secara fisik di depan kamera, bukan sekadar menunjukkan foto.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-blue-100 text-blue-700 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <h3 class="font-black text-xl text-slate-800">Geofencing & GPS</h3>
                    <p class="mt-3 text-slate-600">Presensi hanya dapat dilakukan jika pengguna berada di dalam radius aman yang telah ditentukan dari lokasi kantor atau kampus.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-green-100 text-green-700 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h3 class="font-black text-xl text-slate-800">Otomatisasi Status</h3>
                    <p class="mt-3 text-slate-600">Sistem otomatis mendata status Tepat Waktu, Terlambat, Alfa, hingga Lupa Check-Out berdasarkan aturan jam kerja institusi.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="elektro" class="py-24 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
            <div class="order-2 md:order-1">
                <div class="w-full h-[400px] bg-slate-200 rounded-3xl flex items-center justify-center border-4 border-slate-100">
                    <span class="text-slate-400 font-bold uppercase tracking-widest">[Foto/Gedung Jurusan Elektro]</span>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <h2 class="text-4xl font-black text-maroon-900 mb-6">Jurusan Teknik Elektro</h2>
                <h3 class="text-xl font-bold text-slate-800 mb-4">Politeknik Negeri Banjarmasin</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">
                    Menjadi pusat pendidikan vokasi yang unggul dan adaptif terhadap perkembangan teknologi industri. Aplikasi SIPETANG merupakan salah satu wujud nyata dari upaya digitalisasi dan peningkatan kedisiplinan di lingkungan jurusan.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">✓</div>
                        <span class="text-slate-700 font-medium">Mendukung pengelolaan administrasi Tendik secara digital.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">✓</div>
                        <span class="text-slate-700 font-medium">Memudahkan pemantauan kedisiplinan Siswa Magang.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800 text-center">
        <h3 class="text-white font-black text-2xl tracking-tight mb-2">SIPETANG</h3>
        <p class="mb-8">Sistem Presensi Elektrik dengan Deteksi Wajah</p>
        <p class="text-sm">
            © 2026 Jurusan Teknik Elektro - Politeknik Negeri Banjarmasin.
        </p>
    </footer>

</body>
</html>
