@extends('layouts.pembimbing')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10">

    <section class="animate-in space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <p class="text-slate-500 font-medium text-base italic leading-none mb-2 text-maroon-900/40">Laporan Aktivitas Harian,</p>
                <h2 class="text-3xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-tight italic">Pantau Jurnal <br><span class="text-gold tracking-normal not-italic">Anak Bimbingan</span></h2>
            </div>
            <form action="{{ route('pembimbing.monitoring.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full md:w-64 bg-white border border-maroon-100 rounded-2xl px-10 py-3 text-xs font-bold text-maroon-900 shadow-sm focus:ring-2 focus:ring-maroon-500 outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 top-1/2 -translate-y-1/2 text-maroon-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse($anakBimbingan as $s)
            <div class="bg-white rounded-[2.5rem] p-8 border border-maroon-50 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group flex flex-col h-full">
                <div class="flex items-center gap-5 mb-8">
                    <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center text-2xl font-black text-maroon-900 border-2 border-white group-hover:border-maroon-200 transition-all shadow-inner overflow-hidden">
                        {{ substr($s->nama_lengkap, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-maroon-950 leading-none tracking-tight">{{ $s->nama_lengkap }}</h4>
                        <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest italic">{{ $s->sekolah_asal ?? 'Instansi Tidak Diisi' }}</p>
                    </div>
                </div>

                <div class="flex-1 space-y-4">
                    <div class="flex justify-between items-center px-4 py-3 bg-maroon-50 rounded-2xl border border-maroon-100/50 text-center">
                        <div>
                            <p class="text-xl font-black text-maroon-950 leading-none">{{ $s->logbook_count }}</p>                            <p class="text-xl font-black text-maroon-950 leading-none">{{ $s->total_log }}</p>
                        </div>
                        <div class="w-[1px] h-6 bg-maroon-200"></div>
                        <div>
                            <p class="text-[8px] font-black text-maroon-300 uppercase tracking-widest mb-1 leading-none text-nowrap">Belum Divalidasi</p>
                            <p class="text-xl font-black {{ $s->belum_divalidasi > 0 ? 'text-amber-500' : 'text-emerald-600' }} leading-none">
                                {{ sprintf("%02d", $s->belum_divalidasi) }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-2 Indians-none">Update Terakhir</p>
                        @if($s->log_terakhir)
                            <p class="text-[11px] font-bold text-slate-600 leading-snug italic">"{{ Str::limit($s->log_terakhir->description, 60) }}"</p>
                            <p class="text-[9px] font-bold text-slate-400 mt-2">{{ \Carbon\Carbon::parse($s->log_terakhir->report_date)->translatedFormat('d F Y • H:i') }} WITA</p>
                        @else
                            <p class="text-[11px] font-bold text-slate-400 leading-snug italic">"Belum pernah mengisi logbook harian."</p>
                        @endif
                    </div>
                </div>

                <a href="{{ route('pembimbing.monitoring.show', $s->id_siswa) }}" class="mt-8 w-full bg-maroon-950 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-maroon-950/20 active:scale-95 transition-all flex items-center justify-center gap-2 group-hover:bg-maroon-800">
                    Buka Jurnal Kegiatan
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>
            @empty
            <div class="col-span-full bg-white p-10 rounded-[2.5rem] text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                Tidak ada data anak bimbingan.
            </div>
            @endforelse

        </div>
    </section>
</main>
@endsection
