@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.tendik.index') }}" class="w-10 h-10 bg-white border border-maroon-100 rounded-xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 transition-all shadow-sm group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-maroon-950 tracking-tight italic">Tambah Tenaga Kependidikan</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Registrasi Personel Baru</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-xl">
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Mode Tambah Aktif
            </span>
        </div>
    </div>

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('admin.data.tendik.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[3rem] shadow-premium overflow-hidden border border-maroon-50">
        @csrf

        <div class="p-8 md:p-10 space-y-10">

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic leading-none">Informasi Akun & Instansi</h3>
                        <p class="text-[10px] font-bold text-maroon-400 mt-1 uppercase tracking-widest">Wajib Diisi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Akun</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Unit Kerja / Prodi</label>
                        <select name="id_unit_kerja" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled selected>Pilih Unit...</option>
                            @foreach($unit_kerja as $uk)
                                <option value="{{ $uk->id_unit_kerja }}" {{ old('id_unit_kerja') == $uk->id_unit_kerja ? 'selected' : '' }}>{{ $uk->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pangkat / Golongan</label>
                        <select name="id_pangkat_golongan" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled selected>Pilih Pangkat...</option>
                            @foreach($pangkat_golongan ?? [] as $pg)

                                <option value="{{ $pg->id_pangkat_golongan }}" {{ (old('id_pangkat_golongan', $t->id_pangkat_golongan ?? '') == $pg->id_pangkat_golongan) ? 'selected' : '' }}>
                                    {{ $pg->pangkat->nama_pangkat ?? 'Unknown' }} - {{ $pg->golongan->ruang ?? 'Unknown' }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <!-- FITUR SHOW/HIDE PASSWORD DITAMBAHKAN DI SINI -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Password Default</label>
                        <div class="relative group">
                            <input id="passwordInput" type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 pr-12 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-maroon-600 transition-colors focus:outline-none">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic leading-none">Detail Profil & Struktural</h3>
                        <p class="text-[10px] font-bold text-maroon-400 mt-1 uppercase tracking-widest">Kolom Opsional</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jabatan Fungsional</label>
                        <select name="id_jabatan" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled selected>Pilih Jabatan...</option>
                            @foreach($jabatan as $j)
                                <option value="{{ $j->id_jabatan }}" {{ old('id_jabatan') == $j->id_jabatan ? 'selected' : '' }}>{{ $j->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pendidikan Terakhir</label>
                        <select name="id_pend_terakhir" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled selected>Pilih Pendidikan...</option>
                            @foreach($pendidikan as $pd)
                                <option value="{{ $pd->id_pend_terakhir }}" {{ old('id_pend_terakhir') == $pd->id_pend_terakhir ? 'selected' : '' }}> {{ $pd->name }}  </option>                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Agama</label>
                        <select name="id_agama" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled selected>Pilih Agama...</option>
                            @foreach($agama as $a)
                                <option value="{{ $a->id_agama }}" {{ old('id_agama') == $a->id_agama ? 'selected' : '' }}>{{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                        <select name="jk" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled {{ old('jk') ? '' : 'selected' }}>Pilih...</option>
                            <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">No. Handphone / WA</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota kelahiran..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Foto Profil</label>
                        <input type="file" name="foto_profil" accept="image/*" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-maroon-50 file:text-maroon-700">
                    </div>
                </div>

                <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-start gap-3 mt-6">
                    <div class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-amber-800 leading-relaxed italic uppercase mt-0.5">
                        Catatan: Bagian Detail Profil bersifat opsional dan dapat dilengkap oleh Tendik terkait di kemudian hari.
                    </p>
                </div>
            </div>

        </div>

        <div class="bg-maroon-50/50 border-t border-maroon-100 p-8 flex justify-end gap-4">
            <a href="{{ route('admin.data.tendik.index') }}" class="bg-white text-maroon-900 border border-maroon-100 py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 transition-all">Batalkan</a>
            <button type="submit" class="bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 transition-all">Simpan Data</button>
        </div>

    </form>
</main>

<!-- SCRIPT UNTUK TOGGLE PASSWORD (DITAMBAHKAN DI SINI) -->
<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('eyeIcon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>';
        }
    }
</script>
@endsection
