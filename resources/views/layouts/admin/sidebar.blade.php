<aside id="sidebar" class="fixed left-0 top-0 h-full w-[260px] bg-maroon-950 flex flex-col py-6 shadow-2xl z-50 transition-all duration-300">
    
    <!-- HEADER LOGO & TITLE -->
    <div class="px-7 mb-8 flex items-center gap-4 overflow-hidden">
        <!-- Logo tanpa kotak putih, ditambah efek bayangan -->
        <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo Poliban" class="w-11 h-11 object-contain shrink-0 drop-shadow-md">
        
        <div class="sidebar-header-text whitespace-nowrap">
            <h2 class="text-white font-black text-sm leading-none tracking-tight uppercase">Admin Panel</h2>
            <p class="text-amber-400 text-[10px] font-bold uppercase mt-1 tracking-widest leading-none">Jurusan Elektro</p>
        </div>
    </div>

    <!-- NAVIGATION MENU -->
    <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto no-scrollbar pb-4">
        
        <!-- 1. BERANDA -->
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('admin/dashboard') ? 'bg-white/10 text-amber-400 shadow-inner' : 'text-maroon-200/70 hover:text-white hover:bg-white/5 group' }}">
            <!-- Ikon Dashboard/Beranda -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/dashboard') ? '' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Beranda</span>
        </a>

        <!-- LABEL: DATA MASTER -->
        <div class="sidebar-section-label pt-6 pb-2 px-4">
            <span class="text-[10px] font-black text-maroon-300/40 uppercase tracking-[0.2em]">Data Master</span>
        </div>

        <!-- 2. DATA SISWA -->
        <a href="{{ route('admin.data.siswa.index') }}"
           class="nav-item flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('admin/data/siswa*') ? 'bg-white/10 text-amber-400 shadow-inner' : 'text-maroon-200/70 hover:text-white hover:bg-white/5 group' }}">
            <!-- Ikon Topi Toga (Siswa) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/data/siswa*') ? '' : 'group-hover:scale-110 transition-transform' }}">
                <path d="M21.42 10.922a2 2 0 0 0-.019-3.838L12.83 4.34a2 2 0 0 0-1.66 0L2.6 7.08a2 2 0 0 0 0 3.84l9.36 4.34a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Data Siswa</span>
        </a>

        <!-- 3. DATA TENDIK -->
        <a href="{{ route('admin.data.tendik.index') }}"
           class="nav-item flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('admin/data/tendik*') ? 'bg-white/10 text-amber-400 shadow-inner' : 'text-maroon-200/70 hover:text-white hover:bg-white/5 group' }}">
            <!-- Ikon Koper Kerja (Tendik) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/data/tendik*') ? '' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Data Tendik</span>
        </a>

        <!-- 4. PEMBIMBING -->
        <a href="{{ route('admin.data.pembimbing.index') }}"
           class="nav-item flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('admin/data/pembimbing*') ? 'bg-white/10 text-amber-400 shadow-inner' : 'text-maroon-200/70 hover:text-white hover:bg-white/5 group' }}">
            <!-- Ikon ID Card/Sertifikat (Pembimbing) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/data/pembimbing*') ? '' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><circle cx="12" cy="14" r="3"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Pembimbing</span>
        </a>

        <!-- LABEL: PRESENSI -->
        <div class="sidebar-section-label pt-6 pb-2 px-4">
            <span class="text-[10px] font-black text-maroon-300/40 uppercase tracking-[0.2em]">Presensi & Laporan</span>
        </div>

        <!-- 5. RIWAYAT PRESENSI -->
        <a href="{{ route('admin.riwayat.index') }}"
            class="nav-item flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.riwayat.*') ? 'bg-white/10 text-amber-400 shadow-inner' : 'text-maroon-200/70 hover:text-white hover:bg-white/5 group' }}">
            <!-- Ikon Papan Jalan (Riwayat Presensi) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->routeIs('admin.riwayat.*') ? '' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Riwayat Presensi</span>
        </a>

        <!-- 5. RIWAYAT PRESENSI -->
        <a href="#"
            class="nav-item flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.riwayat.*') ? 'bg-white/10 text-amber-400 shadow-inner' : 'text-maroon-200/70 hover:text-white hover:bg-white/5 group' }}">
            <!-- Ikon Papan Jalan (Riwayat Presensi) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->routeIs('admin.riwayat.*') ? '' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Verifikasi Klaim</span>
        </a>

        <!-- 6. LOGBOOK SISWA -->
        <a href="{{ route('admin.log') }}"
           class="nav-item flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('admin/log*') ? 'bg-white/10 text-amber-400 shadow-inner' : 'text-maroon-200/70 hover:text-white hover:bg-white/5 group' }}">
            <!-- Ikon Buku (Logbook) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->is('admin/log*') ? '' : 'group-hover:scale-110 transition-transform' }}">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Logbook Siswa</span>
        </a>

        <!-- 7. HARI LIBUR -->
        <a href="{{ route('admin.hari-libur') }}"
            class="nav-item flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.hari-libur*') ? 'bg-white/10 text-amber-400 shadow-inner' : 'text-maroon-200/70 hover:text-white hover:bg-white/5 group' }}">
            <!-- Ikon Kalender (Hari Libur) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 {{ request()->routeIs('admin.hari-libur*') ? '' : 'group-hover:scale-110 transition-transform' }}">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Hari Libur</span>
        </a>
    </nav>

    <!-- TOMBOL LOGOUT -->
    <div class="px-6 mt-2 pt-6 border-t border-white/5">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-rose-500/10 text-rose-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-rose-500 hover:text-white hover:shadow-lg hover:shadow-rose-500/20 active:scale-95 transition-all overflow-hidden whitespace-nowrap group">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:-translate-x-1 transition-transform"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="sidebar-text">Logout</span>
            </button>
        </form>
    </div>
</aside>