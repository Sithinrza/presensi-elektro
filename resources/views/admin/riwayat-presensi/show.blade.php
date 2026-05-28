@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-6 animate-in fade-in slide-in-from-right-8 duration-500">
    
    <!-- HEADER & KEMBALI -->
    <button onclick="window.location.href='{{ url('/admin/riwayat-presensi') }}'" class="flex items-center gap-3 text-xs font-black text-slate-500 uppercase tracking-widest hover:text-maroon-700 transition-colors group w-fit mb-2">
        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm group-hover:scale-105 group-hover:border-maroon-200 group-hover:bg-maroon-50 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </div>
        Kembali ke Daftar
    </button>

    <!-- PROFIL RINGKAS PERSONIL -->
    <div class="bg-maroon-900 rounded-3xl p-8 lg:p-10 text-white shadow-lg shadow-maroon-900/20 overflow-hidden border border-maroon-800 relative">
        <!-- Latar Abstrak -->
        <div class="absolute -top-20 -right-20 w-80 h-80 bg-amber-400/10 rounded-full blur-[80px] pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-10">
            
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl border-2 border-amber-400/50 bg-white/10 backdrop-blur-md flex items-center justify-center text-4xl font-black text-amber-400 shadow-inner overflow-hidden">
                    {{ substr($nama_lengkap ?? 'A', 0, 1) }}
                </div>
                <div>
                    <p class="text-[10px] font-black text-amber-400 uppercase tracking-[0.2em] mb-1.5 leading-none">{{ $role ?? 'Siswa Magang' }}</p>
                    <h2 class="text-3xl font-black tracking-tight text-white leading-tight">{{ $nama_lengkap ?? 'Nama User' }}</h2>
                    <p class="text-maroon-200 text-xs font-bold uppercase mt-2 tracking-widest leading-none">{{ $instansi ?? 'Instansi / Unit' }}</p>
                </div>
            </div>

            <!-- STATISTIK INDIVIDU -->
            <div class="flex items-center gap-6 md:gap-10 bg-black/20 p-5 rounded-2xl border border-white/10 backdrop-blur-sm">
                <div class="text-center">
                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Hadir</p>
                    <p class="text-3xl font-black text-emerald-400 mt-1 leading-none">{{ $statistik['hadir'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-white/10"></div>
                <div class="text-center">
                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Terlambat</p>
                    <p class="text-3xl font-black text-amber-400 mt-1 leading-none">{{ $statistik['telat'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-white/10"></div>
                <div class="text-center">
                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Alfa</p>
                    <p class="text-3xl font-black text-rose-400 mt-1 leading-none">{{ $statistik['alfa'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL RIWAYAT INDIVIDU -->
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-black text-slate-800 tracking-tight">Data Riwayat Presensi</h3>
            
            <!-- Tombol Cetak PDF Spesifik Individu (Opsional) -->
            <button class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-maroon-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                Export Riwayat
            </button>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tap In</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tap Out</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    
                    @forelse($riwayat ?? [] as $r)
                        @php
                            $statusName = $r->status_presensi->name ?? 'Alfa';
                            
                            $statusBg = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                            $dotColor = 'bg-emerald-500';
                            
                            if($statusName === 'Terlambat') {
                                $statusBg = 'bg-amber-50 text-amber-700 border-amber-200';
                                $dotColor = 'bg-amber-500';
                            } elseif($statusName === 'Alfa') {
                                $statusBg = 'bg-rose-50 text-rose-600 border-rose-200';
                                $dotColor = 'bg-rose-500';
                            }
                        @endphp
                        
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-8 py-4 text-xs font-bold text-slate-700 group-hover:text-maroon-800 transition-colors">
                                {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                            </td>
                            <td class="px-8 py-4 text-center text-xs font-bold text-slate-500 font-mono">
                                {{ $r->jam_masuk ?? '--:--' }}
                            </td>
                            <td class="px-8 py-4 text-center text-xs font-bold text-slate-500 font-mono">
                                {{ $r->jam_pulang ?? '--:--' }}
                            </td>
                            <td class="px-8 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 {{ $statusBg }} border rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                    {{ $statusName }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 font-bold text-slate-400 text-sm">Belum ada riwayat presensi yang tercatat.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection