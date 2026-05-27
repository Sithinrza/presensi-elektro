@extends('layouts.pembimbing')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10 space-y-8 animate-in">

    <section class="bg-maroon-900 rounded-[3rem] p-8 md:p-10 text-white shadow-premium relative overflow-hidden">
        <div class="relative z-10 flex flex-col xl:flex-row items-center gap-8">
            <div class="flex items-center gap-6 w-full xl:w-auto">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-3xl border-2 border-gold/50 bg-white/10 flex items-center justify-center text-3xl font-black shrink-0">
                    {{ substr($siswa->nama_lengkap, 0, 1) }}
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl md:text-3xl font-black italic tracking-tight">{{ $siswa->nama_lengkap }}</h2>
                    <p class="text-maroon-100/70 italic text-sm md:text-base mt-1">{{ $siswa->sekolah_asal }} | NIS: {{ $siswa->nis }}</p>
                </div>
            </div>

            <div class="w-full xl:w-auto ml-auto grid grid-cols-3 md:grid-cols-5 gap-4 md:gap-6 text-center bg-white/5 p-4 rounded-3xl border border-white/10">
                <div><p class="text-[8px] md:text-[9px] text-maroon-300 uppercase tracking-widest">Tepat CI</p><p class="text-2xl md:text-3xl font-black text-white">{{ $statistik['Tepat CI'] }}</p></div>
                <div><p class="text-[8px] md:text-[9px] text-maroon-300 uppercase tracking-widest">Telat CI</p><p class="text-2xl md:text-3xl font-black text-amber-400">{{ $statistik['Telat CI'] }}</p></div>
                <div><p class="text-[8px] md:text-[9px] text-maroon-300 uppercase tracking-widest">Alfa</p><p class="text-2xl md:text-3xl font-black text-rose-400">{{ $statistik['Alfa'] }}</p></div>
                <div class="border-t md:border-t-0 md:border-l border-white/10 pt-3 md:pt-0 pl-0 md:pl-6"><p class="text-[8px] md:text-[9px] text-maroon-300 uppercase tracking-widest">Tepat CO</p><p class="text-2xl md:text-3xl font-black text-emerald-400">{{ $statistik['Tepat CO'] }}</p></div>
                <div class="border-t md:border-t-0 pt-3 md:pt-0"><p class="text-[8px] md:text-[9px] text-maroon-300 uppercase tracking-widest">Lupa CO</p><p class="text-2xl md:text-3xl font-black text-rose-400">{{ $statistik['Lupa CO'] }}</p></div>
            </div>
        </div>
    </section>

    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-maroon-50/30">
                <tr>
                    <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Hari & Tanggal</th>
                    <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Masuk</th>
                    <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Pulang</th>
                    <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-maroon-50">
                @forelse($riwayatPresensi as $p)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-8 py-5 font-bold text-slate-800 text-sm">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('l, d M Y') }}</td>
                    <td class="px-8 py-5 text-center text-slate-600 italic font-medium">{{ $p->jam_masuk ?? '--:--' }}</td>
                    <td class="px-8 py-5 text-center text-slate-600 italic font-medium">{{ $p->jam_pulang ?? '--:--' }}</td>
                    <td class="px-8 py-5 text-center">
                        <div class="flex flex-col items-center gap-1">
                            @php
                                $ciName = $p->statusCi ? $p->statusCi->name : 'Alfa';
                                $colorCi = $ciName === 'Tepat Waktu' ? 'bg-emerald-100 text-emerald-700' : ($ciName === 'Terlambat' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700');

                                $coName = $p->statusCo ? $p->statusCo->name : 'Belum CO';
                                $colorCo = $coName === 'Tepat Waktu' ? 'bg-emerald-100 text-emerald-700' : ($coName === 'Belum CO' ? 'bg-slate-100 text-slate-500' : 'bg-rose-100 text-rose-700');
                            @endphp

                            <span class="inline-flex px-3 py-1.5 {{ $colorCi }} rounded-lg text-[9px] font-black uppercase tracking-tighter">
                                CI: {{ $ciName }}
                            </span>
                            <span class="inline-flex px-3 py-1.5 {{ $colorCo }} rounded-lg text-[9px] font-black uppercase tracking-tighter">
                                CO: {{ $coName }}
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-10 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada data presensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</main>
@endsection
