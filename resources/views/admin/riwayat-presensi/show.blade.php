@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-6 animate-in fade-in slide-in-from-right-8 duration-500">

    <button onclick="window.location.href='{{ url('/admin/riwayat-presensi') }}'" class="flex items-center gap-3 text-xs font-black text-slate-500 uppercase tracking-widest hover:text-maroon-700 transition-colors group w-fit mb-2">
        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm group-hover:scale-105 group-hover:border-maroon-200 group-hover:bg-maroon-50 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </div>
        Kembali ke Daftar
    </button>

    <div class="bg-maroon-900 rounded-3xl p-8 lg:p-10 text-white shadow-lg shadow-maroon-900/20 overflow-hidden border border-maroon-800 relative">
        <div class="absolute -top-20 -right-20 w-80 h-80 bg-amber-400/10 rounded-full blur-[80px] pointer-events-none"></div>

        <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-8">

            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl border-2 border-amber-400/50 bg-white/10 backdrop-blur-md flex items-center justify-center text-4xl font-black text-amber-400 shadow-inner overflow-hidden shrink-0">
                    {{ substr($nama_lengkap ?? 'A', 0, 1) }}
                </div>
                <div>
                    <p class="text-[10px] font-black text-amber-400 uppercase tracking-[0.2em] mb-1.5 leading-none">{{ $role ?? 'Siswa Magang' }}</p>
                    <h2 class="text-3xl font-black tracking-tight text-white leading-tight">{{ $nama_lengkap ?? 'Nama User' }}</h2>
                    <p class="text-maroon-200 text-xs font-bold uppercase mt-2 tracking-widest leading-none">{{ $instansi ?? 'Instansi / Unit' }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between sm:justify-start gap-4 sm:gap-6 bg-black/20 p-4 sm:p-5 rounded-2xl border border-white/10 backdrop-blur-sm overflow-x-auto no-scrollbar w-full xl:w-auto shrink-0">
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest mb-1.5">Tepat CI</p>
                    <p class="text-2xl font-black text-emerald-400 leading-none">{{ $statistik['Tepat CI'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-white/10 shrink-0"></div>
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest mb-1.5">Telat CI</p>
                    <p class="text-2xl font-black text-amber-400 leading-none">{{ $statistik['Telat CI'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-white/10 shrink-0"></div>
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest mb-1.5">Alfa</p>
                    <p class="text-2xl font-black text-rose-400 leading-none">{{ $statistik['Alfa'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-white/10 shrink-0"></div>
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest mb-1.5">Tepat CO</p>
                    <p class="text-2xl font-black text-emerald-400 leading-none">{{ $statistik['Tepat CO'] ?? 0 }}</p>
                </div>
                <div class="w-[1px] h-10 bg-white/10 shrink-0"></div>
                <div class="text-center shrink-0 px-2">
                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest mb-1.5">Lupa CO</p>
                    <p class="text-2xl font-black text-rose-400 leading-none">{{ $statistik['Lupa CO'] ?? 0 }}</p>
                </div>
            </div>

        </div>
    </div>

    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-black text-slate-800 tracking-tight">Data Riwayat Presensi</h3>
            <!-- Ganti <button> menjadi <a> -->
            <a href="{{ route('admin.riwayat.cetak', request()->route('id_user')) }}" target="_blank" class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-maroon-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                Export Riwayat
            </a>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse min-w-[600px]">
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
                        <tr onclick="window.location.href='{{ route('presensi.detail', $r->id_presensi) }}'" class="hover:bg-slate-50/80 transition-colors group cursor-pointer">

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
                                <div class="flex flex-col sm:flex-row gap-1.5 items-center justify-center">

                                    @if($r->statusCi && $r->statusCi->name == 'Tepat Waktu')
                                        <span class="w-fit px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-md text-[9px] font-black uppercase tracking-widest">CI: {{ $r->statusCi->name }}</span>
                                    @elseif($r->statusCi && $r->statusCi->name == 'Terlambat')
                                        <span class="w-fit px-3 py-1 bg-amber-50 text-amber-600 border border-amber-200 rounded-md text-[9px] font-black uppercase tracking-widest">CI: {{ $r->statusCi->name }}</span>
                                    @else
                                        <span class="w-fit px-3 py-1 bg-rose-50 text-rose-600 border border-rose-200 rounded-md text-[9px] font-black uppercase tracking-widest">CI: {{ $r->statusCi->name ?? 'Alfa' }}</span>
                                    @endif

                                    @if($r->statusCo)
                                        @if($r->statusCo->name == 'Tepat Waktu' || $r->statusCo->name == 'Check Out')
                                            <span class="w-fit px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-md text-[9px] font-black uppercase tracking-widest">CO: {{ $r->statusCo->name }}</span>
                                        @elseif($r->statusCo->name == 'Lupa Check-Out')
                                            <span class="w-fit px-3 py-1 bg-rose-50 text-rose-600 border border-rose-200 rounded-md text-[9px] font-black uppercase tracking-widest flex flex-col items-center">
                                                CO: {{ $r->statusCo->name }}
                                                @if($r->klaim)
                                                    <span class="text-[7px] mt-0.5 {{ $r->klaim->status_verifikasi == 'pending' ? 'text-amber-600' : ($r->klaim->status_verifikasi == 'disetujui' ? 'text-emerald-600' : 'text-rose-600') }}">
                                                        (Klaim: {{ ucfirst($r->klaim->status_verifikasi) }})
                                                    </span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="w-fit px-3 py-1 bg-rose-50 text-rose-600 border border-rose-200 rounded-md text-[9px] font-black uppercase tracking-widest">CO: {{ $r->statusCo->name }}</span>
                                        @endif
                                    @else
                                        <span class="w-fit px-3 py-1 bg-slate-50 text-slate-400 border border-slate-200 rounded-md text-[9px] font-black uppercase tracking-widest">CO: Belum</span>
                                    @endif

                                </div>
                            </td>

                            <td class="pr-6 text-right">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-slate-300 opacity-0 group-hover:opacity-100 group-hover:text-maroon-600 transition-all translate-x-2 group-hover:translate-x-0"><path d="m9 18 6-6-6-6"/></svg>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 font-bold text-slate-400 text-sm">Belum ada riwayat presensi yang tercatat.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
