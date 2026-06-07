@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10 space-y-8 animate-in">
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-5 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-5 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-black text-maroon-950 tracking-tight italic">Penerbitan Sertifikat</h2>
            <p class="text-sm font-bold text-slate-500 mt-1">Kelola dan terbitkan nomor sertifikat resmi untuk siswa magang.</p>
        </div>
    </div>

    <section class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-maroon-950 text-white">
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-center w-16">No</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest">Siswa & Instansi</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-center">Nilai Rata-Rata</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest">Input Nomor Sertifikat Resmi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($penilaian as $index => $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-5 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                        <td class="px-6 py-5">
                            <p class="font-black text-maroon-950 text-sm">{{ $p->siswa->nama_lengkap }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $p->siswa->sekolah_asal }}</p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex items-center justify-center bg-slate-100 text-maroon-900 font-black text-sm w-12 h-12 rounded-xl border border-slate-200">
                                {{ number_format($p->rata_rata, 2, ',', '') }}
                            </span>
                        </td>
                        <td class="px-6 py-5 flex items-center gap-3">
                            <form action="{{ route('admin.sertifikat.update', $p->id_penilaian) }}" method="POST" class="flex items-center gap-3">
                                @csrf @method('PUT')
                                <input type="text" name="nomor_sertifikat" value="{{ $p->nomor_sertifikat }}" required class="w-48 bg-white border-2 border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700 outline-none">
                                <button type="submit" class="bg-maroon-900 text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase hover:bg-maroon-800 transition">Save</button>
                            </form>

                            @if($p->nomor_sertifikat)
                                <a href="{{ route('admin.sertifikat.cetak', $p->id_penilaian) }}" target="_blank" class="bg-emerald-600 text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase hover:bg-emerald-700 transition">
                                    Cetak
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Belum ada data nilai yang diinput oleh Pembimbing.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
