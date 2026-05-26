@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <section class="animate-in" style="animation-delay: 0.1s">
        <div class="relative bg-maroon-900 rounded-3xl p-8 lg:p-10 text-white shadow-lg shadow-maroon-900/20 overflow-hidden border border-maroon-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-amber-400/10 rounded-full blur-[80px] pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-white/5 rounded-full blur-[60px] pointer-events-none"></div>

            <div class="relative z-10 space-y-3">
                <div class="inline-flex px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-[10px] font-black uppercase tracking-[0.2em] backdrop-blur-sm">
                    Dashboard Admin
                </div>
                <h2 class="text-3xl lg:text-4xl font-black tracking-tight leading-tight">
                    Selamat Datang, <br class="hidden md:block">
                    <span class="text-amber-400">{{ auth()->check() ? explode(' ', auth()->user()->name)[0] : 'Admin' }}!</span>
                </h2>
            </div>

            <div class="relative z-10 md:text-left lg:text-right bg-black/20 p-5 rounded-2xl border border-white/10 backdrop-blur-md w-full md:w-fit flex items-center md:block gap-4">
                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-amber-400"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-maroon-200 uppercase tracking-widest mb-1 flex items-center md:justify-end gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="hidden md:block"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        Banjarmasin
                    </p>
                    <p class="text-lg font-bold text-white tracking-tight">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="space-y-6">
        <div class="flex items-center gap-3 px-2">
            <div class="w-1.5 h-6 bg-amber-400 rounded-full"></div>
            <h3 class="text-lg font-black text-slate-800 tracking-tight uppercase">Status Presensi Hari Ini</h3>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">(Siswa & Tendik)</span>
        </div>

        <section class="animate-in grid grid-cols-1 md:grid-cols-3 gap-6" style="animation-delay: 0.2s">
            <div class="bg-white p-6 lg:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 group relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="flex items-center justify-between mb-6 relative z-10">
                    <span class="text-[10px] font-black text-emerald-700 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg uppercase tracking-widest">Hadir</span>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <p class="text-5xl font-black text-slate-800 tracking-tighter leading-none relative z-10">{{ str_pad($hadirHariIni, 2, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase mt-4 tracking-widest leading-none relative z-10">Total pengguna hadir</p>
            </div>

            <div class="bg-white p-6 lg:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 group relative overflow-hidden text-left">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="flex items-center justify-between mb-6 relative z-10">
                    <span class="text-[10px] font-black text-amber-700 bg-amber-50 border border-amber-100 px-3 py-1.5 rounded-lg uppercase tracking-widest">Terlambat</span>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                </div>
                <p class="text-5xl font-black text-slate-800 tracking-tighter leading-none relative z-10">{{ str_pad($terlambatHariIni, 2, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase mt-4 tracking-widest leading-none relative z-10">Masuk lewat jam kerja</p>
            </div>

            <div class="bg-white p-6 lg:p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 group relative overflow-hidden text-left">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-500 text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </div>
                <div class="flex items-center justify-between mb-6 relative z-10">
                    <span class="text-[10px] font-black text-rose-700 bg-rose-50 border border-rose-100 px-3 py-1.5 rounded-lg uppercase tracking-widest">Alfa</span>
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </div>
                </div>
                <p class="text-5xl font-black text-slate-800 tracking-tighter leading-none relative z-10">{{ str_pad($alpaHariIni, 2, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase mt-4 tracking-widest leading-none relative z-10">Belum ada aktivitas</p>
            </div>
        </section>
    </div>

    <div class="space-y-6">
        <div class="flex items-center gap-3 px-2">
            <div class="w-1.5 h-6 bg-maroon-900 rounded-full"></div>
            <h3 class="text-lg font-black text-slate-800 tracking-tight uppercase">Total Pengguna Terdaftar</h3>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">(Data Master)</span>
        </div>

        <section class="animate-in grid grid-cols-1 md:grid-cols-3 gap-6" style="animation-delay: 0.3s">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:border-maroon-200 transition-colors flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Siswa Magang</p>
                    <p class="text-3xl font-black text-slate-800 tracking-tight leading-none group-hover:text-maroon-900 transition-colors">{{ str_pad($totalSiswa, 2, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="w-14 h-14 bg-slate-50 group-hover:bg-maroon-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-maroon-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:border-maroon-200 transition-colors flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tenaga Kependidikan</p>
                    <p class="text-3xl font-black text-slate-800 tracking-tight leading-none group-hover:text-maroon-900 transition-colors">{{ str_pad($totalTendik, 2, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="w-14 h-14 bg-slate-50 group-hover:bg-maroon-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-maroon-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><rect x="19" y="8" width="2" height="10"/><path d="M19 8c0-1.1.9-2 2-2"/></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:border-maroon-200 transition-colors flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Pembimbing</p>
                    <p class="text-3xl font-black text-slate-800 tracking-tight leading-none group-hover:text-maroon-900 transition-colors">{{ str_pad($totalPembimbing, 2, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="w-14 h-14 bg-slate-50 group-hover:bg-maroon-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-maroon-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                </div>
            </div>
        </section>
    </div>

    <section class="animate-in bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden" style="animation-delay: 0.4s">
        <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-maroon-50 text-maroon-700 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-800 tracking-tight">Monitoring Presensi Real-time</h3>
                    <p class="text-xs font-bold text-slate-400 mt-1">Rekam jejak ketepatan waktu terbaru hari ini</p>
                </div>
            </div>
            <a href="{{ route('admin.riwayat.index') }}" class="text-[10px] font-black text-maroon-700 bg-maroon-50 hover:bg-maroon-100 px-4 py-2 rounded-lg uppercase tracking-widest transition-colors flex items-center gap-2 w-fit">
                Semua Aktivitas
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas User</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Masuk</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Pulang</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status Masuk</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Verifikasi Fisik</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($aktivitasHariIni as $aktivitas)
                    <tr class="hover:bg-slate-50/80 transition-all duration-200 group">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0 flex items-center justify-center font-black text-maroon-900">
                                    {{ substr($aktivitas->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-700 transition-colors">
                                        {{ $aktivitas->user->name ?? 'User Tidak Diketahui' }}
                                    </p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-1.5 uppercase tracking-tighter">
                                        {{ $aktivitas->user->role ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold font-mono border border-slate-200">
                                {{ $aktivitas->jam_masuk ?? '--:--' }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold font-mono border border-slate-200">
                                {{ $aktivitas->jam_pulang ?? '--:--' }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            @if($aktivitas->statusCi)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 border rounded-lg text-[10px] font-black uppercase tracking-widest
                                {{ $aktivitas->id_status_ci == 1 ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' :
                                  ($aktivitas->id_status_ci == 2 ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-rose-50 text-rose-600 border border-rose-200') }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $aktivitas->id_status_ci == 1 ? 'bg-emerald-500' : ($aktivitas->id_status_ci == 2 ? 'bg-amber-500' : 'bg-rose-500') }}"></span>
                                {{ $aktivitas->statusCi->name }}
                            </span>
                            @else
                            <span class="text-slate-400 text-xs font-bold">-</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <span class="w-2.5 h-2.5 {{ !empty($aktivitas->latitude_masuk) ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-slate-300' }} rounded-full" title="GPS Masuk"></span>
                                <span class="w-2.5 h-2.5 {{ !empty($aktivitas->foto_masuk) ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-slate-300' }} rounded-full" title="Foto Liveness Masuk"></span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                            Belum ada aktivitas presensi hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection