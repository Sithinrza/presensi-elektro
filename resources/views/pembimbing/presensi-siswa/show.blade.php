@extends('layouts.pembimbing')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10 space-y-8 animate-in">

    <section class="bg-maroon-900 rounded-[3rem] p-8 md:p-10 text-white shadow-premium relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div class="w-24 h-24 rounded-3xl border-2 border-gold/50 bg-white/10 flex items-center justify-center text-3xl font-black">
                {{ substr($siswa->nama_lengkap, 0, 1) }}
            </div>
            <div class="flex-1">
                <h2 class="text-3xl font-black italic">{{ $siswa->nama_lengkap }}</h2>
                <p class="text-maroon-100/70 italic">{{ $siswa->sekolah_asal }} | NIS: {{ $siswa->nis }}</p>
            </div>
            <div class="grid grid-cols-3 gap-6 text-center">
                <div><p class="text-[9px] text-maroon-300 uppercase">Hadir</p><p class="text-3xl font-black">{{ $statistik['Hadir'] }}</p></div>
                <div><p class="text-[9px] text-maroon-300 uppercase">Telat</p><p class="text-3xl font-black text-amber-400">{{ $statistik['Telat'] }}</p></div>
                <div><p class="text-[9px] text-maroon-300 uppercase">Alfa</p><p class="text-3xl font-black text-rose-400">{{ $statistik['Alfa'] }}</p></div>
            </div>
        </div>
    </section>

    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-maroon-50/30">
                <tr>
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest">Hari & Tanggal</th>
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-center">Masuk</th>
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-center">Pulang</th>
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-maroon-50">
                @forelse($riwayatPresensi as $p)
                <tr>
                    <td class="px-8 py-5 font-bold">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('l, d M Y') }}</td>
                    <td class="px-8 py-5 text-center italic">{{ $p->jam_masuk ?? '-' }}</td>
                    <td class="px-8 py-5 text-center italic">{{ $p->jam_pulang ?? '-' }}</td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase
                            {{ $p->status == 'Hadir' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                            {{ $p->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-10 text-center text-slate-400">Belum ada data presensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</main>
@endsection
