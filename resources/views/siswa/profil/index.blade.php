@extends('layouts.siswa')

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

<main class="max-w-4xl mx-auto p-5 lg:p-10 space-y-8 animate-in">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-2xl text-sm font-bold shadow-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl text-sm font-bold shadow-sm flex items-center justify-between">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-4 lg:hidden">
        <h1 class="text-xl font-extrabold text-maroon-950 tracking-tight">Profil Pengguna</h1>
        <div class="text-[10px] font-black text-maroon-600 bg-maroon-50 px-2 py-1 rounded-lg uppercase tracking-widest">Aktif</div>
    </div>

    <section class="bg-maroon-900 rounded-[3rem] p-8 md:p-12 text-white shadow-premium border border-maroon-800 relative">
        
        <!-- Pembungkus khusus efek cahaya -->
        <div class="absolute inset-0 overflow-hidden rounded-[3rem] pointer-events-none">
            <div class="absolute -top-12 -right-12 w-64 h-64 bg-gold/20 rounded-full blur-[80px]"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-white/10 rounded-full blur-[60px]"></div>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">

            <!-- FOTO PROFIL & DROPDOWN MENU -->
            <div x-data="{ openPhotoMenu: false }" class="relative group">
                
                <!-- Tombol Avatar -->
                <button type="button" @click="openPhotoMenu = !openPhotoMenu" class="relative w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-gold p-1 shadow-2xl bg-white focus:outline-none transition-transform active:scale-95 group block">
                    <div class="w-full h-full rounded-full overflow-hidden relative">
                        @if($siswa->foto_profil)
                            <!-- PERBAIKAN: Menggunakan fungsi asset() dari storage Laravel -->
                            <img src="{{ asset('storage/' . $siswa->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&background=bc5a75&color=fff" alt="Foto Profil" class="w-full h-full object-cover">
                        @endif
                        
                        <!-- Overlay saat di-hover -->
                        <div class="absolute inset-0 bg-maroon-950/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        </div>
                    </div>
                    
                    <!-- Ikon Edit Kecil di Pojok Kanan Bawah -->
                    <div class="absolute bottom-1 right-1 w-10 h-10 bg-gold text-maroon-950 rounded-full flex items-center justify-center border-4 border-maroon-900 shadow-lg z-10 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="openPhotoMenu" 
                     @click.outside="openPhotoMenu = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     class="absolute top-[110%] left-1/2 -translate-x-1/2 md:left-0 md:translate-x-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50"
                     style="display: none;">
                    
                    <!-- Opsi Unggah -->
                    <button type="button" onclick="document.getElementById('input-foto').click();" class="w-full text-left px-5 py-3 text-[11px] sm:text-xs font-bold text-slate-700 hover:bg-slate-50 flex items-center gap-3 transition-colors rounded-t-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-maroon-900"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Unggah Baru
                    </button>

                    <!-- Opsi Hapus (Hanya muncul jika ada foto) -->
                    @if($siswa->foto_profil)
                        <div class="h-px bg-slate-100 my-1 mx-4"></div>
                        <form action="{{ route('siswa.profil.delete-foto') }}" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDeleteFoto(event)" class="w-full text-left px-5 py-3 text-[11px] sm:text-xs font-bold text-rose-600 hover:bg-rose-50 flex items-center gap-3 transition-colors rounded-b-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                Hapus Foto
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Form Upload Tersembunyi -->
                <form id="form-foto" action="{{ route('siswa.profil.update-foto') }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf
                    @method('PUT')
                    <input type="file" id="input-foto" name="foto" accept="image/png, image/jpeg, image/jpg" onchange="document.getElementById('form-foto').submit()">
                </form>
            </div>

            <div class="relative z-10 text-center md:text-left space-y-1.5 sm:space-y-2">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight leading-none italic">{{ $siswa->nama_lengkap }}</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-2 sm:gap-3 mt-1">
                    <span class="text-gold font-bold text-[10px] sm:text-sm tracking-widest uppercase">Siswa Magang</span>
                    <span class="hidden sm:block text-maroon-300">•</span>
                    <span class="text-maroon-100 text-[10px] sm:text-sm font-medium">{{ $siswa->sekolah_asal ?? 'Instansi Belum Diisi' }}</span>
                </div>
                <p class="text-[9px] sm:text-[10px] text-maroon-200/50 font-bold uppercase tracking-widest pt-1 sm:pt-2">
                    Bergabung Sejak {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('F Y') }}
                </p>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 items-start">

        <section class="bg-white rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 border border-maroon-100 shadow-sm">
            <div class="flex items-center gap-3 mb-5 sm:mb-6">
                <div class="w-10 h-10 bg-maroon-50 text-maroon-700 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <h3 class="text-base sm:text-lg font-black text-maroon-950 tracking-tight leading-none">Informasi Pribadi</h3>
            </div>
            <a href="{{ route('siswa.profil.edit') }}" class="w-full flex items-center justify-between p-3.5 sm:p-4 bg-maroon-50 hover:bg-maroon-100 rounded-xl sm:rounded-2xl transition-all group">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-maroon-700 sm:w-[18px] sm:h-[18px]"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-maroon-950">Detail & Edit Profil</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-maroon-300 group-hover:translate-x-1 transition-transform sm:w-[16px] sm:h-[16px]"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </section>

        <div class="space-y-5 sm:space-y-6">
            <section class="bg-white rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 border border-maroon-100 shadow-sm space-y-5 sm:space-y-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1-1-1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-black text-maroon-950 tracking-tight leading-none">Pengaturan Keamanan</h3>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    <!-- Form Ubah Kata Sandi -->
                    <form action="{{ route('profile.password.send') }}" method="POST" class="block m-0" onsubmit="confirmChangePassword(event)">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-between p-3.5 sm:p-4 bg-maroon-50 hover:bg-maroon-100 rounded-xl sm:rounded-2xl transition-all group">
                            <div class="flex items-center gap-2.5 sm:gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-maroon-700 sm:w-[18px] sm:h-[18px]"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                <span class="text-xs sm:text-sm font-bold text-maroon-950">Ubah Kata Sandi</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-maroon-300 group-hover:translate-x-1 transition-transform sm:w-[16px] sm:h-[16px]"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    </form>

                    <!-- Tombol Hubungi Admin -->
                    <button class="w-full flex items-center justify-between p-3.5 sm:p-4 bg-slate-50 hover:bg-slate-100 rounded-xl sm:rounded-2xl transition-all group">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-slate-500 sm:w-[18px] sm:h-[18px]"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            <span class="text-xs sm:text-sm font-bold text-slate-700">Hubungi Admin IT</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-slate-300 group-hover:translate-x-1 transition-transform sm:w-[16px] sm:h-[16px]"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>
            </section>

            <!-- Form Logout -->
            <form action="{{ url('/logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="w-full bg-white border-2 border-rose-100 text-rose-600 py-3.5 sm:py-4 rounded-2xl sm:rounded-3xl text-xs font-black uppercase tracking-[0.2em] shadow-sm hover:bg-rose-50 active:scale-[0.98] transition-all flex items-center justify-center gap-2.5 sm:gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[20px] sm:h-[20px]"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Keluar Akun
                </button>
            </form>
            <p class="text-center text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-widest italic pt-1 sm:pt-2">Sistem Presensi v2.5.0</p>
        </div>
    </div>
