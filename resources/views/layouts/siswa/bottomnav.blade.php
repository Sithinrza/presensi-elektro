<!-- MOBILE NAVIGATION (Floating Dock Style) -->
    <nav class="lg:hidden fixed bottom-6 left-5 right-5 z-50">
        <div class="max-w-md mx-auto">
            <div class="bg-maroon-950/95 backdrop-blur-2xl rounded-[2.5rem] p-2 flex justify-between items-center shadow-2xl shadow-maroon-950/40 border border-white/10">
                <!-- Beranda -->
                <a href="{{ route('siswa.dashboard') }}"
                   class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->routeIs('siswa.dashboard') || request()->is('siswa/dashboard') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span class="text-[8px] font-black uppercase tracking-widest mt-1">Beranda</span>
                </a>

                <!-- Absen -->
                <a href="{{ route('presensi.index') }}"
                   class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->routeIs('presensi.index') || request()->is('siswa/presensi') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                    <span class="text-[8px] font-black uppercase tracking-widest mt-1">Absen</span>
                </a>

                <!-- Jurnal -->
                <a href="{{ route('siswa.log') }}"
                   class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->routeIs('siswa.log') || request()->is('siswa/logbook*') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                    <span class="text-[8px] font-black uppercase tracking-widest mt-1">Jurnal</span>
                </a>

                <!-- Riwayat -->
                <a href="{{ route('presensi.riwayat-presensi') }}"
                   class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->routeIs('presensi.riwayat-presensi') || request()->is('siswa/riwayat*') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span class="text-[8px] font-black uppercase tracking-widest mt-1">Riwayat</span>
                </a>

                <!-- Profil -->
                <a href="{{ route('siswa.profil.index') }}"
                   class="flex-1 flex flex-col items-center justify-center py-3 rounded-[2rem] transition-all duration-300 {{ request()->Routeis('siswa.profil.index') ? 'bg-white text-maroon-950 shadow-lg scale-105' : 'text-white/40' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span class="text-[8px] font-black uppercase tracking-widest mt-1">Profil</span>
                </a>
            </div>
        </div>
    </nav>
