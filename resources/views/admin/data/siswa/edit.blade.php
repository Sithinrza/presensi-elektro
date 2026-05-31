@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.siswa.index') ?? '#' }}" class="w-10 h-10 bg-white border border-maroon-100 rounded-xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 transition-all shadow-sm group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-maroon-950 tracking-tight italic">Edit Data Siswa</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Pembaruan Master Data Personel</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-amber-50 border border-amber-100 rounded-xl">
            <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                Mode Edit Aktif
            </span>
        </div>
    </div>

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('admin.data.siswa.update', $siswa->id_siswa ?? 1) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[3rem] shadow-premium overflow-hidden border border-maroon-50">
        @csrf
        @method('PUT')

        <div class="p-8 md:p-10 space-y-10">

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Informasi Dasar Akun</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap ?? '') }}" required placeholder="Masukkan nama..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Akun</label>
                        <input type="email" name="email" value="{{ old('email', $siswa->user->email ?? '') }}" required placeholder="contoh@sekolah.id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Update Password</label>
                        <input type="password" name="password" minlength="6" placeholder="Biarkan kosong jika tidak ingin mengubah password..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                        <p class="text-[9px] font-bold text-amber-500 ml-1 mt-1 uppercase tracking-widest">* Hanya isi jika ingin reset password pengguna.</p>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Data Penugasan Magang</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Status Magang</label>
                        <select name="status" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="Aktif" {{ (old('status', $siswa->status ?? '') == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ (old('status', $siswa->status ?? '') == 'Nonaktif') ? 'selected' : '' }}>Nonaktif (Selesai/Diberhentikan)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">No. Handphone / WA</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp ?? '') }}" placeholder="08..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pembimbing Lapangan</label>
                        <select name="id_pembimbing" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" {{ empty(old('id_pembimbing', $siswa->id_pembimbing)) ? 'selected' : '' }}>
                                Pilih Pembimbing...
                            </option>
                            @foreach($pembimbing ?? [] as $p)
                                <option value="{{ $p->id_pembimbing }}" {{ (old('id_pembimbing', $siswa->id_pembimbing) == $p->id_pembimbing) ? 'selected' : '' }}>
                                    {{ $p->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $siswa->tanggal_mulai ?? '') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $siswa->tanggal_selesai ?? '') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Detail Profil & Akademik</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIS / Nomor Induk</label>
                        <input type="text" name="nis" value="{{ old('nis', $siswa->nis ?? '') }}" placeholder="Kosongkan jika belum tahu..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Agama</label>
                        <select name="id_agama" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled selected>Belum diisi...</option>
                            @foreach($agama ?? [] as $item)
                                <option value="{{ $item->id_agama }}" {{ (old('id_agama', $siswa->id_agama ?? '') == $item->id_agama) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Sekolah Asal</label>
                        <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal', $siswa->sekolah_asal ?? '') }}" placeholder="Nama sekolah..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jurusan / Kelas</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan', $siswa->jurusan ?? '') }}" placeholder="Contoh: TKJ / XII" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                        <select name="jk" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled {{ empty(old('jk', $siswa->jk)) ? 'selected' : '' }}>Pilih...</option>
                            <option value="L" {{ old('jk', $siswa->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jk', $siswa->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Foto Profil</label>
                        @if($siswa->foto_profil)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $siswa->foto_profil) }}" alt="Foto Profil" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="foto_profil" accept="image/jpeg,image/png,image/jpg" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-maroon-50 file:text-maroon-700 hover:file:bg-maroon-100">
                        <p class="text-[9px] font-bold text-slate-400 ml-1 mt-1 uppercase tracking-widest">* Biarkan kosong jika tidak ingin mengubah foto</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}" placeholder="Kota kelahiran..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>



                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-maroon-50/50 border-t border-maroon-100 p-8 flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('admin.data.siswa.index') ?? '#' }}" class="bg-white text-maroon-900 border border-maroon-100 py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 active:scale-95 transition-all">
                Batalkan
            </a>
            <button type="submit" class="bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800 flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan
            </button>
        </div>

    </form>
</main>
@endsection
