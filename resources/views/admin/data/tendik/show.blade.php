@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.tendik.index') }}" class="w-11 h-11 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 hover:border-maroon-200 transition-all shadow-sm group shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Detail Profil Tendik</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Informasi Lengkap Tenaga Kependidikan</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.data.tendik.edit', $tendik->id_tendik) }}" class="bg-amber-50 text-amber-700 border border-amber-200 px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm hover:bg-amber-100 hover:scale-105 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                Edit Profil
            </a>
        </div>
    </div>

    <div class="bg-maroon-900 rounded-[2.5rem] p-8 lg:p-10 text-white shadow-xl shadow-maroon-900/20 border border-maroon-800 relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-400/10 rounded-full blur-[80px] pointer-events-none"></div>

        <div class="relative z-10 w-24 h-24 lg:w-28 lg:h-28 rounded-2xl bg-white/10 border-2 border-white/20 p-1 shrink-0 shadow-lg backdrop-blur-md overflow-hidden flex items-center justify-center text-4xl font-black text-amber-400">
            @if($tendik->foto_profil)
                <img src="{{ asset('storage/' . $tendik->foto_profil) }}" class="w-full h-full object-cover rounded-xl">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($tendik->nama_lengkap) }}&background=fff&color=7f1d1d&size=256&bold=true" class="w-full h-full object-cover rounded-xl">
            @endif
        </div>

        <div class="relative z-10 text-center md:text-left flex-1 w-full">
            <p class="text-[10px] font-black text-amber-400 uppercase tracking-[0.25em] mb-2 leading-none">Tenaga Kependidikan</p>
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight text-white leading-tight mb-4">{{ $tendik->nama_lengkap }}</h2>

            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                @if($tendik->status == 'Aktif')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-xl text-[10px] font-black uppercase tracking-widest backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span> Aktif Bekerja
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-500/20 text-rose-300 border border-rose-500/30 rounded-xl text-[10px] font-black uppercase tracking-widest backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span> Nonaktif
                    </span>
                @endif

                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 text-white border border-white/20 rounded-xl text-[10px] font-black uppercase tracking-widest backdrop-blur-sm font-mono">
                    NIP: {{ $tendik->nip ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-maroon-50 text-maroon-700 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                </div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Posisi & Struktural</h3>
            </div>

            <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                <div class="col-span-2">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Unit Kerja / Prodi</p>
                    <p class="text-base font-black text-maroon-900 uppercase tracking-tight">{{ $tendik->unitKerja->nama_unit ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pangkat Golongan</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->pangkatGolongan->pangkat->nama_pangkat ?? '-' }} ({{ $tendik->pangkatGolongan->golongan->nama_golongan ?? '-' }})</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jabatan</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->jabatan->nama_jabatan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pend. Terakhir</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->pendidikanTerakhir->name ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-slate-50 text-slate-500 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Informasi Pribadi & Kontak</h3>
            </div>

            <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                <div class="col-span-2">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Email Terdaftar</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">No Handphone</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->no_hp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Agama</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->agama->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jenis Kelamin</p>
                    <p class="text-sm font-bold text-slate-800">
                        @if($tendik->jk == 'L') Laki-laki @elseif($tendik->jk == 'P') Perempuan @else - @endif
                    </p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">TTL</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->tempat_lahir ?? '-' }}, {{ $tendik->tanggal_lahir ? \Carbon\Carbon::parse($tendik->tanggal_lahir)->translatedFormat('d M Y') : '-' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Alamat Lengkap</p>
                    <p class="text-sm font-bold text-slate-800">{{ $tendik->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
