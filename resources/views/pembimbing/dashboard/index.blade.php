@extends('layouts.pembimbing')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT COLUMN: Welcome & Stats -->
        <div class="lg:col-span-12 space-y-8">

            <!-- GREETING & CLOCK -->
            <section class="animate-in flex flex-col md:flex-row md:items-end justify-between gap-4" style="animation-delay: 0.1s">
                <div>
                    <p class="text-slate-500 font-medium text-base italic leading-none mb-2 text-maroon-900/40">Selamat datang kembali di panel monitoring,</p>
                    <h2 class="text-3xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-tight italic">Pantau Progres <br><span class="text-gold tracking-normal not-italic">& Logbook Siswa</span></h2>
                </div>
                <div class="md:text-right text-left">
                    <div id="liveClock" class="text-4xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-none mb-1">00:00:00</div>
                    <span id="liveDate" class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-[0.2em] italic">--</span>
                </div>
            </section>

            <!-- STATS CARDS -->
            <section class="animate-in grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6" style="animation-delay: 0.2s">
                <div class="bg-maroon-900 p-8 rounded-[2.5rem] text-white shadow-premium relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <p class="text-4xl font-black tracking-tighter leading-none mb-1">06</p>
                    <p class="text-[10px] font-bold text-maroon-200 uppercase tracking-widest leading-none italic">Anak Bimbingan</p>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <p class="text-4xl font-black text-maroon-950 tracking-tighter leading-none mb-1">12</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none italic">Log Menunggu Review</p>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <p class="text-4xl font-black text-maroon-950 tracking-tighter leading-none mb-1">05</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none italic">Hadir Hari Ini</p>
                </div>

                <div class="bg-gold-light p-8 rounded-[2.5rem] border border-gold/20 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-20 group-hover:scale-110 transition-transform text-gold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                    </div>
                    <p class="text-4xl font-black text-maroon-950 tracking-tighter leading-none mb-1">02</p>
                    <p class="text-[10px] font-bold text-gold-dark uppercase tracking-widest leading-none italic">Siap Penilaian</p>
                </div>
            </section>

            <!-- MONITORING SECTION -->
            <section class="animate-in space-y-6" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-6 bg-maroon-900 rounded-full"></div>
                        <h3 class="text-xl font-black text-maroon-950 tracking-tight italic">Daftar Anak Bimbingan</h3>
                    </div>
                    <button class="text-[10px] font-black text-maroon-700 uppercase underline tracking-widest">Semua Data</button>
                </div>

                <!-- CARDS GRID FOR SUPERVISEES -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                    <!-- Siswa 1 -->
                    <div class="bg-white rounded-[2.5rem] p-6 border border-maroon-50 shadow-sm hover:shadow-xl transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-3xl bg-slate-100 overflow-hidden shadow-inner border-2 border-white group-hover:border-maroon-200 transition-all">
                                <img src="https://i.pravatar.cc/100?img=11" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h4 class="text-lg font-black text-maroon-950 leading-none truncate tracking-tight">Ahmad Fauzi</h4>
                                <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">SMKN 5 Banjarmasin</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6 pt-6 border-t border-slate-50">
                            <div>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Hadir (Bulan Ini)</p>
                                <p class="text-xl font-black text-maroon-950 mt-1">17 / 20 <span class="text-[10px] text-maroon-400 opacity-50">Hari</span></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Logbook Pending</p>
                                <p class="text-xl font-black text-amber-500 mt-1">03 <span class="text-[10px] opacity-50">Log</span></p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button class="flex-1 bg-maroon-50 text-maroon-950 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-maroon-900 hover:text-white transition-all">Detail Riwayat</button>
                            <button class="bg-gold text-maroon-950 p-3 rounded-2xl hover:bg-gold-dark transition-all shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Siswa 2 (Hadir Hari Ini Status) -->
                    <div class="bg-white rounded-[2.5rem] p-6 border border-maroon-50 shadow-sm hover:shadow-xl transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-3xl bg-slate-100 overflow-hidden shadow-inner border-2 border-white group-hover:border-maroon-200 transition-all">
                                <img src="https://i.pravatar.cc/100?img=1" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <div class="flex items-center gap-2">
                                    <h4 class="text-lg font-black text-maroon-950 leading-none truncate tracking-tight">Budi Santoso</h4>
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                </div>
                                <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest truncate">SMK Negeri 2 Banjarmasin</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6 pt-6 border-t border-slate-50">
                            <div>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Hadir (Bulan Ini)</p>
                                <p class="text-xl font-black text-maroon-950 mt-1">19 / 20 <span class="text-[10px] text-maroon-400 opacity-50">Hari</span></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Logbook Pending</p>
                                <p class="text-xl font-black text-emerald-600 mt-1">00 <span class="text-[10px] opacity-50">Log</span></p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button class="flex-1 bg-maroon-50 text-maroon-950 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-maroon-900 hover:text-white transition-all">Detail Riwayat</button>
                            <button class="bg-gold text-maroon-950 p-3 rounded-2xl hover:bg-gold-dark transition-all shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Siswa 3 (Selesai Magang / Penilaian) -->
                    <div class="bg-gold/5 rounded-[2.5rem] p-6 border-2 border-dashed border-gold/30 shadow-sm hover:shadow-xl transition-all group relative">
                        <!-- Badge Penilaian -->
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 bg-maroon-900 text-gold text-[8px] font-black uppercase tracking-[0.3em] rounded-full shadow-lg">Siap Dinilai</div>

                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-3xl bg-slate-100 overflow-hidden shadow-inner border-2 border-gold group-hover:scale-105 transition-all">
                                <img src="https://i.pravatar.cc/100?img=3" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h4 class="text-lg font-black text-maroon-950 leading-none truncate tracking-tight">Rian Hidayat</h4>
                                <p class="text-[10px] font-bold text-gold-dark mt-1 uppercase tracking-widest truncate">Politeknik Negeri BJM</p>
                            </div>
                        </div>

                        <div class="mb-6 pt-6 border-t border-gold/10">
                            <p class="text-[9px] font-black text-maroon-300 uppercase tracking-[0.2em] leading-none mb-2">Masa Magang Berakhir</p>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-gold-dark"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                                <p class="text-sm font-bold text-maroon-950">Silakan input nilai akhir</p>
                            </div>
                        </div>

                        <button class="w-full bg-maroon-950 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl active:scale-95 transition-all flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                            Input Nilai & Sertifikat
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
