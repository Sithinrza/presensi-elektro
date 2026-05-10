@extends('layouts.tendik')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT COLUMN: Greeting, Clock, & Main Action -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-8">

            <!-- GREETING & CLOCK -->
            <section class="animate-in flex flex-col md:flex-row md:items-end justify-between gap-4" style="animation-delay: 0.1s">
                <div>
                    <p class="text-slate-500 font-medium text-base">Selamat pagi 👋</p>
                    <h2 id="liveDate" class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-wider italic">--</h2>
                </div>
                <div class="md:text-right bg-white/40 p-4 rounded-3xl border border-white/50 backdrop-blur-sm lg:bg-transparent lg:p-0 lg:border-0 lg:backdrop-blur-none">
                    <div id="liveClock" class="text-4xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-none mb-1">00:00:00</div>
                    <span class="text-[10px] md:text-xs font-bold text-maroon-500 uppercase tracking-widest">Waktu Indonesia Tengah</span>
                </div>
            </section>

            <!-- MAIN ACTION CARD -->
            <section class="animate-in" style="animation-delay: 0.2s">
                <div class="relative bg-maroon-900 rounded-[3rem] p-8 md:p-12 text-white shadow-premium overflow-hidden border border-maroon-800">
                    <!-- Abstract Shapes -->
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-gold/20 rounded-full blur-[80px]"></div>
                    <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-white/10 rounded-full blur-[60px]"></div>

                    <div class="relative z-10 space-y-10">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="space-y-2">
                                <p class="text-maroon-200/60 text-xs font-bold uppercase tracking-[0.3em]">Sesi Kehadiran Aktif</p>
                                <h3 class="text-3xl md:text-4xl font-black italic tracking-tight leading-tight">Sudahkah anda <br><span class="text-gold">Melakukan Absen</span> hari ini?</h3>
                            </div>
                            <div class="bg-emerald-500/20 text-emerald-300 px-4 py-2 rounded-2xl text-xs font-extrabold border border-emerald-500/30 backdrop-blur-md flex items-center gap-3">
                                <span class="w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_12px_rgba(52,211,153,0.8)]"></span>
                                DI AREA KAMPUS
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Check In -->
                            <button class="group bg-white rounded-[2rem] p-6 flex items-center gap-5 shadow-xl hover:shadow-2xl active:scale-95 transition-all duration-300">
                                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500 shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-maroon-950 font-black text-xl uppercase tracking-wide leading-none">Masuk</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Presensi Pagi</span>
                                </div>
                            </button>

                            <!-- Check Out -->
                            <button class="group bg-maroon-800/50 border border-white/10 rounded-[2rem] p-6 flex items-center gap-5 active:scale-95 transition-all duration-300 hover:bg-rose-900/40">
                                <div class="w-16 h-16 bg-white/10 text-maroon-100 rounded-2xl flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-white font-black text-xl uppercase tracking-wide leading-none">Pulang</span>
                                    <span class="text-[10px] text-maroon-200/50 font-bold uppercase tracking-widest mt-1">Presensi Sore</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN: Stats, History, Info -->
        <div class="lg:col-span-5 xl:col-span-4 space-y-8">

            <!-- QUICK STATS -->
            <section class="animate-in" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-extrabold text-maroon-950 tracking-tight text-lg">Ringkasan Bulan Ini</h3>
                    <button class="text-xs font-bold text-maroon-600 bg-maroon-50 px-4 py-2 rounded-xl border border-maroon-100/50">Laporan</button>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-[2.5rem] border border-maroon-100 shadow-sm flex flex-col items-center hover:scale-105 transition-transform duration-300">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <span class="text-3xl font-black text-maroon-950 leading-none tracking-tighter">22</span>
                        <span class="text-[9px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Hadir</span>
                    </div>
                    <div class="bg-white p-5 rounded-[2.5rem] border border-maroon-100 shadow-sm flex flex-col items-center hover:scale-105 transition-transform duration-300">
                        <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <span class="text-3xl font-black text-maroon-950 leading-none tracking-tighter">03</span>
                        <span class="text-[9px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Telat</span>
                    </div>
                    <div class="bg-white p-5 rounded-[2.5rem] border border-maroon-100 shadow-sm flex flex-col items-center hover:scale-105 transition-transform duration-300">
                        <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </div>
                        <span class="text-3xl font-black text-maroon-950 leading-none tracking-tighter">00</span>
                        <span class="text-[9px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Izin</span>
                    </div>
                </div>
            </section>

            <!-- RECENT HISTORY -->
            <section class="animate-in space-y-5" style="animation-delay: 0.4s">
                <h3 class="font-extrabold text-maroon-950 tracking-tight text-lg">Riwayat Terakhir</h3>

                <div class="space-y-4">
                    <div class="group bg-white p-5 rounded-[2rem] border border-maroon-50 flex items-center justify-between hover:border-maroon-200 transition-all duration-300 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-extrabold text-slate-800 leading-none">Absen Masuk</p>
                                <p class="text-[11px] text-slate-400 font-medium mt-2">Jumat, 12 April • 07:42 WIB</p>
                            </div>
                        </div>
                        <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg uppercase">Tepat Waktu</span>
                    </div>

                    <div class="group bg-white p-5 rounded-[2rem] border border-maroon-50 flex items-center justify-between hover:border-maroon-200 transition-all duration-300 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-extrabold text-slate-800 leading-none">Absen Masuk</p>
                                <p class="text-[11px] text-slate-400 font-medium mt-2">Kamis, 11 April • 08:15 WIB</p>
                            </div>
                        </div>
                        <span class="text-[9px] font-black text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg uppercase">Terlambat</span>
                    </div>
                </div>
            </section>

            <!-- INFO BANNER -->
            <section class="animate-in" style="animation-delay: 0.5s">
                <div class="bg-gold-light/50 border border-gold/20 rounded-[2.5rem] p-6 flex items-start gap-5 backdrop-blur-sm">
                    <div class="w-12 h-12 bg-gold rounded-2xl shrink-0 flex items-center justify-center text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-gold-dark">Liveness Detection</h4>
                        <p class="text-[11px] text-gold-dark/70 mt-1 leading-relaxed font-medium">
                            Sistem memerlukan verifikasi wajah secara langsung untuk memastikan keaslian presensi Anda.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
