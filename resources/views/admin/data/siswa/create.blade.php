@extends('layouts.admin')

@section('content')
<main class="p-4 sm:p-6 md:p-10 space-y-6 sm:space-y-8 animate-in">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data.siswa.index') ?? '#' }}" class="w-10 h-10 shrink-0 bg-white border border-maroon-100 rounded-xl flex items-center justify-center text-maroon-900 hover:bg-maroon-50 transition-all shadow-sm group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-maroon-950 tracking-tight italic">Tambah Data Personel</h1>
                <p class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Registrasi Master Data Personel Baru</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-xl self-start md:self-auto">
            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Mode Tambah Aktif
            </span>
        </div>
    </div>

    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="text-sm font-bold">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('admin.data.siswa.store') }}" method="POST" class="bg-white rounded-3xl sm:rounded-[3rem] shadow-premium overflow-hidden border border-maroon-50">
        @csrf

        <div class="bg-rose-50/80 border border-rose-100 p-4 rounded-2xl mx-4 sm:mx-6 md:mx-8 mt-6 sm:mt-8 flex items-start gap-3">
            <div class="w-8 h-8 bg-rose-500 text-white rounded-lg flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div>
                <p class="text-xs font-black text-rose-800 uppercase tracking-widest">Peringatan Pengisian Data</p>
                <p class="text-[10px] sm:text-[11px] font-bold text-rose-600 mt-1">
                    Semua kolom yang memiliki tanda bintang merah (<span class="text-rose-600 text-sm align-top">*</span>) <span class="underline underline-offset-2">wajib diisi</span>. Jangan biarkan kosong sebelum menyimpan.
                </p>
            </div>
        </div>

        <div class="p-5 sm:p-8 md:p-10 space-y-8 md:space-y-10">

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-5 md:mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-maroon-950 tracking-tight uppercase italic leading-none">Informasi Dasar Akun</h3>
                        <p class="text-[9px] sm:text-[10px] font-bold text-rose-500 mt-1 uppercase tracking-widest">KOLOM WAJIB DIISI</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 bg-slate-50 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Nama Lengkap <span class="text-rose-500 text-sm leading-none align-top">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Email Akun <span class="text-rose-500 text-sm leading-none align-top">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@sekolah.id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Password Default <span class="text-rose-500 text-sm leading-none align-top">*</span>
                        </label>
                        <div class="relative group">
                            <input id="passwordInput" type="password" name="password" required minlength="6" placeholder="Masukkan password (min 6 char)" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 pr-12 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-maroon-600 transition-colors focus:outline-none">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Status Akun <span class="text-rose-500 text-sm leading-none align-top">*</span>
                        </label>
                        <select name="status" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-5 md:mb-6">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-900 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-maroon-950 tracking-tight uppercase italic leading-none">Data Penugasan Presensi</h3>
                        <p class="text-[9px] sm:text-[10px] font-bold text-rose-500 mt-1 uppercase tracking-widest">KOLOM WAJIB DIISI</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 bg-slate-50 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            No. Handphone / WA <span class="text-rose-500 text-sm leading-none align-top">*</span>
                        </label>
                        <input type="tel" inputmode="numeric" name="no_hp" value="{{ old('no_hp') }}" required placeholder="Contoh: 08123456789" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Pembimbing / Supervisor <span class="text-rose-500 text-sm leading-none align-top">*</span>
                        </label>
                        <select name="id_pembimbing" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled selected>Pilih Pembimbing...</option>
                            @foreach($pembimbing ?? [] as $p)
                                <option value="{{ $p->id_pembimbing }}" {{ old('id_pembimbing') == $p->id_pembimbing ? 'selected' : '' }}>
                                    {{ $p->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Tanggal Mulai <span class="text-rose-500 text-sm leading-none align-top">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                            Tanggal Selesai <span class="text-rose-500 text-sm leading-none align-top">*</span>
                        </label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 border-b border-maroon-50 pb-4 mb-5 md:mb-6">
                    <div class="w-10 h-10 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-800 tracking-tight uppercase italic leading-none">Detail Profil Tambahan</h3>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">KOLOM OPSIONAL BOLEH DIKOSONGKAN</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 bg-transparent p-4 sm:p-6 rounded-2xl sm:rounded-3xl border-2 border-dashed border-slate-300">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIS / Nomor Induk</label>
                        <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Kosongkan jika belum tahu..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Agama</label>
                        <select name="id_agama" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled selected>Belum diisi...</option>
                            @foreach($agama ?? [] as $item)
                                <option value="{{ $item->id_agama }}" {{ old('id_agama') == $item->id_agama ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                        <select name="jk" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                            <option value="" disabled {{ empty(old('jk')) ? 'selected' : '' }}>Pilih...</option>
                            <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Instansi / Sekolah Asal</label>
                        <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" placeholder="Nama sekolah/instansi..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jurusan / Kelas</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: TKJ / XII" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}" placeholder="Kota kelahiran..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 sm:py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-start gap-3 mt-5 md:mt-6">
                    <div class="w-8 h-8 bg-slate-400 text-white rounded-lg flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-600 leading-relaxed italic uppercase">
                        Catatan: Bagian Detail Profil bersifat opsional. Jika dibiarkan kosong, sistem akan otomatis meminta pengguna melengkapinya secara mandiri saat mereka melakukan login pertama kali.
                    </p>
                </div>
            </div>

        </div>

        <div class="bg-maroon-50/50 border-t border-maroon-100 p-5 sm:p-8 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-end">
            <a href="{{ route('admin.data.siswa.index') ?? '#' }}" class="bg-white text-maroon-900 border border-maroon-100 py-3.5 sm:py-4 px-10 rounded-xl sm:rounded-2xl font-black text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 active:scale-95 transition-all">
                Batalkan
            </a>
            <button type="submit" class="bg-maroon-950 text-white py-3.5 sm:py-4 px-10 rounded-xl sm:rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800 flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Data Baru
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
