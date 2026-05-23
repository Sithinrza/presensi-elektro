@extends('layouts.admin')

@section('content')
<style>
    .modal-backdrop {
        background: rgba(15, 23, 42, 0.4); /* Warna biru gelap untuk tendik */
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
        <div class="flex items-center gap-4 p-2 bg-blue-50 w-fit rounded-3xl border border-blue-100">
            <div class="px-6 py-2">
                <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest">Total Database</p>
                <p class="text-xl font-black text-blue-950 tracking-tighter">{{ $totalTendik ?? 0 }} Tendik</p>
            </div>
            <div class="w-[1px] h-8 bg-blue-200"></div>
            <div class="px-6 py-2">
                <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest">Staf Aktif</p>
                <p class="text-xl font-black text-emerald-600 tracking-tighter">{{ $tendikAktif ?? 0 }} Orang</p>
            </div>
        </div>

        <button onclick="openModal('add')" class="bg-blue-950 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-blue-800 active:scale-95 transition-all flex items-center justify-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            Tambah Tendik Baru
        </button>
    </section>

    <!-- DATA TABLE -->
    <section class="bg-white rounded-[3rem] border border-slate-100 shadow-premium overflow-hidden">
        <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-white">
            <div class="relative">
                <input type="text" placeholder="Cari NIP atau Nama..." class="bg-slate-50 border border-slate-100 rounded-xl px-10 py-2.5 text-xs font-medium w-80 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-50/30">
                        <th class="px-10 py-6 text-[10px] font-black text-blue-900 uppercase tracking-widest">Identitas Tendik</th>
                        <th class="px-10 py-6 text-[10px] font-black text-blue-900 uppercase tracking-widest">NIP / NIDN</th>
                        <th class="px-10 py-6 text-[10px] font-black text-blue-900 uppercase tracking-widest">Pangkat - Golongan</th>
                        <th class="px-10 py-6 text-[10px] font-black text-blue-900 uppercase tracking-widest text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black text-blue-900 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($tendik as $t)
                    <tr class="hover:bg-slate-50/50 transition-all duration-200 group">
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shadow-sm">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($t->nama_lengkap) }}&background=0f172a&color=fff" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-blue-900 transition-colors">{{ $t->nama_lengkap }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1.5 uppercase">{{ $t->user->email ?? 'Tanpa Email' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-5">
                            <p class="text-xs font-bold text-slate-500">{{ $t->nip ?? 'Belum Diatur' }}</p>
                        </td>
                        <td class="px-10 py-5">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">
                                @if($t->pangkatGolongan)
                                    {{ $t->pangkatGolongan->pangkat->nama_pangkat ?? 'Unknown' }} - {{ $t->pangkatGolongan->golongan->ruang ?? 'Unknown' }}
                                @else
                                    Belum Diatur
                                @endif
                            </span>
                        </td>
                        <td class="px-10 py-5 text-center">
                            @if($t->status == 'Aktif')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Aktif</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-10 py-5">
                            <div class="flex justify-end gap-2">
                                <button onclick="openModal('edit')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-blue-100 hover:text-blue-900 transition-all shadow-sm">
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
                        <td colspan="5" class="px-10 py-8 text-center text-slate-400 font-bold text-sm">Belum ada data Tenaga Kependidikan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

<!-- MODAL CRUD TENDIK -->
<div id="crudModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" onclick="closeModal()"></div>
    <div class="relative w-full max-w-2xl animate-in">
        <form action="{{ route('admin.data.tendik.store') }}" method="POST" class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100 max-h-[90vh] flex flex-col">
            @csrf

            <!-- Modal Header -->
            <div class="bg-blue-950 px-8 py-6 text-white flex items-center justify-between shrink-0">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black tracking-tight italic">Tambah Tendik Baru</h3>
                    <p class="text-[10px] font-bold text-blue-300 uppercase tracking-widest mt-1">Lengkapi data master personel</p>
                </div>
                <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-8 space-y-6 overflow-y-auto no-scrollbar">

                <!-- BAGIAN WAJIB (AKUN & POSISI) -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <h4 class="text-xs font-black text-blue-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Informasi Dasar Akun & Posisi (Wajib)
                    </h4>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_lengkap" required placeholder="Contoh: Ir. Budi, M.T." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Akun</label>
                            <input type="email" name="email" required placeholder="tendik@kampus.id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- INPUTAN BARU: PANGKAT GOLONGAN -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pangkat / Golongan</label>
                            <select name="id_pangkat_golongan" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Pilih Pangkat & Golongan...</option>
                                @if(isset($pangkat_golongan))
                                    @foreach($pangkat_golongan as $pg)
                                        <option value="{{ $pg->id_pangkat_golongan }}">
                                            <!-- Menggabungkan Nama Pangkat dan Ruang Golongan -->
                                            {{ $pg->pangkat->nama_pangkat ?? 'Unknown' }} - {{ $pg->golongan->ruang ?? 'Unknown' }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- INPUTAN BARU: UNIT KERJA -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Unit Kerja</label>
                            <select name="id_unit_kerja" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Pilih Unit...</option>
                                @if(isset($unit_kerja))
                                    @foreach($unit_kerja as $uk)
                                        <!-- Menggunakan nama_unit, bukan name -->
                                        <option value="{{ $uk->id_unit_kerja }}">{{ $uk->nama_unit }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="space-y-2 col-span-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 text-nowrap">Password Default</label>
                            <input type="password" name="password" value="" required minlength="6" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 outline-none">
                            <p class="text-[9px] text-slate-400 mt-1 ml-1"></p>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN OPSIONAL (DETAIL LAINNYA) -->
                <div>
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 ml-1 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Detail Profil (Opsional)
                    </h4>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">NIP / NIDN</label>
                            <input type="text" name="nip" placeholder="Kosongkan jika belum tahu..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- Pilihan Agama -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Agama</label>
                            <select name="id_agama" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Belum diisi...</option>
                                @if(isset($agama))
                                    @foreach($agama as $item)
                                        <!-- Pastikan $item->nama_agama atau $item->name sesuai database-mu -->
                                        <option value="{{ $item->id_agama }}">{{ $item->name ?? $item->nama_agama }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Jabatan (Sudah disesuaikan menjadi id_jabatan sesuai DB) -->
                        <div class="space-y-2 col-span-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jabatan Fungsional</label>
                            <select name="id_jabatan" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Belum diisi...</option>
                                @if(isset($jabatan))
                                    @foreach($jabatan as $jb)
                                        <option value="{{ $jb->id_jabatan }}">{{ $jb->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="text-[9px] text-slate-400 mt-1 ml-1">Kosongkan jika Tendik akan mengisinya secara mandiri nanti.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="p-8 pt-0 shrink-0 flex gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-500 py-4 rounded-2xl font-black text-xs uppercase tracking-widest active:scale-95 transition-all">Batal</button>
                <button type="submit" class="flex-2 bg-blue-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-blue-800">Simpan Data Tendik</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode) {
        const modal = document.getElementById('crudModal');
        const title = document.getElementById('modalTitle');
        if(mode === 'edit') title.textContent = "Edit Data Tendik";
        else title.textContent = "Tambah Tendik Baru";
        modal.classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('crudModal').classList.add('hidden');
    }
</script>
@endsection
