<!-- SIDEBAR NAVIGATION (Desktop) -->
<aside class="hidden lg:flex fixed left-0 top-0 h-full w-28 bg-maroon-950 flex-col items-center py-8 z-50 border-r border-white/5 shadow-2xl">
    <!-- Logo -->
    <div class="mb-10 flex items-center justify-center px-4">
        <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo" class="w-16 h-16 object-contain drop-shadow-2xl">
    </div>

    <!-- Main Menus -->
    <div class="flex flex-col gap-3 flex-1 w-full px-3">
        <!-- 1. Beranda -->
        <a href="{{ url('/pembimbing/dashboard') }}" title="Beranda"
           class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->is('pembimbing/dashboard') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->is('pembimbing/dashboard') ? 'opacity-100' : 'opacity-80' }}">Beranda</span>
        </a>
        
        <!-- 2. Siswa Bimbingan -->
        <a href="{{ route('pembimbing.presensi-siswa.index') }}" title="Siswa Bimbingan"
           class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->routeIs('pembimbing.presensi-siswa.*') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->routeIs('pembimbing.presensi-siswa.*') ? 'opacity-100' : 'opacity-80' }}">Siswa</span>
        </a>

        <!-- 3. Riwayat Jurnal Logbook -->
        <a href="{{ route('pembimbing.monitoring.index') }}" title="Riwayat Jurnal Logbook"
           class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->is('pembimbing/monitoring*') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->is('pembimbing/monitoring*') ? 'opacity-100' : 'opacity-80' }}">Logbook</span>
        </a>
        
        <!-- 4. Penilaian -->
        <a href="{{ route('pembimbing.nilai.index') ?? '#' }}" title="Penilaian"
           class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->routeIs('pembimbing.nilai.*') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
            <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->routeIs('pembimbing.nilai.*') ? 'opacity-100' : 'opacity-80' }}">Nilai</span>
        </a>

        <!-- 5. Profil -->
        <a href="{{ route('pembimbing.profil.index') }}" title="Profil Saya"
        class="group nav-transition flex flex-col items-center justify-center py-4 rounded-[2rem] {{ request()->routeIs('pembimbing.profil.*') ? 'bg-white text-maroon-950 shadow-xl scale-105' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-maroon-950 rounded-full"></span>
            </div>
            <span class="text-[9px] font-black uppercase tracking-[0.2em] mt-2 group-hover:opacity-100 transition-opacity {{ request()->routeIs('pembimbing.profil.*') ? 'opacity-100' : 'opacity-80' }}">Profil</span>
        </a>
    </div>

</aside>