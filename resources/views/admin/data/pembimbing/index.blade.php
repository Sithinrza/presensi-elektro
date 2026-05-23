@extends('layouts.admin')

@section('content')
<style>
    .modal-backdrop {
        background: rgba(43, 11, 22, 0.4);
        backdrop-filter: blur(4px);
    }
</style>

<main class="p-10 space-y-8 animate-in">
    <!-- ALERT NOTIFIKASI -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <!-- HEADER ACTIONS -->
    <section class="flex flex-col xl:flex-row xl:items-center justify-between gap-6">
        <div class="flex items-center gap-4 p-2 bg-maroon-50 w-fit rounded-3xl border border-maroon-100">
            <div class="px-6 py-2">
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Total Pembimbing</p>
                <p class="text-xl font-black text-maroon-950 tracking-tighter">{{ str_pad($totalPembimbing, 2, '0', STR_PAD_LEFT) }} Orang</p>
            </div>
            <div class="w-[1px] h-8 bg-maroon-200"></div>
            <div class="px-6 py-2 text-center">
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Total Bimbingan</p>
                <p class="text-xl font-black text-gold-dark tracking-tighter">0 Siswa</p>
            </div>
        </div>

        <button onclick="openModal('add')" class="bg-maroon-950 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 active:scale-95 transition-all flex items-center justify-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Pembimbing
        </button>
    </section>

    <!-- DATA TABLE -->
    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
        <!-- Table Filter -->
        <div class="px-10 py-8 border-b border-maroon-50 flex items-center justify-between bg-white">
            <div class="relative">
                <input type="text" placeholder="Cari Nama atau NIP..." class="bg-slate-50 border border-slate-100 rounded-xl px-10 py-2.5 text-xs font-medium w-80 focus:ring-2 focus:ring-maroon-500 outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-maroon-50/20">
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Nama Pembimbing</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">NIP / ID Member</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Jabatan</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50/50">
                    @forelse($pembimbing as $p)
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200 group">
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shadow-sm">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($p->nama_lengkap) }}&background=4c1d2e&color=fff" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-900 transition-colors">{{ $p->nama_lengkap }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1.5 uppercase">{{ $p->user->email ?? 'Tanpa Email' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-5">
                            <p class="text-xs font-bold text-slate-500">{{ $p->no_induk ?? '-' }}</p>
                        </td>
                        <td class="px-10 py-5">
                            <p class="text-xs font-bold text-slate-600 uppercase tracking-tight leading-none">{{ $p->jabatan ?? '-' }}</p>
                        </td>
                        <td class="px-10 py-5 text-center">
                            @if($p->status == 'Aktif')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Aktif</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-10 py-5">
                            <div class="flex justify-end gap-2">
                                <button onclick="openModal('edit')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-maroon-100 hover:text-maroon-900 transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                </button>
                                <button class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-100 hover:text-rose-600 transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-8 text-center text-slate-400 font-bold text-sm">Belum ada data Pembimbing.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

<!-- MODAL CRUD PEMBIMBING -->
<div id="crudModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" onclick="closeModal()"></div>
    <div class="relative w-full max-w-2xl animate-in">
        <!-- BUNGKUS DENGAN FORM -->
        <form action="{{ route('admin.data.pembimbing.store') }}" method="POST" class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-maroon-100 max-h-[90vh] flex flex-col">
            @csrf

            <!-- Modal Header -->
            <div class="bg-maroon-950 px-8 py-6 text-white flex items-center justify-between shrink-0">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black tracking-tight italic text-nowrap">Tambah Data Pembimbing</h3>
                    <p class="text-[10px] font-bold text-maroon-300 uppercase tracking-widest mt-1">Registrasi staf pembimbing jurusan</p>
                </div>
                <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-8 space-y-6 overflow-y-auto no-scrollbar">
                <div class="grid grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" required placeholder="Contoh: Nama, M.T." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                    <!-- NIP -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">NIP / Nomor Induk</label>
                        <input type="text" name="no_induk" placeholder="18 digit angka..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                    <!-- Email -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Email Institusi</label>
                        <input type="email" name="email" required placeholder="user@poliban.ac.id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                    <!-- No Telp / WA -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">No. Telepon / WA</label>
                        <input type="text" name="no_telp" placeholder="08..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                    <!-- Jabatan -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Jabatan Fungsional</label>
                        <input type="text" name="jabatan" placeholder="Contoh: Dosen / PLP" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                    <!-- Password -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Password Akses</label>
                        <input type="password" name="password" value="" required minlength="6" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                </div>

                <div class="p-4 bg-gold/5 rounded-2xl border border-gold/20 flex items-start gap-3">
                    <div class="w-8 h-8 bg-gold text-maroon-950 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-gold-dark leading-relaxed italic uppercase">
                        Akun pembimbing memiliki wewenang untuk memvalidasi logbook harian siswa magang yang berada di bawah bimbingannya.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-8 pt-0 shrink-0 flex gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-500 py-4 rounded-2xl font-black text-xs uppercase tracking-widest active:scale-95 transition-all">Batal</button>
                <button type="submit" class="flex-2 bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800">Simpan Pembimbing</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode) {
        const modal = document.getElementById('crudModal');
        const title = document.getElementById('modalTitle');
        if(mode === 'edit') title.textContent = "Ubah Data Pembimbing";
        else title.textContent = "Tambah Data Pembimbing";
        modal.classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('crudModal').classList.add('hidden');
    }
</script>
@endsection
