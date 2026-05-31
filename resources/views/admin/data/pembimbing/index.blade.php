@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-rose-500"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <section class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">

        <div class="flex flex-wrap items-center gap-4">
            <div class="bg-white border border-slate-100 p-5 rounded-3xl shadow-sm flex items-center gap-4 min-w-[220px]">
                <div class="w-12 h-12 rounded-full bg-maroon-50 flex items-center justify-center text-maroon-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Pembimbing</p>
                    <p class="text-2xl font-black text-slate-800 tracking-tight">{{ str_pad($totalPembimbing ?? 0, 2, '0', STR_PAD_LEFT) }} <span class="text-sm font-bold text-slate-400">Orang</span></p>
                </div>
            </div>

            <div class="bg-white border border-slate-100 p-5 rounded-3xl shadow-sm flex items-center gap-4 min-w-[220px]">
                <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bimbingan</p>
                    <p class="text-2xl font-black text-amber-600 tracking-tight">{{ str_pad($totalBimbingan ?? 0, 2, '0', STR_PAD_LEFT) }} <span class="text-sm font-bold text-amber-500/80">Siswa</span></p>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.data.pembimbing.create') }}" class="group bg-maroon-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-maroon-900/20 hover:bg-maroon-950 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 flex items-center justify-center gap-3 w-full lg:w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="group-hover:rotate-90 transition-transform duration-300"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Pembimbing
        </a>
    </section>

    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-white">
            <div class="relative group w-full max-w-md">
                <input type="text" placeholder="Cari Nama atau NIP..." class="bg-slate-50 border border-slate-200 rounded-xl px-11 py-3 text-xs font-medium w-full focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all placeholder:text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-maroon-600 transition-colors"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Pembimbing</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">NIP / ID Member</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jabatan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    @forelse($pembimbing ?? [] as $p)
                    <tr class="hover:bg-slate-50/80 transition-all duration-200 group cursor-pointer"
                    onclick="window.location.href='{{ route('admin.data.pembimbing.show', $p->id_pembimbing) }}'">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($p->nama_lengkap) }}&background=4c1d2e&color=fff" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-700 transition-colors">{{ $p->nama_lengkap }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-1.5 uppercase">{{ $p->user->email ?? 'Tanpa Email' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold font-mono border border-slate-200">
                                {{ $p->no_induk ?? '-' }}
                            </span>
                        </td>
                        <td class="px-8 py-4">
                            <span class="inline-flex items-center px-3 py-1.5 bg-slate-50 text-slate-600 border border-slate-200 rounded-lg text-[10px] font-black uppercase tracking-tight">
                                {{ $p->jabatan ?? '-' }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            @if($p->status == 'Aktif')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-4">
    <div class="flex justify-end gap-2 text-right opacity-80 group-hover:opacity-100 transition-opacity">

        <a href="{{ route('admin.data.pembimbing.edit', $p->id_pembimbing) }}"
           onclick="event.stopPropagation();"
           class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-maroon-700 hover:border-maroon-200 transition-all shadow-sm" title="Edit Data">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
        </a>

        <button type="button"
                onclick="event.stopPropagation(); confirmDelete('{{ route('admin.data.pembimbing.destroy', $p->id_pembimbing) }}')"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all shadow-sm" title="Hapus Data">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
        </button>

    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                                </div>
                                <p class="text-slate-500 font-bold text-sm">Belum ada data Pembimbing.</p>
                                <p class="text-slate-400 text-xs">Silakan tambah pembimbing baru untuk mulai mengelola data.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <form id="deleteForm" action="" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

</main>

<script>
    function confirmDelete(url) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data Pembimbing?',
                text: "Data staf ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7f1d1d', // Tailwind maroon-900 biar konsisten
                cancelButtonColor: '#94a3b8', // Tailwind slate-400
                confirmButtonText: 'Ya, Hapus Data!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = url;
                    form.submit();
                }
            });
        } else {
            // Fallback jika SweetAlert tidak terdeteksi
            if (confirm('Apakah Anda yakin ingin menghapus data Pembimbing ini? Tindakan ini tidak dapat dibatalkan.')) {
                const form = document.getElementById('deleteForm');
                form.action = url;
                form.submit();
            }
        }
    }
</script>
@endsection
