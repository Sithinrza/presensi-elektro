@extends('layouts.admin')

@section('content')
<main class="p-4 sm:p-6 lg:p-10 space-y-6 lg:space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-500">

    <section class="animate-in" style="animation-delay: 0.1s">
        <div class="relative bg-maroon-900 rounded-2xl lg:rounded-3xl p-5 sm:p-8 lg:p-10 text-white shadow-lg shadow-maroon-900/20 overflow-hidden border border-maroon-800 flex flex-col md:flex-row md:items-center justify-between gap-4 lg:gap-6">

            <div class="absolute -top-10 sm:-top-20 -right-10 sm:-right-20 w-40 sm:w-80 h-40 sm:h-80 bg-amber-400/10 rounded-full blur-[60px] lg:blur-[80px] pointer-events-none"></div>
            <div class="absolute -bottom-5 sm:-bottom-10 -left-5 sm:-left-10 w-32 sm:w-64 h-32 sm:h-64 bg-white/5 rounded-full blur-[40px] lg:blur-[60px] pointer-events-none"></div>

            <div class="relative z-10 space-y-2 lg:space-y-3">

                <h2 class="text-xl sm:text-2xl lg:text-4xl font-black tracking-tight leading-tight">
                    Selamat Datang, <br class="hidden md:block">
                    <span class="text-amber-400">{{ auth()->check() ? auth()->user()->name : 'Admin' }}!</span>
                </h2>
            </div>

            <div class="relative z-10 bg-black/20 p-4 lg:p-5 rounded-xl lg:rounded-2xl border border-white/10 backdrop-blur-md w-full md:w-fit mt-2 md:mt-0">
                <div class="flex flex-row md:flex-col items-center md:items-end justify-between gap-2 md:gap-1.5">

                    <div class="text-left md:text-right">
                        <p id="liveDate" class="text-[9px] sm:text-[10px] lg:text-xs font-bold text-maroon-200 uppercase tracking-widest line-clamp-1">
                            Memuat Tanggal...
                        </p>
                    </div>

                    <div class="text-right">
                        <div id="liveClock" class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tighter leading-none mb-1">
                            00:00:00
                        </div>
                        <p class="text-[7px] sm:text-[8px] lg:text-[10px] font-bold text-amber-400 uppercase tracking-widest line-clamp-1">
                            Waktu Indonesia Tengah
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <div class="space-y-4 lg:space-y-6">
        <div class="flex items-center gap-2 lg:gap-3 px-1 lg:px-2">
            <div class="w-1 lg:w-1.5 h-4 lg:h-6 bg-amber-400 rounded-full"></div>
            <h3 class="text-sm lg:text-lg font-black text-slate-800 tracking-tight uppercase">Status Presensi Hari Ini</h3>
            <span class="text-[8px] lg:text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1 hidden sm:inline">(Siswa & Tendik)</span>
        </div>

        <section class="animate-in grid grid-cols-2 md:grid-cols-3 gap-3 lg:gap-6" style="animation-delay: 0.2s">

            <div class="bg-white p-4 lg:p-8 rounded-2xl lg:rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 group relative overflow-hidden flex flex-col justify-between">
                <div class="absolute -right-2 -bottom-2 lg:-right-4 lg:-bottom-4 opacity-[0.03] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lg:w-[120px] lg:h-[120px]"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="flex items-center justify-between mb-3 lg:mb-6 relative z-10">
                    <span class="text-[8px] lg:text-[10px] font-black text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-1 lg:px-3 lg:py-1.5 rounded-md lg:rounded-lg uppercase tracking-widest">Hadir</span>
                    <div class="w-8 h-8 lg:w-12 lg:h-12 rounded-lg lg:rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lg:w-6 lg:h-6"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <p class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter leading-none relative z-10">{{ str_pad($hadirHariIni, 2, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[8px] lg:text-[10px] font-bold text-slate-400 uppercase mt-2 lg:mt-4 tracking-widest leading-none relative z-10 line-clamp-1">Total pengguna hadir</p>
            </div>

            <div class="bg-white p-4 lg:p-8 rounded-2xl lg:rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 group relative overflow-hidden flex flex-col justify-between">
                <div class="absolute -right-2 -bottom-2 lg:-right-4 lg:-bottom-4 opacity-[0.03] group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lg:w-[120px] lg:h-[120px]"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="flex items-center justify-between mb-3 lg:mb-6 relative z-10">
                    <span class="text-[8px] lg:text-[10px] font-black text-amber-700 bg-amber-50 border border-amber-100 px-2 py-1 lg:px-3 lg:py-1.5 rounded-md lg:rounded-lg uppercase tracking-widest">Terlambat</span>
                    <div class="w-8 h-8 lg:w-12 lg:h-12 rounded-lg lg:rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lg:w-6 lg:h-6"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                </div>
                <p class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter leading-none relative z-10">{{ str_pad($terlambatHariIni, 2, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[8px] lg:text-[10px] font-bold text-slate-400 uppercase mt-2 lg:mt-4 tracking-widest leading-none relative z-10 line-clamp-1">Masuk lewat jam</p>
            </div>

            <div class="bg-white p-4 lg:p-8 rounded-2xl lg:rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 group relative overflow-hidden flex flex-col justify-between col-span-2 md:col-span-1">
                <div class="absolute -right-2 -bottom-2 lg:-right-4 lg:-bottom-4 opacity-[0.03] group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-500 text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lg:w-[120px] lg:h-[120px]"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </div>
                <div class="flex items-center justify-between mb-3 lg:mb-6 relative z-10">
                    <span class="text-[8px] lg:text-[10px] font-black text-rose-700 bg-rose-50 border border-rose-100 px-2 py-1 lg:px-3 lg:py-1.5 rounded-md lg:rounded-lg uppercase tracking-widest">Alpa</span>
                    <div class="w-8 h-8 lg:w-12 lg:h-12 rounded-lg lg:rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lg:w-6 lg:h-6"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </div>
                </div>
                <p class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter leading-none relative z-10">{{ str_pad($alpaHariIni, 2, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[8px] lg:text-[10px] font-bold text-slate-400 uppercase mt-2 lg:mt-4 tracking-widest leading-none relative z-10 line-clamp-1">Belum ada aktivitas</p>
            </div>

        </section>
    </div>

    <div class="space-y-4 lg:space-y-6">
        <div class="flex items-center gap-2 lg:gap-3 px-1 lg:px-2">
            <div class="w-1 lg:w-1.5 h-4 lg:h-6 bg-maroon-900 rounded-full"></div>
            <h3 class="text-sm lg:text-lg font-black text-slate-800 tracking-tight uppercase">Total Pengguna Terdaftar</h3>
            <span class="text-[8px] lg:text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1 hidden sm:inline">(Data Master)</span>
        </div>

        <section class="animate-in grid grid-cols-1 md:grid-cols-3 gap-3 lg:gap-6" style="animation-delay: 0.3s">

            <div class="bg-white p-4 lg:p-6 rounded-2xl lg:rounded-3xl border border-slate-100 shadow-sm hover:border-maroon-200 transition-colors flex items-center justify-between group">
                <div>
                    <p class="text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 lg:mb-2">Siswa Magang</p>
                    <p class="text-2xl lg:text-3xl font-black text-slate-800 tracking-tight leading-none group-hover:text-maroon-900 transition-colors">{{ str_pad($totalSiswa, 2, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="w-10 h-10 lg:w-14 lg:h-14 bg-slate-50 group-hover:bg-maroon-50 rounded-xl lg:rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-maroon-700 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lg:w-7 lg:h-7"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>

            <div class="bg-white p-4 lg:p-6 rounded-2xl lg:rounded-3xl border border-slate-100 shadow-sm hover:border-maroon-200 transition-colors flex items-center justify-between group">
                <div>
                    <p class="text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 lg:mb-2">Tenaga Kependidikan</p>
                    <p class="text-2xl lg:text-3xl font-black text-slate-800 tracking-tight leading-none group-hover:text-maroon-900 transition-colors">{{ str_pad($totalTendik, 2, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="w-10 h-10 lg:w-14 lg:h-14 bg-slate-50 group-hover:bg-maroon-50 rounded-xl lg:rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-maroon-700 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lg:w-7 lg:h-7"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><rect x="19" y="8" width="2" height="10"/><path d="M19 8c0-1.1.9-2 2-2"/></svg>
                </div>
            </div>

            <div class="bg-white p-4 lg:p-6 rounded-2xl lg:rounded-3xl border border-slate-100 shadow-sm hover:border-maroon-200 transition-colors flex items-center justify-between group">
                <div>
                    <p class="text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 lg:mb-2">Total Pembimbing</p>
                    <p class="text-2xl lg:text-3xl font-black text-slate-800 tracking-tight leading-none group-hover:text-maroon-900 transition-colors">{{ str_pad($totalPembimbing, 2, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="w-10 h-10 lg:w-14 lg:h-14 bg-slate-50 group-hover:bg-maroon-50 rounded-xl lg:rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-maroon-700 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lg:w-7 lg:h-7"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                </div>
            </div>

        </section>
    </div>

    <section class="animate-in bg-white rounded-2xl lg:rounded-3xl border border-slate-100 shadow-sm overflow-hidden" style="animation-delay: 0.4s">
        <div class="px-4 py-4 lg:px-8 lg:py-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 lg:gap-4">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-maroon-50 text-maroon-700 rounded-xl lg:rounded-2xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lg:w-6 lg:h-6"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <h3 class="text-sm lg:text-lg font-black text-slate-800 tracking-tight leading-tight">Monitoring Real-time</h3>
                    <p class="text-[10px] lg:text-xs font-bold text-slate-400 mt-0.5 lg:mt-1">Rekam jejak ketepatan waktu hari ini</p>
                </div>
            </div>
            <a href="{{ route('admin.riwayat.index') }}" class="text-[9px] lg:text-[10px] font-black text-maroon-700 bg-maroon-50 hover:bg-maroon-100 px-3 py-1.5 lg:px-4 lg:py-2 rounded-lg uppercase tracking-widest transition-colors flex items-center justify-center gap-2 w-full sm:w-fit mt-1 sm:mt-0">
                Semua Aktivitas
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>

        <div class="overflow-x-auto custom-scroll pb-2">
            <table class="w-full text-left border-collapse min-w-[500px] lg:min-w-[600px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-4 py-3 lg:px-8 lg:py-5 text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas User</th>
                        <th class="px-4 py-3 lg:px-8 lg:py-5 text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Masuk</th>
                        <th class="px-4 py-3 lg:px-8 lg:py-5 text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Pulang</th>
                        <th class="px-4 py-3 lg:px-8 lg:py-5 text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    @forelse($aktivitasHariIni as $aktivitas)
                    <tr onclick="window.location.href='{{ route('presensi.detail', $aktivitas->id_presensi) }}'" class="hover:bg-slate-50/80 transition-all duration-200 group cursor-pointer">
                        <td class="px-4 py-3 lg:px-8 lg:py-4">
                            <div class="flex items-center gap-3 lg:gap-4">
                                <div class="w-8 h-8 lg:w-11 lg:h-11 rounded-lg lg:rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0 flex items-center justify-center font-black text-maroon-900 text-xs lg:text-base">
                                    {{ substr($aktivitas->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs lg:text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-700 transition-colors">
                                        {{ $aktivitas->user->name ?? 'User Tidak Diketahui' }}
                                    </p>
                                    <p class="text-[9px] lg:text-[10px] font-bold text-slate-400 mt-1 lg:mt-1.5 uppercase tracking-tighter">
                                        {{ $aktivitas->user->roles->first()->name ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 lg:px-8 lg:py-4 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] lg:text-xs font-bold font-mono border border-slate-200">
                                {{ $aktivitas->jam_masuk ?? '--:--' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 lg:px-8 lg:py-4 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] lg:text-xs font-bold font-mono border border-slate-200">
                                {{ $aktivitas->jam_pulang ?? '--:--' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 lg:px-8 lg:py-4 text-center">
                            <div class="flex flex-col gap-1 lg:flex-row lg:gap-1.5 items-center justify-center">
                                @php
                                    $ciName = $aktivitas->statusCi ? $aktivitas->statusCi->name : 'Alpa';
                                    $colorCi = $ciName === 'Tepat Waktu' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' :
                                                ($ciName === 'Terlambat' ? 'bg-amber-50 text-amber-600 border-amber-200' :
                                                ($ciName === 'Libur' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-rose-50 text-rose-600 border-rose-200'));

                                    $coName = $aktivitas->statusCo ? $aktivitas->statusCo->name : 'Belum CO';
                                    $colorCo = in_array($coName, ['Tepat Waktu', 'Check Out']) ? 'bg-emerald-50 text-emerald-600 border-emerald-200' :
                                                ($coName === 'Terlambat CO' ? 'bg-amber-50 text-amber-600 border-amber-200' :
                                                ($coName === 'Belum CO' ? 'bg-slate-50 text-slate-500 border-slate-200' :
                                                ($coName === 'Libur' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-rose-50 text-rose-600 border-rose-200')));
                                @endphp

                                <span class="inline-flex items-center px-2 lg:px-2.5 py-1 {{ $colorCi }} border rounded-md text-[8px] lg:text-[9px] font-black uppercase tracking-widest w-[70px] lg:w-[85px] justify-center">
                                    IN: {{ $ciName == 'Tepat Waktu' ? 'Tepat' : $ciName }}
                                </span>
                                <span class="inline-flex items-center px-2 lg:px-2.5 py-1 {{ $colorCo }} border rounded-md text-[8px] lg:text-[9px] font-black uppercase tracking-widest w-[70px] lg:w-[85px] justify-center mt-0.5 lg:mt-0">
                                    OUT: {{ in_array($coName, ['Tepat Waktu', 'Check Out']) ? 'Tepat' : ($coName == 'Terlambat CO' ? 'Terlambat CO' : ($coName == 'Lupa Check-Out' ? 'Lupa CO' : $coName)) }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 lg:px-8 lg:py-10 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px] lg:text-xs">
                            Belum ada aktivitas presensi hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

<script>
    function updateClock() {
        const now = new Date();

        // Format Tanggal (Contoh: Kamis, 14 Mei 2026)
        const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('liveDate').innerText = now.toLocaleDateString('id-ID', optionsDate);

        // Format Jam (Contoh: 09:05:22)
        const timeString = now.toLocaleTimeString('id-ID', { hour12: false });
        // Ganti titik (.) dengan titik dua (:) agar rapi
        document.getElementById('liveClock').innerText = timeString.replace(/\./g, ':');
    }

    // Jalankan detik ini juga, lalu ulangi setiap 1000 milidetik (1 detik)
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection
