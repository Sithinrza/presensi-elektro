<!-- FLOATING BOTTOM NAVIGATION (Mobile Only) -->
<nav class="lg:hidden fixed bottom-6 left-5 right-5 z-50">
    <div class="max-w-md mx-auto">
        <div class="bg-maroon-950/95 backdrop-blur-2xl rounded-[2.5rem] p-2.5 flex justify-between items-center shadow-2xl shadow-maroon-950/40 border border-white/10">
            <!-- Dashboard -->
            <a href="{{ url('/tendik/dashboard') }}"
               class="w-14 h-14 flex items-center justify-center rounded-full transition-all duration-300 {{ request()->is('tendik/dashboard') ? 'bg-white text-maroon-950 shadow-xl' : 'text-white/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </a>
            <!-- Presensi -->
            <a href="{{ url('/tendik/presensi') }}"
               class="w-14 h-14 flex items-center justify-center rounded-full transition-all duration-300 {{ request()->is('tendik/presensi') ? 'bg-white text-maroon-950 shadow-xl' : 'text-white/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
            </a>
            <!-- Riwayat -->
            <a href="{{ url('/tendik/riwayat') }}"
               class="w-14 h-14 flex items-center justify-center rounded-full transition-all duration-300 {{ request()->is('tendik/riwayat') ? 'bg-white text-maroon-950 shadow-xl' : 'text-white/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </a>
            <!-- Profil -->
            <a href="{{ url('/tendik/profil') }}"
               class="w-14 h-14 flex items-center justify-center rounded-full transition-all duration-300 {{ request()->is('tendik/profil') ? 'bg-white text-maroon-950 shadow-xl' : 'text-white/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </a>
        </div>
    </div>
</nav>
