@extends('layouts.pembimbing')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 space-y-6 sm:space-y-8 animate-in">

    <div class="flex items-center justify-between">
        <a href="{{ route('pembimbing.presensi-siswa.index') }}" class="inline-flex items-center gap-2 px-4 py-2 sm:px-5 sm:py-2.5 bg-white border border-slate-200 rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-black text-slate-500 uppercase tracking-widest hover:bg-slate-50 hover:text-maroon-900 transition-colors shadow-sm active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
        <h2 class="text-sm sm:text-lg font-black text-maroon-950 tracking-tight hidden sm:block">Detail Riwayat Siswa</h2>
    </div>

    <section class="bg-white rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 border border-slate-100 shadow-sm">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start lg:items-center">

            <div class="flex items-center gap-4 sm:gap-5 flex-1 w-full">
                <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-2xl sm:rounded-[1.5rem] bg-slate-50 text-maroon-900 border border-slate-100 flex items-center justify-center text-2xl sm:text-4xl font-black shrink-0 shadow-inner">
                    {{ substr($siswa->nama_lengkap, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl sm:text-3xl font-black text-maroon-950 tracking-tight leading-none">{{ $siswa->nama_lengkap }}</h2>
                    <p class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest mt-1.5 sm:mt-2">{{ $siswa->sekolah_asal }}</p>
                    <div class="mt-2.5 inline-flex px-3 py-1 bg-slate-50 border border-slate-200 rounded-lg text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest leading-none">
                        NIS: {{ $siswa->nis }}
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between sm:justify-start gap-4 sm:gap-6 lg:gap-8 w-full lg:w-auto shrink-0 mt-2 lg:mt-0 bg-slate-50 border border-slate-100 p-4 sm:p-5 rounded-2xl overflow-x-auto no-scrollbar">
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Tepat CI</p>
                    <p class="text-xl sm:text-2xl font-black text-emerald-500 leading-none">{{ $statistik['Tepat CI'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Telat CI</p>
                    <p class="text-xl sm:text-2xl font-black text-amber-500 leading-none">{{ $statistik['Telat CI'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Alfa</p>
                    <p class="text-xl sm:text-2xl font-black text-rose-500 leading-none">{{ $statistik['Alfa'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Libur</p>
                    <p class="text-xl sm:text-2xl font-black text-blue-500 leading-none">{{ $statistik['Libur'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Tepat CO</p>
                    <p class="text-xl sm:text-2xl font-black text-emerald-500 leading-none">{{ $statistik['Tepat CO'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Lupa CO</p>
                    <p class="text-xl sm:text-2xl font-black text-rose-500 leading-none">{{ $statistik['Lupa CO'] ?? 0 }}</p>
                </div>
            </div>

        </div>
    </section>

    <section class="bg-white rounded-3xl sm:rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead class="bg-slate-50/80 border-b border-slate-100">
                    <tr>
                        <th class="px-6 sm:px-8 py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">Hari & Tanggal</th>
                        <th class="px-6 sm:px-8 py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Masuk</th>
                        <th class="px-6 sm:px-8 py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Pulang</th>
                        <th class="px-6 sm:px-8 py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status Kehadiran</th>
                        <th class="px-6 sm:px-8 py-5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">

                    @forelse($riwayatPresensi as $p)
                    @if($p->id_presensi)
                        <tr onclick="window.location.href='{{ route('presensi.detail', $p->id_presensi) }}'" class="hover:bg-slate-50/50 transition-colors group cursor-pointer">
                    @else
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                    @endif
                        <td class="px-6 sm:px-8 py-4 sm:py-5">
                            <p class="font-bold text-slate-800 text-xs sm:text-sm group-hover:text-maroon-800 transition-colors">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('l, d M Y') }}</p>
                        </td>
                        <td class="px-6 sm:px-8 py-4 sm:py-5 text-center text-slate-500 text-xs sm:text-sm font-semibold font-mono">
                            {{ $p->jam_masuk ?? '--:--' }}
                        </td>
                        <td class="px-6 sm:px-8 py-4 sm:py-5 text-center text-slate-500 text-xs sm:text-sm font-semibold font-mono">
                            {{ $p->jam_pulang ?? '--:--' }}
                        </td>
                        <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-1.5 sm:gap-2">
                                @php
                                    $ciName = $p->statusCi ? $p->statusCi->name : 'Alfa';
                                    $colorCi = $ciName === 'Tepat Waktu' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' :
                                              ($ciName === 'Terlambat' ? 'bg-amber-50 text-amber-600 border-amber-200' :
                                              ($ciName === 'Libur' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-rose-50 text-rose-600 border-rose-200'));

                                    $coName = $p->statusCo ? $p->statusCo->name : 'Belum CO';
                                    $colorCo = $coName === 'Tepat Waktu' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' :
                                              ($coName === 'Belum CO' ? 'bg-slate-50 text-slate-500 border-slate-200' :
                                              ($coName === 'Libur' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-rose-50 text-rose-600 border-rose-200'));
                                @endphp

                                <span class="inline-flex items-center px-2.5 py-1 {{ $colorCi }} border rounded-md text-[8px] sm:text-[9px] font-black uppercase tracking-widest w-[85px] justify-center">
                                    IN: {{ $ciName == 'Tepat Waktu' ? 'Tepat' : $ciName }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-1 {{ $colorCo }} border rounded-md text-[8px] sm:text-[9px] font-black uppercase tracking-widest w-[85px] justify-center">
                                    OUT: {{ $coName == 'Tepat Waktu' ? 'Tepat' : ($coName == 'Lupa Check-Out' ? 'Lupa' : $coName) }}
                                </span>
                            </div>
                        </td>
                        <td class="pr-6 sm:pr-8 text-right">
                            @if($p->id_presensi)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-slate-300 opacity-0 group-hover:opacity-100 group-hover:text-maroon-600 transition-all translate-x-2 group-hover:translate-x-0 ml-auto"><path d="m9 18 6-6-6-6"/></svg>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-50 text-slate-300 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Belum ada data presensi bulan ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
