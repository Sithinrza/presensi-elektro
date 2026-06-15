@extends('layouts.tendik')
@section('page_title', 'Detail & Edit Profil')
@section('hide_nav', true)
@section('content')
<style>
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: slideIn 0.5s ease-out forwards;
    }
</style>

<main class="max-w-4xl mx-auto p-4 sm:p-5 lg:p-10 space-y-6 sm:space-y-8 animate-in">

    <div class="flex items-center gap-3 sm:gap-4 border-b border-maroon-100/30 pb-3 sm:pb-4">
        <a href="{{ route('tendik.profil.index') ?? '#' }}" class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-lg sm:rounded-xl bg-maroon-50 text-maroon-950 hover:bg-maroon-100 transition-colors shadow-sm shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div>
            <h1 class="text-base sm:text-xl font-black text-maroon-950 tracking-tight uppercase italic leading-none">Biodata Lengkap</h1>
            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Manajemen Data Tendik</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-bold shadow-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-bold shadow-sm flex items-center justify-between">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- BAGIAN FOTO PROFIL (WARNA MAROON) -->
    <section class="relative overflow-hidden bg-maroon-900 rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-8 border border-maroon-800 shadow-premium flex flex-col sm:flex-row items-center gap-5 sm:gap-8 text-center sm:text-left">
        <!-- Efek Cahaya Tipis -->
        <div class="absolute -top-12 -right-12 w-48 h-48 sm:w-64 sm:h-64 bg-gold/20 rounded-full blur-[60px] pointer-events-none"></div>

        <div class="relative z-10 w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-gold p-1 shadow-md bg-white shrink-0">
            <div class="w-full h-full rounded-full overflow-hidden">
                @if($tendik->foto_profil)
                    <img src="{{ asset('storage/' . $tendik->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($tendik->nama_lengkap) }}&background=bc5a75&color=fff" alt="Foto Profil" class="w-full h-full object-cover">
                @endif
            </div>
        </div>

        <div class="relative z-10 flex-1 space-y-3 sm:space-y-4">
            <div>
                <!-- NAMA DAN NIP DIMASUKKAN KE SINI -->
                <h3 class="text-lg sm:text-xl font-black text-white uppercase tracking-tight leading-none">{{ $tendik->nama_lengkap }}</h3>
                <p class="text-xs sm:text-sm font-bold text-gold mt-1 sm:mt-1.5">NIP. {{ $tendik->nip ?? '-' }}</p>
                <p class="text-[9px] sm:text-[10px] font-bold text-maroon-200/70 mt-2 sm:mt-2.5 uppercase tracking-widest">Format: JPG, PNG. Ukuran maksimal 2MB.</p>
            </div>

            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5 sm:gap-3">
                <button type="button" onclick="document.getElementById('input-foto').click();" class="bg-white hover:bg-slate-100 text-maroon-950 px-4 py-2.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest transition-colors flex items-center gap-1.5 shadow-sm active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Unggah Baru
                </button>

                @if($tendik->foto_profil)
                    <form action="{{ route('tendik.profil.delete-foto') }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDeleteFoto(event)" class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest transition-colors flex items-center gap-1.5 shadow-sm active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            Hapus
                        </button>
                    </form>
                @endif
            </div>

            <form id="form-foto" action="{{ route('tendik.profil.update-foto') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                @method('PUT')
                <input type="file" id="input-foto" name="foto" accept="image/png, image/jpeg, image/jpg" onchange="document.getElementById('form-foto').submit()">
            </form>
        </div>
    </section>

    <!-- FORM BIODATA BAWAH DENGAN ID DAN ONSUBMIT JS -->
    <form id="formEditProfil" onsubmit="confirmUpdate(event)" action="{{ route('tendik.profil.update') }}" method="POST" class="space-y-6 sm:space-y-8">
        @csrf
        @method('PUT')

        <section class="bg-white rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-8 border border-maroon-100 shadow-sm space-y-5 sm:space-y-6">
            <div class="flex items-center gap-2.5 sm:gap-3 border-b border-slate-50 pb-3 sm:pb-4">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-slate-50 text-slate-600 rounded-lg sm:rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="sm:w-5 sm:h-5"><rect width="18" height="18" x="3" y="3" rx="2" font-weight="bold"/><path d="M7 7h10M7 12h10M7 17h13"/></svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-black text-slate-800 uppercase tracking-tight leading-none">Data Instansi & Kedinasan</h3>
                    <p class="text-[8px] sm:text-[9px] font-bold text-slate-400 mt-0.5 uppercase tracking-widest">Hanya dapat diubah oleh Admin IT</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" value="{{ $tendik->nip ?? '-' }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-400 outline-none cursor-not-allowed shadow-inner">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap & Gelar</label>
                    <input type="text" value="{{ $tendik->nama_lengkap }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-400 outline-none cursor-not-allowed shadow-inner">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Unit Kerja / Prodi</label>
                    <input type="text" value="{{ $tendik->unitKerja->nama_unit ?? '-' }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-400 outline-none cursor-not-allowed shadow-inner">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pangkat / Golongan ruang</label>
                    <input type="text" value="{{ $tendik->pangkatGolongan->pangkat->nama_pangkat ?? 'Unknown' }} - {{ $tendik->pangkatGolongan->golongan->ruang ?? 'Unknown' }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-400 outline-none cursor-not-allowed shadow-inner">
                </div>
            </div>
        </section>

        <section class="bg-white rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-8 border border-maroon-100 shadow-sm space-y-5 sm:space-y-6">
            <div class="flex items-center gap-2.5 sm:gap-3 border-b border-maroon-50 pb-3 sm:pb-4">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-maroon-50 text-maroon-700 rounded-lg sm:rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="sm:w-5 sm:h-5"><path d="M20 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-black text-maroon-950 uppercase tracking-tight leading-none">Biodata & Kontak Mandiri</h3>
                    <p class="text-[8px] sm:text-[9px] font-bold text-gold-dark mt-0.5 uppercase tracking-widest">Silakan lengkapi atau perbarui jika ada perubahan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Email Akun</label>
                    <input type="email" name="email" value="{{ old('email', $tendik->user->email) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">No. Handphone / WhatsApp</label>
                    <input type="tel" inputmode="numeric" name="no_hp" value="{{ old('no_hp', $tendik->no_hp) }}" placeholder="08..." oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $tendik->tempat_lahir) }}" placeholder="Kota Kelahiran..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $tendik->tanggal_lahir) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Agama</label>
                    <select name="id_agama" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                        <option value="" disabled>Pilih Agama...</option>
                        @foreach($agama ?? [] as $a)
                            <option value="{{ $a->id_agama }}" {{ old('id_agama', $tendik->id_agama) == $a->id_agama ? 'selected' : '' }}>{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                    <select name="jk" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                        <option value="" disabled>Pilih...</option>
                        <option value="L" {{ old('jk', $tendik->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jk', $tendik->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Alamat Domisili Lengkap</label>
                    <textarea name="alamat" rows="2" placeholder="Tulis alamat lengkap rumah saat ini..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-medium text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none resize-none transition-all shadow-sm">{{ old('alamat', $tendik->alamat) }}</textarea>
                </div>
            </div>
        </section>

        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 bg-maroon-50/30 p-4 sm:p-6 rounded-2xl sm:rounded-[2rem] border border-maroon-50">
            <a href="{{ route('tendik.profil.index') ?? '#' }}" class="w-full sm:w-auto bg-white text-maroon-900 border border-maroon-100 py-3 sm:py-4 px-6 sm:px-10 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 transition-all active:scale-95">Kembali</a>
            <button type="submit" class="w-full sm:w-auto bg-maroon-950 text-white py-3 sm:py-4 px-6 sm:px-10 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest text-center shadow-xl hover:bg-maroon-800 transition-all active:scale-95 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan
            </button>
        </div>

    </form>
</main>

<script>
    // Konfirmasi Hapus Foto
    function confirmDeleteFoto(event) {
        event.preventDefault();

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Foto Profil?',
                text: "Foto profil Anda akan dihapus dan kembali ke inisial nama.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    // Kelas khusus agar responsive di HP
                    popup: 'rounded-[2rem] p-4 sm:p-6 w-11/12 sm:w-auto',
                    title: 'text-lg sm:text-xl font-black text-maroon-950',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm shadow-lg',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit();
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
                event.target.closest('form').submit();
            }
        }
    }

    // FUNGSI KONFIRMASI SIMPAN PROFIL DENGAN SWEETALERT2
    function confirmUpdate(event) {
        event.preventDefault(); // Cegah submit otomatis
        const form = document.getElementById('formEditProfil');

        // Pastikan HTML5 validation bawaan browser berjalan
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Pastikan biodata Anda yang diperbarui sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4d182b', // Warna maroon-900 Tailwind
                cancelButtonColor: '#94a3b8',  // Warna slate-400 Tailwind
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true, // Tombol batal di kiri, simpan di kanan
                customClass: {
                    // Kelas khusus agar responsive di HP
                    popup: 'rounded-[2rem] p-4 sm:p-6 w-11/12 sm:w-auto',
                    title: 'text-lg sm:text-xl font-black text-maroon-950',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm shadow-lg',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Lanjutkan submit form jika user klik 'Ya'
                }
            });
        } else {
            // Fallback jika CDN SweetAlert gagal dimuat
            if (confirm('Apakah Anda yakin ingin menyimpan perubahan profil ini?')) {
                form.submit();
            }
        }
    }
</script>
@endsection