@extends('layouts.siswa')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT COLUMN -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-8">

            <!-- GREETING & CLOCK -->
            <section class="animate-in flex flex-col md:flex-row md:items-end justify-between gap-4" style="animation-delay: 0.1s">
                <div>
                    <p class="text-slate-500 font-medium text-base">Selamat pagi, Semangat Magang! 🚀</p>
                    <h2 id="liveDate" class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-wider italic">--</h2>
                </div>
                <div class="md:text-right text-left">
                    <div id="liveClock" class="text-4xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-none mb-1">00:00:00</div>
                    <span class="text-[10px] md:text-xs font-bold text-maroon-500 uppercase tracking-widest">Waktu Indonesia Tengah</span>
                </div>
            </section>

            <!-- PRESENSI CARD -->
            <section class="animate-in" style="animation-delay: 0.2s">
                <div class="relative bg-maroon-900 rounded-[3rem] p-8 md:p-10 text-white shadow-premium overflow-hidden border border-maroon-800">
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-gold/20 rounded-full blur-[80px]"></div>
                    <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-white/10 rounded-full blur-[60px]"></div>

                    <div class="relative z-10 space-y-8">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="space-y-2">
                                <p class="text-maroon-200/60 text-xs font-bold uppercase tracking-[0.3em]">Status Absensi</p>
                                <h3 class="text-2xl md:text-3xl font-black italic tracking-tight leading-tight">Pastikan Lokasi & Wajah <br><span class="text-gold">Terverifikasi</span></h3>
                            </div>
                            <div class="bg-emerald-500/20 text-emerald-300 px-4 py-2 rounded-2xl text-xs font-extrabold border border-emerald-500/30 backdrop-blur-md flex items-center gap-3">
                                <span class="w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_12px_rgba(52,211,153,0.8)]"></span>
                                RADIUS VALID
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <a href="#" class="group bg-white rounded-[2rem] p-6 flex items-center gap-5 shadow-xl hover:shadow-2xl active:scale-95 transition-all duration-300">
                                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-maroon-950 font-black text-lg uppercase tracking-wide leading-none">Absen Masuk</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Start Working</span>
                                </div>
                            </a>
                            <a href="#" class="group bg-maroon-800 border border-white/10 rounded-[2rem] p-6 flex items-center gap-5 active:scale-95 transition-all duration-300 hover:bg-rose-900/40">
                                <div class="w-14 h-14 bg-white/10 text-maroon-100 rounded-2xl flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-white font-black text-lg uppercase tracking-wide leading-none">Absen Pulang</span>
                                    <span class="text-[10px] text-maroon-200/50 font-bold uppercase tracking-widest mt-1">End Session</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- LOG HARIAN QUICK ACCESS -->
            <section class="animate-in" style="animation-delay: 0.3s">
                <div class="bg-white rounded-[2.5rem] p-8 border border-maroon-100 shadow-sm flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                    <div class="w-20 h-20 bg-gold-light text-gold-dark rounded-3xl flex items-center justify-center shrink-0 shadow-inner mx-auto md:mx-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-black text-maroon-950 tracking-tight">Log Harian Siswa</h3>
                        <p class="text-sm text-slate-500 font-medium mt-1 leading-relaxed">
                            Jangan lupa isi laporan kegiatan magang kamu hari ini agar terekap oleh pembimbing.
                        </p>
                    </div>
                    <button class="bg-maroon-950 text-white px-8 py-4 rounded-2xl font-bold hover:bg-maroon-800 transition-all shadow-lg active:scale-95 whitespace-nowrap w-full md:w-auto">
                        Isi Log Hari Ini
                    </button>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="lg:col-span-5 xl:col-span-4 space-y-8">

            <!-- ATTENDANCE SUMMARY CARD (REVISED) -->
            <section class="animate-in" style="animation-delay: 0.4s">
                <div class="bg-white p-8 rounded-[3rem] border border-maroon-100 shadow-sm space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-extrabold text-maroon-950 tracking-tight text-lg">Kehadiran Bulan Ini</h3>
                        <span class="text-[10px] font-black bg-gold-light text-gold-dark px-3 py-1 rounded-full uppercase tracking-tighter">April 2024</span>
                    </div>

                    <div class="flex flex-col items-center justify-center py-6 bg-maroon-50 rounded-[2rem] border border-maroon-100/50">
                        <div class="flex items-baseline gap-1">
                            <span class="text-6xl font-black text-maroon-950 leading-none">17</span>
                            <span class="text-lg font-bold text-maroon-500/60 uppercase tracking-tighter">/ 20</span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-[0.2em]">Total Kehadiran</p>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-maroon-50/50 p-3 rounded-2xl border border-maroon-100/30 flex flex-col items-center">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Hadir</span>
                            <span class="text-xl font-black text-maroon-900 mt-1">16</span>
                        </div>
                        <div class="bg-amber-50 p-3 rounded-2xl border border-amber-100 flex flex-col items-center">
                            <span class="text-[9px] font-bold text-amber-600/60 uppercase tracking-widest leading-none">Telat</span>
                            <span class="text-xl font-black text-amber-600 mt-1">01</span>
                        </div>
                        <div class="bg-rose-50 p-3 rounded-2xl border border-rose-100 flex flex-col items-center">
                            <span class="text-[9px] font-bold text-rose-400 uppercase tracking-widest leading-none">Alpa</span>
                            <span class="text-xl font-black text-rose-600 mt-1">03</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- INFO BANNER -->
            <section class="animate-in" style="animation-delay: 0.5s">
                <div class="bg-gradient-to-br from-gold/20 to-maroon-50 border border-gold/30 rounded-[2.5rem] p-6 flex items-start gap-5 backdrop-blur-sm">
                    <div class="w-12 h-12 bg-gold rounded-2xl shrink-0 flex items-center justify-center text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-gold-dark uppercase tracking-wider">Tips Keamanan</h4>
                        <p class="text-[11px] text-gold-dark/70 mt-1.5 leading-relaxed font-medium">
                            Pastikan kamu berada di area Jurusan saat melakukan presensi untuk menghindari kegagalan sistem lokasi.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
