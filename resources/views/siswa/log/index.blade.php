@extends('layouts.siswa')

@section('content')
<!-- CSS KHUSUS HALAMAN LOGBOOK -->
<style>
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: slideUp 0.5s ease-out forwards;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #bc5a75;
        border-radius: 10px;
    }
</style>

<!-- KONTEN UTAMA LOGBOOK -->
<main class="max-w-7xl mx-auto p-5 lg:p-10">

    <!-- Judul Halaman (Untuk Mobile) -->
    <div class="flex items-center gap-4 mb-4 lg:hidden">
        <h1 class="text-xl font-extrabold text-maroon-950 tracking-tight">E-Logbook Siswa</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

        <!-- BAGIAN FORM INPUT (COL 5) -->
        <div class="lg:col-span-5 space-y-8 animate-in" style="animation-delay: 0.1s">
            <div class="bg-white rounded-[2.5rem] p-8 border border-maroon-100 shadow-premium">
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-maroon-950 tracking-tight">Form Kegiatan</h2>
                    <p class="text-sm text-slate-400 font-medium mt-1">Input rincian tugas yang Anda kerjakan hari ini.</p>
                </div>

                <form class="space-y-6">
                    <!-- TANGGAL -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Tanggal</label>
                        <div class="relative">
                            <input type="text" value="15 April 2024" readonly class="w-full bg-maroon-50 border-none rounded-2xl px-5 py-4 text-sm font-bold text-maroon-900 focus:ring-0 cursor-default">
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 text-maroon-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- DESKRIPSI KEGIATAN -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Uraian Pekerjaan</label>
                        <textarea placeholder="Contoh: Maintenance jaringan di Gedung Elektro lantai 2..." rows="8" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:ring-2 focus:ring-maroon-500 focus:bg-white transition-all outline-none resize-none"></textarea>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <button type="button" class="w-full bg-maroon-950 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl shadow-maroon-950/20 active:scale-95 transition-all flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
                        Simpan Log
                    </button>
                </form>
            </div>

            <!-- INFO CARD -->
            <div class="bg-gold-light border border-gold/30 rounded-[2.5rem] p-6 flex items-start gap-5">
                <div class="w-12 h-12 bg-gold rounded-2xl shrink-0 flex items-center justify-center text-white shadow-lg shadow-gold/20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-extrabold text-gold-dark">Petunjuk Log</h4>
                    <p class="text-[11px] text-gold-dark/70 mt-1 leading-relaxed font-medium">
                        Log harian wajib diisi setiap hari kerja sebagai syarat penilaian magang oleh koordinator.
                    </p>
                </div>
            </div>
        </div>

        <!-- BAGIAN RIWAYAT (COL 7) -->
        <div class="lg:col-span-7 space-y-6 animate-in" style="animation-delay: 0.2s">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-maroon-950 tracking-tight">Riwayat Log</h2>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Daftar Kegiatan Terbaru</p>
                </div>

                <!-- FILTER BULAN -->
                <div class="relative">
                    <select class="appearance-none bg-white border border-maroon-100 rounded-xl px-4 py-2 pr-10 text-xs font-bold text-maroon-950 shadow-sm focus:outline-none focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                        <option value="4">April 2024</option>
                        <option value="3">Maret 2024</option>
                        <option value="2">Februari 2024</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-maroon-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>
            </div>

            <!-- LOG LIST -->
            <div class="space-y-4 max-h-[700px] overflow-y-auto no-scrollbar pr-1 custom-scrollbar">

                <!-- Log Card 1 -->
                <div class="group bg-white p-6 rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-maroon-900 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-maroon-900/10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-extrabold text-slate-800 tracking-tight">Senin, 15 April 2024</h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[9px] font-black text-maroon-400 uppercase tracking-widest">Tersimpan</span>
                                    <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                    <span class="text-[9px] font-bold text-slate-400">17:05 WITA</span>
                                </div>
                            </div>
                        </div>

                        <!-- CRUD ACTIONS -->
                        <div class="flex items-center gap-1">
                            <button title="Edit Log" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            </button>
                            <button title="Hapus Log" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                        <p class="text-xs font-semibold text-slate-600 leading-relaxed italic">
                            "Melakukan perbaikan pada kabel jaringan di Laboratorium Komputer 1, melakukan crimping ulang pada 5 titik kabel RJ45, dan memastikan seluruh komputer terhubung ke gateway lokal Poliban."
                        </p>
                    </div>
                </div>

                <!-- Log Card 2 -->
                <div class="group bg-white p-6 rounded-[2.5rem] border border-maroon-50 shadow-sm opacity-80">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-extrabold text-slate-800 tracking-tight">Jumat, 12 April 2024</h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tersimpan</span>
                                    <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                    <span class="text-[9px] font-bold text-slate-400">16:30 WITA</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-300 hover:text-amber-600 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="bg-slate-50/50 rounded-2xl p-5 border border-slate-100">
                        <p class="text-xs font-semibold text-slate-500 leading-relaxed italic">
                            "Mempelajari skema panel listrik 3 fasa di gedung administrasi pusat dan membantu teknisi dalam pengecekan grounding pada panel distribusi utama."
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection
