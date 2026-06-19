@extends('layouts.pembimbing')
@section('page_title', 'Data Siswa Bimbingan')

@section('content')
<style>
    .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 8px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 space-y-6 sm:space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/60 backdrop-blur-md p-4 sm:p-6 rounded-3xl sm:rounded-[2.5rem] border border-maroon-100/50 shadow-sm">
        <div class="flex items-center gap-3 sm:gap-4 pl-1 sm:pl-2">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-xl sm:rounded-2xl flex items-center justify-center text-maroon-900 shadow-sm border border-maroon-50 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-[22px] sm:h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M7 21v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/></svg>
            </div>
            <div>
                <h2 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight leading-none">Anak Bimbingan</h2>
                <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 line-clamp-1">Data profil siswa magang Anda</p>
            </div>
        </div>

        <form id="filterForm" method="GET" action="{{ route('pembimbing.data-siswa.index') }}" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto mt-2 md:mt-0">

            <select name="status" onchange="submitForm()" class="bg-white border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:py-3.5 text-[11px] sm:text-xs font-bold text-maroon-950 shadow-sm hover:border-maroon-200 focus:border-maroon-500 outline-none cursor-pointer w-full sm:w-auto appearance-none">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Hanya Aktif</option>
                <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif / Selesai</option>
            </select>

            <div class="relative group w-full sm:w-80">
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau NIS..." class="w-full bg-white border-2 border-slate-100 rounded-xl sm:rounded-2xl px-10 sm:px-12 py-3 sm:py-3.5 text-[11px] sm:text-xs font-bold text-maroon-950 shadow-sm hover:border-maroon-200 focus:border-maroon-500 focus:ring-4 focus:ring-maroon-500/10 outline-none transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 sm:left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-maroon-500 transition-colors duration-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
        </form>
    </div>

    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[850px]">
                <thead>
                    <tr class="bg-maroon-50/30">
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Identitas Siswa</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">NIS</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Asal Sekolah</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50/50">
                    @forelse($siswa as $s)
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200 group">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-lg text-maroon-900 shrink-0 border-2 border-white group-hover:border-maroon-100 transition-all shadow-inner overflow-hidden">
                                    @if($s->foto_profil)
                                        <img src="{{ asset('storage/' . $s->foto_profil) }}" alt="Foto" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-tight group-hover:text-maroon-700 transition-colors">{{ $s->nama_lengkap }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter italic">{{ $s->no_hp ?? 'Tanpa No. HP' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold font-mono border border-slate-200">{{ $s->nis ?? '-' }}</span>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <p class="text-xs font-bold text-slate-700 uppercase tracking-tight leading-none">{{ $s->sekolah_asal ?? '-' }}</p>
                            <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase">{{ $s->jurusan ?? '-' }}</p>
                        </td>
                        <td class="px-10 py-6 text-center">
                            @if($s->status == 'Aktif')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter shadow-sm">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-tighter shadow-sm">
                                    <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end opacity-100 lg:opacity-60 lg:group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('pembimbing.data-siswa.show', $s->id_siswa) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[9px] font-black text-maroon-700 bg-maroon-50 border border-maroon-100 rounded-lg hover:bg-maroon-900 hover:text-white transition-all uppercase tracking-widest shadow-sm">
                                    Profil
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                            Data anak bimbingan tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($siswa->hasPages())
        <div class="px-10 py-6 border-t border-maroon-50 bg-maroon-50/10">
            {{ $siswa->links() }}
        </div>
        @else
        <div class="px-10 py-8 border-t border-maroon-50 bg-maroon-50/10 flex items-center justify-between">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Menampilkan seluruh {{ $siswa->count() }} data siswa</p>
        </div>
        @endif

    </section>
</main>

<script>
    function submitForm() {
        document.getElementById('filterForm').submit();
    }

    let typingTimer;
    const inputElement = document.getElementById('searchInput');

    inputElement.addEventListener('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(submitForm, 800);
    });

    inputElement.addEventListener('keydown', function () {
        clearTimeout(typingTimer);
    });
</script>
@endsection
