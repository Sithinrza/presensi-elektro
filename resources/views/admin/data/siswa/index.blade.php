@extends('layouts.admin')

@section('content')
<style>
    .modal-backdrop {
        background: rgba(43, 11, 22, 0.4);
        backdrop-filter: blur(4px);
    }
</style>

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
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Database</p>
                    <p class="text-2xl font-black text-slate-800 tracking-tight">{{ $totalSiswa ?? 0 }} <span class="text-sm font-bold text-slate-400">Siswa</span></p>
                </div>
            </div>

            <div class="bg-white border border-slate-100 p-5 rounded-3xl shadow-sm flex items-center gap-4 min-w-[220px]">
                <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Siswa Aktif</p>
                    <p class="text-2xl font-black text-emerald-600 tracking-tight">{{ $siswaAktif ?? 0 }} <span class="text-sm font-bold text-emerald-400/80">Orang</span></p>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.data.siswa.create') }}" class="group bg-maroon-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-maroon-900/20 hover:bg-maroon-950 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 flex items-center justify-center gap-3 w-full lg:w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="group-hover:rotate-90 transition-transform duration-300"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Siswa Baru
        </a>
    </section>

    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Siswa Magang</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">NIS / ID</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sekolah Asal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    @forelse($siswa ?? [] as $s)<tr class="hover:bg-slate-50/80 transition-all duration-200 group cursor-pointer"
                        onclick="window.location.href='{{ route('admin.data.siswa.show', $s->id_siswa) }}'">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-700 transition-colors">{{ $s->nama_lengkap }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-1.5">{{ $s->user->email ?? 'Tidak ada email' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold font-mono border border-slate-200">
                                {{ $s->nis }}
                            </span>
                        </td>
                        <td class="px-8 py-4">
                            <p class="text-xs font-bold text-slate-700 uppercase tracking-tight leading-none">{{ $s->sekolah_asal }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">{{ $s->jurusan }}</p>
                        </td>
                        <td class="px-8 py-4 text-center">
                            @if($s->status == 'Aktif')
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
                                <a href="{{ route('admin.data.siswa.edit', $s->id_siswa) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-maroon-700 hover:border-maroon-200 transition-all shadow-sm" title="Edit Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                </a>
                                <button type="button" 
                                        onclick="confirmDelete('{{ route('admin.data.siswa.destroy', $s->id_siswa) }}')"
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
                                <p class="text-slate-500 font-bold text-sm">Belum ada data Siswa Magang.</p>
                                <p class="text-slate-400 text-xs">Silakan tambah siswa baru untuk mulai mengelola data.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </section>
</main>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    /* MODAL LOGIC */
    function openModal(mode) {
        const modal = document.getElementById('crudModal');
        const title = document.getElementById('modalTitle');

        if(modal && title) {
            if(mode === 'edit') {
                title.textContent = "Edit Data Siswa";
            } else {
                title.textContent = "Tambah Siswa Baru";
            }
            modal.classList.remove('hidden');
        }
    }

    function closeModal() {
        const modal = document.getElementById('crudModal');
        if(modal) modal.classList.add('hidden');
    }

    // Fungsi Delete dengan SweetAlert2
    function confirmDelete(url) {
        // Pastikan Swal sudah terdefinisi, jika belum bisa pakai confirm biasa sebagai fallback
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data Siswa?',
                text: "Data yang dihapus beserta rekam jejak presensinya tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7f1d1d', // Warna setara maroon-900 di Tailwind
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true, // Biar tombol Batal di kiri, Hapus di kanan (standar UI UX)
                customClass: {
                    popup: 'rounded-2xl',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = url;
                    form.submit();
                }
            })
        } else {
            // Fallback jika CDN SweetAlert gagal load
            if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = url;
                form.submit();
            }
        }
    }
</script>
@endsection