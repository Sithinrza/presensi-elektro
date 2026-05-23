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
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Total Database</p>
                <p class="text-xl font-black text-maroon-950 tracking-tighter">{{ $totalSiswa ?? 0 }} Siswa</p>
            </div>
            <div class="w-[1px] h-8 bg-maroon-200"></div>
            <div class="px-6 py-2">
                <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest">Siswa Aktif</p>
                <p class="text-xl font-black text-emerald-600 tracking-tighter">{{ $siswaAktif ?? 0 }} Orang</p>
            </div>
        </div>

        <button onclick="openModal('add')" class="bg-maroon-950 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 active:scale-95 transition-all flex items-center justify-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Siswa Baru
        </button>
    </section>

    <!-- DATA TABLE -->
    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
        <div class="overflow-x-auto no-scrollbar pt-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-maroon-50/20">
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Siswa Magang</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">NIS / ID</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Sekolah Asal</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50/50">

                    @forelse($siswa as $s)
                    <tr class="hover:bg-maroon-50/20 transition-all duration-200 group">
                        <td class="px-10 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shadow-sm">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-900 transition-colors">{{ $s->nama_lengkap }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1.5 uppercase">{{ $s->user->email ?? 'Tanpa Email' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-5"><p class="text-xs font-bold text-slate-500">{{ $s->nis }}</p></td>
                        <td class="px-10 py-5">
                            <p class="text-xs font-bold text-slate-600 uppercase tracking-tight leading-none">{{ $s->sekolah_asal }}</p>
                            <p class="text-[9px] font-bold text-slate-300 mt-1 uppercase">{{ $s->jurusan }}</p>
                        </td>
                        <td class="px-10 py-5 text-center">
                            @if($s->status == 'Aktif')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Aktif</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-10 py-5">
                            <div class="flex justify-end gap-2 text-right">
                                <!-- Tombol Edit (Akan kita bahas logikanya nanti) -->
                                <button onclick="openModal('edit')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-maroon-100 hover:text-maroon-900 transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                </button>
                                <!-- Tombol Hapus Sementara -->
                                <button class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-100 hover:text-rose-600 transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-8 text-center text-slate-400 font-bold text-sm">Belum ada data Siswa Magang.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </section>
</main>

<!-- MODAL CRUD SISWA -->
<div id="crudModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" onclick="closeModal()"></div>
    <div class="relative w-full max-w-2xl animate-in">

        <!-- FORM DIMULAI DI SINI -->
        <form action="{{ route('admin.data.siswa.store') }}" method="POST" class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-maroon-100 max-h-[90vh] flex flex-col">
            @csrf

            <!-- Modal Header -->
            <div class="bg-maroon-950 px-8 py-6 text-white flex items-center justify-between shrink-0">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black tracking-tight italic">Tambah Siswa Magang</h3>
                    <p class="text-[10px] font-bold text-maroon-300 uppercase tracking-widest mt-1">Lengkapi data master personel</p>
                </div>
                <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body -->
           <!-- Modal Body -->
            <div class="p-8 space-y-6 overflow-y-auto no-scrollbar">

                <!-- BAGIAN WAJIB (AKUN) -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 mb-6">
                    <h4 class="text-xs font-black text-maroon-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Informasi Dasar Akun (Wajib)
                    </h4>
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required placeholder="Masukkan nama..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        </div>
                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Akun</label>
                            <input type="email" name="email" required placeholder="contoh@sekolah.id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        </div>
                        <!-- Password -->
                        <div class="space-y-2 col-span-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 text-nowrap">Password Default</label>
                            <input type="password" name="password" value="" required minlength="6" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        </div>
                    </div>
                    <!-- BAGIAN DATA PENUGASAN (Diisi Admin) -->
                <div>
                    <h4 class="text-xs font-black text-maroon-900 uppercase tracking-widest mb-4 ml-1 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Data Penugasan Magang
                    </h4>
                    <div class="grid grid-cols-2 gap-6 p-6 bg-slate-50 border border-slate-100 rounded-2xl">

                        <!-- No HP -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">No. Handphone / WA</label>
                            <input type="text" name="no_hp" placeholder="08..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        </div>

                        <!-- Pembimbing -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pembimbing Lapangan</label>
                            <select name="id_pembimbing" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                                <option value="">Pilih Pembimbing...</option>
                                @foreach($pembimbing as $p)
                                    <option value="{{ $p->id_pembimbing }}">{{ $p->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        </div>

                    </div>
                </div>
                </div>

                <!-- BAGIAN OPSIONAL (DETAIL SISWA) -->
                <div>
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 ml-1 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Detail Profil (Opsional)
                    </h4>
                    <div class="grid grid-cols-2 gap-6">
                        <!-- NIS (Hilangkan atribut 'required') -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">NIS / Nomor Induk</label>
                            <input type="text" name="nis" placeholder="Kosongkan jika belum tahu..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        </div>

                        <!-- Agama (Hilangkan atribut 'required') -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Agama</label>
                            <select name="id_agama" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                                <option value="">Belum diisi...</option>
                                @foreach($agama as $item)
                                    <option value="{{ $item->id_agama }}">{{ $item->nama_agama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sekolah Asal (Hilangkan atribut 'required') -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sekolah Asal</label>
                            <input type="text" name="sekolah_asal" placeholder="Nama sekolah..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        </div>

                        <!-- Jurusan (Hilangkan atribut 'required') -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jurusan / Kelas</label>
                            <input type="text" name="jurusan" placeholder="Contoh: TKJ / XII" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-start gap-3 mt-4">
                    <div class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-amber-800 leading-relaxed italic uppercase">
                        Catatan: Bagian Detail Profil bersifat opsional. Jika dibiarkan kosong, sistem akan meminta siswa melengkapinya secara mandiri saat mereka login.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-8 pt-0 shrink-0 flex gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-500 py-4 rounded-2xl font-black text-xs uppercase tracking-widest active:scale-95 transition-all">Batal</button>
                <button type="submit" class="flex-2 bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800">Simpan Data Siswa</button>
            </div>
        </form>
        <!-- FORM SELESAI -->

    </div>
</div>

<script>
    /* MODAL LOGIC */
    function openModal(mode) {
        const modal = document.getElementById('crudModal');
        const title = document.getElementById('modalTitle');

        if(mode === 'edit') {
            title.textContent = "Edit Data Siswa";
            // Catatan: Logika isi data edit akan kita tambahkan nanti jika diperlukan
        } else {
            title.textContent = "Tambah Siswa Baru";
        }

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('crudModal').classList.add('hidden');
    }
</script>
@endsection
