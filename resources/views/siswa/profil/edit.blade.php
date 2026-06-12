@extends('layouts.siswa')
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
        <a href="{{ route('siswa.profil') ?? '#' }}" class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-lg sm:rounded-xl bg-maroon-50 text-maroon-950 hover:bg-maroon-100 transition-colors shadow-sm shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div>
            <h1 class="text-base sm:text-xl font-black text-maroon-950 tracking-tight uppercase italic leading-none">Biodata Lengkap</h1>
            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Manajemen Data Siswa</p>
        </div>
    </div>

    <section class="bg-maroon-900 rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-8 border border-maroon-800 shadow-premium flex flex-col sm:flex-row items-center gap-5 sm:gap-8 text-center sm:text-left relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-gold/20 rounded-full blur-[60px] pointer-events-none"></div>
        <div class="relative z-10 w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-gold p-1 shadow-md bg-white shrink-0">
            <div class="w-full h-full rounded-full overflow-hidden bg-slate-100 flex items-center justify-center text-4xl font-black text-maroon-900">
                @if($siswa->foto_profil)
                    <img src="{{ asset('storage/' . $siswa->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    {{ substr($siswa->nama_lengkap, 0, 1) }}
                @endif
            </div>
        </div>

        <div class="relative z-10 flex-1 space-y-3 sm:space-y-4">
            <div>
                <h3 class="text-lg sm:text-xl font-black text-white uppercase tracking-tight leading-none">{{ $siswa->nama_lengkap }}</h3>
                <p class="text-xs sm:text-sm font-bold text-gold mt-1.5">NIS: {{ $siswa->nis ?? '-' }}</p>
                <p class="text-[9px] sm:text-[10px] font-bold text-maroon-200/70 mt-2.5 uppercase tracking-widest">Format: JPG, PNG. Ukuran maksimal 2MB.</p>
            </div>

            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5 sm:gap-3">
                <button type="button" onclick="document.getElementById('input-foto').click();" class="bg-white hover:bg-slate-100 text-maroon-950 px-4 py-2.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest transition-colors flex items-center gap-1.5 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Unggah Baru
                </button>

                @if($siswa->foto_profil)
                    <form action="{{ route('siswa.profil.delete-foto') }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDeleteFoto(event)" class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest transition-colors flex items-center gap-1.5 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            Hapus
                        </button>
                    </form>
                @endif
            </div>

            <form id="form-foto" action="{{ route('siswa.profil.update-foto') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                @method('PUT')
                <input type="file" id="input-foto" name="foto" accept="image/png, image/jpeg, image/jpg" onchange="document.getElementById('form-foto').submit()">
            </form>
        </div>
    </section>

    <form action="{{ route('siswa.profil.update') }}" method="POST" class="space-y-6 sm:space-y-8">
        @csrf
        @method('PUT')

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
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">No. Handphone / WhatsApp</label>
                    <input type="tel" inputmode="numeric" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" placeholder="08..." oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" placeholder="Kota Kelahiran..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Agama</label>
                    <select name="id_agama" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                        <option value="" disabled>Pilih Agama...</option>
                        @foreach($agama ?? [] as $a)
                            <option value="{{ $a->id_agama }}" {{ old('id_agama', $siswa->id_agama) == $a->id_agama ? 'selected' : '' }}>{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                    <select name="jk" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all cursor-pointer shadow-sm">
                        <option value="" disabled>Pilih...</option>
                        <option value="L" {{ old('jk', $siswa->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jk', $siswa->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Alamat Domisili Lengkap</label>
                    <textarea name="alamat" rows="2" placeholder="Tulis alamat lengkap rumah saat ini..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-medium text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none resize-none transition-all shadow-sm">{{ old('alamat', $siswa->alamat) }}</textarea>
                </div>

                <div class="space-y-1.5 sm:col-span-2 mt-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor Induk Siswa (NIM/NIS)</label>
                    <input type="text" value="{{ $siswa->nis ?? '-' }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-bold text-slate-400 outline-none cursor-not-allowed shadow-inner">
                    <p class="text-[8px] sm:text-[9px] font-bold text-slate-400 mt-1 ml-1">* NIS hanya dapat diubah oleh Admin IT.</p>
                </div>
            </div>
        </section>

        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 bg-maroon-50/30 p-4 sm:p-6 rounded-2xl sm:rounded-[2rem] border border-maroon-50">
            <a href="{{ route('siswa.profil') ?? '#' }}" class="w-full sm:w-auto bg-white text-maroon-900 border border-maroon-100 py-3 sm:py-4 px-6 sm:px-10 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest text-center shadow-sm hover:bg-maroon-50 transition-all active:scale-95">Kembali</a>
            <button type="submit" class="w-full sm:w-auto bg-maroon-950 text-white py-3 sm:py-4 px-6 sm:px-10 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest text-center shadow-xl hover:bg-maroon-800 transition-all active:scale-95 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</main>

<script>
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
                cancelButtonText: 'Batal'
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
</script>
@endsection
