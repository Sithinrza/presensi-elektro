@extends('layouts.admin')
@section('page_title', 'Data Pembimbing')

@section('content')
<style>
    .modal-backdrop {
        background: rgba(43, 11, 22, 0.4);
        backdrop-filter: blur(4px);
    }

    /* Custom Scrollbar untuk Tabel yang Responsif */
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

    <!-- ALERT NOTIFIKASI -->
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

    <!-- STATISTIK & HEADER ACTIONS -->
    <section class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">

        <div class="flex items-center gap-4 w-full lg:w-auto">
            <!-- WIDGET TOTAL PEMBIMBING -->
            <div class="bg-white border border-slate-100 p-5 sm:p-6 rounded-[2rem] shadow-sm flex items-center gap-4 flex-1 lg:min-w-[200px] pr-8">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-maroon-50 flex items-center justify-center text-maroon-700 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Pembimbing</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight leading-none">{{ $totalPembimbing ?? 0}} <span class="text-xs font-bold text-slate-400 ml-1">Orang</span></p>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.data.pembimbing.create') }}" class="group bg-maroon-900 text-white px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest shadow-lg shadow-maroon-900/20 hover:bg-maroon-950 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 flex items-center justify-center gap-3 w-full lg:w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[18px] sm:h-[18px] group-hover:rotate-90 transition-transform duration-300"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Pembimbing
        </a>
    </section>

    <!-- DATA TABLE SECTION -->
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">

        <!-- HEADER TABEL & SEARCH BAR -->
        <div class="px-6 md:px-8 py-5 sm:py-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between sm:justify-end items-center gap-3 bg-white shrink-0">
            <form method="GET" action="{{ route('admin.data.pembimbing.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-center">

                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto bg-slate-50 border border-slate-200 text-slate-700 text-[10px] sm:text-xs font-bold rounded-xl px-4 py-2.5 sm:py-3 outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Hanya Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <div class="relative w-full md:w-80 group">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" onkeyup="filterTable()" placeholder="Cari Nama atau NIP..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-10 py-2.5 sm:py-3 text-[10px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[16px] sm:h-[16px] absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-maroon-500 transition-colors"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>

                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.data.pembimbing.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-rose-600 transition-colors" title="Reset Filter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- MENGGUNAKAN custom-scrollbar -->
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[850px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Pembimbing</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">NIP / No Induk</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">Jabatan</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="tableBody">

                    @forelse($pembimbing ?? [] as $p)
                    <tr class="pembimbing-row hover:bg-slate-50/80 transition-all duration-200 group">
                        <td class="px-6 sm:px-8 py-4">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0 flex items-center justify-center font-black text-maroon-900 text-lg">
                                    @if($p->foto_profil)
                                        <img src="{{ asset('storage/' . $p->foto_profil) }}" alt="Foto {{ $p->nama_lengkap }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($p->nama_lengkap, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <p class="pembimbing-name text-xs sm:text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-700 transition-colors">{{ $p->nama_lengkap }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 sm:px-8 py-4">
                            <span class="pembimbing-nip inline-flex items-center px-2 sm:px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] sm:text-xs font-bold font-mono border border-slate-200">
                                {{ $p->no_induk ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 sm:px-8 py-4">
                            <span class="student-email text-[10px] sm:text-xs font-bold text-slate-700 leading-tight line-clamp-2">
                                {{ $p->user->email ?? 'Tidak ada email' }}
                            </span>
                        </td>
                        <td class="px-6 sm:px-8 py-4">
                            <p class="text-[10px] sm:text-xs font-bold text-slate-700 uppercase tracking-tight leading-none">{{ $p->jabatan ?? '-' }}</p>
                        </td>
                        <td class="px-6 sm:px-8 py-4 text-center">
                            @if($p->status == 'Aktif')
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

                                <!-- Tombol Detail (Ikon Mata) dengan Tooltip Kustom -->
                                <div class="relative group/tooltip">
                                    <a href="{{ route('admin.data.pembimbing.show', $p->id_pembimbing) }}" class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg sm:rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm active:scale-95" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[16px] sm:h-[16px]"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <!-- Tooltip Label -->
                                    <span class="absolute -top-9 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[9px] font-bold px-2.5 py-1 rounded-md opacity-0 group-hover/tooltip:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-sm z-10">Lihat Detail</span>
                                </div>

                                <!-- Tombol Edit dengan Tooltip Kustom -->
                                <div class="relative group/tooltip">
                                    <a href="{{ route('admin.data.pembimbing.edit', $p->id_pembimbing) }}" class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg sm:rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-maroon-700 hover:border-maroon-200 transition-all shadow-sm active:scale-95" title="Edit Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[16px] sm:h-[16px]"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                    </a>
                                    <!-- Tooltip Label -->
                                    <span class="absolute -top-9 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[9px] font-bold px-2.5 py-1 rounded-md opacity-0 group-hover/tooltip:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-sm z-10">Edit Data</span>
                                </div>

                                <!-- Tombol Hapus dengan Tooltip Kustom -->
                                <div class="relative group/tooltip">
                                    <button type="button"
                                            onclick="confirmDelete('{{ route('admin.data.pembimbing.destroy', $p->id_pembimbing) }}')"
                                            class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg sm:rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all shadow-sm active:scale-95" title="Hapus Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[16px] sm:h-[16px]"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                    <!-- Tooltip Label -->
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
                                <p class="text-slate-500 font-bold text-xs sm:text-sm">Belum ada data Pembimbing.</p>
                                <p class="text-slate-400 text-[10px] sm:text-xs">Silakan tambah pembimbing baru untuk mulai mengelola data.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                    <!-- Empty State untuk Search JS -->
                    <tr id="js-empty-state" style="display: none;">
                        <td colspan="5" class="px-6 sm:px-8 py-12 sm:py-16 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mb-2 border border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[32px] sm:h-[32px]"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                </div>
                                <p class="text-slate-500 font-bold text-xs sm:text-sm">Pembimbing tidak ditemukan.</p>
                                <p class="text-slate-400 text-[10px] sm:text-xs">Pencarian tidak cocok dengan nama atau NIP pembimbing mana pun.</p>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- PAGINATION SECTION -->
        <div class="px-6 md:px-8 py-5 border-t border-slate-100 bg-white flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0">
            @if(isset($pembimbing) && method_exists($pembimbing, 'links') && $pembimbing->hasPages())
                <!-- Tampilan Pagination Kustom Laravel -->
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center sm:text-left">
                    Menampilkan {{ $pembimbing->firstItem() }} - {{ $pembimbing->lastItem() }} dari {{ $pembimbing->total() }} data
                </p>

                <div class="flex items-center gap-1.5">
                    @if ($pembimbing->onFirstPage())
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 border border-slate-200 shadow-sm cursor-not-allowed" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                    @else
                        <a href="{{ $pembimbing->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-maroon-50 hover:text-maroon-700 transition-all border border-slate-200 shadow-sm active:scale-95" title="Sebelumnya">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
                        </a>
                    @endif

                    @foreach ($pembimbing->elements() as $element)
                        @if (is_string($element))
                            <span class="text-slate-400 px-1 font-bold text-xs">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $pembimbing->currentPage())
                                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-maroon-900 text-white font-black text-xs shadow-sm active:scale-95">{{ $page }}</button>
                                @else
                                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-slate-600 hover:bg-slate-50 hover:text-maroon-900 font-black text-xs border border-slate-200 shadow-sm transition-all active:scale-95">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($pembimbing->hasMorePages())
                        <a href="{{ $pembimbing->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-maroon-50 hover:text-maroon-700 transition-all border border-slate-200 shadow-sm active:scale-95" title="Selanjutnya">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    @else
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 border border-slate-200 shadow-sm cursor-not-allowed" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    @endif
                </div>
            @elseif(isset($pembimbing) && method_exists($pembimbing, 'links') && !$pembimbing->hasPages())
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center sm:text-left w-full">
                    Menampilkan seluruh {{ $pembimbing->total() }} data
                </p>
            @else
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center sm:text-left">
                    Menampilkan {{ $totalPembimbing ?? (is_array($pembimbing) ? count($pembimbing) : ($pembimbing->count() ?? 0)) }} data
                </p>
                <div class="flex items-center gap-1.5">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 border border-slate-200 shadow-sm cursor-not-allowed" disabled title="Sebelumnya"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg></button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-maroon-900 text-white font-black text-xs shadow-sm active:scale-95">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-300 border border-slate-200 shadow-sm cursor-not-allowed" disabled title="Selanjutnya"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></button>
                </div>
            @endif
        </div>

    </section>
</main>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    // JS Filter Pencarian Instan
    function filterTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll(".pembimbing-row");
        const emptyState = document.getElementById("js-empty-state");
        let hasVisibleRow = false;

        rows.forEach(row => {
            const name = row.querySelector(".pembimbing-name").textContent.toLowerCase();
            const nip = row.querySelector(".pembimbing-nip").textContent.toLowerCase();

            if (name.includes(input) || nip.includes(input)) {
                row.style.display = "";
                hasVisibleRow = true;
            } else {
                row.style.display = "none";
            }
        });

        // Toggle Empty State
        if (!hasVisibleRow && rows.length > 0) {
            emptyState.style.display = "";
        } else if (emptyState) {
            emptyState.style.display = "none";
        }
    }

    // Fungsi Delete dengan SweetAlert2
    function confirmDelete(url) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data Pembimbing?',
                text: "Data yang dihapus beserta rekam jejaknya tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48', // rose-600
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2rem] p-4 sm:p-6 w-11/12 sm:w-auto',
                    title: 'text-lg sm:text-xl font-black text-maroon-950',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm shadow-lg',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = url;
                    form.submit();
                }
            })
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus data pembimbing ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = url;
                form.submit();
            }
        }
    }
</script>
@endsection
