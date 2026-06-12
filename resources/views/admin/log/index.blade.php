@extends('layouts.admin')
@section('page_title', 'Logbook Siswa')

@section('content')
<main class="p-10 space-y-8 animate-in">

    <section class="bg-white rounded-[2.5rem] p-8 border border-maroon-50 shadow-premium">
        <form action="{{ route('admin.log') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">

            <div class="space-y-2">
                <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Cari Siswa</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau NIS..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 pl-10 text-xs font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Status Validasi</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-maroon-950 outline-none cursor-pointer focus:ring-2 focus:ring-maroon-500">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima (Accepted)</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Periode Bulan</label>
                <select name="bulan" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-maroon-950 outline-none cursor-pointer focus:ring-2 focus:ring-maroon-500">
                    <option value="all" {{ request('bulan') == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach($daftarBulan as $num => $namaBulan)
                        <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $namaBulan }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-maroon-950 text-white py-3.5 rounded-xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 active:scale-95 transition-all">
                Terapkan Filter
            </button>

        </form>
    </section>

    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-maroon-50/30">
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest w-1/5">Siswa & Tanggal</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest w-2/5 text-center">Uraian Pekerjaan</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest w-1/5 text-center">Status & Pembimbing</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest w-1/5 text-right">Catatan Respon</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50/50">

                    @forelse($logs as $log)
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200 group">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-lg text-maroon-900 shrink-0 border-2 border-white group-hover:border-maroon-100 transition-all shadow-inner overflow-hidden">
                                    @if($log->foto_profil)
                                        <img src="{{ asset('storage/' . $log->foto_profil) }}" alt="Foto {{ $log->nama_lengkap }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($log->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-tight">{{ $log->nama_siswa }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter italic">
                                        {{ \Carbon\Carbon::parse($log->report_date)->translatedFormat('l, d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-10 py-6">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 italic text-[11px] font-semibold text-slate-600 leading-relaxed {{ $log->status == 'ditolak' ? 'line-through opacity-70' : 'shadow-inner' }}">
                                "{{ $log->description }}"
                            </div>
                        </td>

                        <td class="px-10 py-6 text-center space-y-2">
                            @if($log->status == 'pending')
                                <span class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Menunggu</span>
                            @elseif($log->status == 'diterima')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Diterima ✅</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Ditolak ❌</span>
                            @endif

                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2">Oleh: {{ $log->nama_pembimbing }}</p>
                        </td>

                        <td class="px-10 py-6 text-right">
                            @if($log->catatan_pembimbing)
                                <p class="text-[10px] font-bold leading-snug italic {{ $log->status == 'diterima' ? 'text-emerald-700/60' : 'text-rose-700' }}">
                                    "{{ $log->catatan_pembimbing }}"
                                </p>
                            @else
                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">Belum ada respon</p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-10 py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                            Tidak ada data logbook yang ditemukan.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-10 py-6 border-t border-maroon-50 bg-maroon-50/10">
            {{ $logs->links() }}
        </div>
        @else
        <div class="px-10 py-8 border-t border-maroon-50 bg-maroon-50/10 flex items-center justify-between">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Menampilkan {{ $logs->count() }} data logbook</p>
        </div>
        @endif

    </section>
</main>
@endsection
