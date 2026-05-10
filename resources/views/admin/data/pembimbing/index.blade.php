@extends('layouts.admin')

@section('content')
<!-- Tambahan CSS Khusus Halaman Ini (Modal Backdrop) -->
<style>
    .modal-backdrop {
        background: rgba(43, 11, 22, 0.4);
        backdrop-filter: blur(4px);
    }
</style>

<main class="p-10 space-y-8 animate-in">
    <!-- HEADER ACTIONS -->
    <section class="flex flex-col xl:flex-row xl:items-center justify-between gap-6">
        <div class="flex items-center gap-4 p-2 bg-maroon-50 w-fit rounded-3xl border border-maroon-100">
            <div class="px-6 py-2">
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Total Pembimbing</p>
                <p class="text-xl font-black text-maroon-950 tracking-tighter">08 Orang</p>
            </div>
            <div class="w-[1px] h-8 bg-maroon-200"></div>
            <div class="px-6 py-2 text-center">
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Total Bimbingan</p>
                <p class="text-xl font-black text-gold-dark tracking-tighter">32 Siswa</p>
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
            <div class="flex items-center gap-3">
                <select class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-[10px] font-black text-maroon-900 outline-none uppercase tracking-widest">
                    <option>Semua Bidang</option>
                    <option>Laboran</option>
                    <option>Dosen Elektro</option>
                    <option>Staf Administrasi</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-maroon-50/20">
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Nama Pembimbing</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">NIP / ID Member</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Jabatan / Unit</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Bimbingan</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50/50">
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200 group">
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shadow-sm">
                                    <img src="https://i.pravatar.cc/100?img=68" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-900 transition-colors">Dr. Ir. Heru Santoso</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1.5 uppercase">heru.s@poliban.ac.id</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-5">
                            <p class="text-xs font-bold text-slate-500">197605122005011002</p>
                        </td>
                        <td class="px-10 py-5">
                            <p class="text-xs font-bold text-slate-600 uppercase tracking-tight leading-none">Dosen Lektor</p>
                            <p class="text-[9px] font-bold text-slate-300 mt-1 uppercase">Prodi Listrik</p>
                        </td>
                        <td class="px-10 py-5 text-center">
                            <span class="px-3 py-1 bg-maroon-50 text-maroon-800 rounded-lg text-[9px] font-black uppercase tracking-tighter">04 Siswa</span>
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
                    <!-- Row 2 -->
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200 group">
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shadow-sm">
                                    <img src="https://i.pravatar.cc/100?img=44" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-900 transition-colors">Siti Aminah, S.T.</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1.5 uppercase">siti.a@poliban.ac.id</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-5">
                            <p class="text-xs font-bold text-slate-500">199203152023012005</p>
                        </td>
                        <td class="px-10 py-5">
                            <p class="text-xs font-bold text-slate-600 uppercase tracking-tight leading-none">PLP Ahli Pertama</p>
                            <p class="text-[9px] font-bold text-slate-300 mt-1 uppercase">Lab PLC & Otomasi</p>
                        </td>
                        <td class="px-10 py-5 text-center">
                            <span class="px-3 py-1 bg-maroon-50 text-maroon-800 rounded-lg text-[9px] font-black uppercase tracking-tighter">06 Siswa</span>
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
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-10 py-8 border-t border-maroon-50 flex items-center justify-between bg-white">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Menampilkan 1-8 dari 8 data pembimbing</p>
            <div class="flex gap-2">
                <button class="w-10 h-10 rounded-xl border border-maroon-50 flex items-center justify-center text-maroon-900 bg-white hover:bg-maroon-50 active:scale-90 transition-all shadow-sm opacity-50 cursor-not-allowed"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg></button>
                <button class="w-10 h-10 rounded-xl border border-maroon-50 flex items-center justify-center text-maroon-900 bg-white hover:bg-maroon-50 active:scale-90 transition-all shadow-sm opacity-50 cursor-not-allowed"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></button>
            </div>
        </div>
    </section>
</main>

<!-- MODAL CRUD PEMBIMBING -->
<div id="crudModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" onclick="closeModal()"></div>
    <div class="relative w-full max-w-2xl animate-in">
        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-maroon-100 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="bg-maroon-950 px-8 py-6 text-white flex items-center justify-between shrink-0">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black tracking-tight italic text-nowrap">Tambah Data Pembimbing</h3>
                    <p class="text-[10px] font-bold text-maroon-300 uppercase tracking-widest mt-1">Registrasi staf pembimbing jurusan</p>
                </div>
                <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div class="p-8 space-y-6 overflow-y-auto no-scrollbar">
                <div class="grid grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Nama Lengkap & Gelar</label>
                        <input type="text" placeholder="Contoh: Nama, M.T." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                    <!-- NIP -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">NIP / Nomor Identitas</label>
                        <input type="text" placeholder="18 digit angka..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                    <!-- Email -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Email Institusi</label>
                        <input type="email" placeholder="user@poliban.ac.id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                    <!-- Bidang/Unit -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Unit Kerja / Laboratorium</label>
                        <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500">
                            <option>Lab PLC & Otomasi</option>
                            <option>Lab Jaringan Komputer</option>
                            <option>Lab Listrik Dasar</option>
                            <option>Administrasi Jurusan</option>
                        </select>
                    </div>
                    <!-- Jabatan -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Jabatan Fungsional</label>
                        <input type="text" placeholder="Contoh: Dosen / PLP" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>
                    <!-- Password -->
                    <div class="col-span-2 sm:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Password Akses</label>
                        <input type="password" value="pembimbing123" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
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
                <button onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-500 py-4 rounded-2xl font-black text-xs uppercase tracking-widest active:scale-95 transition-all">Batal</button>
                <button class="flex-2 bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800">Simpan Pembimbing</button>
            </div>
        </div>
    </div>
</div>

<script>
    /* MODAL LOGIC */
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
