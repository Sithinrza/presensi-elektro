@php
    $profil = \App\Models\Tendik::with('unitKerja')->where('id_user', Auth::id())->first();
@endphp
<header class="sticky top-0 z-40 glass-effect border-b border-maroon-100/30 px-5 lg:px-10 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="lg:hidden w-11 h-11 bg-maroon-900 rounded-2xl flex items-center justify-center shadow-lg shadow-maroon-900/20 rotate-3 transition-transform duration-300">
                <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png" alt="Logo" class="w-7 h-7 object-contain">
            </div>
            <div>
                <h1 class="text-sm md:text-lg font-extrabold text-maroon-950 leading-none tracking-tight">
                    {{ $profil->nama_lengkap ?? Auth::user()->email }}
                </h1>
                <p class="hidden md:block text-[10px] font-bold text-gold-dark uppercase tracking-widest mt-1">
                    {{ $profil->unitKerja->nama_unit ?? 'Staf Jurusan Teknik Elektro' }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-maroon-100 shadow-sm text-maroon-900 active:scale-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
            </button>
            <div class="w-10 h-10 rounded-full border-2 border-gold p-0.5 shadow-sm">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($profil->nama_lengkap ?? Auth::user()->email) }}&background=800000&color=fff&bold=true" alt="Profile" class="w-full h-full rounded-full object-cover">
            </div>
        </div>
    </div>
</header>
