@extends('layouts.admin')
@section('page_title', 'Data Siswa')

@section('content')
<main class="p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.siswa.index') }}" class="w-11 h-11 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 hover:border-maroon-200 transition-all shadow-sm group shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Detail Profil Siswa</h1>
            </div>
        </div>

        {{-- <a href="{{ route('admin.data.siswa.edit', $siswa->id_siswa) }}" class="bg-amber-50 text-amber-700 border border-amber-200 px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm hover:bg-amber-100 hover:scale-105 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
            Edit Profil
        </a> --}}
    </div>

    <div class="bg-maroon-900 rounded-[2.5rem] p-8 lg:p-10 text-white shadow-xl shadow-maroon-900/20 border border-maroon-800 relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
        <div class="relative z-10 w-24 h-24 lg:w-28 lg:h-28 rounded-2xl bg-white/10 border-2 border-white/20 p-1 shrink-0 shadow-lg">
            @if($siswa->foto_profil)
                <img src="{{ asset('storage/' . $siswa->foto_profil) }}" alt="Foto {{ $siswa->nama_lengkap }}" class="w-full h-full object-cover">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
            @endif
        </div>

        <div class="relative z-10 text-center md:text-left flex-1">
            <h2 class="text-3xl font-black tracking-tight text-white leading-tight">{{ $siswa->nama_lengkap }}</h2>
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-3">
                <span class="px-3 py-1 bg-white/10 rounded-lg text-[10px] font-bold uppercase tracking-widest text-white/80">NIS: {{ $siswa->nis ?? '-' }}</span>
                @if($siswa->status == 'Aktif')
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-lg text-[10px] font-black uppercase tracking-widest">Aktif</span>
                @else
                    <span class="px-3 py-1 bg-rose-500/20 text-rose-300 rounded-lg text-[10px] font-black uppercase tracking-widest">Nonaktif</span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                <div class="w-1.5 h-4 bg-maroon-900 rounded-full"></div> Informasi Pribadi
            </h3>
            <div class="space-y-5">
                <div><p class="text-[9px] font-bold text-slate-400 uppercase">Email</p><p class="text-sm font-bold text-slate-800">{{ $siswa->user->email ?? '-' }}</p></div>
                <div><p class="text-[9px] font-bold text-slate-400 uppercase">Tempat, Tanggal Lahir</p><p class="text-sm font-bold text-slate-800">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ?? '-' }}</p></div>
                <div><p class="text-[9px] font-bold text-slate-400 uppercase">Agama</p><p class="text-sm font-bold text-slate-800">{{ $siswa->agama->name ?? '-' }}</p></div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase">Jenis Kelamin</p>
                    <p class="text-sm font-bold text-slate-800">
                        @if($siswa->jk == 'L')
                            Laki-laki
                        @elseif($siswa->jk == 'P')
                            Perempuan
                        @else
                            Belum diisi
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                <div class="w-1.5 h-4 bg-maroon-900 rounded-full"></div> Instansi & Jurusan
            </h3>
            <div class="space-y-5">
                <div><p class="text-[9px] font-bold text-slate-400 uppercase">Sekolah Asal</p><p class="text-sm font-bold text-slate-800">{{ $siswa->sekolah_asal ?? '-' }}</p></div>
                <div><p class="text-[9px] font-bold text-slate-400 uppercase">Jurusan</p><p class="text-sm font-bold text-slate-800">{{ $siswa->jurusan ?? '-' }}</p></div>
                <div><p class="text-[9px] font-bold text-slate-400 uppercase">Pembimbing</p><p class="text-sm font-bold text-slate-800">{{ $siswa->pembimbing->nama_lengkap ?? 'Belum ditentukan' }}</p></div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                <div class="w-1.5 h-4 bg-maroon-900 rounded-full"></div> Periode & Kontak
            </h3>
            <div class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase">Mulai Magang</p>
                        <p class="text-sm font-bold text-slate-800">
                            {{ $siswa->tanggal_mulai ? \Carbon\Carbon::parse($siswa->tanggal_mulai)->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase">Selesai Magang</p>
                        <p class="text-sm font-bold text-slate-800">
                            {{ $siswa->tanggal_selesai ? \Carbon\Carbon::parse($siswa->tanggal_selesai)->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                </div>

                <div><p class="text-[9px] font-bold text-slate-400 uppercase">No. HP / WhatsApp</p><p class="text-sm font-bold text-slate-800">{{ $siswa->no_hp ?? '-' }}</p></div>
                <div><p class="text-[9px] font-bold text-slate-400 uppercase">Alamat</p><p class="text-sm font-bold text-slate-800">{{ $siswa->alamat ?? '-' }}</p></div>
            </div>
        </div>

    </div>
</main>
@endsection
