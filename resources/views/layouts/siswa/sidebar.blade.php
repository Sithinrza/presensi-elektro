<!-- SIDEBAR NAVIGATION (Desktop) -->
    <aside class="hidden lg:flex fixed left-0 top-0 h-full w-28 bg-maroon-950 flex-col items-center py-8 z-50 border-r border-white/5 shadow-2xl">
        <!-- Logo -->
        <div class="mb-10 flex items-center justify-center px-4">
            <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo" class="w-16 h-16 object-contain drop-shadow-2xl">
        </div>

        <!-- Main Menus -->
        <div class="flex flex-col gap-3 flex-1 w-full px-3">
            <!-- 1. Dashboard -->
            <a href="{{ route('siswa.dashboard') }}" title="Dashboard"
               class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->routeIs('siswa.dashboard') || request()->is('siswa/dashboard') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/40 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->routeIs('siswa.dashboard') || request()->is('siswa/dashboard') ? 'opacity-100' : 'opacity-40' }}">Beranda</span>
            </a>
            
            <!-- 2. Presensi (Kamera/Scan) -->
            <a href="{{ route('presensi.index') }}" title="Presensi"
               class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->routeIs('presensi.index') || request()->is('siswa/presensi') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/40 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->routeIs('presensi.index') || request()->is('siswa/presensi') ? 'opacity-100' : 'opacity-40' }}">Absen</span>
            </a>

            <!-- 3. Riwayat Presensi -->
            <a href="{{ route('presensi.riwayat-presensi') }}" title="Riwayat Presensi"
               class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->routeIs('presensi.riwayat-presensi') || request()->is('siswa/riwayat*') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/40 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->routeIs('presensi.riwayat-presensi') || request()->is('siswa/riwayat*') ? 'opacity-100' : 'opacity-40' }}">Riwayat</span>
            </a>
            
            <!-- 4. Logbook -->
            <a href="{{ route('siswa.log') }}" title="Log Book"
               class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->routeIs('siswa.log') || request()->is('siswa/logbook*') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/40 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->routeIs('siswa.log') || request()->is('siswa/logbook*') ? 'opacity-100' : 'opacity-40' }}">Jurnal</span>
            </a>
        </div>

        <!-- 5. Profil -->
        <div class="w-full px-3 mt-4 space-y-2">
            <a href="{{ url('/siswa/profil') }}" title="Profil Saya"
               class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->is('siswa/profil*') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/40 hover:text-white' }}">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-maroon-950 rounded-full"></span>
                </div>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->is('siswa/profil*') ? 'opacity-100' : 'opacity-40' }}">Profil</span>
            </a>
        </div>
    </aside>