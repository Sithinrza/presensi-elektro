@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.tendik.index') }}" class="w-11 h-11 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 hover:border-maroon-200 transition-all shadow-sm group shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Detail Personel Tendik</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Informasi Lengkap Tenaga Kependidikan</p>
            </div>
        </div>

        <a href="{{ route('admin.data.tendik.edit', $tendik->id_tendik) }}" class="bg-amber-50 text-amber-700 border border-amber-200 px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm hover:bg-amber-100 hover:scale-105 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
            Edit Data
        </a>
    </div>

    <div class="bg-maroon-900 rounded-[2.5rem] p-8 lg:p-10 text-white shadow-xl shadow-maroon-900/20 border border-maroon-800 relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-400/10 rounded-full blur-[80px] pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-white/5 rounded-full blur-[60px] pointer-events-none"></div>

        <div class="relative z-10 w-24 h-24 lg:w-28 lg:h-28 rounded-3xl bg-white/10 border-2 border-white/20 p-1 shrink-0 shadow-lg backdrop-blur-md">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($tendik->nama_lengkap) }}&background=fff&color=7f1d1d&size=256&bold=true" class="w-full h-full object-cover rounded-2xl">
        </div>

        <div class="relative z-10 text-center md:text-left flex-1">
            <p class="text-[10px] font-black text-amber-400 uppercase tracking-[0.3em] mb-2 leading-none">Tenaga Kependidikan</p>
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight">{{ $tendik->nama_lengkap }}</h2>
            
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-4">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 text-white border border-white/10 rounded-lg text-[10px] font-black uppercase tracking-widest backdrop-blur-sm font-mono">
                    NIP: {{ $tendik->nip ?? 'N/A' }}
                </span>
                
                @if($tendik->status == 'Aktif')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-lg text-[10px] font-black uppercase tracking-widest backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span> Aktif Bekerja
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-500/20 text-rose-300 border border-rose-500/30 rounded-lg text-[10px] font-black uppercase tracking-widest backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400 shadow-[0_0_8px_rgba(244,63,94,0.8)]"></span> Nonaktif
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                <div class="w-1.5 h-4 bg-maroon-900 rounded-full"></div> Posisi & Penempatan
            </h3>
            <div class="space-y-6">
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Unit Kerja / Prodi</p>
                    <p class="text-sm font-black text-maroon-900 uppercase leading-tight">{{ $tendik->unitKerja->nama_unit ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jabatan Fungsional</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->jabatan->nama_jabatan ?? 'Belum Diatur' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pangkat - Golongan</p>
                    <p class="text-sm font-bold text-slate-800">
                        @if($tendik->pangkatGolongan)
                            {{ $tendik->pangkatGolongan->pangkat->nama_pangkat }} ({{ $tendik->pangkatGolongan->golongan->ruang }})
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                <div class="w-1.5 h-4 bg-maroon-900 rounded-full"></div> Informasi Pribadi
            </h3>
            <div class="space-y-6">
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Identitas Pegawai (NIP)</p>
                    <p class="text-sm font-bold text-slate-800 font-mono tracking-tighter">{{ $tendik->nip ?? 'Data belum dilengkapi' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Agama</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->agama->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Terdaftar Pada Sistem</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->created_at ? $tendik->created_at->locale('id')->translatedFormat('d F Y, H:i') : '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                <div class="w-1.5 h-4 bg-maroon-900 rounded-full"></div> Akun & Keamanan
            </h3>
            <div class="space-y-6">
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1 text-emerald-600">Email Akun Login</p>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9.5C2 7 4 5 6.5 5H18c2.5 0 4.5 2 4.5 4.5V17z"/><path d="m22 10-10 7L2 10"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $tendik->user->email ?? '-' }}</p>
                    </div>
                </div>
                
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Status Keanggotaan</p>
                    <span class="inline-flex px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase italic">Master Personel</span>
                </div>

                <div class="pt-2">
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100">
                        <p class="text-[10px] font-bold text-amber-800 leading-tight">Pegawai ini menggunakan autentikasi akun tunggal untuk akses presensi dan laporan.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection