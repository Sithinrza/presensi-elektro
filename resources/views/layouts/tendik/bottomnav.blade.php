<!-- MOBILE NAVIGATION (Floating Dock Style) -->
<nav class="lg:hidden fixed bottom-6 left-5 right-5 z-50">
    <div class="max-w-md mx-auto">
        <div class="bg-maroon-950/95 backdrop-blur-2xl rounded-[2.5rem] p-2 flex justify-between items-center shadow-2xl shadow-maroon-950/40 border border-white/10">
            <!-- Beranda -->
            <a href="{{ route('tendik.dashboard') }}"
               class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->is('tendik/dashboard') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="text-[8px] font-black uppercase tracking-widest mt-1">Beranda</span>
            </a>

            <!-- presensi -->
            <a href="{{ route('presensi.index') }}"
               class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->is('tendik/presensi') || request()->routeIs('presensi.index') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                <span class="text-[8px] font-black uppercase tracking-widest mt-1">Presensi</span>
            </a>

            <!-- Riwayat -->
            <a href="{{ route('presensi.riwayat-presensi') }}"
               class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->is('tendik/riwayat') || request()->routeIs('presensi.riwayat-presensi') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span class="text-[8px] font-black uppercase tracking-widest mt-1">Riwayat</span>
            </a>

            <!-- Profil -->
            <a href="{{ route('tendik.profil.index') }}"
               class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->Routeis('tendik.profil.index') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="text-[8px] font-black uppercase tracking-widest mt-1">Profil</span>
            </a>
        </div>
    </div>
</nav>
