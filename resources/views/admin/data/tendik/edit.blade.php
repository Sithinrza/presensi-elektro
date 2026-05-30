@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.tendik.index') }}" class="w-10 h-10 bg-white border border-maroon-100 rounded-xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 transition-all shadow-sm group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-maroon-950 tracking-tight italic">Edit Data Tendik</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Pembaruan Master Data Personel</p>
            </div>
        </div>
    </div>

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('admin.data.tendik.update', $tendik->id_tendik) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[3rem] shadow-premium overflow-hidden border border-maroon-50">
        @csrf
        @method('PUT')

        <div class="p-8 md:p-10 space-y-10">

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Informasi Akun & Instansi</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Status Kepegawaian</label>
                        <select name="status" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="Aktif" {{ old('status', $tendik->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status', $tendik->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif (Pindah / Pensiun)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $tendik->nama_lengkap) }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Akun</label>
                        <input type="email" name="email" value="{{ old('email', $tendik->user->email ?? '') }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Unit Kerja / Prodi</label>
                        <select name="id_unit_kerja" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            @foreach($unit_kerja as $uk)
                                <option value="{{ $uk->id_unit_kerja }}" {{ old('id_unit_kerja', $tendik->id_unit_kerja) == $uk->id_unit_kerja ? 'selected' : '' }}>{{ $uk->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pangkat / Golongan</label>
                        <select name="id_pangkat_golongan" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled {{ empty(old('id_pangkat_golongan', $tendik->id_pangkat_golongan ?? '')) ? 'selected' : '' }}>
                                Pilih Pangkat & Golongan...
                            </option>
                            @foreach($pangkat_golongan ?? [] as $pg)
                                <option value="{{ $pg->id_pangkat_golongan }}" {{ (old('id_pangkat_golongan', $tendik->id_pangkat_golongan ?? '') == $pg->id_pangkat_golongan) ? 'selected' : '' }}>
                                    {{ $pg->pangkat->nama_pangkat ?? 'Unknown' }} - {{ $pg->golongan->ruang ?? 'Unknown' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Update Password</label>
                        <input type="password" name="password" minlength="6" placeholder="Biarkan kosong jika tidak diubah" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Detail Profil & Struktural</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', $tendik->nip) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jabatan Fungsional</label>
                        <select name="id_jabatan" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled {{ empty(old('id_jabatan', $tendik->id_jabatan)) ? 'selected' : '' }}>Pilih Jabatan...</option>
                            @foreach($jabatan as $j)
                                <option value="{{ $j->id_jabatan }}" {{ old('id_jabatan', $tendik->id_jabatan) == $j->id_jabatan ? 'selected' : '' }}>{{ $j->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pendidikan Terakhir</label>
                        <select name="id_pend_terakhir" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled {{ empty(old('id_pend_terakhir', $tendik->id_pend_terakhir ?? '')) ? 'selected' : '' }}>
                                Pilih Pendidikan...
                            </option>
                            @foreach($pendidikan as $pd)
                                <option value="{{ $pd->id_pend_terakhir }}" {{ (old('id_pend_terakhir', $tendik->id_pend_terakhir ?? '') == $pd->id_pend_terakhir) ? 'selected' : '' }}>
                                    {{ $pd->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Agama</label>
                        <select name="id_agama" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled {{ empty(old('id_agama', $tendik->id_agama)) ? 'selected' : '' }}>Pilih Agama...</option>
                            @foreach($agama as $a)
                                <option value="{{ $a->id_agama }}" {{ old('id_agama', $tendik->id_agama) == $a->id_agama ? 'selected' : '' }}>{{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                        <select name="jk" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled {{ empty(old('jk', $tendik->jk)) ? 'selected' : '' }}>Pilih...</option>
                            <option value="L" {{ old('jk', $tendik->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jk', $tendik->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">No. Handphone / WA</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $tendik->no_hp) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $tendik->tempat_lahir) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $tendik->tanggal_lahir) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">{{ old('alamat', $tendik->alamat) }}</textarea>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Foto Profil</label>
                        @if($tendik->foto_profil)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $tendik->foto_profil) }}" alt="Foto" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="foto_profil" accept="image/*" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-maroon-50 file:text-maroon-700">
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-maroon-50/50 border-t border-maroon-100 p-8 flex justify-end gap-4">
            <a href="{{ route('admin.data.tendik.index') }}" class="bg-white text-maroon-900 border border-maroon-100 py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 transition-all">Batalkan</a>
            <button type="submit" class="bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-maroon-800 transition-all">Simpan Perubahan</button>
        </div>

    </form>
</main>
@endsection
