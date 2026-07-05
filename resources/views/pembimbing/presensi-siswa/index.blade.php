@extends('layouts.pembimbing')
@section('page_title', 'Siswa')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 animate-in">

    <section id="view-master" class="space-y-4 sm:space-y-10">

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

            <form method="GET" action="{{ route('pembimbing.presensi-siswa.index') }}" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <!-- Filter Status -->
                <select name="status" onchange="this.form.submit()" class="bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Hanya Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Hanya Nonaktif / Lulus</option>
                </select>

                <!-- Kolom Pencarian -->
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-maroon-500 shadow-sm w-full sm:w-48">
                    <button type="submit" class="bg-maroon-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-sm hover:bg-maroon-800 transition-all">
                        Cari
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('pembimbing.presensi-siswa.index') }}" class="bg-slate-100 text-slate-500 px-3 py-2.5 rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-6 xl:gap-8">

            @forelse($anakBimbingan ?? [] as $s)
            <a href="{{ route('pembimbing.presensi-siswa.show', $s->id_user) }}" class="relative bg-white rounded-[1.5rem] sm:rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-maroon-100 transition-all duration-300 group flex flex-col overflow-hidden">

                <div class="h-12 sm:h-20 bg-maroon-950 relative overflow-hidden shrink-0">
                    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#d8b98b 1.5px, transparent 1.5px); background-size: 16px 16px;"></div>
                </div>

                <div class="px-4 pb-4 sm:px-6 sm:pb-6 relative flex flex-col flex-1">

                    <div class="flex justify-between items-end -mt-6 sm:-mt-10 mb-3 sm:mb-5">
                        <div class="relative w-14 h-14 sm:w-20 sm:h-20 bg-white rounded-[1.2rem] sm:rounded-[1.5rem] p-1 shadow-sm">
                            <div class="w-full h-full bg-slate-100 rounded-[1rem] sm:rounded-[1.2rem] flex items-center justify-center font-black text-xl sm:text-3xl text-maroon-900 overflow-hidden border border-slate-200 group-hover:border-maroon-200 transition-colors">
                                @if($s->foto_profil)
                                    <img src="{{ asset('storage/' . $s->foto_profil) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($s->nama_lengkap, 0, 1) }}
                                @endif
                            </div>
                        </div>
                        <div class="w-7 h-7 sm:w-10 sm:h-10 bg-maroon-50 text-maroon-900 rounded-full flex items-center justify-center group-hover:bg-maroon-900 group-hover:text-white transition-colors shadow-sm mb-1 sm:mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-[18px] sm:h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-0.5 transition-transform"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                    </div>

                    <div class="mb-3 sm:mb-4">
                        <h4 class="text-base sm:text-xl font-black text-maroon-950 truncate tracking-tight group-hover:text-maroon-700 transition-colors">{{ $s->nama_lengkap }}</h4>
                        @if($s->status == 'Aktif')
                            <span class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest">Aktif</span>
                        @else
                            <span class="bg-rose-100 text-rose-700 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest">Selesai/Nonaktif</span>
                        @endif
                        <p class="text-[8px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] truncate mt-0.5 sm:mt-1">{{ $s->sekolah_asal ?? 'Instansi Tidak Diisi' }}</p>
                    </div>

                    <div class="mt-auto space-y-1.5 sm:space-y-2">
                        <div class="grid grid-cols-3 gap-1.5 sm:gap-2">
                            <div class="bg-emerald-50/70 border border-emerald-100 rounded-xl sm:rounded-2xl p-1.5 sm:p-3 text-center group-hover:bg-emerald-50 transition-colors">
                                <p class="text-sm sm:text-xl font-black text-emerald-600 leading-none">{{ $s->stat_tepat_ci }}</p>
                                <p class="text-[7px] sm:text-[8px] font-bold text-emerald-700/60 uppercase tracking-widest mt-1 line-clamp-1">Tepat CI</p>
                            </div>
                            <div class="bg-amber-50/70 border border-amber-100 rounded-xl sm:rounded-2xl p-1.5 sm:p-3 text-center group-hover:bg-amber-50 transition-colors">
                                <p class="text-sm sm:text-xl font-black text-amber-500 leading-none">{{ $s->stat_telat_ci }}</p>
                                <p class="text-[7px] sm:text-[8px] font-bold text-amber-700/60 uppercase tracking-widest mt-1 line-clamp-1">Telat CI</p>
                            </div>
                            <div class="bg-rose-50/70 border border-rose-100 rounded-xl sm:rounded-2xl p-1.5 sm:p-3 text-center group-hover:bg-rose-50 transition-colors">
                                <p class="text-sm sm:text-xl font-black text-rose-500 leading-none">{{ $s->stat_alpa }}</p>
                                <p class="text-[7px] sm:text-[8px] font-bold text-rose-700/60 uppercase tracking-widest mt-1 line-clamp-1">Alpa</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-1 sm:gap-1.5">
                            <div class="bg-slate-50 border border-slate-100 rounded-lg sm:rounded-xl p-1.5 sm:p-2 flex flex-col justify-center items-center group-hover:border-emerald-100 transition-colors">
                                <span class="text-[6px] sm:text-[8px] font-black text-slate-400 uppercase tracking-wider">Tepat CO</span>
                                <span class="text-[10px] sm:text-sm font-black text-slate-700 mt-0.5 sm:mt-1">{{ $s->stat_tepat_co }}</span>
                            </div>
                            <div class="bg-slate-50 border border-slate-100 rounded-lg sm:rounded-xl p-1.5 sm:p-2 flex flex-col justify-center items-center group-hover:border-amber-100 transition-colors">
                                <span class="text-[6px] sm:text-[8px] font-black text-slate-400 uppercase tracking-wider">Telat CO</span>
                                <span class="text-[10px] sm:text-sm font-black text-amber-500 mt-0.5 sm:mt-1">{{ $s->stat_telat_co }}</span>
                            </div>
                            <div class="bg-slate-50 border border-slate-100 rounded-lg sm:rounded-xl p-1.5 sm:p-2 flex flex-col justify-center items-center group-hover:border-rose-100 transition-colors">
                                <span class="text-[6px] sm:text-[8px] font-black text-slate-400 uppercase tracking-wider">Lupa CO</span>
                                <span class="text-[10px] sm:text-sm font-black text-rose-500 mt-0.5 sm:mt-1">{{ $s->stat_lupa_co }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @empty

            <div class="col-span-full bg-white/50 backdrop-blur-sm p-6 sm:p-12 rounded-[2rem] sm:rounded-[3rem] border-2 border-dashed border-maroon-100 flex flex-col items-center justify-center text-center">
                <div class="w-14 h-14 sm:w-20 sm:h-20 bg-white rounded-full shadow-sm flex items-center justify-center text-maroon-200 mb-3 sm:mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-10 sm:h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="text-base sm:text-xl font-black text-maroon-950 tracking-tight mb-1 sm:mb-2">Tidak Ada Data Siswa</h3>
                <p class="text-[10px] sm:text-sm font-medium text-slate-500 max-w-md mx-auto">Saat ini belum ada data anak bimbingan yang terkait dengan pencarian Anda.</p>
            </div>
            @endforelse

        </div>
    </section>
</main>
@endsection
