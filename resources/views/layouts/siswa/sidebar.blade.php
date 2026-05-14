<!-- SIDEBAR NAVIGATION (Desktop) -->
<aside class="hidden lg:flex fixed left-0 top-0 h-full w-24 bg-maroon-950 flex-col items-center py-8 z-50 border-r border-white/10 shadow-2xl">
    <div class="mb-8">
        <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo" class="w-14 h-14 object-contain">
    </div>

    <div class="flex flex-col gap-6 flex-1">
        <!-- 1. Dashboard -->
        <a href="{{ route('siswa.dashboard') }}" title="Dashboard"
           class="p-4 transition-all {{ request()->is('siswa/dashboard') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </a>

        <!-- 2. Presensi (Kamera/Scan) -->
        <a href="{{ route('presensi.index') }}" title="Presensi"
           class="p-4 transition-all {{ request()->routeIs('presensi.index') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
        </a>

        <!-- 3. Riwayat Presensi -->
        <a href="{{ route('presensi.riwayat-presensi') }}" title="Riwayat Presensi"
           class="p-4 transition-all {{ request()->is('siswa/riwayat') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </a>

        <!-- 4. Logbook -->
        <a href="{{ route('siswa.log') }}" title="Log Book"
           class="p-4 transition-all {{ request()->is('siswa/logbook') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
        </a>

        <!-- 5. Profil -->
        <a href="{{ url('/siswa/profil') }}" title="Profil Saya"
           class="p-4 transition-all {{ request()->is('siswa/profil') ? 'bg-white text-maroon-950 rounded-2xl shadow-lg' : 'text-white/50 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </a>
    </div>

    <!-- Tombol Logout -->
    <form action="{{ url('/logout') }}" method="POST" class="m-0 p-0 mt-4">
        @csrf
        <button type="submit" title="Logout" class="p-4 text-white/50 hover:text-rose-400 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
    </form>
</aside>
