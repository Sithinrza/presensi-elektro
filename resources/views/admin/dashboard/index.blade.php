@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-10">

    <!-- WELCOME SECTION -->
    <section class="animate-in" style="animation-delay: 0.1s">
        <div class="relative bg-maroon-900 rounded-[3rem] p-10 text-white shadow-premium overflow-hidden border border-maroon-800">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-gold/20 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-white/10 rounded-full blur-[80px]"></div>

            <div class="relative z-10 flex flex-col xl:flex-row justify-between items-center gap-10">
                <div class="space-y-4">
                    <div class="inline-flex px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-[10px] font-black uppercase tracking-[0.25em]">Sistem Monitoring Aktif</div>
                    <h2 class="text-4xl xl:text-5xl font-black italic tracking-tight leading-tight">Ringkasan Statistik <br><span class="text-gold tracking-normal not-italic">Presensi & Pengguna</span></h2>
                    <p class="text-maroon-100/60 text-sm max-w-lg leading-relaxed font-medium italic">Data diperbarui secara real-time berdasarkan aktivitas di area kampus.</p>
                </div>

                <div class="flex gap-4">
                    <button class="bg-white text-maroon-950 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all">Input Data</button>
                    <button class="bg-maroon-800 border border-white/10 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest active:scale-95 transition-all">Export Report</button>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS PART 1: KEHADIRAN HARI INI -->
    <div class="space-y-6">
        <div class="flex items-center gap-3 px-2">
            <div class="w-1 h-6 bg-gold rounded-full"></div>
            <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Status Presensi Hari Ini</h3>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-2">(Siswa & Tendik)</span>
        </div>

        <section class="animate-in grid grid-cols-3 gap-6" style="animation-delay: 0.2s">
            <!-- Hadir -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-widest">Hadir</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-100/50 flex items-center justify-center text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <p class="text-5xl font-black text-maroon-950 tracking-tighter leading-none">41</p>
                <p class="text-[9px] font-bold text-slate-400 uppercase mt-3 tracking-[0.2em] leading-none italic">Total pengguna hadir hari ini</p>
            </div>

            <!-- Terlambat -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden text-left">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-amber-600 bg-amber-50 px-3 py-1 rounded-full uppercase tracking-widest">Terlambat</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-100/50 flex items-center justify-center text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                </div>
                <p class="text-5xl font-black text-maroon-950 tracking-tighter leading-none">03</p>
                <p class="text-[9px] font-bold text-slate-400 uppercase mt-3 tracking-[0.2em] leading-none italic">Terdeteksi masuk lewat jam kerja</p>
            </div>

            <!-- Alpa -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden text-left">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-rose-600 bg-rose-50 px-3 py-1 rounded-full uppercase tracking-widest">Alpa</span>
                    <div class="w-10 h-10 rounded-xl bg-rose-100/50 flex items-center justify-center text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </div>
                </div>
                <p class="text-5xl font-black text-maroon-950 tracking-tighter leading-none">01</p>
                <p class="text-[9px] font-bold text-slate-400 uppercase mt-3 tracking-[0.2em] leading-none italic">Belum ada aktivitas presensi</p>
            </div>
        </section>
    </div>

    <!-- STATS PART 2: TOTAL DATA MASTER -->
    <div class="space-y-6">
        <div class="flex items-center gap-3 px-2">
            <div class="w-1 h-6 bg-maroon-950 rounded-full"></div>
            <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Total Pengguna Terdaftar</h3>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-2">(Data Master)</span>
        </div>

        <section class="animate-in grid grid-cols-3 gap-6" style="animation-delay: 0.3s">
            <!-- Total Siswa -->
            <div class="bg-maroon-50/40 p-8 rounded-[2.5rem] border border-maroon-100 shadow-sm hover:border-maroon-200 transition-all flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest mb-1">Total Siswa Magang</p>
                    <p class="text-4xl font-black text-maroon-950 tracking-tighter leading-none">32</p>
                    <p class="text-[9px] font-bold text-maroon-700/60 mt-3 flex items-center gap-1 uppercase">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                        +2 Bulan ini
                    </p>
                </div>
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-maroon-900 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>

            <!-- Total Tendik -->
            <div class="bg-maroon-50/40 p-8 rounded-[2.5rem] border border-maroon-100 shadow-sm hover:border-maroon-200 transition-all flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest mb-1 text-nowrap">Total Tenaga Kependidikan</p>
                    <p class="text-4xl font-black text-maroon-950 tracking-tighter leading-none">13</p>
                    <p class="text-[9px] font-bold text-maroon-700/60 mt-3 uppercase">Aktif Jurusan</p>
                </div>
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-maroon-900 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><rect x="19" y="8" width="2" height="10"/><path d="M19 8c0-1.1.9-2 2-2"/></svg>
                </div>
            </div>

            <!-- Total Pembimbing -->
            <div class="bg-maroon-50/40 p-8 rounded-[2.5rem] border border-maroon-100 shadow-sm hover:border-maroon-200 transition-all flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest mb-1">Total Pembimbing</p>
                    <p class="text-4xl font-black text-maroon-950 tracking-tighter leading-none">08</p>
                    <p class="text-[9px] font-bold text-maroon-700/60 mt-3 uppercase italic leading-none">Staf Elektro</p>
                </div>
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-maroon-900 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                </div>
            </div>
        </section>
    </div>

    <!-- RECENT ACTIVITY TABLE -->
    <section class="animate-in bg-white rounded-[3rem] border border-maroon-50 shadow-sm overflow-hidden" style="animation-delay: 0.4s">
        <div class="px-10 py-8 border-b border-maroon-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-maroon-50 text-maroon-950 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3 class="text-lg font-black text-maroon-950 tracking-tight italic">Monitoring Presensi Real-time</h3>
            </div>
            <button class="text-[10px] font-black text-maroon-700 uppercase underline tracking-widest">Semua Aktivitas</button>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-maroon-50/20">
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Identitas User</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Waktu Tap</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Kategori</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50/50">
                    <tr class="hover:bg-maroon-50/30 transition-all duration-200">
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shadow-sm flex items-center justify-center">
                                    <img src="https://i.pravatar.cc/100?img=1" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight">Budi Santoso</p>
                                    <p class="text-[9px] font-bold text-maroon-500 mt-1.5 uppercase tracking-tighter">Siswa Magang</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-5 text-center font-bold text-sm text-slate-600 italic">07:42:01</td>
                        <td class="px-10 py-5 text-center">
                            <span class="px-3 py-1 bg-maroon-50 text-maroon-800 rounded-lg text-[9px] font-black uppercase whitespace-nowrap">Siswa</span>
                        </td>
                        <td class="px-10 py-5 text-center">
                            <span class="inline-flex px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Hadir</span>
                        </td>
                        <td class="px-10 py-5 text-right">
                            <div class="flex justify-end gap-1.5">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full" title="Valid"></span>
                                <span class="w-2 h-2 bg-emerald-500 rounded-full" title="Valid"></span>
                                <span class="w-2 h-2 bg-emerald-500 rounded-full" title="Valid"></span>
                            </div>
                        </td>
                    </tr>
                    <!-- Row Tendik -->
                    <tr class="hover:bg-maroon-50/30 transition-all duration-200">
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shadow-sm flex items-center justify-center">
                                    <img src="https://i.pravatar.cc/100?img=5" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight">Sri Wahyuni, M.T.</p>
                                    <p class="text-[9px] font-bold text-gold-dark mt-1.5 uppercase tracking-tighter">Tenaga Kependidikan</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-5 text-center font-bold text-sm text-slate-600 italic">07:55:12</td>
                        <td class="px-10 py-5 text-center">
                            <span class="px-3 py-1 bg-gold-light text-gold-dark rounded-lg text-[9px] font-black uppercase whitespace-nowrap">Tendik</span>
                        </td>
                        <td class="px-10 py-5 text-center">
                            <span class="inline-flex px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Hadir</span>
                        </td>
                        <td class="px-10 py-5 text-right">
                            <div class="flex justify-end gap-1.5">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
