@extends('layouts.pembimbing')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10">

    <section id="view-master" class="animate-in space-y-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <p class="text-slate-500 font-medium text-base italic leading-none mb-2 text-maroon-900/40">Monitoring Kehadiran,</p>
                <h2 class="text-3xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-tight italic">Pilih Siswa <br><span class="text-gold tracking-normal not-italic">Untuk Lihat Riwayat</span></h2>
            </div>
            <form action="{{ route('pembimbing.presensi-siswa.index') }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full md:w-64 bg-white border border-maroon-100 rounded-2xl px-10 py-3 text-xs font-bold text-maroon-900 shadow-sm focus:ring-2 focus:ring-maroon-500 outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 top-1/2 -translate-y-1/2 text-maroon-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($anakBimbingan as $s)
            <a href="{{ route('pembimbing.presensi-siswa.show', $s->id_siswa) }}" class="bg-white rounded-[2.5rem] pt-8 border border-maroon-50 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all cursor-pointer group flex flex-col overflow-hidden">
                <div class="flex items-center gap-5 mb-6 px-8">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center font-black text-2xl text-maroon-900 border-2 border-white group-hover:border-maroon-200 shadow-inner overflow-hidden">
                            {{ substr($s->nama_lengkap, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-maroon-950 leading-none tracking-tight">{{ $s->nama_lengkap }}</h4>
                        <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest italic">{{ $s->sekolah_asal ?? 'Instansi Tidak Diisi' }}</p>
                    </div>
                </div>

                <div class="mt-auto border-t border-slate-100 bg-slate-50/50 p-5">
                    <div class="flex justify-between items-center text-center mb-4">
                        <div class="flex-1">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Tepat CI</p>
                            <p class="text-lg font-black text-emerald-600 leading-none">{{ $s->presensi->where('statusCi.name', 'Tepat Waktu')->count() }}</p>
                        </div>
                        <div class="flex-1 border-x border-slate-200">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Telat CI</p>
                            <p class="text-lg font-black text-amber-500 leading-none">{{ $s->presensi->where('statusCi.name', 'Terlambat')->count() }}</p>
                        </div>
                        <div class="flex-1">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Alfa</p>
                            <p class="text-lg font-black text-rose-500 leading-none">{{ $s->presensi->where('statusCi.name', 'Alfa')->count() }}</p>
                        </div>
                    </div>

                    <div class="flex justify-center gap-6 text-center pt-3 border-t border-slate-200/60">
                        <div class="flex-1">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Tepat CO</p>
                            <p class="text-lg font-black text-emerald-600 leading-none">{{ $s->presensi->where('statusCo.name', 'Tepat Waktu')->count() }}</p>
                        </div>
                        <div class="flex-1 border-l border-slate-200">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Lupa CO</p>
                            <p class="text-lg font-black text-rose-500 leading-none">{{ $s->presensi->where('statusCo.name', 'Lupa Check-Out')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-maroon-900 py-3 flex items-center justify-center gap-2 text-[10px] font-black text-white uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                    Lihat Detail Riwayat
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </a>
            @empty
            <div class="col-span-full bg-white p-10 rounded-[2.5rem] text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                Tidak ada data anak bimbingan.
            </div>
            @endforelse
        </div>
    </section>
</main>
@endsection
