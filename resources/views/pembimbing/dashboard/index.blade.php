@extends('layouts.pembimbing')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <div class="lg:col-span-12 space-y-8">

            <section class="animate-in flex flex-col md:flex-row md:items-end justify-between gap-4" style="animation-delay: 0.1s">
                <div>
                    <p class="text-slate-500 font-medium text-base italic leading-none mb-2 text-maroon-900/40">Selamat datang kembali, Bapak/Ibu {{ explode(',', $pembimbing->nama_lengkap)[0] }}</p>
                    <h2 class="text-3xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-tight italic">Pantau Progres <br><span class="text-gold tracking-normal not-italic">& Logbook Siswa</span></h2>
                </div>
                <div class="md:text-right text-left">
                    <div id="liveClock" class="text-4xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-none mb-1">00:00:00</div>
                    <span id="liveDate" class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-[0.2em] italic">--</span>
                </div>
            </section>

            <section class="animate-in grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6" style="animation-delay: 0.2s">
                <div class="bg-maroon-900 p-8 rounded-[2.5rem] text-white shadow-premium relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <p class="text-4xl font-black tracking-tighter leading-none mb-1">{{ str_pad($totalBimbingan, 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-[10px] font-bold text-maroon-200 uppercase tracking-widest leading-none italic">Anak Bimbingan</p>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <p class="text-4xl font-black text-maroon-950 tracking-tighter leading-none mb-1">{{ str_pad($totalLogPending, 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none italic">Log Menunggu Review</p>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <p class="text-4xl font-black text-maroon-950 tracking-tighter leading-none mb-1">{{ str_pad($hadirHariIni, 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none italic">Hadir Hari Ini</p>
                </div>

                <div class="bg-gold-light p-8 rounded-[2.5rem] border border-gold/20 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-20 group-hover:scale-110 transition-transform text-gold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                    </div>
                    <p class="text-4xl font-black text-maroon-950 tracking-tighter leading-none mb-1">{{ str_pad($siapPenilaian, 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-[10px] font-bold text-gold-dark uppercase tracking-widest leading-none italic">Siap Penilaian</p>
                </div>
            </section>

            <section class="animate-in space-y-6" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-6 bg-maroon-900 rounded-full"></div>
                        <h3 class="text-xl font-black text-maroon-950 tracking-tight italic">Daftar Anak Bimbingan</h3>
                    </div>
                    <button class="text-[10px] font-black text-maroon-700 uppercase underline tracking-widest">Semua Data</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                    @forelse($daftarSiswa as $siswa)
                        @php
                            $isSelesai = \Carbon\Carbon::parse($siswa->tanggal_selesai)->endOfDay()->isPast();
                        @endphp

                        @if($isSelesai)
                            <div class="bg-gold/5 rounded-[2.5rem] p-6 border-2 border-dashed border-gold/30 shadow-sm hover:shadow-xl transition-all group relative">
                                <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 bg-maroon-900 text-gold text-[8px] font-black uppercase tracking-[0.3em] rounded-full shadow-lg">Siap Dinilai</div>

                                <div class="flex items-center gap-4 mb-6 mt-2">
                                    <div class="w-16 h-16 rounded-3xl bg-slate-100 overflow-hidden shadow-inner border-2 border-gold group-hover:scale-105 transition-all shrink-0">
                                        <img src="{{ $siswa->foto_profil ? asset('storage/' . $siswa->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama_lengkap).'&background=fef3c7&color=b45309' }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h4 class="text-lg font-black text-maroon-950 leading-none truncate tracking-tight">{{ $siswa->nama_lengkap }}</h4>
                                        <p class="text-[10px] font-bold text-gold-dark mt-1 uppercase tracking-widest truncate">{{ $siswa->sekolah_asal ?? 'Belum Diatur' }}</p>
                                    </div>
                                </div>

                                <div class="mb-6 pt-6 border-t border-gold/10">
                                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-[0.2em] leading-none mb-2">Masa Magang Berakhir</p>
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-gold-dark"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                                        <p class="text-sm font-bold text-maroon-950">Silakan input nilai akhir</p>
                                    </div>
                                </div>

                                <button class="w-full bg-maroon-950 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl active:scale-95 transition-all flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                                    Input Nilai Akhir
                                </button>
                            </div>
                        @else
                            <div class="bg-white rounded-[2.5rem] p-6 border border-maroon-50 shadow-sm hover:shadow-xl transition-all group">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-16 h-16 rounded-3xl bg-slate-100 overflow-hidden shadow-inner border-2 border-white group-hover:border-maroon-200 transition-all shrink-0">
                                        <img src="{{ $siswa->foto_profil ? asset('storage/' . $siswa->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama_lengkap).'&background=f1f5f9&color=7f1d1d' }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <h4 class="text-lg font-black text-maroon-950 leading-none truncate tracking-tight">{{ $siswa->nama_lengkap }}</h4>
                                        <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest truncate">{{ $siswa->sekolah_asal ?? 'Belum Diatur' }}</p>

                                        <div class="mt-2.5 flex items-center gap-1.5">
                                            @php
                                                $presensiHariIni = $siswa->presensi->first();
                                                $statusCi = $presensiHariIni ? $presensiHariIni->id_status_ci : null;
                                            @endphp

                                            @if($statusCi == 1)
                                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest rounded-md border border-emerald-100 flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Tepat Waktu</span>
                                            @elseif($statusCi == 2)
                                                <span class="px-2 py-1 bg-amber-50 text-amber-600 text-[9px] font-black uppercase tracking-widest rounded-md border border-amber-100 flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Terlambat</span>
                                            @elseif($statusCi == 3)
                                                <span class="px-2 py-1 bg-rose-50 text-rose-600 text-[9px] font-black uppercase tracking-widest rounded-md border border-rose-100 flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Alfa</span>
                                            @else
                                                <span class="px-2 py-1 bg-slate-50 text-slate-500 text-[9px] font-black uppercase tracking-widest rounded-md border border-slate-200 flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Belum Presensi</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-6 pt-5 border-t border-slate-50">
                                    <div>
                                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Hadir (Bulan Ini)</p>
                                        <p class="text-xl font-black text-maroon-950 mt-1">{{ str_pad($siswa->hadir_bulan_ini, 2, '0', STR_PAD_LEFT) }} <span class="text-[10px] text-maroon-400 opacity-50">Hari</span></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Logbook Pending</p>
                                        <p class="text-xl font-black {{ $siswa->log_pending > 0 ? 'text-amber-500' : 'text-emerald-600' }} mt-1">
                                            {{ str_pad($siswa->log_pending, 2, '0', STR_PAD_LEFT) }} <span class="text-[10px] opacity-50">Log</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('pembimbing.presensi-siswa.show', $siswa->id_siswa) }}" class="flex-1 bg-maroon-50 text-maroon-950 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-maroon-900 hover:text-white transition-all">
                                        Detail Riwayat
                                    </a>
                                    <button class="bg-gold text-maroon-950 p-3 rounded-2xl hover:bg-gold-dark transition-all shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="md:col-span-2 xl:col-span-3 bg-white rounded-[2.5rem] border border-dashed border-slate-200 p-10 text-center flex flex-col items-center justify-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M22 11h-6"/></svg>
                            </div>
                            <h4 class="text-xl font-black text-slate-800 tracking-tight mb-1">Belum Ada Anak Bimbingan</h4>
                            <p class="text-xs font-bold text-slate-400">Data siswa magang di bawah bimbingan Anda akan muncul di sini.</p>
                        </div>
                    @endforelse

                </div>
            </section>
        </div>
    </div>
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
