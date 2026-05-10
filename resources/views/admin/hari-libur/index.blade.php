@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">

    <!-- HEADER ACTIONS -->
    <section class="flex flex-col xl:flex-row xl:items-center justify-between gap-6">
        <div class="flex items-center gap-4 p-2 bg-maroon-50 w-fit rounded-3xl border border-maroon-100">
            <div class="px-6 py-2">
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Tahun Aktif</p>
                <p class="text-xl font-black text-maroon-950 tracking-tighter">2024</p>
            </div>
            <div class="w-[1px] h-8 bg-maroon-200"></div>
            <div class="px-6 py-2 text-center">
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Total Libur</p>
                <p class="text-xl font-black text-rose-600 tracking-tighter">18 Hari</p>
            </div>
        </div>

        <button onclick="openModal('add')" class="bg-maroon-950 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 active:scale-95 transition-all flex items-center justify-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Hari Libur
        </button>
    </section>

    <!-- DATA TABLE -->
    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
        <div class="px-10 py-8 border-b border-maroon-50 flex items-center justify-between bg-white">
            <div class="flex items-center gap-4">
                <h3 class="text-lg font-black text-maroon-950 tracking-tight italic">Daftar Libur & Cuti Bersama</h3>
            </div>
            <div class="flex items-center gap-3">
                <select class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-[10px] font-black text-maroon-900 outline-none uppercase tracking-widest">
                    <option>Tahun 2024</option>
                    <option>Tahun 2023</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-maroon-50/20">
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Tanggal</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Nama Hari Libur / Keterangan</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Kategori</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50/50">
                    <!-- Row 1 -->
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200">
                        <td class="px-10 py-6">
                            <p class="text-sm font-extrabold text-maroon-950 tracking-tight">10 - 11 April 2024</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">2 Hari</p>
                        </td>
                        <td class="px-10 py-6">
                            <p class="text-sm font-bold text-slate-700 leading-tight">Hari Raya Idul Fitri 1445 Hijriah</p>
                            <p class="text-[9px] font-bold text-maroon-300 uppercase mt-1 italic">Libur Nasional</p>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Hari Libur</span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex justify-end gap-2 text-right">
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
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200">
                        <td class="px-10 py-6">
                            <p class="text-sm font-extrabold text-maroon-950 tracking-tight">08 April 2024</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">1 Hari</p>
                        </td>
                        <td class="px-10 py-6">
                            <p class="text-sm font-bold text-slate-700 leading-tight">Cuti Bersama Hari Raya Idul Fitri</p>
                            <p class="text-[9px] font-bold text-maroon-300 uppercase mt-1 italic">Penyesuaian Kalender Akademik</p>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <span class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Cuti Bersama</span>
                        </td>
                        <td class="px-10 py-6">
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

        <!-- Footer Pagination -->
        <div class="px-10 py-8 border-t border-maroon-50 bg-maroon-50/10 flex items-center justify-between">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic leading-none">Menampilkan hari libur tahun ajaran berjalan</p>
            <div class="flex gap-2">
                <button class="w-10 h-10 rounded-xl bg-white border border-maroon-100 flex items-center justify-center text-maroon-900 shadow-sm active:scale-90 transition-all"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg></button>
                <button class="w-10 h-10 rounded-xl bg-white border border-maroon-100 flex items-center justify-center text-maroon-900 shadow-sm active:scale-90 transition-all"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></button>
            </div>
        </div>
    </section>
</main>

<!-- MODAL ADD/EDIT HOLIDAY -->
<div id="crudModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-maroon-950/40 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="relative w-full max-w-lg animate-in">
        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-maroon-100 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="bg-maroon-950 px-8 py-6 text-white flex items-center justify-between shrink-0">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black tracking-tight italic">Tambah Hari Libur</h3>
                    <p class="text-[10px] font-bold text-maroon-300 uppercase tracking-widest mt-1">Konfigurasi tanggal merah sistem</p>
                </div>
                <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-8 space-y-6 overflow-y-auto no-scrollbar">
                <div class="space-y-4">
                    <!-- Nama Libur -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Nama Hari Libur</label>
                        <input type="text" placeholder="Contoh: Tahun Baru Islam..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                    </div>

                    <!-- Rentang Tanggal -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Mulai Tanggal</label>
                            <input type="date" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Selesai Tanggal</label>
                            <input type="date" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500">
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Kategori Libur</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="libur-cat" value="nasional" checked class="hidden peer">
                                <div class="p-3 border-2 border-slate-100 rounded-2xl text-center font-bold text-[10px] text-slate-400 peer-checked:border-maroon-950 peer-checked:bg-maroon-50 peer-checked:text-maroon-950 transition-all uppercase tracking-widest">Hari Libur</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="libur-cat" value="cuti" class="hidden peer">
                                <div class="p-3 border-2 border-slate-100 rounded-2xl text-center font-bold text-[10px] text-slate-400 peer-checked:border-maroon-950 peer-checked:bg-maroon-50 peer-checked:text-maroon-950 transition-all uppercase tracking-widest">Cuti Bersama</div>
                            </label>
                        </div>
                    </div>

                    <!-- Keterangan Tambahan -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Keterangan Tambahan</label>
                        <textarea placeholder="Catatan singkat (Opsional)..." rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none resize-none"></textarea>
                    </div>
                </div>

                <!-- Info Note -->
                <div class="p-4 bg-maroon-50 rounded-2xl border border-maroon-100 flex items-start gap-3">
                    <div class="w-8 h-8 bg-maroon-900 text-white rounded-lg flex items-center justify-center shrink-0 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-maroon-800 leading-relaxed italic uppercase">
                        Sistem tidak akan menghitung "Alpa" pada rentang tanggal tersebut. Pastikan data sudah sesuai dengan SKB 3 Menteri.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-8 pt-0 shrink-0 flex gap-4">
                <button onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-500 py-4 rounded-2xl font-black text-xs uppercase tracking-widest active:scale-95 transition-all">Batal</button>
                <button class="flex-2 bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800">Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(mode) {
        const modal = document.getElementById('crudModal');
        const title = document.getElementById('modalTitle');
        if(mode === 'edit') title.textContent = "Edit Hari Libur";
        else title.textContent = "Tambah Hari Libur";
        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('crudModal').classList.add('hidden');
    }
</script>
@endsection
