@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <!-- ALERT NOTIFIKASI -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-5 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-5 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') ?? $errors->first() }}
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-5 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-black text-maroon-950 tracking-tight italic">Penerbitan Sertifikat</h2>
            <p class="text-sm font-bold text-slate-500 mt-1">Kelola dan terbitkan nomor sertifikat resmi untuk siswa magang.</p>
        </div>
    </div>

    <!-- DATA TABLE SECTION -->
    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
        
        <div class="px-8 py-6 border-b border-maroon-50 bg-white">
            <h3 class="text-lg font-black text-maroon-950 tracking-tight italic leading-none">Daftar Penilaian Akhir</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Input nomor surat resmi dan klik cetak</p>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-maroon-50/30">
                        <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center w-16">No</th>
                        <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Siswa & Instansi Asal</th>
                        <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Nilai Akhir</th>
                        <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Input & Cetak Sertifikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50">
                    
                    @forelse($penilaian as $index => $p)
                    <tr class="hover:bg-maroon-50/20 transition-colors group">
                        <td class="px-8 py-5 text-center font-bold text-slate-400 text-xs">{{ $index + 1 }}</td>
                        
                        <!-- Profil Siswa -->
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shadow-sm border-2 border-white group-hover:border-maroon-100 transition-all flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($p->siswa->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-sm tracking-tight group-hover:text-maroon-900 transition-colors">{{ $p->siswa->nama_lengkap }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 line-clamp-1">{{ $p->siswa->sekolah_asal }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Rata-rata -->
                        <td class="px-8 py-5 text-center">
                            @php
                                $nilaiAvg = number_format($p->rata_rata, 2, ',', '');
                                $isLulus = $p->rata_rata >= 6.00;
                            @endphp
                            <div class="inline-flex flex-col items-center justify-center">
                                <span class="inline-flex items-center justify-center bg-white text-maroon-900 font-black text-sm w-12 h-12 rounded-[1rem] border-2 border-maroon-100 shadow-sm {{ $isLulus ? 'border-emerald-200 text-emerald-700 bg-emerald-50' : 'border-rose-200 text-rose-700 bg-rose-50' }}">
                                    {{ $nilaiAvg }}
                                </span>
                            </div>
                        </td>

                        <!-- Form Input Nomor Sertifikat & Cetak -->
                        <td class="px-8 py-5">
                            <form action="{{ route('admin.sertifikat.update', $p->id_penilaian) }}" method="POST" class="flex items-center gap-2 w-max">
                                @csrf @method('PUT')
                                
                                <div class="relative">
                                    <input type="text" name="nomor_sertifikat" value="{{ $p->nomor_sertifikat }}" required placeholder="Contoh: 004/PL18.3/..." 
                                        class="w-56 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 focus:bg-white transition-all shadow-sm">
                                </div>
                                
                                <!-- Tombol Simpan -->
                                <button type="submit" title="Simpan Nomor Sertifikat" class="h-11 px-4 bg-maroon-950 text-white rounded-xl flex items-center justify-center gap-2 shadow-lg hover:bg-maroon-800 active:scale-95 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Simpan</span>
                                </button>
                                
                                <!-- Tombol Cetak (Hanya Muncul Jika Nomor Sudah Ada) -->
                                @if($p->nomor_sertifikat)
                                    <div class="w-px h-6 bg-slate-200 mx-1"></div> <!-- Pembatas -->
                                    
                                    <a href="{{ route('admin.sertifikat.cetak', $p->id_penilaian) }}" target="_blank" title="Cetak Sertifikat (PDF)" class="h-11 px-4 bg-emerald-500 text-white rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 active:scale-95 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Cetak</span>
                                    </a>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @empty
                    
                    <!-- Empty State Modern -->
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-maroon-50 text-maroon-200 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                            </div>
                            <p class="text-lg font-black text-maroon-900 tracking-tight">Belum Ada Penilaian</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Belum ada data nilai akhir yang disubmit oleh pembimbing lapangan.</p>
                        </td>
                    </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection