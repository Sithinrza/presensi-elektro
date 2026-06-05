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
                <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-2xl sm:rounded-[1.5rem] bg-slate-50 text-maroon-900 border border-slate-100 flex items-center justify-center text-2xl sm:text-4xl font-black shrink-0 shadow-inner overflow-hidden">
                    @if(isset($siswa->foto_profil) && $siswa->foto_profil)
                        <img src="{{ asset('storage/profil/' . $siswa->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($siswa->nama_lengkap, 0, 1) }}
                    @endif
                </div>
                <div>
                    <h2 class="text-xl sm:text-3xl font-black text-maroon-950 tracking-tight leading-none">{{ $siswa->nama_lengkap }}</h2>
                    <p class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest mt-1.5 sm:mt-2">{{ $siswa->sekolah_asal }}</p>
                    <div class="mt-2.5 inline-flex px-3 py-1 bg-slate-50 border border-slate-200 rounded-lg text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest leading-none">
                        NIS: {{ $siswa->nis }}
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between sm:justify-start gap-3 sm:gap-4 lg:gap-5 w-full lg:w-auto shrink-0 mt-2 lg:mt-0 bg-slate-50 border border-slate-100 p-4 rounded-2xl overflow-x-auto no-scrollbar">
                <div class="text-center shrink-0 px-1">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Tepat CI</p>
                    <p class="text-lg font-black text-emerald-500 leading-none">{{ $statistik['Tepat CI'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-8 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-1">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Telat CI</p>
                    <p class="text-lg font-black text-amber-500 leading-none">{{ $statistik['Telat CI'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-8 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-1">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Alfa</p>
                    <p class="text-lg font-black text-rose-500 leading-none">{{ $statistik['Alfa'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-8 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-1">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Libur</p>
                    <p class="text-lg font-black text-blue-500 leading-none">{{ $statistik['Libur'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-8 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-1">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Tepat CO</p>
                    <p class="text-lg font-black text-emerald-500 leading-none">{{ $statistik['Tepat CO'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-8 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-1">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Telat CO</p>
                    <p class="text-lg font-black text-amber-500 leading-none">{{ $statistik['Telat CO'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-8 bg-slate-200 shrink-0"></div>
                <div class="text-center shrink-0 px-1">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Lupa CO</p>
                    <p class="text-lg font-black text-rose-500 leading-none">{{ $statistik['Lupa CO'] ?? 0 }}</p>
                </div>
            </div>

        </div>
    </section>

    <section class="bg-white rounded-3xl sm:rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-base sm:text-lg font-black text-slate-800 tracking-tight">Data Riwayat Presensi</h3>

            <div class="flex items-center gap-3">
                <form action="{{ route('pembimbing.presensi-siswa.show', $siswa->id_user) }}" method="GET" class="flex items-center gap-2">
                    <select name="bulan" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-[10px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan', date('m')) == $i ? 'selected' : '' }}>
                                {{ Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                            </option>
                        @endfor
                    </select>

                    <select name="tahun" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-[10px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer">
                        @for ($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>

                    <button type="submit" class="bg-maroon-900 text-white px-4 py-2 rounded-xl text-[10px] sm:text-xs font-bold hover:bg-maroon-800 transition shadow-sm active:scale-95 cursor-pointer">
                        Filter
                    </button>
                </form>
            </div>
        </div>

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
                            <div class="flex flex-col sm:flex-row gap-1.5 items-center justify-center">

                                @php
                                    // LOGIKA WARNA MURNI TANPA SINGKATAN TEKS
                                    $ciName = isset($p->statusCi) ? $p->statusCi->name : 'Alfa';
                                    $colorCi = match($ciName) {
                                        'Tepat Waktu' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Terlambat' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        default => 'bg-rose-50 text-rose-600 border-rose-200' // Alfa
                                    };

                                    $coName = isset($p->statusCo) ? $p->statusCo->name : 'Belum CO';
                                    $colorCo = match($coName) {
                                        'Tepat Waktu', 'Check Out' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Terlambat CO' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Belum CO' => 'bg-slate-50 text-slate-500 border-slate-200',
                                        'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        default => 'bg-rose-50 text-rose-600 border-rose-200' // Lupa CO
                                    };
                                @endphp

                                <span class="inline-flex items-center px-3 py-1.5 {{ $colorCi }} border rounded-md text-[9px] font-black uppercase tracking-widest justify-center whitespace-nowrap">
                                    IN: {{ $ciName }}
                                </span>

                                <span class="inline-flex items-center px-3 py-1.5 {{ $colorCo }} border rounded-md text-[9px] font-black uppercase tracking-widest justify-center whitespace-nowrap mt-1 sm:mt-0">
                                    OUT: {{ $coName }}
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
