@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">

    <!-- HEADER & TOMBOL KEMBALI -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.pembimbing.index') }}" class="w-10 h-10 bg-white border border-maroon-100 rounded-xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 transition-all shadow-sm group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-maroon-950 tracking-tight italic">Tambah Pembimbing Baru</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Registrasi Data Master Personel</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-xl">
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Mode Tambah Aktif
            </span>
        </div>
    </div>

    <!-- ALERT NOTIFIKASI ERROR -->
    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <!-- FORM TAMBAH -->
    <form action="{{ route('admin.data.pembimbing.store') }}" method="POST" class="bg-white rounded-[3rem] shadow-premium overflow-hidden border border-maroon-50">
        @csrf

        <div class="p-8 md:p-10 space-y-10">

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic leading-none">Informasi Akun & Data Diri</h3>
                        <p class="text-[10px] font-bold text-maroon-400 mt-1 uppercase tracking-widest">Kolom Wajib Diisi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: Budi, M.T." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIP / Nomor Induk</label>
                        <input type="text" name="no_induk" value="{{ old('no_induk') }}" placeholder="18 digit NIP..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Institusi</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="pembimbing@poliban.ac.id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nomor Telepon / WA</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="08..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jabatan Fungsional</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Dosen Elektro" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Password Default</label>
                        <div class="relative group">
                            <input id="passwordInput" type="password" name="password" required minlength="6" placeholder="Masukkan password awal (min 6 karakter)" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3.5 pr-12 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-maroon-600 transition-colors focus:outline-none">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-4 mt-6 bg-gold/5 rounded-2xl border border-gold/20 flex items-start gap-3">
                    <div class="w-8 h-8 bg-gold text-maroon-950 rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-gold-dark leading-relaxed italic uppercase mt-0.5">
                        Akun ini memiliki wewenang untuk memvalidasi logbook dan memantau siswa magang di lapangan.
                    </p>
                </div>
            </div>

        </div>

        <!-- FOOTER ACTIONS -->
        <div class="bg-maroon-50/50 border-t border-maroon-100 p-8 flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('admin.data.pembimbing.index') }}" class="bg-white text-maroon-900 border border-maroon-100 py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 active:scale-95 transition-all">
                Batalkan
            </a>
            <button type="submit" class="bg-maroon-950 text-white py-4 px-10 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800 flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Pembimbing Baru
            </button>
        </div>
    </form>
</main>
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