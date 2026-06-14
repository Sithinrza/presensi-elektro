<!-- SIDEBAR NAVIGATION -->
<aside id="sidebar" class="fixed left-0 top-0 h-full w-[260px] bg-maroon-950 flex flex-col py-6 shadow-2xl z-50 transition-all duration-300 -translate-x-full md:translate-x-0 border-r border-white/5">

    <!-- Header Logo & Title -->
    <div class="px-7 mb-8 flex items-center gap-4 overflow-hidden">
        <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo Poliban" class="w-11 h-11 object-contain shrink-0 drop-shadow-md">
        <div class="sidebar-header-text whitespace-nowrap">
            <h2 class="text-white font-black text-sm leading-none tracking-tight uppercase">Admin Sipetang</h2>
            <p class="text-amber-400 text-[10px] font-bold uppercase mt-1 tracking-widest leading-none">Jurusan Elektro</p>
        </div>
    </div>

    <!-- Main Navigation Menus -->
    <nav class="flex-1 px-3 space-y-1.5 overflow-y-auto no-scrollbar pb-4 relative">
        
        <!-- 1. BERANDA -->
        <a href="{{ route('admin.dashboard') }}" title="Beranda"
           class="nav-item relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/dashboard') ? 'bg-gradient-to-r from-amber-400/10 to-transparent text-amber-400' : 'text-white/80 hover:text-white hover:bg-white/10 group' }}">
            
            <!-- Active Indicator Pill -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-amber-400 rounded-r-full shadow-[0_0_12px_rgba(251,191,36,0.6)] transition-opacity duration-300 {{ request()->is('admin/dashboard') ? 'opacity-100' : 'opacity-0' }}"></div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/dashboard') ? 'drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Beranda</span>
        </a>

        <!-- LABEL: DATA MASTER -->
        <div class="sidebar-section-label pt-6 pb-2 px-4">
            <span class="text-[9px] font-black text-maroon-300/70 uppercase tracking-[0.2em]">Data Master</span>
        </div>

        <!-- 2. DATA SISWA -->
        <a href="{{ route('admin.data.siswa.index') }}" title="Data Siswa"
           class="nav-item relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/data/siswa*') ? 'bg-gradient-to-r from-amber-400/10 to-transparent text-amber-400' : 'text-white/80 hover:text-white hover:bg-white/10 group' }}">
            
            <!-- Active Indicator Pill -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-amber-400 rounded-r-full shadow-[0_0_12px_rgba(251,191,36,0.6)] transition-opacity duration-300 {{ request()->is('admin/data/siswa*') ? 'opacity-100' : 'opacity-0' }}"></div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/data/siswa*') ? 'drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'group-hover:scale-110 transition-transform' }}">
                <path d="M21.42 10.922a2 2 0 0 0-.019-3.838L12.83 4.34a2 2 0 0 0-1.66 0L2.6 7.08a2 2 0 0 0 0 3.84l9.36 4.34a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Data Siswa</span>
        </a>

        <!-- 3. DATA TENDIK -->
        <a href="{{ route('admin.data.tendik.index') }}" title="Data Tendik"
           class="nav-item relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/data/tendik*') ? 'bg-gradient-to-r from-amber-400/10 to-transparent text-amber-400' : 'text-white/80 hover:text-white hover:bg-white/10 group' }}">
            
            <!-- Active Indicator Pill -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-amber-400 rounded-r-full shadow-[0_0_12px_rgba(251,191,36,0.6)] transition-opacity duration-300 {{ request()->is('admin/data/tendik*') ? 'opacity-100' : 'opacity-0' }}"></div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/data/tendik*') ? 'drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Data Tendik</span>
        </a>

        <!-- 4. PEMBIMBING -->
        <a href="{{ route('admin.data.pembimbing.index') }}" title="Pembimbing"
           class="nav-item relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/data/pembimbing*') ? 'bg-gradient-to-r from-amber-400/10 to-transparent text-amber-400' : 'text-white/80 hover:text-white hover:bg-white/10 group' }}">
            
            <!-- Active Indicator Pill -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-amber-400 rounded-r-full shadow-[0_0_12px_rgba(251,191,36,0.6)] transition-opacity duration-300 {{ request()->is('admin/data/pembimbing*') ? 'opacity-100' : 'opacity-0' }}"></div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/data/pembimbing*') ? 'drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><circle cx="12" cy="14" r="3"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Pembimbing</span>
        </a>

        <!-- LABEL: PRESENSI & LAPORAN -->
        <div class="sidebar-section-label pt-6 pb-2 px-4">
            <span class="text-[10px] font-black text-maroon-300/70 uppercase tracking-[0.2em]">Presensi & Laporan</span>
        </div>

        <!-- 5. RIWAYAT PRESENSI -->
        <a href="{{ route('admin.riwayat.index') }}" title="Riwayat Presensi"
           class="nav-item relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.riwayat.*') ? 'bg-gradient-to-r from-amber-400/10 to-transparent text-amber-400' : 'text-white/80 hover:text-white hover:bg-white/10 group' }}">
            
            <!-- Active Indicator Pill -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-amber-400 rounded-r-full shadow-[0_0_12px_rgba(251,191,36,0.6)] transition-opacity duration-300 {{ request()->routeIs('admin.riwayat.*') ? 'opacity-100' : 'opacity-0' }}"></div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->routeIs('admin.riwayat.*') ? 'drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Riwayat Presensi</span>
        </a>

        <!-- 6. LOGBOOK SISWA -->
        <a href="{{ route('admin.log') }}" title="Logbook Siswa"
           class="nav-item relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/log*') ? 'bg-gradient-to-r from-amber-400/10 to-transparent text-amber-400' : 'text-white/80 hover:text-white hover:bg-white/10 group' }}">
            
            <!-- Active Indicator Pill -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-amber-400 rounded-r-full shadow-[0_0_12px_rgba(251,191,36,0.6)] transition-opacity duration-300 {{ request()->is('admin/log*') ? 'opacity-100' : 'opacity-0' }}"></div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/log*') ? 'drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'group-hover:scale-110 transition-transform' }}">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Logbook Siswa</span>
        </a>

        <!-- 7. HARI LIBUR -->
        <a href="{{ route('admin.hari-libur.index') }}" title="Hari Libur"
           class="nav-item relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.hari-libur.*') ? 'bg-gradient-to-r from-amber-400/10 to-transparent text-amber-400' : 'text-white/80 hover:text-white hover:bg-white/10 group' }}">
            
            <!-- Active Indicator Pill -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-amber-400 rounded-r-full shadow-[0_0_12px_rgba(251,191,36,0.6)] transition-opacity duration-300 {{ request()->routeIs('admin.hari-libur.*') ? 'opacity-100' : 'opacity-0' }}"></div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->routeIs('admin.hari-libur.*') ? 'drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'group-hover:scale-110 transition-transform' }}">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Hari Libur</span>
        </a>

        <!-- LABEL: MANAJEMEN SERTIFIKAT -->
        <div class="sidebar-section-label pt-6 pb-2 px-4">
            <span class="text-[10px] font-black text-maroon-300/70 uppercase tracking-[0.2em]">Manajemen Sertifikat</span>
        </div>

        <!-- 8. PENERBITAN SERTIFIKAT -->
        <a href="{{ route('admin.sertifikat.index') }}" title="Sertifikat Siswa"
           class="nav-item relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.sertifikat.*') ? 'bg-gradient-to-r from-amber-400/10 to-transparent text-amber-400' : 'text-white/80 hover:text-white hover:bg-white/10 group' }}">
            
            <!-- Active Indicator Pill -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-amber-400 rounded-r-full shadow-[0_0_12px_rgba(251,191,36,0.6)] transition-opacity duration-300 {{ request()->routeIs('admin.sertifikat.*') ? 'opacity-100' : 'opacity-0' }}"></div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->routeIs('admin.sertifikat.*') ? 'drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'group-hover:scale-110 transition-transform' }}">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Sertifikat Siswa</span>
        </a>

        <!-- 9. MASTER KAJUR -->
        <a href="{{ route('admin.kajur.index') }}" title="Master Kajur"
           class="nav-item relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.kajur.*') ? 'bg-gradient-to-r from-amber-400/10 to-transparent text-amber-400' : 'text-white/80 hover:text-white hover:bg-white/10 group' }}">
            
            <!-- Active Indicator Pill -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-amber-400 rounded-r-full shadow-[0_0_12px_rgba(251,191,36,0.6)] transition-opacity duration-300 {{ request()->routeIs('admin.kajur.*') ? 'opacity-100' : 'opacity-0' }}"></div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->routeIs('admin.kajur.*') ? 'drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'group-hover:scale-110 transition-transform' }}">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Master Kajur</span>
        </a>

    </nav>

    <!-- TOMBOL LOGOUT -->
    <div class="px-4 mt-4 shrink-0 transition-all duration-300">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" title="Logout dari Aplikasi" class="w-full flex items-center justify-center gap-3 px-4 py-3.5 bg-rose-500/10 text-rose-500 rounded-2xl font-black text-xs hover:bg-rose-600 hover:text-white hover:shadow-[0_0_15px_rgba(225,29,72,0.4)] active:scale-95 transition-all duration-300 overflow-hidden whitespace-nowrap group">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:-translate-x-1 transition-transform"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="sidebar-text tracking-widest font-black uppercase">Logout</span>
            </button>
        </form>
    </div>
</aside>