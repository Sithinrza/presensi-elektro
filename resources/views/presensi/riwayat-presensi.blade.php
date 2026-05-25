@extends($layout)

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10 space-y-8">
    <section class="bg-white rounded-[2.5rem] p-6 lg:p-8 border border-maroon-100 shadow-sm">
        <form action="{{ route('presensi.riwayat-presensi') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-xl font-black text-maroon-950 tracking-tight italic">Filter Periode</h2>
                <p class="text-sm text-slate-500 font-medium">Lihat data kehadiran Anda bulan ini.</p>
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

    <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
            <span class="text-3xl font-black text-emerald-600 leading-none">{{ $hadir ?? 0 }}</span>
            <span class="text-[10px] text-emerald-700/60 font-bold mt-2 uppercase tracking-widest">Tepat Waktu</span>
        </div>

        <div class="bg-amber-50 border border-amber-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
            <span class="text-3xl font-black text-amber-600 leading-none">{{ $telat ?? 0 }}</span>
            <span class="text-[10px] text-amber-700/60 font-bold mt-2 uppercase tracking-widest">Terlambat</span>
        </div>

        <div class="bg-maroon-50 border border-maroon-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
            <span class="text-3xl font-black text-maroon-900 leading-none">{{ $alfa ?? 0 }}</span>
            <span class="text-[10px] text-maroon-700/60 font-bold mt-2 uppercase tracking-widest">Alfa</span>
        </div>
    </section>

    <section class="bg-white rounded-[2.5rem] border border-maroon-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-maroon-900 text-white">
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-center">Masuk</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-center">Pulang</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Status Harian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50">
                    @forelse($riwayat as $r)
                    <tr class="hover:bg-maroon-50/40 transition-colors">
                        <td class="px-8 py-5">
                            <p class="text-sm font-extrabold text-slate-800">
                                {{ Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                            </p>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-sm font-bold text-slate-600">{{ $r->jam_masuk ?? '--:--' }}</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-sm font-bold text-slate-600">{{ $r->jam_pulang ?? '--:--' }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1">
                                @if($r->statusCi && $r->statusCi->name == 'Tepat Waktu')
                                    <span class="w-fit px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[9px] font-black uppercase">CI: {{ $r->statusCi->name }}</span>
                                @elseif($r->statusCi && $r->statusCi->name == 'Terlambat')
                                    <span class="w-fit px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[9px] font-black uppercase">CI: {{ $r->statusCi->name }}</span>
                                @else
                                    <span class="w-fit px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-[9px] font-black uppercase">CI: {{ $r->statusCi->name ?? 'Alfa' }}</span>
                                @endif

                                @if($r->statusCo)
                                    @if($r->statusCo->name == 'Tepat Waktu')
                                        <span class="w-fit px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[9px] font-black uppercase">CO: {{ $r->statusCo->name }}</span>
                                    @else
                                        <span class="w-fit px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-[9px] font-black uppercase">CO: {{ $r->statusCo->name }}</span>
                                    @endif
                                @else
                                    <span class="w-fit px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[9px] font-black uppercase">CO: Belum</span>
                                @endif
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
