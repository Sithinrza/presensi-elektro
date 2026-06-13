@extends('layouts.admin')
@section('page_title', 'Data Pembimbing')

@section('content')
<main class="p-4 sm:p-6 lg:p-10 space-y-6 sm:space-y-8 animate-in">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3 sm:gap-4">
            <a href="{{ route('admin.data.pembimbing.index') }}" class="w-9 h-9 sm:w-10 sm:h-10 bg-white border border-maroon-100 rounded-lg sm:rounded-xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 transition-all shadow-sm group shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform sm:w-5 sm:h-5"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-maroon-950 tracking-tight italic leading-none">Edit Data Pembimbing</h1>
            </div>
        </div>
        {{-- <div class="px-3 py-2 sm:px-4 sm:py-2 bg-amber-50 border border-amber-100 rounded-lg sm:rounded-xl w-fit">
            <span class="text-[9px] sm:text-[10px] font-black text-amber-600 uppercase tracking-widest flex items-center gap-1.5 sm:gap-2">
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-amber-500 rounded-full animate-pulse"></span>
                Mode Edit Aktif
            </span>
        </div> --}}
    </div>

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-xl sm:rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 sm:w-5 sm:h-5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="text-xs sm:text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('admin.data.pembimbing.update', $pembimbing->id_pembimbing) }}" method="POST" class="bg-white rounded-3xl sm:rounded-[3rem] shadow-premium overflow-hidden border border-maroon-50">
        @csrf
        @method('PUT')



        <div class="p-4 sm:p-6 md:p-10 space-y-8 sm:space-y-10">

            <div>
                <div class="flex items-center gap-2.5 sm:gap-3 border-b border-maroon-50 pb-3 sm:pb-4 mb-4 sm:mb-6">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-maroon-50 text-maroon-900 rounded-lg sm:rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="sm:w-[18px] sm:h-[18px]"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-maroon-950 tracking-tight uppercase italic leading-none">Informasi Akun & Data Diri</h3>
                        <p class="text-[8px] sm:text-[10px] font-bold text-rose-500 mt-0.5 sm:mt-1 uppercase tracking-widest">* KOLOM WAJIB DIISI</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 bg-slate-50/50 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100">

                    <div class="space-y-1.5 sm:space-y-2 md:col-span-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Status Kepegawaian <span class="text-rose-500 text-xs sm:text-sm leading-none align-top">*</span>
                        </label>
                        <select name="status" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3.5 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="Aktif" {{ old('status', $pembimbing->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status', $pembimbing->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif (Tidak Aktif/Pindah)</option>
                        </select>
                    </div>

                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Nama Lengkap & Gelar <span class="text-rose-500 text-xs sm:text-sm leading-none align-top">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pembimbing->nama_lengkap) }}" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3.5 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            NIP / Nomor Induk <span class="text-rose-500 text-xs sm:text-sm leading-none align-top">*</span>
                        </label>
                        <input type="text" name="no_induk" value="{{ old('no_induk', $pembimbing->no_induk) }}" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3.5 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Email Institusi <span class="text-rose-500 text-xs sm:text-sm leading-none align-top">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $pembimbing->email ?? ($pembimbing->user->email ?? '')) }}" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3.5 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Nomor Telepon / WA <span class="text-rose-500 text-xs sm:text-sm leading-none align-top">*</span>
                        </label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $pembimbing->no_telp) }}" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3.5 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Jabatan Fungsional <span class="text-rose-500 text-xs sm:text-sm leading-none align-top">*</span>
                        </label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $pembimbing->jabatan) }}" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3.5 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Pendidikan Terakhir <span class="text-rose-500 text-xs sm:text-sm leading-none align-top">*</span>
                        </label>
                        <select name="id_pend_terakhir" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3.5 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled {{ empty(old('id_pend_terakhir', $pembimbing->id_pend_terakhir ?? '')) ? 'selected' : '' }}>Pilih Pendidikan...</option>
                            @foreach($pendidikan ?? [] as $item)
                                <option value="{{ $item->id_pend_terakhir }}" {{ (old('id_pend_terakhir', $pembimbing->id_pend_terakhir ?? '') == $item->id_pend_terakhir) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Agama <span class="text-rose-500 text-xs sm:text-sm leading-none align-top">*</span>
                        </label>
                        <select name="id_agama" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3.5 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm appearance-none">
                            <option value="" disabled {{ empty(old('id_agama', $pembimbing->id_agama ?? '')) ? 'selected' : '' }}>Pilih Agama...</option>
                            @foreach($agama ?? [] as $item)
                                <option value="{{ $item->id_agama }}" {{ (old('id_agama', $pembimbing->id_agama ?? '') == $item->id_agama) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5 sm:space-y-2 md:col-span-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Update Password</label>
                        <div class="relative group">
                            <input id="passwordInput" type="password" name="password" minlength="6" placeholder="Biarkan kosong jika tak ingin merubah sandi..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3.5 pr-10 sm:pr-12 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center text-slate-400 hover:text-maroon-600 transition-colors focus:outline-none">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[18px] sm:h-[18px]"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        <p class="text-[8px] sm:text-[9px] font-bold text-amber-500 ml-1 mt-1 uppercase tracking-widest">* Hanya isi jika ingin mereset password pengguna.</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-maroon-50/50 border-t border-maroon-100 p-4 sm:p-6 lg:p-8 flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4">
            <a href="{{ route('admin.data.pembimbing.index') }}" class="w-full sm:w-auto bg-white text-maroon-900 border border-maroon-100 py-3 sm:py-4 px-6 sm:px-10 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 transition-all active:scale-95">
                Batalkan
            </a>
            <button type="submit" class="w-full sm:w-auto bg-maroon-950 text-white py-3 sm:py-4 px-6 sm:px-10 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest text-center shadow-xl hover:bg-maroon-800 transition-all active:scale-95 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[18px] sm:h-[18px]"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan
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
