<header class="sticky top-0 z-40 glass-effect px-10 py-5">
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-6">
      <button onclick="toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-maroon-50 text-maroon-950 hover:bg-maroon-100 transition-colors shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>

    <div class="flex items-center gap-6">
        <div class="text-right">
            <p class="text-xs font-black text-maroon-950 leading-none tracking-tight">
                {{ Auth::user()->email }}
            </p>
            <p class="text-[9px] font-bold text-maroon-500 uppercase mt-1 tracking-tighter italic">
                {{ Auth::user()->roles->first() ? ucfirst(Auth::user()->roles->first()->name) : 'User' }}
            </p>
        </div>
        <div class="w-10 h-10 rounded-xl border-2 border-gold p-0.5 shadow-sm overflow-hidden flex items-center justify-center bg-white">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->email) }}&background=800000&color=fff&bold=true" alt="User Avatar" class="w-full h-full rounded-[10px] object-cover">
        </div>
    </div>
  </div>
</header>
