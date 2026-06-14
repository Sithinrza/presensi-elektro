<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>Sistem E-Presensi - Jurusan Teknik Elektro Poliban</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            maroon: {
              50: '#fdf6f7', 100: '#f9e8eb', 200: '#f2cfd6', 300: '#e5a8b7',
              400: '#d27b91', 500: '#bc5a75', 600: '#9f3f5d', 700: '#7f2b46',
              800: '#652037', 900: '#4d182b', 950: '#2b0b16'
            },
            cream: '#fcfaf8',
            gold: {
                light: '#f7f1e7', DEFAULT: '#d8b98b', dark: '#b89a6d'
            }
          },
          fontFamily: {
            heading: ['Plus Jakarta Sans', 'sans-serif'],
            sans: ['Plus Jakarta Sans', 'sans-serif']
          },
          boxShadow: {
            'soft': '0 20px 50px -12px rgba(77, 24, 43, 0.15)',
            'glow': '0 0 20px rgba(216,185,139,0.3)'
          },
          animation: {
            'float-slow': 'float 6s ease-in-out infinite',
            'float-fast': 'float 4s ease-in-out infinite',
            'fade-up': 'fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards'
          },
          keyframes: {
            float: {
              '0%, 100%': { transform: 'translateY(0px)' },
              '50%': { transform: 'translateY(-15px)' }
            },
            fadeUp: {
              '0%': { opacity: '0', transform: 'translateY(30px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            }
          }
        }
      }
    }
  </script>

  <style>
    html { scroll-behavior: smooth; }
    body { background-color: #fcfaf8; }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; sm:width: 8px; }
    ::-webkit-scrollbar-track { background: #fcfaf8; }
    ::-webkit-scrollbar-thumb { background: #bc5a75; border-radius: 10px; }
    
    .glass-nav {
      background: rgba(43, 11, 22, 0.85);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.8);
    }
    
    .pattern-bg {
      background-image: radial-gradient(rgba(188, 90, 117, 0.1) 1px, transparent 1px);
      background-size: 30px 30px;
    }
  </style>
</head>

<body class="text-slate-800 antialiased overflow-x-hidden selection:bg-maroon-500 selection:text-white">

  <!-- NAVBAR -->
  <header class="fixed top-0 w-full z-50 glass-nav transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
      
      <!-- Logo & Brand -->
      <div class="flex items-center gap-3 sm:gap-4 group cursor-pointer">
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-lg sm:rounded-xl p-1 shadow-glow group-hover:scale-105 transition-transform duration-300">
            <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo Poliban" class="w-full h-full object-contain" />
        </div>
        <div>
          <p class="text-[8px] sm:text-[10px] font-bold uppercase tracking-[0.1em] sm:tracking-[0.2em] text-gold mb-0.5">Politeknik Negeri Banjarmasin</p>
          <h1 class="text-xs sm:text-sm md:text-lg font-extrabold text-white font-heading tracking-wide leading-none">Teknik Elektro</h1>
        </div>
      </div>

      <!-- Desktop Nav -->
      <nav class="hidden lg:flex items-center gap-8 text-xs font-bold text-white/80 uppercase tracking-widest">
        <a href="#beranda" class="hover:text-gold transition-colors">Beranda</a>
        <a href="#fitur" class="hover:text-gold transition-colors">Fitur Sistem</a>
        <a href="#tentang" class="hover:text-gold transition-colors">Informasi</a>
      </nav>

      <!-- Login Button -->
      <div class="flex items-center">
        <!-- Tetap tampil di Mobile dengan ukuran lebih kecil, memanjang penuh jika dibutuhkan -->
        <a href="login.html" class="flex items-center gap-2 bg-gold hover:bg-gold-dark text-maroon-950 px-4 py-2 sm:px-6 sm:py-2.5 rounded-full font-black text-[10px] sm:text-xs uppercase tracking-widest transition-all hover:shadow-glow hover:-translate-y-0.5 active:scale-95">
          <span class="hidden sm:inline">Masuk Sistem</span>
          <span class="sm:hidden">Masuk</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        </a>
      </div>

    </div>
  </header>

  <!-- HERO SECTION -->
  <section id="beranda" class="relative pt-28 pb-16 lg:pt-40 lg:pb-28 bg-maroon-950 overflow-hidden">
    <!-- Abstract Background Elements -->
    <div class="absolute top-0 right-0 w-[400px] h-[400px] lg:w-[800px] lg:h-[800px] bg-maroon-800 rounded-full blur-[80px] lg:blur-[120px] opacity-50 -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] lg:w-[600px] lg:h-[600px] bg-gold/20 rounded-full blur-[80px] lg:blur-[100px] translate-y-1/3 -translate-x-1/4"></div>
    <div class="absolute inset-0 pattern-bg opacity-30"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
      
      <!-- Hero Text -->
      <div class="space-y-6 sm:space-y-8 animate-fade-up z-10 text-center lg:text-left pt-8 lg:pt-0">

        <h2 class="font-heading text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-[1.2] lg:leading-[1.15] tracking-tight">
          Kemudahan Presensi dengan<br>
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold to-[#f4d8a5]">Verifikasi Wajah</span> & <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold to-[#f4d8a5]">Lokasi</span>.
        </h2>

        <p class="text-maroon-100/80 text-sm sm:text-base lg:text-lg leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium px-2 sm:px-0">
          Memudahkan pencatatan kehadiran harian Tenaga Kependidikan dan aktivitas Siswa Magang secara terintegrasi di lingkungan Jurusan Teknik Elektro Politeknik Negeri Banjarmasin.
        </p>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 justify-center lg:justify-start pt-2 sm:pt-4 w-full px-4 sm:px-0">
          <a href="login.html" class="w-full sm:w-auto bg-white text-maroon-950 px-6 sm:px-8 py-3.5 sm:py-4 rounded-full font-black text-[10px] sm:text-xs uppercase tracking-widest shadow-xl hover:bg-slate-50 hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
            Masuk ke Aplikasi
          </a>
          <a href="#fitur" class="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 rounded-full font-bold text-[10px] sm:text-xs uppercase tracking-widest text-white hover:bg-white/10 border border-transparent hover:border-white/20 transition-all flex items-center justify-center gap-2">
            Lihat Fitur Utama
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
          </a>
        </div>
      </div>

      <!-- Hero Visual / Mockup (Hidden on mobile for better focus, visible on tablet/desktop) -->
      <div class="relative hidden lg:block animate-fade-up z-10" style="animation-delay: 0.2s;">
        <!-- Floating Elements -->
        <div class="absolute -left-12 top-20 w-24 h-24 bg-white/5 backdrop-blur-lg rounded-2xl border border-white/20 flex items-center justify-center animate-float-slow shadow-2xl z-20">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <div class="absolute -right-8 bottom-32 w-28 h-28 bg-maroon-600/20 backdrop-blur-lg rounded-full border border-maroon-400/30 flex items-center justify-center animate-float-fast shadow-2xl z-20">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>

        <!-- Main Image Card -->
        <div class="relative rounded-[2.5rem] overflow-hidden border-4 border-white/10 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)] transform rotate-2 hover:rotate-0 transition-transform duration-500">
            <div class="absolute inset-0 bg-maroon-900/40 mix-blend-multiply z-10"></div>
            <img src="https://images.unsplash.com/photo-1581092921461-eab62e97a780?auto=format&fit=crop&w=1000&q=80" alt="Siswa Magang Elektro" class="w-full h-[500px] object-cover scale-105">
            
            <!-- Glass Overlay Info -->
            <div class="absolute bottom-6 left-6 right-6 z-20 glass-card rounded-2xl p-4 flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-800">Verifikasi Presensi Sukses</p>
                    <p class="text-[10px] text-slate-500 font-medium">Data Kehadiran Anda Telah Disimpan</p>
                </div>
            </div>
        </div>
      </div>

    </div>
  </section>

  <!-- FEATURES SECTION -->
  <section id="fitur" class="py-16 sm:py-24 relative overflow-hidden bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
      
      <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
        <span class="text-[9px] sm:text-[10px] font-black text-maroon-600 uppercase tracking-[0.2em]">Fasilitas Aplikasi</span>
        <h3 class="font-heading text-2xl sm:text-3xl md:text-4xl font-extrabold text-maroon-950 mt-3 sm:mt-4 mb-3 sm:mb-4 tracking-tight">Fitur Utama Sistem Presensi</h3>
        <p class="text-slate-500 text-sm md:text-base leading-relaxed px-2 sm:px-0">
          Dilengkapi dengan metode verifikasi modern guna memberikan kemudahan serta kejelasan informasi dalam pencatatan kehadiran setiap harinya.
        </p>
      </div>

      <!-- DENGAN xl:grid-cols-6, KITA BISA MEMBUAT BARIS BAWAH (2 ITEM) BERADA DI TENGAH -->
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-5 sm:gap-6 lg:gap-8">
        
        <!-- Feature 1 -->
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100 hover:-translate-y-2 hover:shadow-soft transition-all duration-300 group xl:col-span-2">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-maroon-50 text-maroon-700 flex items-center justify-center mb-5 sm:mb-6 group-hover:bg-maroon-950 group-hover:text-gold transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[32px] sm:h-[32px]"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
          </div>
          <h4 class="text-lg sm:text-xl font-extrabold text-maroon-950 mb-2.5 sm:mb-3 tracking-tight">Verifikasi Wajah (Liveness)</h4>
          <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
            Memastikan kehadiran secara langsung melalui pemindaian wajah yang responsif terhadap pergerakan sederhana, untuk mendata personil dengan tepat.
          </p>
        </div>

        <!-- Feature 2 -->
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100 hover:-translate-y-2 hover:shadow-soft transition-all duration-300 group xl:col-span-2">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-maroon-50 text-maroon-700 flex items-center justify-center mb-5 sm:mb-6 group-hover:bg-maroon-950 group-hover:text-gold transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[32px] sm:h-[32px]"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <h4 class="text-lg sm:text-xl font-extrabold text-maroon-950 mb-2.5 sm:mb-3 tracking-tight">Cek Lokasi Presensi (GPS)</h4>
          <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
            Sistem terintegrasi dengan pemetaan lokasi untuk mencatat titik kehadiran secara otomatis saat pengguna berada di dalam area lingkungan kampus.
          </p>
        </div>

        <!-- Feature 3 -->
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100 hover:-translate-y-2 hover:shadow-soft transition-all duration-300 group xl:col-span-2">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-maroon-50 text-maroon-700 flex items-center justify-center mb-5 sm:mb-6 group-hover:bg-maroon-950 group-hover:text-gold transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[32px] sm:h-[32px]"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <h4 class="text-lg sm:text-xl font-extrabold text-maroon-950 mb-2.5 sm:mb-3 tracking-tight">Jurnal Kegiatan Harian</h4>
          <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
            Tersedia form pengisian jurnal kegiatan (logbook) digital khusus bagi Siswa Magang untuk melaporkan kegiatan hariannya kepada pembimbing lapangan.
          </p>
        </div>

        <!-- Feature 4 (Digeser ke tengah pada desktop dengan col-start-2) -->
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100 hover:-translate-y-2 hover:shadow-soft transition-all duration-300 group xl:col-span-2 xl:col-start-2">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-maroon-50 text-maroon-700 flex items-center justify-center mb-5 sm:mb-6 group-hover:bg-maroon-950 group-hover:text-gold transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[32px] sm:h-[32px]"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          </div>
          <h4 class="text-lg sm:text-xl font-extrabold text-maroon-950 mb-2.5 sm:mb-3 tracking-tight">Rekap Data Otomatis</h4>
          <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
            Laporan absensi, keterlambatan, hingga rekapitulasi data per individu dapat disusun dan diakses dengan cepat untuk keperluan evaluasi administrasi.
          </p>
        </div>

        <!-- Feature 5 -->
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-100 hover:-translate-y-2 hover:shadow-soft transition-all duration-300 group xl:col-span-2">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-maroon-50 text-maroon-700 flex items-center justify-center mb-5 sm:mb-6 group-hover:bg-maroon-950 group-hover:text-gold transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[32px] sm:h-[32px]"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </div>
          <h4 class="text-lg sm:text-xl font-extrabold text-maroon-950 mb-2.5 sm:mb-3 tracking-tight">E-Sertifikat Praktik Kerja</h4>
          <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
            Sistem menyediakan fitur pencetakan sertifikat format digital setelah masa tugas Siswa Magang berakhir, yang dilengkapi dengan transkrip penilaian kegiatan.
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- ABOUT SECTION -->
  <section id="tentang" class="py-16 sm:py-24 bg-maroon-900 border-y border-maroon-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 pattern-bg opacity-10"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] lg:w-[800px] lg:h-[800px] bg-gold/5 rounded-full blur-[80px] lg:blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10 grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
      
      <!-- Text Info -->
      <div class="space-y-5 sm:space-y-6 text-center lg:text-left">
        <span class="inline-block text-[9px] sm:text-[10px] font-black text-gold uppercase tracking-[0.2em] border border-gold/30 px-3 py-1.5 rounded-full bg-gold/10">Latar Belakang</span>
        <h3 class="font-heading text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">Modernisasi Layanan <br> <span class="font-normal opacity-90">Jurusan Elektro.</span></h3>
        <div class="w-12 sm:w-16 h-1 bg-gold rounded-full mx-auto lg:mx-0"></div>
        <p class="text-maroon-100/80 leading-relaxed text-sm sm:text-base px-2 sm:px-0">
          Aplikasi E-Presensi ini dikembangkan guna menjembatani kebutuhan pencatatan administrasi kehadiran yang sebelumnya dilakukan secara manual menjadi lebih rapi dan terpusat dalam satu ruang digital.
        </p>
        <p class="text-maroon-100/80 leading-relaxed text-sm sm:text-base px-2 sm:px-0">
          Hadirnya sistem ini diharapkan mampu mendukung efisiensi waktu, serta menyederhanakan pelaporan evaluasi kedisiplinan dan rekapitulasi data bagi staf Tenaga Kependidikan maupun kegiatan Siswa Magang.
        </p>
        
        <div class="pt-4 sm:pt-6 grid grid-cols-2 gap-4 sm:gap-8 justify-center lg:justify-start">
            <div>
                <p class="text-3xl sm:text-4xl font-black text-gold">4</p>
                <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-maroon-200 mt-1.5 sm:mt-2">Level Akses User</p>
            </div>
            <div>
                <p class="text-3xl sm:text-4xl font-black text-gold">100%</p>
                <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-maroon-200 mt-1.5 sm:mt-2">Sistem Tanpa Kertas</p>
            </div>
        </div>
      </div>

      <!-- Image/Cards -->
      <div class="grid gap-3 sm:gap-4 sm:grid-cols-2 mt-8 lg:mt-0">
        <div class="bg-white/10 backdrop-blur-md rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-white/10 hover:bg-white/15 transition-colors">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gold/20 flex items-center justify-center text-gold mb-3 sm:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="sm:w-5 sm:h-5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><rect x="19" y="8" width="2" height="10"/><path d="M19 8c0-1.1.9-2 2-2"/></svg>
            </div>
            <h4 class="font-bold text-base sm:text-lg mb-1.5 sm:mb-2">Tenaga Kependidikan</h4>
            <p class="text-[11px] sm:text-xs text-white/60 leading-relaxed">Pencatatan presensi rutin masuk dan pulang bagi staf harian maupun teknisi laboratorium.</p>
        </div>
        
        <div class="bg-white/10 backdrop-blur-md rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-white/10 hover:bg-white/15 transition-colors sm:translate-y-8">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gold/20 flex items-center justify-center text-gold mb-3 sm:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="sm:w-5 sm:h-5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h4 class="font-bold text-base sm:text-lg mb-1.5 sm:mb-2">Siswa Magang</h4>
            <p class="text-[11px] sm:text-xs text-white/60 leading-relaxed">Pengisian presensi kehadiran dan laporan kegiatan melalui jurnal logbook digital.</p>
        </div>

        <div class="bg-white/10 backdrop-blur-md rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-white/10 hover:bg-white/15 transition-colors">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gold/20 flex items-center justify-center text-gold mb-3 sm:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="sm:w-5 sm:h-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
            </div>
            <h4 class="font-bold text-base sm:text-lg mb-1.5 sm:mb-2">Pembimbing Siswa</h4>
            <p class="text-[11px] sm:text-xs text-white/60 leading-relaxed">Melakukan peninjauan serta verifikasi logbook harian sebelum mengisi nilai evaluasi akhir praktik.</p>
        </div>

        <div class="bg-white/10 backdrop-blur-md rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-white/10 hover:bg-white/15 transition-colors sm:translate-y-8">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gold/20 flex items-center justify-center text-gold mb-3 sm:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="sm:w-5 sm:h-5"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
            </div>
            <h4 class="font-bold text-base sm:text-lg mb-1.5 sm:mb-2">Administrator</h4>
            <p class="text-[11px] sm:text-xs text-white/60 leading-relaxed">Melakukan pendataan master personil, pengelolaan hari libur, pemantauan riwayat dan rilis cetak sertifikat.</p>
        </div>
      </div>

    </div>
  </section>

  <!-- CTA SECTION -->
  <section class="py-16 sm:py-24 relative bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
      <div class="bg-white rounded-[2rem] sm:rounded-[3rem] p-8 sm:p-10 md:p-16 text-center shadow-premium border border-slate-100 relative overflow-hidden">
        <div class="absolute -top-10 sm:-top-20 -left-10 sm:-left-20 w-40 h-40 sm:w-64 sm:h-64 bg-maroon-100 rounded-full blur-[60px] sm:blur-[80px] opacity-60 pointer-events-none"></div>
        <div class="absolute -bottom-10 sm:-bottom-20 -right-10 sm:-right-20 w-40 h-40 sm:w-64 sm:h-64 bg-gold/20 rounded-full blur-[60px] sm:blur-[80px] pointer-events-none"></div>

        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-maroon-50 text-maroon-900 rounded-xl sm:rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6 shadow-sm border border-maroon-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="sm:w-[32px] sm:h-[32px]"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        </div>
        <h3 class="font-heading text-2xl sm:text-3xl md:text-5xl font-extrabold text-maroon-950 mb-3 sm:mb-4 relative z-10 tracking-tight">Kunjungi Aplikasi</h3>
        <p class="text-slate-500 max-w-xl mx-auto mb-8 sm:mb-10 text-xs sm:text-sm md:text-base relative z-10 px-2 sm:px-0">
          Gunakan alamat email atau nomor identitas (NIP/NIS) yang telah didaftarkan oleh Pihak Jurusan untuk mengakses menu sistem.
        </p>
        
        <a href="login.html" class="flex sm:inline-flex items-center justify-center w-full sm:w-auto gap-2 sm:gap-3 bg-maroon-950 text-white px-6 sm:px-10 py-4 sm:py-5 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest hover:bg-maroon-800 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1 active:scale-95 relative z-10">
            Masuk ke Sistem
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
      <div class="flex flex-col sm:flex-row items-center gap-3">
          <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo" class="w-8 h-8 opacity-80 grayscale">
          <div>
            <h4 class="font-bold text-maroon-950 text-xs sm:text-sm leading-none">Sistem Presensi Elektro</h4>
            <p class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Politeknik Negeri Banjarmasin</p>
          </div>
      </div>
      <p class="text-[10px] sm:text-[11px] font-bold text-slate-400">© 2026. Dikembangkan untuk Tugas Akhir.</p>
    </div>
  </footer>

  <!-- Script for Navbar Background on Scroll -->
  <script>
    window.addEventListener('scroll', () => {
      const header = document.querySelector('header');
      if (window.scrollY > 50) {
        header.classList.add('shadow-lg', 'bg-maroon-950/95');
        header.classList.remove('bg-transparent');
      } else {
        header.classList.remove('shadow-lg', 'bg-maroon-950/95');
        header.classList.add('bg-transparent');
      }
    });
  </script>
</body>
</html>