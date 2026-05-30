@extends('layouts.pembimbing')

@section('content')
<!-- KONTEN UTAMA SISWA BIMBINGAN -->
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 animate-in">

    <!-- VIEW 1: MASTER LIST (SEMUA SISWA) -->
    <section id="view-master" class="space-y-6 sm:space-y-10">

        <!-- HEADER & PENCARIAN (Desain Baru Minimalis & Responsif) -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/50 backdrop-blur-md p-4 sm:p-6 rounded-3xl sm:rounded-[2.5rem] border border-maroon-50/50 shadow-sm">
            <div class="flex items-center gap-3 sm:gap-4 pl-1 sm:pl-2">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-2xl flex items-center justify-center text-maroon-900 shadow-sm border border-maroon-50 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-[22px] sm:h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight leading-none">Presensi Siswa</h2>
                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 line-clamp-1">Pantau Rekapitulasi Kehadiran</p>
                </div>
            </div>

            <form action="{{ route('pembimbing.presensi-siswa.index') }}" method="GET" class="relative group w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full md:w-80 bg-white border-2 border-slate-100 rounded-2xl px-10 sm:px-12 py-3 sm:py-3.5 text-xs font-bold text-maroon-950 shadow-sm hover:border-maroon-200 focus:border-maroon-500 focus:ring-4 focus:ring-maroon-500/10 outline-none transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 sm:left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-maroon-500 transition-colors duration-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <button type="submit" class="absolute right-1.5 sm:right-2 top-1/2 -translate-y-1/2 bg-maroon-950 text-white p-2 rounded-xl hover:bg-maroon-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                </button>
            </form>
        </div>

        <!-- LIST CARDS GRID (Minimalist & Compact on Mobile) -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 xl:gap-8">

            @forelse($anakBimbingan ?? [] as $s)
            <a href="{{ route('pembimbing.presensi-siswa.show', $s->id_user) }}" class="relative bg-white rounded-3xl sm:rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-maroon-100 transition-all duration-300 group flex flex-col overflow-hidden">

                <!-- Card Banner Top (Diperkecil di mobile) -->
                <div class="h-16 sm:h-20 bg-maroon-950 relative overflow-hidden shrink-0">
                    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#d8b98b 1.5px, transparent 1.5px); background-size: 16px 16px;"></div>
                </div>

                <div class="px-5 pb-5 sm:px-6 sm:pb-6 relative flex flex-col flex-1">

                    <!-- Avatar & Quick Action Button -->
                    <div class="flex justify-between items-end -mt-8 sm:-mt-10 mb-4 sm:mb-5">
                        <div class="relative w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl sm:rounded-[1.5rem] p-1 shadow-sm">
                            <div class="w-full h-full bg-slate-100 rounded-xl sm:rounded-[1.2rem] flex items-center justify-center font-black text-2xl sm:text-3xl text-maroon-900 overflow-hidden border border-slate-200 group-hover:border-maroon-200 transition-colors">
                                <!-- Bisa diganti tag img jika ada foto -->
                                {{ substr($s->nama_lengkap, 0, 1) }}
                            </div>
                        </div>
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-maroon-50 text-maroon-900 rounded-full flex items-center justify-center group-hover:bg-maroon-900 group-hover:text-white transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-[18px] sm:h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-0.5 transition-transform"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                    </div>

                    <!-- Identitas Siswa -->
                    <div class="mb-4">
                        <h4 class="text-lg sm:text-xl font-black text-maroon-950 truncate tracking-tight group-hover:text-maroon-700 transition-colors">{{ $s->nama_lengkap }}</h4>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] truncate mt-1">{{ $s->sekolah_asal ?? 'Instansi Tidak Diisi' }}</p>
                    </div>

                    <!-- Statistik Presensi (Grid Rapat on Mobile) -->
                    <div class="mt-auto space-y-2">
                        <!-- Baris 1: Check In & Alpa -->
                        <div class="grid grid-cols-3 gap-2">
                            <div class="bg-emerald-50/70 border border-emerald-100 rounded-xl sm:rounded-2xl p-2 sm:p-3 text-center group-hover:bg-emerald-50 transition-colors">
                                <p class="text-lg sm:text-xl font-black text-emerald-600 leading-none">{{ collect($s->presensi)->where('statusCi.name', 'Tepat Waktu')->count() }}</p>
                                <p class="text-[8px] font-bold text-emerald-700/60 uppercase tracking-widest mt-1.5 line-clamp-1">Tepat CI</p>
                            </div>
                            <div class="bg-amber-50/70 border border-amber-100 rounded-xl sm:rounded-2xl p-2 sm:p-3 text-center group-hover:bg-amber-50 transition-colors">
                                <p class="text-lg sm:text-xl font-black text-amber-500 leading-none">{{ collect($s->presensi)->where('statusCi.name', 'Terlambat')->count() }}</p>
                                <p class="text-[8px] font-bold text-amber-700/60 uppercase tracking-widest mt-1.5 line-clamp-1">Telat CI</p>
                            </div>
                            <div class="bg-rose-50/70 border border-rose-100 rounded-xl sm:rounded-2xl p-2 sm:p-3 text-center group-hover:bg-rose-50 transition-colors">
                                <p class="text-lg sm:text-xl font-black text-rose-500 leading-none">{{ collect($s->presensi)->where('statusCi.name', 'Alfa')->count() }}</p>
                                <p class="text-[8px] font-bold text-rose-700/60 uppercase tracking-widest mt-1.5 line-clamp-1">Alfa</p>
                            </div>
                        </div>

                        <!-- Baris 2: Check Out -->
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-slate-50 border border-slate-100 rounded-xl sm:rounded-2xl p-2.5 sm:p-3 flex justify-between items-center px-3 sm:px-4 group-hover:border-maroon-100 transition-colors">
                                <span class="text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase tracking-widest">Tepat CO</span>
                                <span class="text-base sm:text-lg font-black text-slate-700">{{ collect($s->presensi)->where('statusCo.name', 'Tepat Waktu')->count() }}</span>
                            </div>
                            <div class="bg-slate-50 border border-slate-100 rounded-xl sm:rounded-2xl p-2.5 sm:p-3 flex justify-between items-center px-3 sm:px-4 group-hover:border-rose-100 transition-colors">
                                <span class="text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase tracking-widest">Lupa CO</span>
                                <span class="text-base sm:text-lg font-black text-rose-500">{{ collect($s->presensi)->where('statusCo.name', 'Lupa Check-Out')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @empty

            <!-- EMPTY STATE -->
            <div class="col-span-full bg-white/50 backdrop-blur-sm p-8 sm:p-12 rounded-3xl sm:rounded-[3rem] border-2 border-dashed border-maroon-100 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-full shadow-sm flex items-center justify-center text-maroon-200 mb-4 sm:mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight mb-2">Tidak Ada Data Siswa</h3>
                <p class="text-xs sm:text-sm font-medium text-slate-500 max-w-md mx-auto">Saat ini belum ada data anak bimbingan yang terkait dengan pencarian Anda.</p>
            </div>
            @endforelse

        </div>
    </section>
</main>
@endsection
