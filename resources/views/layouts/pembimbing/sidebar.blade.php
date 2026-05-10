<!-- SIDEBAR NAVIGATION (Desktop) -->
<aside class="hidden lg:flex fixed left-0 top-0 h-full w-24 bg-maroon-950 flex-col items-center py-8 z-50 border-r border-white/10 shadow-2xl">
    <div class="mb-12">
        <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo" class="w-14 h-14 object-contain">
    </div>
    <div class="flex flex-col gap-6 flex-1">
        <!-- Dashboard -->
        <a href="{{ url('/pembimbing/dashboard') }}" title="Beranda"
           class="p-4 transition-all duration-300 {{ request()->is('pembimbing/dashboard') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </a>
        <!-- Data Siswa Bimbingan -->
        <a href="#" title="Siswa Bimbingan"
           class="p-4 transition-all duration-300 {{ request()->is('pembimbing/siswa') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </a>
        <!-- Presensi/Logbook Masuk -->
        <a href="#" title="Riwayat"
           class="p-4 transition-all duration-300 {{ request()->is('pembimbing/riwayat') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </a>
        <!-- Input Nilai -->
        <a href="#" title="Penilaian"
           class="p-4 transition-all duration-300 {{ request()->is('pembimbing/nilai') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
        </a>
    </div>
    <!-- Profil / Logout -->
    <a href="#" class="p-4 text-white/50 hover:text-rose-400 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </a>
</aside>
