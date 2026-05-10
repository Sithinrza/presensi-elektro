@extends('layouts.tendik')

@section('content')
<!-- CSS KHUSUS HALAMAN PROFIL -->
<style>
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: slideIn 0.5s ease-out forwards;
    }
    .edit-input {
        @apply w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none transition-all;
    }
</style>

<!-- KONTEN UTAMA PROFIL -->
<main class="max-w-4xl mx-auto p-5 lg:p-10 space-y-8 animate-in">

    <!-- Judul Halaman (Untuk Mobile) -->
    <div class="flex items-center justify-between mb-4 lg:hidden">
        <h1 class="text-xl font-extrabold text-maroon-950 tracking-tight">Profil Pengguna</h1>
        <div class="text-[10px] font-black text-maroon-600 bg-maroon-50 px-2 py-1 rounded-lg uppercase tracking-widest">Aktif</div>
    </div>

    <!-- SECTION 1: HEADER PROFIL -->
    <section class="bg-maroon-900 rounded-[3rem] p-8 md:p-12 text-white shadow-premium overflow-hidden border border-maroon-800 relative">
        <div class="absolute -top-12 -right-12 w-64 h-64 bg-gold/20 rounded-full blur-[80px]"></div>
        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-white/10 rounded-full blur-[60px]"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <!-- Avatar -->
            <div class="relative">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-gold p-1 shadow-2xl">
                    <img src="https://i.pravatar.cc/300?img=11" alt="Foto Profil" class="w-full h-full rounded-full object-cover">
                </div>
                <button class="absolute bottom-1 right-1 w-10 h-10 bg-gold text-maroon-950 rounded-full flex items-center justify-center border-4 border-maroon-900 shadow-lg active:scale-90 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </button>
            </div>

            <!-- Nama & Role -->
            <div class="text-center md:text-left space-y-2">
                <h2 class="text-3xl md:text-4xl font-black tracking-tight leading-none italic">Nurul Kholisyah</h2>
                <div class="flex flex-col md:flex-row items-center gap-3">
                    <span class="text-gold font-bold text-sm tracking-[0.2em] uppercase">Siswa Magang</span>
                    <span class="hidden md:block w-1.5 h-1.5 bg-white/30 rounded-full"></span>
                    <span class="text-maroon-100/70 text-sm font-medium">Politeknik Negeri Banjarmasin</span>
                </div>
                <p class="text-[10px] text-maroon-200/50 font-bold uppercase tracking-widest pt-2">Bergabung Sejak Maret 2024</p>
            </div>
        </div>
    </section>

    <!-- SECTION 2: DETAIL INFORMASI -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

        <!-- Informasi Pribadi -->
        <section id="personal-info-card" class="bg-white rounded-[2.5rem] p-8 border border-maroon-100 shadow-sm space-y-6 transition-all duration-300">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-maroon-50 text-maroon-700 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-maroon-950 tracking-tight">Informasi Pribadi</h3>
                </div>
                <!-- Tombol Edit -->
                <button onclick="toggleEditMode()" id="edit-btn" class="text-xs font-bold text-maroon-600 hover:text-maroon-900 flex items-center gap-1 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    Edit
                </button>
            </div>

            <div class="space-y-5">
                <!-- NIM/NIS -->
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">Nomor Induk Siswa (NIM)</p>
                    <div id="nis-view" class="text-sm font-bold text-maroon-950">202100567821</div>
                    <input id="nis-input" type="text" value="202100567821" class="hidden w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>
                <!-- Email -->
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">Email Terdaftar</p>
                    <div id="email-view" class="text-sm font-bold text-maroon-950">nurul.kholisyah@student.poliban.ac.id</div>
                    <input id="email-input" type="email" value="nurul.kholisyah@student.poliban.ac.id" class="hidden w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>
                <!-- Telepon -->
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">Nomor Telepon</p>
                    <div id="phone-view" class="text-sm font-bold text-maroon-950">+62 821-5542-XXXX</div>
                    <input id="phone-input" type="text" value="+62 821-5542-XXXX" class="hidden w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-maroon-950 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>
            </div>

            <!-- Tombol Simpan/Batal -->
            <div id="edit-actions" class="hidden flex items-center gap-3 pt-4 border-t border-slate-100">
                <button onclick="saveChanges()" class="flex-1 bg-maroon-900 text-white py-3 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-maroon-900/20 active:scale-95 transition-all">Simpan</button>
                <button onclick="toggleEditMode()" class="flex-1 bg-slate-100 text-slate-500 py-3 rounded-xl text-xs font-black uppercase tracking-widest active:scale-95 transition-all">Batal</button>
            </div>
        </section>

        <!-- Pengaturan Akun -->
        <section class="bg-white rounded-[2.5rem] p-8 border border-maroon-100 shadow-sm space-y-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gold-light text-gold-dark rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <h3 class="text-lg font-black text-maroon-950 tracking-tight">Pengaturan Keamanan</h3>
            </div>

            <div class="space-y-4">
                <button class="w-full flex items-center justify-between p-4 bg-maroon-50 hover:bg-maroon-100 rounded-2xl transition-all group">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-maroon-700"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <span class="text-sm font-bold text-maroon-950">Ubah Kata Sandi</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-maroon-300 group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"/></svg>
                </button>

                <button class="w-full flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100 rounded-2xl transition-all group">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-slate-500"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <span class="text-sm font-bold text-slate-700">Hubungi Admin IT</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-slate-300 group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </section>
    </div>

    <!-- LOGOUT SECTION (Di dalam form agar aman) -->
    <section class="animate-in" style="animation-delay: 0.3s">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-white border-2 border-rose-100 text-rose-600 py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-sm hover:bg-rose-50 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar dari Akun
            </button>
        </form>
        <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-6 italic">Versi Aplikasi 2.5.0 - Elektro Poliban</p>
    </section>

</main>

<!-- SCRIPT LOGIKA EDIT PROFIL -->
<script>
    let isEditMode = false;

    function toggleEditMode() {
        isEditMode = !isEditMode;

        const views = ['nis-view', 'email-view', 'phone-view'];
        const inputs = ['nis-input', 'email-input', 'phone-input'];
        const editBtn = document.getElementById('edit-btn');
        const actions = document.getElementById('edit-actions');
        const card = document.getElementById('personal-info-card');

        views.forEach(id => document.getElementById(id).classList.toggle('hidden', isEditMode));
        inputs.forEach(id => document.getElementById(id).classList.toggle('hidden', !isEditMode));

        editBtn.classList.toggle('hidden', isEditMode);
        actions.classList.toggle('hidden', !isEditMode);

        if(isEditMode) {
            card.classList.add('ring-2', 'ring-maroon-100', 'bg-maroon-50/20');
        } else {
            card.classList.remove('ring-2', 'ring-maroon-100', 'bg-maroon-50/20');
        }
    }

    function saveChanges() {
        // Simulasi penyimpanan data
        document.getElementById('nis-view').textContent = document.getElementById('nis-input').value;
        document.getElementById('email-view').textContent = document.getElementById('email-input').value;
        document.getElementById('phone-view').textContent = document.getElementById('phone-input').value;

        // Matikan mode edit
        toggleEditMode();
        console.log("Data berhasil diperbarui secara lokal");
    }
</script>
@endsection
