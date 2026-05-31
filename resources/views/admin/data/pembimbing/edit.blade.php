@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.pembimbing.index') }}" class="w-10 h-10 bg-white border border-maroon-100 rounded-xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 transition-all shadow-sm group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-maroon-950 tracking-tight italic">Edit Data Pembimbing</h1>
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
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('admin.data.pembimbing.update', $pembimbing->id_pembimbing) }}" method="POST" class="bg-white rounded-[3rem] shadow-premium overflow-hidden border border-maroon-50">
        @csrf
        @method('PUT')

        <div class="p-8 md:p-10 space-y-10">

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Informasi Akun & Data Diri</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Status Kepegawaian</label>
                        <select name="status" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="Aktif" {{ old('status', $pembimbing->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status', $pembimbing->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif (Tidak Aktif/Pindah)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pembimbing->nama_lengkap) }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIP / Nomor Induk</label>
                        <input type="text" name="no_induk" value="{{ old('no_induk', $pembimbing->no_induk) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Institusi</label>
                        <input type="email" name="email" value="{{ old('email', $pembimbing->email ?? ($pembimbing->user->email ?? '')) }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nomor Telepon / WA</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $pembimbing->no_telp) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jabatan Fungsional</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $pembimbing->jabatan) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Agama</label>
                        <select name="id_agama" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled {{ empty(old('id_agama', $pembimbing->id_agama ?? '')) ? 'selected' : '' }}>Pilih Agama...</option>
                            @foreach($agama ?? [] as $item)
                                <option value="{{ $item->id_agama }}" {{ (old('id_agama', $pembimbing->id_agama ?? '') == $item->id_agama) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Update Password</label>
                        <input type="password" name="password" minlength="6" placeholder="Biarkan kosong jika tak ingin merubah sandi" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                        <p class="text-[9px] font-bold text-amber-500 ml-1 mt-1 uppercase tracking-widest">* Hanya isi jika ingin mereset password pengguna.</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-maroon-50/50 border-t border-maroon-100 p-8 flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('admin.data.pembimbing.index') }}" class="bg-white text-maroon-900 border border-maroon-100 py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 active:scale-95 transition-all">
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
