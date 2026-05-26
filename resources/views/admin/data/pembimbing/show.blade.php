@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.pembimbing.index') }}" class="w-11 h-11 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 hover:border-maroon-200 transition-all shadow-sm group shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Detail Profil Pembimbing</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Informasi Lengkap Dosen / Pembimbing Lapangan</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.data.pembimbing.edit', $pembimbing->id_pembimbing) }}" class="bg-amber-50 text-amber-700 border border-amber-200 px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm hover:bg-amber-100 hover:scale-105 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                Edit Profil
            </a>
        </div>
    </div>

    <div class="bg-maroon-900 rounded-[2.5rem] p-8 lg:p-10 text-white shadow-xl shadow-maroon-900/20 border border-maroon-800 relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-400/10 rounded-full blur-[80px] pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-white/5 rounded-full blur-[60px] pointer-events-none"></div>

        <div class="relative z-10 w-24 h-24 lg:w-28 lg:h-28 rounded-2xl bg-white/10 border-2 border-white/20 p-1 shrink-0 shadow-lg backdrop-blur-md">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($pembimbing->nama_lengkap) }}&background=fff&color=7f1d1d&size=256&bold=true" class="w-full h-full object-cover rounded-xl">
        </div>

        <div class="relative z-10 text-center md:text-left flex-1 w-full">
            <p class="text-[10px] font-black text-amber-400 uppercase tracking-[0.25em] mb-2 leading-none">Pembimbing Akademik / Lapangan</p>
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight mb-4">{{ $pembimbing->nama_lengkap }}</h2>
            
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                @if($pembimbing->status == 'Aktif')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-xl text-[10px] font-black uppercase tracking-widest backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span> Aktif Mengajar
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-500/20 text-rose-300 border border-rose-500/30 rounded-xl text-[10px] font-black uppercase tracking-widest backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span> Nonaktif
                    </span>
                @endif

                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 text-white border border-white/20 rounded-xl text-[10px] font-black uppercase tracking-widest backdrop-blur-sm font-mono">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><circle cx="12" cy="14" r="3"/></svg>
                    ID: {{ $pembimbing->no_induk ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-maroon-50 text-maroon-700 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                </div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Posisi & Struktural</h3>
            </div>
            
            <div class="space-y-6">
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">NIP / Nomor Induk</p>
                    <p class="text-sm font-bold text-slate-800 font-mono">{{ $pembimbing->no_induk ?? 'Belum Diatur' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jabatan Fungsional</p>
                    <p class="text-base font-black text-maroon-900 uppercase tracking-tight">{{ $pembimbing->jabatan ?? 'Belum ditentukan' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-slate-50 text-slate-500 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Kontak Akun</h3>
            </div>
            
            <div class="space-y-6">
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Email Terdaftar</p>
                    <p class="text-sm font-bold text-slate-800">{{ $pembimbing->user->email ?? 'Belum ada email yang ditautkan.' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Bergabung</p>
                    <p class="text-sm font-bold text-slate-800">{{ $pembimbing->created_at ? $pembimbing->created_at->translatedFormat('d F Y') : '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Aktivitas Bimbingan</h3>
            </div>
            
            <div class="flex flex-col items-center justify-center h-full pb-8">
                <p class="text-5xl font-black text-amber-500 tracking-tighter leading-none mb-2">0</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Siswa Magang Dibimbing<br>Saat Ini</p>
            </div>
        </div>

    </div>
</main>
@endsection