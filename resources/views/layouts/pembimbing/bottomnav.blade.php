<!-- MOBILE NAVIGATION (Floating Dock Style) -->
<nav class="lg:hidden fixed bottom-6 left-5 right-5 z-50">
    <div class="max-w-md mx-auto">
        <div class="bg-maroon-950/95 backdrop-blur-2xl rounded-[2.5rem] p-2 flex justify-between items-center shadow-2xl shadow-maroon-950/40 border border-white/10">
            <!-- Beranda -->
            <a href="{{ url('/pembimbing/dashboard') }}" 
               class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->is('pembimbing/dashboard') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="text-[8px] font-black uppercase tracking-widest mt-1">Beranda</span>
            </a>

            <!-- Siswa -->
            <a href="{{ route('pembimbing.presensi-siswa.index') }}" 
               class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->routeIs('pembimbing.presensi-siswa.*') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="text-[8px] font-black uppercase tracking-widest mt-1">Siswa</span>
            </a>

            <!-- Logbook -->
            <a href="{{ route('pembimbing.monitoring.index') }}" 
               class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->is('pembimbing/monitoring*') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span class="text-[8px] font-black uppercase tracking-widest mt-1">Logbook</span>
            </a>

            <!-- Nilai -->
            <a href="#" 
               class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->is('pembimbing/nilai') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                <span class="text-[8px] font-black uppercase tracking-widest mt-1">Nilai</span>
            </a>
        </div>
    </div>
</nav>