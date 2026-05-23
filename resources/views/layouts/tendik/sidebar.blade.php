<!-- SIDEBAR NAVIGATION (Desktop) -->
<aside class="hidden lg:flex fixed left-0 top-0 h-full w-24 bg-maroon-950 flex-col items-center py-8 z-50 border-r border-white/10 shadow-2xl">
    <div class="mb-12 flex items-center justify-center px-4">
        <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo" class="w-14 h-14 object-contain">
    </div>
    <div class="flex flex-col gap-8 flex-1">
        <!-- Dashboard -->
        <a href="{{ route('tendik.dashboard') }}" title="Dashboard"
           class="p-3 transition-all duration-300 {{ request()->is('tendik/dashboard') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </a>
        <!-- Presensi Masuk/Pulang -->
        <a href="{{ route('presensi.index') }}" title="Presensi"
           class="p-3 transition-all duration-300 {{ request()->is('tendik/presensi') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
        </a>
        <!-- Riwayat -->
        <a href="{{ route('presensi.riwayat-presensi') }}" title="Riwayat"
           class="p-3 transition-all duration-300 {{ request()->is('tendik/riwayat') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </a>
    </div>
    <!-- Profil / Logout -->
    <a href="{{ url('/tendik/profil') }}" title="Profil Saya"
       class="p-3 transition-all duration-300 {{ request()->is('tendik/profil') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-rose-400' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </a>
</aside>
