@extends('layouts.admin')
@section('page_title', 'Riwayat Presensi')

@section('content')
<main class="max-w-7xl mx-auto w-full p-6 lg:p-10 space-y-6 animate-in fade-in slide-in-from-right-8 duration-500">

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
                    @if(isset($foto_profil) && $foto_profil)
                        <img src="{{ asset('storage/' . $foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                    @else
                        {{-- Jika tidak ada foto, tampilkan inisial huruf depan --}}
                        {{ substr($nama_lengkap ?? 'A', 0, 1) }}
                    @endif
                </div>
                <div>
                    <p class="text-[10px] font-black text-amber-400 uppercase tracking-[0.2em] mb-1.5 leading-none">{{ $role ?? 'Siswa Magang' }}</p>
                    <h2 class="text-3xl font-black tracking-tight text-white leading-tight">{{ $nama_lengkap ?? 'Nama User' }}</h2>
                    <p class="text-maroon-200 text-xs font-bold uppercase mt-2 tracking-widest leading-none">{{ $instansi ?? 'Instansi / Unit' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-4 sm:flex sm:items-center sm:justify-start gap-y-4 gap-x-1 sm:gap-4 bg-black/20 p-4 rounded-2xl border border-white/10 backdrop-blur-sm w-full xl:w-auto shrink-0">

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Tepat CI</p>
                    <p class="text-lg sm:text-xl font-black text-emerald-400 leading-none">{{ $statistik['Tepat CI'] ?? 0 }}</p>
                </div>

                <!-- Garis Pemisah (Disembunyikan di HP) -->
                <div class="hidden sm:block w-[1px] h-8 bg-white/10 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Telat CI</p>
                    <p class="text-lg sm:text-xl font-black text-amber-400 leading-none">{{ $statistik['Telat CI'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-white/10 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Alpa</p>
                    <p class="text-lg sm:text-xl font-black text-rose-400 leading-none">{{ $statistik['Alpa'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-white/10 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Libur</p>
                    <p class="text-lg sm:text-xl font-black text-blue-400 leading-none">{{ $statistik['Libur'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-white/10 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Tepat CO</p>
                    <p class="text-lg sm:text-xl font-black text-emerald-400 leading-none">{{ $statistik['Tepat CO'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-white/10 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Terlambat CO</p>
                    <p class="text-lg sm:text-xl font-black text-amber-400 leading-none">{{ $statistik['Telat CO'] ?? 0 }}</p>
                </div>

                <div class="hidden sm:block w-[1px] h-8 bg-white/10 shrink-0"></div>

                <div class="text-center shrink-0">
                    <p class="text-[7px] sm:text-[8px] font-black text-maroon-300 uppercase tracking-widest mb-1 sm:mb-1.5 line-clamp-1">Lupa CO</p>
                    <p class="text-lg sm:text-xl font-black text-rose-400 leading-none">{{ $statistik['Lupa CO'] ?? 0 }}</p>
                </div>

            </div>

        </div>
    </div>

    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="px-6 sm:px-8 py-6 border-b border-slate-100 flex flex-col xl:flex-row xl:items-center justify-between gap-6 bg-white">
            <div>
                <h3 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight leading-none italic">Data Riwayat Presensi</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 line-clamp-1">Filter laporan berdasarkan bulan dan tahun</p>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-5 w-full xl:w-auto">
                <form action="{{ route('admin.riwayat.detail', $id_user ?? 1) }}" method="GET" class="flex flex-wrap items-center gap-2 sm:gap-3 w-full sm:w-auto">
                    <div class="relative flex-1 sm:flex-none">
                        <select name="bulan" class="w-full appearance-none bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 pr-10 text-[10px] sm:text-xs font-bold text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ ($bulan ?? date('m')) == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>

                    <div class="relative w-[35%] sm:w-auto">
                        <select name="tahun" class="w-full appearance-none bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 pr-10 text-[10px] sm:text-xs font-bold text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                            @for ($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ ($tahun ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>

                    <button type="submit" class="w-full sm:w-auto bg-maroon-950 text-white px-5 py-2.5 rounded-xl shadow-md hover:bg-maroon-800 active:scale-95 transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.3-4.3"/><circle cx="10" cy="10" r="7"/></svg>
                        <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest">Filter</span>
                    </button>
                </form>

                <div class="hidden sm:block w-[1px] h-8 bg-slate-200"></div>

                <a href="{{ route('admin.riwayat.cetak', ['id_user' => $id_user ?? 1, 'bulan' => request('bulan', date('m')), 'tahun' => request('tahun', date('Y'))]) }}" target="_blank" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-rose-50 border border-rose-200 text-rose-600 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest hover:bg-rose-100 transition-colors shadow-sm active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                    Export PDF
                </a>
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tap In</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tap Out</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    @forelse($riwayat ?? [] as $r)
                        @if(isset($r->id_presensi))
                            <tr onclick="window.location.href='{{ route('presensi.detail', $r->id_presensi) }}'" class="hover:bg-slate-50/80 transition-colors group cursor-pointer">
                        @else
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                        @endif

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

                                    @php
                                        // LOGIKA WARNA (Cukup urus warna saja, teks murni dari DB)
                                        $ciName = isset($r->statusCi) ? $r->statusCi->name : 'Alpa';
                                        $colorCi = match($ciName) {
                                            'Tepat Waktu' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                            'Terlambat' => 'bg-amber-50 text-amber-600 border-amber-200',
                                            'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'Belum Presensi' => 'bg-slate-50 text-slate-500 border-slate-200',
                                            default => 'bg-rose-50 text-rose-600 border-rose-200' // Alpa
                                        };

                                        $coName = isset($r->statusCo) ? $r->statusCo->name : 'Belum CO';
                                        $colorCo = match($coName) {
                                            'Tepat Waktu', 'Check Out' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                            'Terlambat CO' => 'bg-amber-50 text-amber-600 border-amber-200',
                                            'Belum CO' => 'bg-slate-50 text-slate-500 border-slate-200',
                                            'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'Belum Presensi' => 'bg-slate-50 text-slate-500 border-slate-200',
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
                                @if(isset($r->alasan) && $r->alasan)
                                    <div class="mt-1 text-[10px] text-amber-600 font-bold italic max-w-[180px] md:max-w-[250px] truncate text-center mx-auto bg-amber-50 border border-amber-200 px-2 py-0.5 rounded" title="{{ $r->alasan }}">
                                        💬 Alasan: {{ $r->alasan }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 font-bold text-slate-400 text-sm">Belum ada riwayat presensi yang tercatat pada filter ini.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
