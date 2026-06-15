<header class="sticky top-0 z-40 glass-effect border-b border-maroon-100/30 px-4 sm:px-5 lg:px-10 py-3 sm:py-4 bg-white/80 backdrop-blur-md">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 overflow-hidden">
            <button onclick="toggleSidebar()" class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-lg sm:rounded-xl bg-maroon-50 text-maroon-950 hover:bg-maroon-100 transition-colors shadow-sm shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="min-w-0">
                <h1 class="text-sm sm:text-base md:text-lg font-extrabold text-maroon-950 leading-none tracking-tight truncate">
                    @yield('page_title', 'Dashboard')
                </h1>

            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-black text-maroon-950 leading-none tracking-tight truncate max-w-[150px]">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-[9px] font-bold text-maroon-500 uppercase mt-1 tracking-widest">
                    {{ Auth::user()->roles->first() ? ucfirst(Auth::user()->roles->first()->name) : 'User' }}
                </p>
            </div>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-gold p-0.5 shadow-sm overflow-hidden flex items-center justify-center bg-white focus:outline-none active:scale-95 transition-transform">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->email) }}&background=800000&color=fff&bold=true" alt="Admin Avatar" class="w-full h-full rounded-full object-cover">
                </button>

                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-2" class="absolute right-0 mt-2 sm:mt-3 w-48 bg-white rounded-2xl shadow-xl border border-maroon-50 py-2 z-50" style="display: none;">
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-5 py-3 text-[11px] sm:text-xs font-bold text-rose-600 hover:bg-rose-50 flex items-center gap-3 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Logout/Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
