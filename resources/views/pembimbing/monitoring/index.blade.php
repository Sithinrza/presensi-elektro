@extends('layouts.pembimbing')
@section('page_title', 'Logbook')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 animate-in">

    <section class="space-y-6 sm:space-y-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/60 backdrop-blur-md p-4 sm:p-6 rounded-3xl sm:rounded-[2.5rem] border border-maroon-100/50 shadow-sm">
            <div class="flex items-center gap-3 sm:gap-4 pl-1 sm:pl-2">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-xl sm:rounded-2xl flex items-center justify-center text-maroon-900 shadow-sm border border-maroon-50 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-[22px] sm:h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight leading-none">Logbook</h2>
                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 line-clamp-1">Validasi Logbook Siswa Magang</p>
                </div>
            </div>

            <form action="{{ route('pembimbing.monitoring.index') }}" method="GET" class="relative group w-full md:w-auto mt-2 md:mt-0">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peserta magang..." class="w-full md:w-80 bg-white border-2 border-slate-100 rounded-xl sm:rounded-2xl px-10 sm:px-12 py-3 sm:py-3.5 text-[11px] sm:text-xs font-bold text-maroon-950 shadow-sm hover:border-maroon-200 focus:border-maroon-500 focus:ring-4 focus:ring-maroon-500/10 outline-none transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 sm:left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-maroon-500 transition-colors duration-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <button type="submit" class="absolute right-1.5 sm:right-2 top-1/2 -translate-y-1/2 bg-maroon-950 text-white p-2 rounded-lg sm:rounded-xl hover:bg-maroon-800 transition-colors active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 sm:gap-6 xl:gap-8">

            @forelse($anakBimbingan as $s)
            <div class="relative bg-white rounded-3xl sm:rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-maroon-100 transition-all duration-300 group flex flex-col overflow-hidden">

                <div class="h-16 sm:h-20 bg-maroon-950 relative overflow-hidden shrink-0">
                    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#d8b98b 1.5px, transparent 1.5px); background-size: 16px 16px;"></div>
                </div>

                <div class="px-5 pb-5 sm:px-6 sm:pb-6 relative flex flex-col flex-1">

                    <div class="flex justify-between items-end -mt-8 sm:-mt-10 mb-4 sm:mb-5">
                        <div class="relative w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl sm:rounded-[1.5rem] p-1 shadow-sm">
                            <div class="w-full h-full bg-slate-100 rounded-xl sm:rounded-[1.2rem] flex items-center justify-center font-black text-2xl sm:text-3xl text-maroon-900 overflow-hidden border border-slate-200 group-hover:border-maroon-200 transition-colors shadow-inner">
                                @if($s->foto_profil)
                                    <img src="{{ asset('storage/' . $s->foto_profil) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($s->nama_lengkap, 0, 1) }}
                                @endif
                            </div>
                        </div>

                        @if(($s->belum_divalidasi ?? 0) > 0)
                            <div class="mb-2 mr-1 px-3 py-1 bg-amber-50 border border-amber-200 text-amber-600 rounded-full text-[8px] sm:text-[9px] font-black uppercase tracking-widest flex items-center gap-1.5 shadow-sm">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                Perlu Review
                            </div>
                        @endif
                    </div>

                    <div class="mb-5">
                        <h4 class="text-lg sm:text-xl font-black text-maroon-950 truncate tracking-tight group-hover:text-maroon-700 transition-colors">{{ $s->nama_lengkap }}</h4>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] truncate mt-1">{{ $s->sekolah_asal ?? 'Instansi Tidak Diisi' }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-3 flex flex-col justify-center text-center group-hover:border-maroon-50 transition-colors">
                            <p class="text-xl sm:text-2xl font-black text-maroon-900 leading-none">{{ $s->logbook_count ?? $s->total_log ?? 0 }}</p>
                            <p class="text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Total Jurnal</p>
                        </div>
                        <div class="bg-amber-50/50 border border-amber-100 rounded-2xl p-3 flex flex-col justify-center text-center group-hover:bg-amber-50 transition-colors">
                            <p class="text-xl sm:text-2xl font-black {{ ($s->belum_divalidasi > 0) ? 'text-amber-500' : 'text-emerald-600' }} leading-none">
                                {{ sprintf("%02d", $s->belum_divalidasi ?? 0) }}
                            </p>
                            <p class="text-[8px] sm:text-[9px] font-bold text-amber-700/60 uppercase tracking-widest mt-1.5 line-clamp-1">Tertunda</p>
                        </div>
                    </div>

                    <div class="mt-auto mb-5 sm:mb-6 p-3.5 sm:p-4 bg-slate-50/70 rounded-xl sm:rounded-2xl border border-slate-100/80">
                        <p class="text-[8px] sm:text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1.5 sm:mb-2 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            Log Terakhir
                        </p>
                        @if($s->log_terakhir)
                            <p class="text-[9px] sm:text-[10px] font-bold text-slate-600 leading-relaxed italic line-clamp-2">"{{ $s->log_terakhir->description ?? $s->log_terakhir->uraian }}"</p>
                            <p class="text-[8px] font-bold text-maroon-400 mt-2 sm:mt-2.5">{{ \Carbon\Carbon::parse($s->log_terakhir->report_date ?? $s->log_terakhir->tanggal)->translatedFormat('d M Y • H:i') }} WITA</p>
                        @else
                            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 leading-snug italic">Belum pernah mengisi logbook harian.</p>
                        @endif
                    </div>

                    <a href="{{ route('pembimbing.monitoring.show', $s->id_siswa) }}" class="w-full bg-slate-50 border border-slate-100 text-slate-500 py-3 sm:py-3.5 rounded-xl sm:rounded-2xl text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em] flex items-center justify-center gap-2 group-hover:bg-maroon-950 group-hover:text-white group-hover:border-maroon-950 group-hover:shadow-lg group-hover:shadow-maroon-950/20 active:scale-95 transition-all duration-300 z-10">
                        Buka Detail Jurnal
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
            </div>
            @empty

            <div class="col-span-full bg-white/50 backdrop-blur-sm p-8 sm:p-12 rounded-3xl sm:rounded-[3rem] border-2 border-dashed border-maroon-100 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white shadow-sm text-maroon-200 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/></svg>
                </div>
                <h3 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight mb-2">Belum Ada Peserta Magang</h3>
                <p class="text-xs sm:text-sm font-medium text-slate-500 max-w-md">Data peserta magang yang berada di bawah bimbingan Anda, atau hasil pencarian Anda tidak ditemukan.</p>
            </div>
            @endforelse

        </div>
    </section>
</main>
@endsection
