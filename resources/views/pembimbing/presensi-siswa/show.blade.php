@extends('layouts.pembimbing')
@section('page_title', 'Siswa')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-10 space-y-4 sm:space-y-6 lg:space-y-8 animate-in">

    <div class="flex items-center justify-between">
        <a href="{{ $backUrl }}" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 py-2 sm:px-5 sm:py-2.5 bg-white border border-slate-200 rounded-lg sm:rounded-2xl text-[9px] sm:text-xs font-black text-slate-500 uppercase tracking-widest hover:bg-slate-50 hover:text-maroon-900 transition-colors shadow-sm active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
        <h2 class="text-xs sm:text-lg font-black text-maroon-950 tracking-tight hidden sm:block">Detail Riwayat Siswa</h2>
    </div>

    <section class="bg-maroon-900 rounded-[1.5rem] sm:rounded-[2.5rem] p-4 sm:p-6 lg:p-8 border border-maroon-800 shadow-premium relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-48 sm:w-64 h-48 sm:h-64 bg-gold/10 rounded-full blur-[60px] pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row gap-4 sm:gap-6 lg:gap-8 items-start lg:items-center">

            <div class="flex items-center gap-3 sm:gap-5 flex-1 w-full">
                <div class="w-14 h-14 sm:w-20 sm:h-20 lg:w-24 lg:h-24 rounded-xl sm:rounded-[1.5rem] bg-white border-2 border-gold flex items-center justify-center text-xl sm:text-3xl lg:text-4xl font-black text-maroon-900 shrink-0 shadow-md p-0.5 overflow-hidden">
                    <div class="w-full h-full rounded-[0.6rem] sm:rounded-[1.2rem] overflow-hidden bg-slate-100 flex items-center justify-center">
                        @if(isset($siswa->foto_profil) && $siswa->foto_profil)
                            <img src="{{ asset('storage/' . $siswa->foto_profil) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($siswa->nama_lengkap, 0, 1) }}
                        @endif
                    </div>
                </div>

                <div>
                    <h2 class="text-lg sm:text-2xl lg:text-3xl font-black text-white tracking-tight leading-none">{{ $siswa->nama_lengkap }}</h2>
                    <p class="text-[9px] sm:text-[10px] lg:text-xs font-bold text-maroon-200/80 uppercase tracking-widest mt-1 lg:mt-1.5 line-clamp-1">{{ $siswa->sekolah_asal }}</p>
                    <div class="mt-1.5 sm:mt-2.5 inline-flex px-2 py-1 sm:px-3 sm:py-1 bg-white/10 border border-white/20 backdrop-blur-sm rounded-md sm:rounded-lg text-[8px] sm:text-[9px] lg:text-[10px] font-black text-gold uppercase tracking-widest leading-none">
                        NIS: {{ $siswa->nis ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-4 sm:flex sm:items-center sm:justify-start gap-y-3 gap-x-1 sm:gap-4 lg:gap-5 w-full lg:w-auto shrink-0 mt-3 sm:mt-0 bg-maroon-950/50 border border-maroon-800/50 p-3 sm:p-4 rounded-xl sm:rounded-2xl backdrop-blur-sm">

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300/60 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Tepat CI</p>
                    <p class="text-sm sm:text-lg font-black text-emerald-400 leading-none">{{ $statistik['Tepat CI'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-maroon-800 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300/60 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Telat CI</p>
                    <p class="text-sm sm:text-lg font-black text-amber-400 leading-none">{{ $statistik['Telat CI'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-maroon-800 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300/60 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Alpa</p>
                    <p class="text-sm sm:text-lg font-black text-rose-400 leading-none">{{ $statistik['Alpa'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-maroon-800 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300/60 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Libur</p>
                    <p class="text-sm sm:text-lg font-black text-blue-400 leading-none">{{ $statistik['Libur'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-maroon-800 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300/60 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Tepat CO</p>
                    <p class="text-sm sm:text-lg font-black text-emerald-400 leading-none">{{ $statistik['Tepat CO'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-maroon-800 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300/60 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Telat CO</p>
                    <p class="text-sm sm:text-lg font-black text-amber-400 leading-none">{{ $statistik['Telat CO'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-maroon-800 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300/60 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Lupa CO</p>
                    <p class="text-sm sm:text-lg font-black text-rose-400 leading-none">{{ $statistik['Lupa CO'] ?? 0 }}</p>
                </div>

            </div>

        </div>
    </section>

    <section class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
            <h3 class="text-sm sm:text-base lg:text-lg font-black text-slate-800 tracking-tight">Data Riwayat Presensi</h3>

            <div class="flex items-center gap-2 sm:gap-3 w-full md:w-auto">
                <form action="{{ route('pembimbing.presensi-siswa.show', $siswa->id_user) }}" method="GET" class="flex items-center gap-1.5 sm:gap-2 w-full">
                    <select name="bulan" class="flex-1 md:flex-auto bg-slate-50 border border-slate-200 rounded-lg sm:rounded-xl px-2 py-1.5 sm:px-3 sm:py-2 text-[9px] sm:text-[10px] lg:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan', date('m')) == $i ? 'selected' : '' }}>
                                {{ Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                            </option>
                        @endfor
                    </select>

                    <select name="tahun" class="flex-1 md:flex-auto bg-slate-50 border border-slate-200 rounded-lg sm:rounded-xl px-2 py-1.5 sm:px-3 sm:py-2 text-[9px] sm:text-[10px] lg:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer">
                        @for ($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>

                    <button type="submit" class="bg-maroon-900 text-white px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg sm:rounded-xl text-[9px] sm:text-[10px] lg:text-xs font-bold hover:bg-maroon-800 transition shadow-sm active:scale-95 cursor-pointer shrink-0">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto custom-scroll pb-2">
            <table class="w-full text-left border-collapse min-w-[550px] lg:min-w-[650px]">
                <thead class="bg-slate-50/80 border-b border-slate-100">
                    <tr>
                        <th class="px-4 sm:px-6 lg:px-8 py-3 lg:py-5 text-[8px] sm:text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest">Hari & Tanggal</th>
                        <th class="px-4 sm:px-6 lg:px-8 py-3 lg:py-5 text-[8px] sm:text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Masuk</th>
                        <th class="px-4 sm:px-6 lg:px-8 py-3 lg:py-5 text-[8px] sm:text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Pulang</th>
                        <th class="px-4 sm:px-6 lg:px-8 py-3 lg:py-5 text-[8px] sm:text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status Kehadiran</th>
                        <th class="px-4 sm:px-6 lg:px-8 py-3 lg:py-5 text-[8px] sm:text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">

                    @forelse($riwayatPresensi as $p)

                    @if($p->id_presensi)
                        <tr onclick="window.location.href='{{ route('presensi.detail', $p->id_presensi) }}'" class="hover:bg-slate-50/50 transition-colors group cursor-pointer">
                    @else
                        <tr class="bg-slate-50/30 transition-colors">
                    @endif
                        <td class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 lg:py-5">
                            <p class="font-bold {{ isset($p->id_presensi) ? 'text-slate-800 group-hover:text-maroon-800' : 'text-slate-400' }} text-[10px] sm:text-xs lg:text-sm transition-colors">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('l, d M Y') }}</p>
                        </td>
                        <td class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 lg:py-5 text-center {{ isset($p->id_presensi) ? 'text-slate-500' : 'text-slate-300' }} text-[10px] sm:text-xs lg:text-sm font-semibold font-mono">
                            {{ $p->jam_masuk ?? '--:--' }}
                        </td>
                        <td class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 lg:py-5 text-center {{ isset($p->id_presensi) ? 'text-slate-500' : 'text-slate-300' }} text-[10px] sm:text-xs lg:text-sm font-semibold font-mono">
                            {{ $p->jam_pulang ?? '--:--' }}
                        </td>
                        <td class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 lg:py-5 text-center">
                            <div class="flex flex-col gap-1 lg:flex-row lg:gap-1.5 items-center justify-center {{ isset($p->id_presensi) ? '' : 'opacity-60' }}">

                                @php
                                    $ciName = isset($p->statusCi) ? $p->statusCi->name : 'Alpa';
                                    $colorCi = match($ciName) {
                                        'Tepat Waktu' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Terlambat' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'Belum Presensi' => 'bg-slate-50 text-slate-500 border-slate-200',
                                        default => 'bg-rose-50 text-rose-600 border-rose-200'
                                    };

                                    $coName = isset($p->statusCo) ? $p->statusCo->name : 'Belum CO';
                                    $colorCo = match($coName) {
                                        'Tepat Waktu', 'Check Out' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Terlambat CO' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Belum CO' => 'bg-slate-50 text-slate-500 border-slate-200',
                                        'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'Belum Presensi' => 'bg-slate-50 text-slate-500 border-slate-200',
                                        default => 'bg-rose-50 text-rose-600 border-rose-200'
                                    };
                                @endphp

                                <span class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-1.5 {{ $colorCi }} border rounded-md text-[7px] sm:text-[8px] lg:text-[9px] font-black uppercase tracking-widest justify-center whitespace-nowrap w-full lg:w-auto">
                                    IN: {{ $ciName }}
                                </span>

                                <span class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-1.5 {{ $colorCo }} border rounded-md text-[7px] sm:text-[8px] lg:text-[9px] font-black uppercase tracking-widest justify-center whitespace-nowrap w-full lg:w-auto mt-0.5 lg:mt-0">
                                    OUT: {{ $coName }}
                                </span>
                            </div>
                            @if(isset($p->alasan) && $p->alasan)
                                <div class="mt-1 text-[10px] text-amber-600 font-bold italic max-w-[150px] md:max-w-[200px] truncate text-center mx-auto bg-amber-50 border border-amber-200 px-2 py-0.5 rounded" title="{{ $p->alasan }}">
                                    💬 Alasan: {{ $p->alasan }}
                                </div>
                            @endif
                        </td>
                        <td class="pr-4 sm:pr-6 lg:pr-8 py-3 sm:py-4 lg:py-5 text-center">
                            @if(isset($p->id_presensi))
                                <span class="inline-flex items-center justify-center gap-1 text-[9px] lg:text-[10px] font-black text-maroon-700 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0 cursor-pointer">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center gap-1 text-[9px] lg:text-[10px] font-black text-slate-300 uppercase tracking-widest cursor-not-allowed">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 lg:p-12 text-center">
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-[9px] sm:text-[10px]">Belum ada data presensi bulan ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</main>
@endsection
