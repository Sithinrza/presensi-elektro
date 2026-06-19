@extends($layout)
@section('page_title', 'Riwayat Presensi')

@section('content')

{{-- RIWAYAT PRESENSI TENDIK DAN SISWA --}}
<main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-10 space-y-6 lg:space-y-8">
    <section class="bg-white rounded-[2rem] lg:rounded-[2.5rem] p-5 lg:p-8 border border-maroon-100 shadow-sm">
        <form action="{{ route('presensi.riwayat-presensi') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-4 lg:gap-6">
            <div class="text-center md:text-left">
                <h2 class="text-lg lg:text-xl font-black text-maroon-950 tracking-tight italic">Filter Periode</h2>
                <p class="text-xs lg:text-sm text-slate-500 font-medium mt-1">Lihat data kehadiran bulan ini.</p>
            </div>

            <div class="flex flex-wrap items-center justify-center md:justify-end gap-2 lg:gap-3 w-full md:w-auto">
                <select name="bulan" class="flex-1 md:flex-none bg-maroon-50 border-none rounded-xl lg:rounded-2xl px-3 lg:px-5 py-2.5 lg:py-3.5 text-xs lg:text-sm font-bold text-maroon-900 focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                <select name="tahun" class="flex-1 md:flex-none bg-maroon-50 border-none rounded-xl lg:rounded-2xl px-3 lg:px-5 py-2.5 lg:py-3.5 text-xs lg:text-sm font-bold text-maroon-900 focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                    @for ($y = date('Y'); $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <button type="submit" class="w-full md:w-auto bg-maroon-900 text-white px-5 lg:px-6 py-2.5 lg:py-3.5 rounded-xl lg:rounded-2xl text-xs lg:text-sm font-bold shadow-lg hover:bg-maroon-800 transition-all mt-2 md:mt-0">
                    <span>Cari Data</span>
                </button>
            </div>
        </form>
    </section>

    <div class="space-y-1.5 sm:space-y-2">
        <section class="grid grid-cols-2 md:grid-cols-4 gap-1.5 sm:gap-2">
            <div class="bg-emerald-50 border border-emerald-100 p-2 sm:p-2.5 rounded-xl sm:rounded-2xl flex flex-col items-center justify-center shadow-sm">
                <span class="text-lg sm:text-xl font-black text-emerald-600 leading-none">{{ $hadir ?? 0 }}</span>
                <span class="text-[7px] sm:text-[8px] text-emerald-700/70 font-bold mt-1 uppercase tracking-widest text-center">Tepat CI</span>
            </div>

            <div class="bg-amber-50 border border-amber-100 p-2 sm:p-2.5 rounded-xl sm:rounded-2xl flex flex-col items-center justify-center shadow-sm">
                <span class="text-lg sm:text-xl font-black text-amber-600 leading-none">{{ $telat ?? 0 }}</span>
                <span class="text-[7px] sm:text-[8px] text-amber-700/70 font-bold mt-1 uppercase tracking-widest text-center">Telat CI</span>
            </div>

            <div class="bg-rose-50 border border-rose-100 p-2 sm:p-2.5 rounded-xl sm:rounded-2xl flex flex-col items-center justify-center shadow-sm">
                <span class="text-lg sm:text-xl font-black text-rose-600 leading-none">{{ $alpa ?? 0 }}</span>
                <span class="text-[7px] sm:text-[8px] text-rose-700/70 font-bold mt-1 uppercase tracking-widest text-center">Alpa</span>
            </div>

            <div class="bg-blue-50 border border-blue-100 p-2 sm:p-2.5 rounded-xl sm:rounded-2xl flex flex-col items-center justify-center shadow-sm">
                <span class="text-lg sm:text-xl font-black text-blue-600 leading-none">{{ $libur ?? 0 }}</span>
                <span class="text-[7px] sm:text-[8px] text-blue-700/70 font-bold mt-1 uppercase tracking-widest text-center">Libur</span>
            </div>
        </section>

        <section class="grid grid-cols-3 gap-1.5 sm:gap-2">
            <div class="bg-emerald-50 border border-emerald-100 p-2 sm:p-2.5 rounded-xl sm:rounded-2xl flex flex-col items-center justify-center shadow-sm">
                <span class="text-lg sm:text-xl font-black text-emerald-600 leading-none">{{ $tepat_co ?? 0 }}</span>
                <span class="text-[7px] sm:text-[8px] text-emerald-700/70 font-bold mt-1 uppercase tracking-widest text-center">Tepat CO</span>
            </div>

            <div class="bg-amber-50 border border-amber-100 p-2 sm:p-2.5 rounded-xl sm:rounded-2xl flex flex-col items-center justify-center shadow-sm">
                <span class="text-lg sm:text-xl font-black text-amber-600 leading-none">{{ $telat_co ?? 0 }}</span>
                <span class="text-[7px] sm:text-[8px] text-amber-700/70 font-bold mt-1 uppercase tracking-widest text-center">Telat CO</span>
            </div>

            <div class="bg-rose-50 border border-rose-100 p-2 sm:p-2.5 rounded-xl sm:rounded-2xl flex flex-col items-center justify-center shadow-sm">
                <span class="text-lg sm:text-xl font-black text-rose-600 leading-none">{{ $lupa_co ?? 0 }}</span>
                <span class="text-[7px] sm:text-[8px] text-rose-700/70 font-bold mt-1 uppercase tracking-widest text-center">Lupa CO</span>
            </div>
        </section>
    </div>

    <section class="bg-white rounded-[2rem] lg:rounded-[2.5rem] border border-maroon-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto custom-scroll pb-2">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-maroon-900 text-white">
                        <th class="px-4 lg:px-8 py-4 lg:py-5 text-[10px] lg:text-xs font-bold uppercase tracking-widest whitespace-nowrap">Tanggal</th>
                        <th class="px-4 lg:px-8 py-4 lg:py-5 text-[10px] lg:text-xs font-bold uppercase tracking-widest text-center">Masuk</th>
                        <th class="px-4 lg:px-8 py-4 lg:py-5 text-[10px] lg:text-xs font-bold uppercase tracking-widest text-center">Pulang</th>
                        <th class="px-4 lg:px-8 py-4 lg:py-5 text-[10px] lg:text-xs font-bold uppercase tracking-widest">Status Kehadiran</th>
                        <th class="px-4 lg:px-8 py-4 lg:py-5 text-[10px] lg:text-xs font-bold uppercase tracking-widest text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50">
                    @forelse($riwayat as $r)

                    @if($r->id_presensi)
                        <tr onclick="window.location.href='{{ route('presensi.detail', $r->id_presensi) }}'" class="hover:bg-maroon-50/40 transition-colors cursor-pointer group">
                    @else
                        <tr class="bg-slate-50/30 transition-colors">
                    @endif

                        <td class="px-4 lg:px-8 py-4 lg:py-5 whitespace-nowrap">
                            @if($r->id_presensi)
                                <span class="text-xs lg:text-sm font-extrabold text-maroon-900 group-hover:text-maroon-600 transition-colors block">
                                    {{ Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d M Y') }}
                                </span>
                            @else
                                <span class="text-xs lg:text-sm font-extrabold text-slate-400 block">
                                    {{ Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d M Y') }}
                                </span>
                            @endif
                        </td>

                        <td class="px-4 lg:px-8 py-4 lg:py-5 text-center">
                            <span class="text-xs lg:text-sm font-bold {{ isset($r->id_presensi) ? 'text-slate-600' : 'text-slate-300' }} font-mono">{{ $r->jam_masuk ?? '--:--' }}</span>
                        </td>

                        <td class="px-4 lg:px-8 py-4 lg:py-5 text-center">
                            <span class="text-xs lg:text-sm font-bold {{ isset($r->id_presensi) ? 'text-slate-600' : 'text-slate-300' }} font-mono">{{ $r->jam_pulang ?? '--:--' }}</span>
                        </td>

                        <td class="px-4 lg:px-8 py-4 lg:py-5">
                            <div class="flex flex-col gap-1.5 items-start {{ isset($r->id_presensi) ? '' : 'opacity-60' }}">

                                @php
                                    $ciName = isset($r->statusCi) ? $r->statusCi->name : 'Alpa';
                                    $colorCi = match($ciName) {
                                        'Tepat Waktu' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Terlambat' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'Belum Presensi' => 'bg-slate-50 text-slate-500 border-slate-200',
                                        default => 'bg-rose-50 text-rose-600 border-rose-200'
                                    };

                                    $coName = isset($r->statusCo) ? $r->statusCo->name : 'Belum CO';
                                    $colorCo = match($coName) {
                                        'Tepat Waktu', 'Check Out' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Terlambat CO' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Belum CO' => 'bg-slate-50 text-slate-500 border-slate-200',
                                        'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'Belum Presensi' => 'bg-slate-50 text-slate-500 border-slate-200',
                                        default => 'bg-rose-50 text-rose-600 border-rose-200'
                                    };
                                @endphp

                                <span class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-1.5 {{ $colorCi }} border rounded-md text-[8px] lg:text-[9px] font-black uppercase tracking-widest justify-center whitespace-nowrap w-full sm:w-auto">
                                    IN: {{ $ciName }}
                                </span>

                                <span class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-1.5 {{ $colorCo }} border rounded-md text-[8px] lg:text-[9px] font-black uppercase tracking-widest justify-center whitespace-nowrap w-full sm:w-auto">
                                    OUT: {{ $coName }}
                                </span>
                                @if(isset($r->alasan) && $r->alasan)
                                    <div class="mt-1 text-[10px] text-amber-600 font-bold italic max-w-[150px] sm:max-w-full text-left bg-amber-50 border border-amber-200 px-2 py-0.5 rounded" title="{{ $r->alasan }}">
                                        💬 Alasan: {{ $r->alasan }}
                                    </div>
                                @endif

                            </div>
                        </td>

                        <!-- 🚨 TOMBOL DETAIL OPSI -->
                        <td class="px-4 lg:px-8 py-4 lg:py-5 text-center">
                            @if(isset($r->id_presensi))
                                <span class="inline-flex items-center justify-center gap-1 text-[10px] font-black text-maroon-700 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0 cursor-pointer">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center gap-1 text-[10px] font-black text-slate-300 uppercase tracking-widest cursor-not-allowed">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 lg:px-8 py-8 lg:py-10 text-center text-slate-400 font-bold uppercase text-[10px] lg:text-xs tracking-widest">Belum ada data presensi bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</main>
@endsection
