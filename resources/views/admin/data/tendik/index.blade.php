@extends('layouts.admin')
@section('page_title', 'Data Tendik')

@section('content')
<style>
    .modal-backdrop {
        background: rgba(43, 11, 22, 0.4);
        backdrop-filter: blur(4px);
    }

    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<main class="p-4 sm:p-6 lg:p-10 space-y-6 sm:space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 sm:px-5 py-3 sm:py-4 rounded-xl sm:rounded-2xl flex items-center gap-3 shadow-sm animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500 shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span class="text-xs sm:text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 sm:px-5 py-3 sm:py-4 rounded-xl sm:rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-rose-500 shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="text-xs sm:text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <section class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">

        <div class="flex items-center gap-4">
            <div class="bg-white border border-slate-100 p-5 sm:p-6 rounded-[2rem] shadow-sm flex items-center gap-4 w-auto min-w-[200px] pr-8">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-maroon-50 flex items-center justify-center text-maroon-700 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Tendik</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight leading-none">{{ $totalTendik ?? 0 }} <span class="text-xs font-bold text-slate-400 ml-1">Tendik</span></p>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.data.tendik.create') }}" class="group bg-maroon-900 text-white px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest shadow-lg shadow-maroon-900/20 hover:bg-maroon-950 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 flex items-center justify-center gap-3 w-full lg:w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[18px] sm:h-[18px] group-hover:rotate-90 transition-transform duration-300"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            Tambah Tendik Baru
        </a>
    </section>

    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">

        <div class="px-6 md:px-8 py-5 sm:py-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between sm:justify-end items-center gap-3 bg-white shrink-0">
            <form method="GET" action="{{ route('admin.data.tendik.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-center">

                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto bg-slate-50 border border-slate-200 text-slate-700 text-[10px] sm:text-xs font-bold rounded-xl px-4 py-2.5 sm:py-3 outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Hanya Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif / Selesai</option>
                </select>

                <div class="relative w-full md:w-80 group">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" onkeyup="filterTable()" placeholder="Cari Nama atau NIP..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-10 py-2.5 sm:py-3 text-[10px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[16px] sm:h-[16px] absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-maroon-500 transition-colors"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>

                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.data.tendik.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-rose-600 transition-colors" title="Reset Filter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[850px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Tendik</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">NIP / NIDN</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">Pangkat - Golongan</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="tableBody">

                    @forelse($tendik ?? [] as $t)
                    <tr class="tendik-row hover:bg-slate-50/80 transition-all duration-200 group">
                        <td class="px-6 sm:px-8 py-4">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0">
                                    @if($t->foto_profil)
                                        <img src="{{ asset('storage/' . $t->foto_profil) }}" alt="Foto {{ $t->nama_lengkap }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($t->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="tendik-name text-xs sm:text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-700 transition-colors">{{ $t->nama_lengkap }}</p>
                                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 mt-1 sm:mt-1.5 line-clamp-1">{{ $t->user->email ?? 'Tanpa Email' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 sm:px-8 py-4">
                            <span class="tendik-nip inline-flex items-center px-2 sm:px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] sm:text-xs font-bold font-mono border border-slate-200">
                                {{ $t->nip ?? 'Belum Diatur' }}
                            </span>
                        </td>
                        <td class="px-6 sm:px-8 py-4">
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 bg-slate-50 text-slate-600 border border-slate-200 rounded-md sm:rounded-lg text-[9px] sm:text-[10px] font-black uppercase tracking-tight">
                                @if($t->pangkatGolongan)
                                    {{ $t->pangkatGolongan->pangkat->nama_pangkat ?? 'Unknown' }} - {{ $t->pangkatGolongan->golongan->ruang ?? 'Unknown' }}
                                @else
                                    Belum Diatur
                                @endif
                            </span>
                        </td>
                        <td class="px-6 sm:px-8 py-4 text-center">
                            @if($t->status == 'Aktif')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 sm:px-3 sm:py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-md sm:rounded-lg text-[8px] sm:text-[9px] font-black uppercase tracking-widest shadow-sm">
                                    <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 sm:px-3 sm:py-1.5 bg-rose-50 text-rose-600 border border-rose-200 rounded-md sm:rounded-lg text-[8px] sm:text-[9px] font-black uppercase tracking-widest shadow-sm">
                                    <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 sm:px-8 py-4 text-center">
                            <div class="flex justify-center gap-1.5 sm:gap-2 opacity-100 lg:opacity-60 lg:group-hover:opacity-100 transition-opacity">

                                <div class="relative group/tooltip">
                                    <a href="{{ route('admin.data.tendik.show', $t->id_tendik) }}" class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg sm:rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[16px] sm:h-[16px]"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <span class="absolute -top-9 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[9px] font-bold px-2.5 py-1 rounded-md opacity-0 group-hover/tooltip:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-sm z-10">Lihat Detail</span>
                                </div>

                                <div class="relative group/tooltip">
                                    <a href="{{ route('admin.data.tendik.edit', $t->id_tendik) }}" class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg sm:rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-maroon-700 hover:border-maroon-200 transition-all shadow-sm active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[16px] sm:h-[16px]"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                    </a>
                                    <span class="absolute -top-9 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[9px] font-bold px-2.5 py-1 rounded-md opacity-0 group-hover/tooltip:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-sm z-10">Edit Data</span>
                                </div>

                                <div class="relative group/tooltip">
                                    <button type="button"
                                            onclick="confirmDelete('{{ route('admin.data.tendik.destroy', $t->id_tendik) }}')"
                                            class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg sm:rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all shadow-sm active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[16px] sm:h-[16px]"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                    <span class="absolute -top-9 left-1/2 -translate-x-1/2 bg-rose-600 text-white text-[9px] font-bold px-2.5 py-1 rounded-md opacity-0 group-hover/tooltip:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-sm z-10">Hapus Data</span>
                                </div>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 sm:px-8 py-12 sm:py-16 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mb-2 shadow-sm border border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[32px] sm:h-[32px]"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                                </div>
                                <p class="text-slate-500 font-bold text-xs sm:text-sm">Belum ada data Tenaga Kependidikan.</p>
                                <p class="text-slate-400 text-[10px] sm:text-xs">Silakan tambah tendik baru untuk mulai mengelola data.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                    <tr id="js-empty-state" style="display: none;">
                        <td colspan="5" class="px-6 sm:px-8 py-12 sm:py-16 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mb-2 border border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[32px] sm:h-[32px]"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                </div>
                                <p class="text-slate-500 font-bold text-xs sm:text-sm">Tendik tidak ditemukan.</p>
                                <p class="text-slate-400 text-[10px] sm:text-xs">Pencarian tidak cocok dengan nama atau NIP manapun.</p>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="px-6 md:px-8 py-5 border-t border-slate-100 bg-white flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0">
            @if(isset($tendik) && method_exists($tendik, 'links') && $tendik->hasPages())
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center sm:text-left">
                    Menampilkan {{ $tendik->firstItem() }} - {{ $tendik->lastItem() }} dari {{ $tendik->total() }} data
                </p>

                <div class="flex items-center gap-1.5">
                    @if ($tendik->onFirstPage())
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 border border-slate-200 shadow-sm cursor-not-allowed" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                    @else
                        <a href="{{ $tendik->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-maroon-50 hover:text-maroon-700 transition-all border border-slate-200 shadow-sm active:scale-95" title="Sebelumnya">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
                        </a>
                    @endif

                    @foreach ($tendik->elements() as $element)
                        @if (is_string($element))
                            <span class="text-slate-400 px-1 font-bold text-xs">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $tendik->currentPage())
                                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-maroon-900 text-white font-black text-xs shadow-sm active:scale-95">{{ $page }}</button>
                                @else
                                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-slate-600 hover:bg-slate-50 hover:text-maroon-900 font-black text-xs border border-slate-200 shadow-sm transition-all active:scale-95">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($tendik->hasMorePages())
                        <a href="{{ $tendik->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-maroon-50 hover:text-maroon-700 transition-all border border-slate-200 shadow-sm active:scale-95" title="Selanjutnya">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    @else
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 border border-slate-200 shadow-sm cursor-not-allowed" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    @endif
                </div>
            @elseif(isset($tendik) && method_exists($tendik, 'links') && !$tendik->hasPages())
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center sm:text-left w-full">
                    Menampilkan seluruh {{ $tendik->total() }} data
                </p>
            @else
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center sm:text-left">
                    Menampilkan {{ $totalTendik ?? (is_array($tendik) ? count($tendik) : ($tendik->count() ?? 0)) }} data tendik
                </p>
                <div class="flex items-center gap-1.5">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 border border-slate-200 shadow-sm cursor-not-allowed" disabled title="Sebelumnya"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg></button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-maroon-900 text-white font-black text-xs shadow-sm active:scale-95">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 border border-slate-200 shadow-sm cursor-not-allowed" disabled title="Selanjutnya"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></button>
                </div>
            @endif
        </div>

    </section>

    <form id="deleteForm" action="" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

</main>

<script>
    function filterTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll(".tendik-row");
        const emptyState = document.getElementById("js-empty-state");
        let hasVisibleRow = false;

        rows.forEach(row => {
            const name = row.querySelector(".tendik-name").textContent.toLowerCase();
            const nip = row.querySelector(".tendik-nip").textContent.toLowerCase();

            if (name.includes(input) || nip.includes(input)) {
                row.style.display = "";
                hasVisibleRow = true;
            } else {
                row.style.display = "none";
            }
        });

        if (!hasVisibleRow && rows.length > 0) {
            emptyState.style.display = "";
        } else if (emptyState) {
            emptyState.style.display = "none";
        }
    }

    function confirmDelete(url) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data Tendik?',
                text: "Data staf ini beserta rekam jejak presensinya akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus Data!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2rem] p-4 sm:p-6 w-11/12 sm:w-auto',
                    title: 'text-lg sm:text-xl font-black text-slate-800',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm shadow-lg',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = url;
                    form.submit();
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus data Tendik ini? Tindakan ini tidak dapat dibatalkan.')) {
                const form = document.getElementById('deleteForm');
                form.action = url;
                form.submit();
            }
        }
    }
</script>
@endsection
