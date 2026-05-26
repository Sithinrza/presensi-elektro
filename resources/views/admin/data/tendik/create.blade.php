@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.tendik.index') }}" class="w-11 h-11 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 hover:border-maroon-200 transition-all shadow-sm group shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Tambah Data Tendik</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Registrasi Master Data Personel Baru</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-xl w-fit">
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>
                Mode Tambah Aktif
            </span>
        </div>
    </div>

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-rose-500 shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('admin.data.tendik.store') }}" method="POST" class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        @csrf

        <div class="p-8 md:p-10 space-y-12">

            <div>
                <div class="flex items-center gap-4 border-b border-slate-100 pb-5 mb-6">
                    <div class="w-12 h-12 bg-maroon-50 text-maroon-800 rounded-2xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 tracking-tight leading-none">Informasi Dasar Akun & Posisi</h3>
                        <p class="text-[10px] font-bold text-maroon-600 mt-1.5 uppercase tracking-widest flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-maroon-500"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Kolom Wajib Diisi
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 lg:p-8 rounded-3xl border border-slate-100">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: Ir. Budi, M.T." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all shadow-sm placeholder:text-slate-300">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Akun</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="tendik@kampus.id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all shadow-sm placeholder:text-slate-300">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pangkat / Golongan</label>
                        <select name="id_pangkat_golongan" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled {{ old('id_pangkat_golongan') ? '' : 'selected' }}>Pilih Pangkat & Golongan...</option>
                            @foreach($pangkat_golongan ?? [] as $pg)
                                <option value="{{ $pg->id_pangkat_golongan }}" {{ old('id_pangkat_golongan') == $pg->id_pangkat_golongan ? 'selected' : '' }}>
                                    {{ $pg->pangkat->nama_pangkat ?? 'Unknown' }} - {{ $pg->golongan->ruang ?? 'Unknown' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Unit Kerja</label>
                        <select name="id_unit_kerja" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled {{ old('id_unit_kerja') ? '' : 'selected' }}>Pilih Unit Kerja...</option>
                            @foreach($unit_kerja ?? [] as $uk)
                                <option value="{{ $uk->id_unit_kerja }}" {{ old('id_unit_kerja') == $uk->id_unit_kerja ? 'selected' : '' }}>
                                    {{ $uk->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Password Default</label>
                        <input type="password" name="password" required minlength="6" placeholder="Masukkan password awal (min 6 karakter)" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all shadow-sm placeholder:text-slate-300">
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-4 border-b border-slate-100 pb-5 mb-6">
                    <div class="w-12 h-12 bg-slate-100 text-slate-500 rounded-2xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 tracking-tight leading-none">Detail Profil Lainnya</h3>
                        <p class="text-[10px] font-bold text-slate-400 mt-1.5 uppercase tracking-widest">Kolom Opsional (Bisa dikosongkan)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white border border-slate-100 p-6 lg:p-8 rounded-3xl">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">NIP / NIDN</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Kosongkan jika belum tahu..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all shadow-sm placeholder:text-slate-300">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Agama</label>
                        <select name="id_agama" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled {{ old('id_agama') ? '' : 'selected' }}>Belum diisi...</option>
                            @foreach($agama ?? [] as $item)
                                <option value="{{ $item->id_agama }}" {{ old('id_agama') == $item->id_agama ? 'selected' : '' }}>
                                    {{ $item->name ?? $item->nama_agama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jabatan Fungsional</label>
                        <select name="id_jabatan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled {{ old('id_jabatan') ? '' : 'selected' }}>Belum diisi...</option>
                            @foreach($jabatan ?? [] as $jb)
                                <option value="{{ $jb->id_jabatan }}" {{ old('id_jabatan') == $jb->id_jabatan ? 'selected' : '' }}>
                                    {{ $jb->name ?? $jb->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="p-5 bg-amber-50 rounded-2xl border border-amber-100 flex items-start gap-4 mt-6 shadow-sm">
                    <div class="w-10 h-10 bg-amber-400 text-maroon-950 rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <p class="text-[11px] font-bold text-amber-800 leading-relaxed uppercase mt-0.5 tracking-wide">
                        <span class="font-black text-amber-900">Catatan Penting:</span> Bagian ini bersifat opsional. Jika dikosongkan saat pendaftaran, Tendik yang bersangkutan tetap dapat melengkapinya sendiri di menu pengaturan profil mereka nanti.
                    </p>
                </div>
            </div>

        </div>

        <div class="bg-slate-50 border-t border-slate-100 p-6 lg:p-8 flex flex-col sm:flex-row gap-4 justify-end items-center">
            <a href="{{ route('admin.data.tendik.index') }}" class="w-full sm:w-auto bg-white text-slate-600 border border-slate-200 py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest text-center shadow-sm hover:bg-slate-100 hover:text-slate-800 active:scale-95 transition-all">
                Batalkan
            </a>
            <button type="submit" class="w-full sm:w-auto bg-maroon-900 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-maroon-900/20 hover:bg-maroon-950 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all flex justify-center items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Data Baru
            </button>
        </div>
    </form>
</main>
@endsection