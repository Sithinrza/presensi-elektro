@extends('layouts.pembimbing')
@section('page_title', 'Dashboard')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 space-y-6 lg:space-y-10">

    <!-- HERO SECTION -->
    <!-- HERO SECTION -->
    <!-- HERO SECTION -->
    <section class="animate-in bg-maroon-900 rounded-[2rem] lg:rounded-[2.5rem] p-6 lg:p-8 border border-maroon-800 shadow-premium relative overflow-hidden" style="animation-delay: 0.1s">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">

            <div class="space-y-1">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
                    Monitoring Siswa Magang
                </h2>
                <p class="text-maroon-200 text-xs lg:text-sm font-bold uppercase tracking-widest opacity-80">
                    Dashboard Pembimbing Teknik Elektro
                </p>
            </div>

            <!-- Widget Waktu Minimalis -->
            <div class="flex items-center gap-4 bg-maroon-800/50 px-5 py-3 rounded-2xl border border-maroon-700/50 w-full lg:w-auto justify-between lg:justify-start">
                <div class="text-right">
                    <div id="liveDate" class="text-[9px] font-black text-maroon-200 uppercase tracking-widest">Memuat...</div>
                    <div id="liveClock" class="text-2xl font-black text-white tracking-tighter leading-none font-mono">00:00:00</div>
                </div>
                <div class="w-10 h-10 bg-gold text-maroon-950 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
        </div>
    </section>

    <!-- KARTU STATISTIK (Disesuaikan untuk Mobile) -->
    <section class="animate-in grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6" style="animation-delay: 0.2s">
        <!-- Total Anak Bimbingan -->
        <div class="bg-white p-4 sm:p-5 lg:p-8 rounded-[1.5rem] lg:rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden flex flex-col justify-center">
            <div class="absolute -right-3 -bottom-3 opacity-[0.03] group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="flex items-center justify-between mb-2 lg:mb-3">
                <p class="text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Bimbingan</p>
                <div class="w-6 h-6 lg:w-10 lg:h-10 rounded-lg lg:rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-maroon-900 group-hover:bg-maroon-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 lg:w-5 lg:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
            </div>
            <p class="text-2xl lg:text-4xl font-black text-maroon-950 tracking-tighter leading-none">{{ str_pad($totalBimbingan, 2, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- Log Menunggu Review -->
        <div class="bg-amber-50/50 p-4 sm:p-5 lg:p-8 rounded-[1.5rem] lg:rounded-[2.5rem] border border-amber-100/50 shadow-sm hover:shadow-md hover:bg-amber-50 transition-all group relative overflow-hidden flex flex-col justify-center">
            <div class="absolute -right-3 -bottom-3 opacity-[0.05] group-hover:scale-110 transition-transform text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div class="flex items-center justify-between mb-2 lg:mb-3">
                <p class="text-[9px] lg:text-[10px] font-black text-amber-700/60 uppercase tracking-widest leading-none">Tertunda</p>
                <div class="w-6 h-6 lg:w-10 lg:h-10 rounded-lg lg:rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 lg:w-5 lg:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 0-5H20"/></svg>
                </div>
            </div>
            <p class="text-2xl lg:text-4xl font-black text-amber-600 tracking-tighter leading-none">{{ str_pad($totalLogPending, 2, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="bg-emerald-50/50 p-4 sm:p-5 lg:p-8 rounded-[1.5rem] lg:rounded-[2.5rem] border border-emerald-100/50 shadow-sm hover:shadow-md hover:bg-emerald-50 transition-all group relative overflow-hidden flex flex-col justify-center">
            <div class="absolute -right-3 -bottom-3 opacity-[0.05] group-hover:scale-110 transition-transform text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="flex items-center justify-between mb-2 lg:mb-3">
                <p class="text-[9px] lg:text-[10px] font-black text-emerald-700/60 uppercase tracking-widest leading-none">Hadir Tepat Waktu</p>
                <div class="w-6 h-6 lg:w-10 lg:h-10 rounded-lg lg:rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 lg:w-5 lg:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
            </div>
            <p class="text-2xl lg:text-4xl font-black text-emerald-600 tracking-tighter leading-none">{{ str_pad($hadirHariIni, 2, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- Siap Penilaian -->
        <div class="bg-gold-light p-4 sm:p-5 lg:p-8 rounded-[1.5rem] lg:rounded-[2.5rem] border border-gold/30 shadow-sm hover:shadow-md transition-all group relative overflow-hidden flex flex-col justify-center">
            <div class="absolute -right-3 -bottom-3 opacity-[0.15] group-hover:scale-110 transition-transform text-gold-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
            </div>
            <div class="flex items-center justify-between mb-2 lg:mb-3">
                <p class="text-[9px] lg:text-[10px] font-black text-maroon-900/60 uppercase tracking-widest leading-none">Siap Dinilai</p>
                <div class="w-6 h-6 lg:w-10 lg:h-10 rounded-lg lg:rounded-xl bg-gold flex items-center justify-center text-maroon-950 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 lg:w-5 lg:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                </div>
            </div>
            <p class="text-2xl lg:text-4xl font-black text-maroon-950 tracking-tighter leading-none">{{ str_pad($siapPenilaian, 2, '0', STR_PAD_LEFT) }}</p>
        </div>
    </section>

    <!-- DAFTAR ANAK BIMBINGAN (Disesuaikan untuk Mobile) -->
    <section class="animate-in space-y-4 lg:space-y-6" style="animation-delay: 0.3s">
        <div class="flex items-center justify-between px-1 lg:px-2">
            <div class="flex items-center gap-2 lg:gap-3">
                <div class="w-1.5 h-5 lg:h-6 bg-maroon-900 rounded-full"></div>
                <h3 class="text-lg lg:text-2xl font-black text-maroon-950 tracking-tight">Daftar Anak Bimbingan</h3>
            </div>
            <a href="{{ route('pembimbing.presensi-siswa.index') }}" class="text-[9px] lg:text-xs font-black text-maroon-700 uppercase underline tracking-widest hover:text-maroon-900 transition-colors">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6">

            @forelse($daftarSiswa as $siswa)
                @php
                    $isSelesai = \Carbon\Carbon::parse($siswa->tanggal_selesai)->endOfDay()->isPast();

                    $presensiHariIni = collect($siswa->presensi)->first();
                    $statusCi = $presensiHariIni ? $presensiHariIni->id_status_ci : null;
                @endphp

                <!-- KARTU SISWA -->
                @if($isSelesai)
                    <!-- Tampilan Jika Magang Telah Selesai -->
                    <div class="bg-gold/5 rounded-[1.5rem] lg:rounded-[2.5rem] p-5 lg:p-6 border-2 border-dashed border-gold/40 shadow-sm hover:shadow-lg transition-all group relative flex flex-col h-full">
                        <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 px-3 py-1 bg-maroon-950 text-gold text-[7px] lg:text-[8px] font-black uppercase tracking-[0.3em] rounded-full shadow-md whitespace-nowrap">Telah Selesai - Siap Dinilai</div>

                        <div class="flex items-center gap-3.5 lg:gap-4 mb-4 lg:mb-6 mt-3">
                            <div class="w-14 h-14 lg:w-16 lg:h-16 rounded-2xl bg-slate-100 overflow-hidden shadow-inner border-2 border-gold group-hover:scale-105 transition-all shrink-0 flex items-center justify-center font-black text-xl lg:text-2xl text-maroon-900">
                                @if($siswa->foto_profil)
                                    <img src="/uploads/profil/{{ $siswa->foto_profil }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($siswa->nama_lengkap, 0, 1) }}
                                @endif
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h4 class="text-base lg:text-lg font-black text-maroon-950 leading-none truncate tracking-tight">{{ $siswa->nama_lengkap }}</h4>
                                <p class="text-[9px] lg:text-[10px] font-bold text-gold-dark mt-1 uppercase tracking-widest truncate">{{ $siswa->sekolah_asal ?? 'Instansi Tidak Diisi' }}</p>
                            </div>
                        </div>

                        <div class="mb-5 lg:mb-6 pt-4 lg:pt-5 border-t border-gold/20 flex-1">
                            <p class="text-[8px] lg:text-[9px] font-black text-maroon-900/50 uppercase tracking-[0.2em] leading-none mb-2">Status Akhir Program</p>
                            <div class="flex items-start gap-2 bg-white/50 p-2.5 lg:p-3 rounded-xl border border-gold/30">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-gold-dark shrink-0 mt-0.5"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                                <p class="text-[11px] lg:text-xs font-bold text-maroon-950 leading-snug">Masa magang telah berakhir. Silakan input nilai akhir agar sertifikat dapat dirilis.</p>
                            </div>
                        </div>

                        <a href="#" class="w-full bg-maroon-950 text-white py-3 lg:py-4 rounded-xl lg:rounded-2xl text-[9px] lg:text-[10px] font-black uppercase tracking-widest shadow-md hover:shadow-xl active:scale-95 transition-all flex items-center justify-center gap-2 hover:bg-maroon-800 mt-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                            Input Nilai Akhir
                        </a>
                    </div>
                @else
                    <!-- Tampilan Magang Berjalan -->
                    <div class="bg-white rounded-[1.5rem] lg:rounded-[2.5rem] p-5 lg:p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:border-maroon-100 transition-all group flex flex-col h-full relative overflow-hidden">

                        <!-- Tanda Hadir Hari Ini -->
                        @if($statusCi == 1 || $statusCi == 2)
                            <div class="absolute top-0 right-0 bg-emerald-50 text-emerald-600 text-[7px] lg:text-[8px] font-black uppercase tracking-widest px-2.5 py-1 lg:px-3 lg:py-1.5 rounded-bl-xl border-b border-l border-emerald-100 flex items-center gap-1.5 shadow-sm">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Hadir
                            </div>
                        @endif

                        <div class="flex items-center gap-3.5 lg:gap-4 mb-5 lg:mb-6 mt-1 lg:mt-2">
                            <div class="w-14 h-14 lg:w-16 lg:h-16 rounded-2xl bg-slate-50 overflow-hidden shadow-inner border border-slate-200 group-hover:border-maroon-200 transition-all shrink-0 flex items-center justify-center font-black text-xl lg:text-2xl text-maroon-900">
                                @if($siswa->foto_profil)
                                    <img src="{{ asset('storage/' . $siswa->foto_profil) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($siswa->nama_lengkap, 0, 1) }}
                                @endif
                            </div>
                            <div class="flex-1 overflow-hidden pr-2">
                                <h4 class="text-base lg:text-lg font-black text-maroon-950 leading-none truncate tracking-tight">{{ $siswa->nama_lengkap }}</h4>
                                <p class="text-[9px] font-bold text-slate-400 mt-1 lg:mt-1.5 uppercase tracking-widest truncate">{{ $siswa->sekolah_asal ?? 'Instansi Tidak Diisi' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2.5 lg:gap-3 mb-5 lg:mb-6 pt-4 lg:pt-5 border-t border-slate-50 flex-1">
                            <div class="bg-slate-50 p-2.5 lg:p-3 rounded-xl border border-slate-100">
                                <p class="text-[7px] lg:text-[8px] font-black text-slate-400 uppercase tracking-widest line-clamp-1 mb-1">Hadir Bln Ini</p>
                                <p class="text-lg lg:text-xl font-black text-maroon-950 leading-none">{{ str_pad($siswa->hadir_bulan_ini ?? 0, 2, '0', STR_PAD_LEFT) }} <span class="text-[8px] lg:text-[9px] text-maroon-300">Hari</span></p>
                            </div>
                            <div class="bg-amber-50/50 p-2.5 lg:p-3 rounded-xl border border-amber-100/50">
                                <p class="text-[7px] lg:text-[8px] font-black text-amber-700/60 uppercase tracking-widest line-clamp-1 mb-1">Log Tertunda</p>
                                <p class="text-lg lg:text-xl font-black {{ ($siswa->log_pending ?? 0) > 0 ? 'text-amber-600' : 'text-slate-400' }} leading-none">
                                    {{ str_pad($siswa->log_pending ?? 0, 2, '0', STR_PAD_LEFT) }} <span class="text-[8px] lg:text-[9px] opacity-60">Log</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-2 mt-auto">
                            <a href="{{ route('pembimbing.presensi-siswa.show', $siswa->id_user) }}" class="flex-1 bg-maroon-50 text-maroon-900 border border-maroon-100 py-3 lg:py-3.5 rounded-xl text-[9px] lg:text-[10px] font-black uppercase tracking-widest text-center hover:bg-maroon-900 hover:text-white transition-all shadow-sm">
                                Riwayat
                            </a>
                            <a href="{{ route('pembimbing.monitoring.show', $siswa->id_siswa) }}" class="bg-slate-50 text-slate-500 border border-slate-200 px-3 lg:px-3.5 py-3 lg:py-3.5 rounded-xl hover:bg-amber-100 hover:text-amber-700 hover:border-amber-200 transition-all shadow-sm flex items-center justify-center" title="Validasi Jurnal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            </a>
                        </div>
                    </div>
                @endif
            @empty
                <div class="md:col-span-2 xl:col-span-3 bg-white/50 backdrop-blur-sm rounded-[2rem] lg:rounded-[3rem] border-2 border-dashed border-maroon-100 p-8 lg:p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-white shadow-sm text-maroon-200 rounded-full flex items-center justify-center mb-4 lg:mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 lg:w-10 lg:h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/></svg>
                    </div>
                    <h4 class="text-lg lg:text-xl font-black text-maroon-950 tracking-tight mb-2">Belum Ada Anak Bimbingan</h4>
                    <p class="text-xs lg:text-sm font-medium text-slate-500 max-w-md">Data siswa magang yang berada di bawah bimbingan Anda akan otomatis muncul di sini.</p>
                </div>
            @endforelse

        </div>
    </section>
</main>

<script>
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { hour12: false });
        document.getElementById('liveClock').textContent = timeString;

        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateString = now.toLocaleDateString('id-ID', options);
        document.getElementById('liveDate').textContent = dateString;
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection
