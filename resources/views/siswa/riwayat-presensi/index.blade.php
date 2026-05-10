@extends('layouts.siswa')

@section('content')
<!-- CSS KHUSUS HALAMAN RIWAYAT -->
<style>
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up {
        animation: slideUp 0.5s ease-out forwards;
    }
    /* Custom Scrollbar for Table */
    .custom-scroll::-webkit-scrollbar { height: 4px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #bc5a75; border-radius: 10px; }
</style>

<!-- KONTEN UTAMA RIWAYAT PRESENSI -->
<main class="max-w-7xl mx-auto p-5 lg:p-10 space-y-8 animate-slide-up">

    <!-- Judul Halaman (Untuk Mobile, karena Topbar Desktop bisa beda tampilan) -->
    <div class="flex items-center gap-4 mb-4 lg:hidden">
        <h1 class="text-xl font-extrabold text-maroon-950 tracking-tight">Riwayat Presensi</h1>
    </div>

    <!-- FILTER SECTION -->
    <section class="bg-white rounded-[2.5rem] p-6 lg:p-8 border border-maroon-100 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-xl font-black text-maroon-950 tracking-tight">Filter Periode</h2>
                <p class="text-sm text-slate-500 font-medium">Pilih bulan dan tahun untuk melihat data.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Dropdown Bulan -->
                <div class="relative min-w-[140px]">
                    <select class="w-full appearance-none bg-maroon-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-maroon-900 focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4" selected>April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-maroon-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

                <!-- Dropdown Tahun -->
                <div class="relative min-w-[110px]">
                    <select class="w-full appearance-none bg-maroon-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-maroon-900 focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                        <option value="2023">2023</option>
                        <option value="2024" selected>2024</option>
                        <option value="2025">2025</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-maroon-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

                <button class="bg-maroon-900 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg hover:bg-maroon-800 active:scale-95 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.3-4.3"/><circle cx="10" cy="10" r="7"/></svg>
                    <span>Cari</span>
                </button>
            </div>
        </div>
    </section>

    <!-- SUMMARY CARDS -->
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem] flex flex-col items-center">
            <span class="text-3xl font-black text-emerald-600 leading-none">22</span>
            <span class="text-[10px] text-emerald-700/60 font-bold mt-2 uppercase tracking-widest">Total Hadir</span>
        </div>
        <div class="bg-amber-50 border border-amber-100 p-6 rounded-[2rem] flex flex-col items-center">
            <span class="text-3xl font-black text-amber-600 leading-none">03</span>
            <span class="text-[10px] text-amber-700/60 font-bold mt-2 uppercase tracking-widest">Terlambat</span>
        </div>
        <div class="bg-rose-50 border border-rose-100 p-6 rounded-[2rem] flex flex-col items-center">
            <span class="text-3xl font-black text-rose-600 leading-none">01</span>
            <span class="text-[10px] text-rose-700/60 font-bold mt-2 uppercase tracking-widest">Izin/Sakit</span>
        </div>
        <div class="bg-maroon-50 border border-maroon-100 p-6 rounded-[2rem] flex flex-col items-center">
            <span class="text-3xl font-black text-maroon-900 leading-none">00</span>
            <span class="text-[10px] text-maroon-700/60 font-bold mt-2 uppercase tracking-widest">Alpa</span>
        </div>
    </section>

    <!-- TABLE SECTION -->
    <section class="bg-white rounded-[2.5rem] border border-maroon-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-maroon-900 text-white">
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Hari & Tanggal</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Jam Masuk</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Jam Pulang</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50">
                    <!-- Data 1 -->
                    <tr class="hover:bg-maroon-50/40 transition-colors">
                        <td class="px-8 py-5">
                            <p class="text-sm font-extrabold text-slate-800">Senin, 15 April 2024</p>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                <span class="text-sm font-bold text-slate-600">07:42:10</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-rose-500 rounded-full"></span>
                                <span class="text-sm font-bold text-slate-600">16:05:44</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-xl text-[10px] font-black uppercase tracking-wider">Tepat Waktu</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button class="text-maroon-400 hover:text-maroon-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </td>
                    </tr>
                    <!-- Data 2 -->
                    <tr class="hover:bg-maroon-50/40 transition-colors">
                        <td class="px-8 py-5">
                            <p class="text-sm font-extrabold text-slate-800">Jumat, 12 April 2024</p>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                <span class="text-sm font-bold text-slate-600">08:15:32</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-rose-500 rounded-full"></span>
                                <span class="text-sm font-bold text-slate-600">16:10:12</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1.5 bg-amber-100 text-amber-700 rounded-xl text-[10px] font-black uppercase tracking-wider">Terlambat</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button class="text-maroon-400 hover:text-maroon-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </td>
                    </tr>
                    <!-- Data 3 (Izin) -->
                    <tr class="hover:bg-maroon-50/40 transition-colors">
                        <td class="px-8 py-5">
                            <p class="text-sm font-extrabold text-slate-800">Kamis, 11 April 2024</p>
                        </td>
                        <td colspan="2" class="px-8 py-5 text-center text-slate-400 text-xs font-bold tracking-widest uppercase">
                            -- Izin Sakit (Terlampir) --
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1.5 bg-rose-100 text-rose-700 rounded-xl text-[10px] font-black uppercase tracking-wider">Izin</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button class="text-maroon-400 hover:text-maroon-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="bg-maroon-50/30 px-8 py-6 flex items-center justify-between">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Halaman 1 dari 4</p>
            <div class="flex gap-2">
                <button class="w-10 h-10 rounded-xl bg-white border border-maroon-100 flex items-center justify-center text-maroon-900 shadow-sm active:scale-90 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button class="w-10 h-10 rounded-xl bg-white border border-maroon-100 flex items-center justify-center text-maroon-900 shadow-sm active:scale-90 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </section>
</main>
@endsection
