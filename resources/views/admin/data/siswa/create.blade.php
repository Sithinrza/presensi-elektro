@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">

    <!-- HEADER / TOMBOL KEMBALI -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.siswa.index') ?? '#' }}" class="w-10 h-10 bg-white border border-maroon-100 rounded-xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 transition-all shadow-sm group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-maroon-950 tracking-tight italic">Tambah Data Siswa</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Registrasi Master Data Personel Baru</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-xl">
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Mode Tambah Aktif
            </span>
        </div>
    </div>

    <!-- ALERT NOTIFIKASI -->
    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <!-- FORM TAMBAH -->
    <form action="{{ route('admin.data.siswa.store') }}" method="POST" class="bg-white rounded-[3rem] shadow-premium overflow-hidden border border-maroon-50">
        @csrf

        <div class="p-8 md:p-10 space-y-10">

            <!-- BAGIAN 1: AKUN -->
            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic leading-none">Informasi Dasar Akun</h3>
                        <p class="text-[10px] font-bold text-maroon-400 mt-1 uppercase tracking-widest">Kolom Wajib Diisi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <!-- Nama Lengkap -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Akun</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@sekolah.id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <!-- Password Default -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Password Default</label>
                        <input type="password" name="password" required minlength="6" placeholder="Masukkan password awal (min 6 karakter)" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: DATA PENUGASAN -->
            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic leading-none">Data Penugasan Magang</h3>
                        <p class="text-[10px] font-bold text-maroon-400 mt-1 uppercase tracking-widest">Kolom Wajib Diisi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <!-- No HP -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">No. Handphone / WA</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Pembimbing -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pembimbing Lapangan</label>
                        <select name="id_pembimbing" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled selected>Pilih Pembimbing...</option>
                            @foreach($pembimbing ?? [] as $p)
                                <option value="{{ $p->id_pembimbing }}" {{ old('id_pembimbing') == $p->id_pembimbing ? 'selected' : '' }}>
                                    {{ $p->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                    </div>
                </div>
            </div>

            <!-- BAGIAN 3: OPSIONAL (DETAIL SISWA) -->
            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic leading-none">Detail Profil & Akademik</h3>
                        <p class="text-[10px] font-bold text-maroon-400 mt-1 uppercase tracking-widest">Kolom Opsional</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <!-- NIS -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIS / Nomor Induk</label>
                        <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Kosongkan jika belum tahu..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Agama -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Agama</label>
                        <select name="id_agama" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled selected>Belum diisi...</option>
                            @foreach($agama ?? [] as $item)
                                <option value="{{ $item->id_agama }}" {{ old('id_agama') == $item->id_agama ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sekolah Asal -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Sekolah Asal</label>
                        <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" placeholder="Nama sekolah..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Jurusan -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jurusan / Kelas</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: TKJ / XII" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                </div>

                <!-- Info Box (Catatan) -->
                <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-start gap-3 mt-6">
                    <div class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-amber-800 leading-relaxed italic uppercase mt-0.5">
                        Catatan: Bagian Detail Profil bersifat opsional. Jika dibiarkan kosong, sistem akan otomatis meminta siswa melengkapinya secara mandiri saat mereka melakukan login pertama kali.
                    </p>
                </div>
            </div>

        </div>

        <!-- FOOTER ACTIONS -->
        <div class="bg-maroon-50/50 border-t border-maroon-100 p-8 flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('admin.data.siswa.index') ?? '#' }}" class="bg-white text-maroon-900 border border-maroon-100 py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 active:scale-95 transition-all">
                Batalkan
            </a>
            <button type="submit" class="bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800 flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Data Baru
            </button>
        </div>

    </form>
</main>
@endsection