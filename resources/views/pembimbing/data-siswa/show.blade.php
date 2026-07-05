@extends('layouts.pembimbing')
@section('page_title', 'Profil Siswa')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-10 space-y-6 sm:space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <div class="flex items-center gap-3 sm:gap-4 mb-2">
        <a href="{{ route('pembimbing.data-siswa.index') }}" class="w-8 h-8 sm:w-10 sm:h-10 bg-white border border-slate-200 rounded-lg sm:rounded-xl flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-maroon-700 transition-all shadow-sm active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <h1 class="text-xl sm:text-2xl font-black text-maroon-950 tracking-tight italic leading-none">Profil Anak Bimbingan</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

        <div class="space-y-6">
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden p-6 sm:p-8 text-center flex flex-col items-center relative">
                @if($siswa->status == 'Aktif')
                    <div class="absolute top-4 right-4 bg-emerald-50 text-emerald-600 border border-emerald-100 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest flex items-center gap-1.5 shadow-sm">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Aktif
                    </div>
                @else
                    <div class="absolute top-4 right-4 bg-rose-50 text-rose-600 border border-rose-100 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest flex items-center gap-1.5 shadow-sm">
                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> Nonaktif
                    </div>
                @endif

                <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-[1.5rem] bg-slate-100 border-4 border-white shadow-lg overflow-hidden mb-4 sm:mb-5 shrink-0 relative">
                    @if($siswa->foto_profil)
                        <img src="{{ asset('storage/' . $siswa->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                    @endif
                </div>

                <h2 class="text-lg sm:text-xl font-black text-slate-800 tracking-tight leading-tight">{{ $siswa->nama_lengkap }}</h2>
                <p class="text-[10px] sm:text-xs font-bold font-mono text-maroon-600 bg-maroon-50 px-3 py-1 rounded-md mt-2">{{ $siswa->nis ?? 'NIS Belum Diatur' }}</p>

                <div class="w-full h-px bg-slate-100 my-5"></div>

                <div class="w-full space-y-3">
                    <a href="mailto:{{ $siswa->user->email }}" class="flex items-center gap-3 w-full bg-slate-50 p-3 rounded-xl hover:bg-slate-100 transition-colors border border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-slate-400 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <div class="text-left overflow-hidden">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Email Siswa</p>
                            <p class="text-xs font-bold text-slate-700 truncate">{{ $siswa->user->email ?? '-' }}</p>
                        </div>
                    </a>

                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $siswa->no_hp) }}" target="_blank" class="flex items-center gap-3 w-full bg-emerald-50/50 p-3 rounded-xl hover:bg-emerald-50 transition-colors border border-emerald-100/50 group">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 shadow-sm flex items-center justify-center text-emerald-600 shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div class="text-left overflow-hidden">
                            <p class="text-[9px] font-black text-emerald-600/70 uppercase tracking-widest">No. Handphone / WA</p>
                            <p class="text-xs font-bold text-emerald-800 truncate">{{ $siswa->no_hp ?? '-' }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 tracking-tight italic leading-none">Biodata Diri</h3>
                        <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Informasi personal anak bimbingan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tempat & Tanggal Lahir</p>
                        <p class="text-sm font-bold text-slate-800">
                            {{ $siswa->tempat_lahir ?? '-' }},
                            {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Jenis Kelamin</p>
                        <p class="text-sm font-bold text-slate-800">
                            {{ $siswa->jk == 'L' ? 'Laki-laki' : ($siswa->jk == 'P' ? 'Perempuan' : '-') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Agama</p>
                        <p class="text-sm font-bold text-slate-800">{{ $siswa->agama->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Lengkap</p>
                        <p class="text-sm font-bold text-slate-800 leading-snug">{{ $siswa->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
                    <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 tracking-tight italic leading-none">Informasi Akademik & Periode</h3>
                        <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Sekolah asal dan masa magang</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Sekolah / Instansi Asal</p>
                        <p class="text-sm font-bold text-slate-800">{{ $siswa->sekolah_asal ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Jurusan / Program Studi</p>
                        <p class="text-sm font-bold text-slate-800">{{ $siswa->jurusan ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2 mt-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Periode Pelaksanaan Magang</p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-1 bg-slate-50 border border-slate-100 p-3 rounded-xl flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Mulai</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $siswa->tanggal_mulai ? \Carbon\Carbon::parse($siswa->tanggal_mulai)->translatedFormat('d F Y') : '-' }}</p>
                                </div>
                            </div>
                            <div class="flex-1 bg-slate-50 border border-slate-100 p-3 rounded-xl flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Berakhir</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $siswa->tanggal_selesai ? \Carbon\Carbon::parse($siswa->tanggal_selesai)->translatedFormat('d F Y') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
