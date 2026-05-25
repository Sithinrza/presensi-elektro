<aside id="sidebar" class="fixed left-0 top-0 h-full bg-maroon-950 flex flex-col py-8 border-r border-white/10 shadow-2xl z-50">
    <div class="px-6 mb-10 flex items-center gap-3 overflow-hidden">
        <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo" class="w-10 h-10 object-contain shrink-0">
        <div class="sidebar-header-text whitespace-nowrap">
            <h2 class="text-white font-black text-sm leading-none tracking-tight uppercase">Admin Panel</h2>
            <p class="text-gold-dark text-[9px] font-bold uppercase mt-1 tracking-widest leading-none">Jurusan Elektro</p>
        </div>
    </div>

    <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto no-scrollbar">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/dashboard') ? 'bg-maroon-500 text-white shadow-lg shadow-maroon-900/50' : 'text-white/50 hover:text-white hover:bg-white/5 group' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Beranda</span>
        </a>

        <div class="sidebar-section-label pt-6 pb-2 px-4">
            <span class="text-[9px] font-black text-maroon-300/40 uppercase tracking-[0.2em]">Data Master</span>
        </div>

        <a href="{{ route('admin.data.siswa.index') }}"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/data/siswa') ? 'bg-maroon-500 text-white shadow-lg shadow-maroon-900/50' : 'text-white/50 hover:text-white hover:bg-white/5 group' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:scale-110 transition-transform">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Data Siswa</span>
        </a>

        <a href="{{ route('admin.data.tendik.index') }}"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/data/tendik') ? 'bg-maroon-500 text-white shadow-lg shadow-maroon-900/50' : 'text-white/50 hover:text-white hover:bg-white/5 group' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:scale-110 transition-transform">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/><rect x="19" y="8" width="2" height="10"/>
                <path d="M19 8c0-1.1.9-2 2-2"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Data Tendik</span>
        </a>

        <a href="{{ route('admin.data.pembimbing.index') }}"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/data/pembimbing') ? 'bg-maroon-500 text-white shadow-lg shadow-maroon-900/50' : 'text-white/50 hover:text-white hover:bg-white/5 group' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:scale-110 transition-transform"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Pembimbing</span>
        </a>

        <div class="sidebar-section-label pt-6 pb-2 px-4">
            <span class="text-[9px] font-black text-maroon-300/40 uppercase tracking-[0.2em]">Presensi & Laporan</span>
        </div>

        <a href="{{ route('admin.riwayat.index') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.riwayat.*') ? 'bg-maroon-500 text-white shadow-lg shadow-maroon-900/50' : 'text-white/50 hover:text-white hover:bg-white/5 group' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:scale-110 transition-transform"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Riwayat Presensi</span>
        </a>

        <a href="{{ route('admin.klaim.index') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.klaim.*') ? 'bg-maroon-500 text-white shadow-lg shadow-maroon-900/50' : 'text-white/50 hover:text-white hover:bg-white/5 group' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:scale-110 transition-transform">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            <span class="sidebar-text flex-1 flex items-center justify-between text-xs font-bold uppercase tracking-wide whitespace-nowrap">
                Verifikasi Klaim
                @php
                    $pendingCount = \App\Models\KlaimPresensi::where('status_verifikasi', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="bg-amber-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full ml-2 shadow-sm">{{ $pendingCount }}</span>
                @endif
            </span>
        </a>

        <a href="{{ route('admin.log') }}"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/log') ? 'bg-maroon-500 text-white shadow-lg shadow-maroon-900/50' : 'text-white/50 hover:text-white hover:bg-white/5 group' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:scale-110 transition-transform">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Logbook Siswa</span>
        </a>

        <a href="{{ route('admin.hari-libur.index') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.hari-libur*') ? 'bg-maroon-500 text-white shadow-lg shadow-maroon-900/50' : 'text-white/50 hover:text-white hover:bg-white/5 group' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:scale-110 transition-transform">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
            </svg>
            <span class="sidebar-text text-xs font-bold uppercase tracking-wide whitespace-nowrap">Hari Libur</span>
        </a>
    </nav>

    <div class="px-4 mt-6">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-rose-500/10 text-rose-500 rounded-xl font-bold text-xs hover:bg-rose-500 hover:text-white transition-all overflow-hidden whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="sidebar-text">LOGOUT</span>
            </button>
        </form>
    </div>
</aside>