</main>

<!-- TAMBAHKAN LIBRARY SWEETALERT 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi konfirmasi Hapus Foto menggunakan SweetAlert
    function confirmDeleteFoto(event) {
        event.preventDefault(); // Mencegah submit form secara otomatis

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Foto Profil?',
                text: "Foto profil Anda akan dihapus dan kembali ke inisial nama.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48', // Tailwind rose-600
                cancelButtonColor: '#94a3b8',  // Tailwind slate-400
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
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

    // Fungsi konfirmasi Ubah Kata Sandi dengan SweetAlert
    function confirmChangePassword(event) {
        event.preventDefault(); // Mencegah submit form secara otomatis

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Ubah Kata Sandi?',
                text: "Sistem akan mengirimkan link ke email untuk mengatur ulang kata sandi Anda. Lanjutkan?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4d182b', // Tailwind maroon-900
                cancelButtonColor: '#94a3b8',  // Tailwind slate-400
                confirmButtonText: 'Ya, Ubah Sandi!',
                cancelButtonText: 'Batal',
                reverseButtons: true, // Tombol batal di kiri, ubah sandi di kanan
                customClass: {
                    popup: 'rounded-[2rem] p-4 sm:p-6 w-11/12 sm:w-auto',
                    title: 'text-lg sm:text-xl font-black text-maroon-950',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm shadow-lg',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5 sm:px-8 sm:py-3 text-xs sm:text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Lanjutkan submit jika dikonfirmasi
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin mengatur ulang kata sandi?')) {
                event.target.submit();
            }
        }
    }
</script>
@endsection