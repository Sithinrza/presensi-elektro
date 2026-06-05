@extends($layout)

@section('content')

{{-- RIWAYAT PRESENSI TENDIK DAN SISWA --}}
<main class="max-w-7xl mx-auto p-5 lg:p-10 space-y-8">
    <section class="bg-white rounded-[2.5rem] p-6 lg:p-8 border border-maroon-100 shadow-sm">
        <form action="{{ route('presensi.riwayat-presensi') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-xl font-black text-maroon-950 tracking-tight italic">Filter Periode</h2>
                <p class="text-sm text-slate-500 font-medium">Lihat data kehadiran bulan ini.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <select name="bulan" class="bg-maroon-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-maroon-900 focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                <select name="tahun" class="bg-maroon-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-maroon-900 focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                    @for ($y = date('Y'); $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <button type="submit" class="bg-maroon-900 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg hover:bg-maroon-800 transition-all">
                    <span>Cari</span>
                </button>
            </div>
        </form>
    </section>

    <div class="space-y-4">
        <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
                <span class="text-3xl font-black text-emerald-600 leading-none">{{ $hadir ?? 0 }}</span>
                <span class="text-[10px] text-emerald-700/60 font-bold mt-2 uppercase tracking-widest">Tepat CI</span>
            </div>

            <div class="bg-amber-50 border border-amber-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
                <span class="text-3xl font-black text-amber-600 leading-none">{{ $telat ?? 0 }}</span>
                <span class="text-[10px] text-amber-700/60 font-bold mt-2 uppercase tracking-widest">Telat CI</span>
            </div>

            <div class="bg-rose-50 border border-rose-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
                <span class="text-3xl font-black text-rose-600 leading-none">{{ $alfa ?? 0 }}</span>
                <span class="text-[10px] text-rose-700/60 font-bold mt-2 uppercase tracking-widest">Alfa</span>
            </div>

            <div class="bg-blue-50 border border-blue-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
                <span class="text-3xl font-black text-blue-600 leading-none">{{ $libur ?? 0 }}</span>
                <span class="text-[10px] text-blue-700/60 font-bold mt-2 uppercase tracking-widest">Libur</span>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
                <span class="text-3xl font-black text-emerald-600 leading-none">{{ $tepat_co ?? 0 }}</span>
                <span class="text-[10px] text-emerald-700/60 font-bold mt-2 uppercase tracking-widest">Tepat CO</span>
            </div>

            <div class="bg-amber-50 border border-amber-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
                <span class="text-3xl font-black text-amber-600 leading-none">{{ $telat_co ?? 0 }}</span>
                <span class="text-[10px] text-amber-700/60 font-bold mt-2 uppercase tracking-widest">Telat CO</span>
            </div>

            <div class="bg-rose-50 border border-rose-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
                <span class="text-3xl font-black text-rose-600 leading-none">{{ $lupa_co ?? 0 }}</span>
                <span class="text-[10px] text-rose-700/60 font-bold mt-2 uppercase tracking-widest">Lupa CO</span>
            </div>
        </section>
    </div>

    <section class="bg-white rounded-[2.5rem] border border-maroon-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-maroon-900 text-white">
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-center">Masuk</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-center">Pulang</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50">
                    @forelse($riwayat as $r)
                    <tr class="hover:bg-maroon-50/40 transition-colors">
                        <td class="px-8 py-5">
                            @if($r->id_presensi)
                                <a href="{{ route('presensi.detail', $r->id_presensi) }}" class="text-sm font-extrabold text-maroon-900 hover:text-maroon-600 underline decoration-maroon-200 underline-offset-4 transition-colors">
                                    {{ Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                                </a>
                            @else
                                <span class="text-sm font-extrabold text-slate-400">
                                    {{ Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-sm font-bold text-slate-600 font-mono">{{ $r->jam_masuk ?? '--:--' }}</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-sm font-bold text-slate-600 font-mono">{{ $r->jam_pulang ?? '--:--' }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col sm:flex-row gap-1.5 items-start">

                                @php
                                    // LOGIKA WARNA MURNI TANPA SINGKATAN TEKS
                                    $ciName = isset($r->statusCi) ? $r->statusCi->name : 'Alfa';
                                    $colorCi = match($ciName) {
                                        'Tepat Waktu' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Terlambat' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        default => 'bg-rose-50 text-rose-600 border-rose-200' // Alfa
                                    };

                                    $coName = isset($r->statusCo) ? $r->statusCo->name : 'Belum CO';
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

                                <span class="inline-flex items-center px-3 py-1.5 {{ $colorCo }} border rounded-md text-[9px] font-black uppercase tracking-widest justify-center whitespace-nowrap">
                                    OUT: {{ $coName }}
                                </span>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-10 text-center text-slate-400 font-bold uppercase text-xs tracking-widest">Belum ada data presensi bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

@endsection
