@extends('layouts.tendik')
@section('page_title', 'Dashboard')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10">
    @if(session('success'))
        <div class="mb-4 sm:mb-6 p-3 sm:p-4 text-xs sm:text-sm text-emerald-800 font-bold rounded-xl sm:rounded-2xl bg-emerald-50 border border-emerald-200 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col lg:grid lg:grid-cols-12 gap-6 lg:gap-8 items-start">

        <section class="lg:col-span-7 xl:col-span-8 w-full order-1 animate-in" style="animation-delay: 0.1s">
            <div class="relative bg-maroon-900 rounded-[2rem] lg:rounded-[3rem] p-6 sm:p-8 md:p-10 text-white shadow-premium overflow-hidden border border-maroon-800">
                <div class="absolute -top-12 -right-12 w-48 sm:w-64 h-48 sm:h-64 bg-gold/20 rounded-full blur-[60px] sm:blur-[80px] pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-32 sm:w-48 h-32 sm:h-48 bg-white/10 rounded-full blur-[40px] sm:blur-[60px] pointer-events-none"></div>

                <div class="relative z-10 space-y-6 sm:space-y-8">

                    <div class="flex flex-col items-center justify-center sm:flex-row sm:justify-between sm:items-end gap-3 sm:gap-4 text-center sm:text-left">
                        <div class="flex flex-col items-center sm:items-start">
                            <p class="text-maroon-200/60 text-[9px] sm:text-[10px] font-bold uppercase tracking-[0.3em] mb-1.5 sm:mb-2">Waktu Indonesia Tengah</p>
                            <div id="liveClock" class="text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tighter leading-none drop-shadow-md">
                                00:00:00
                            </div>
                        </div>
                        <div class="mt-1 sm:mt-0">
                            <h2 id="liveDate" class="text-[10px] sm:text-xs md:text-sm font-bold text-gold uppercase tracking-widest italic pt-1">
                                Memuat Tanggal...
                            </h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

                        {{-- ================= LOGIKA TOMBOL PRESENSI TENDIK ================= --}}
                        @if($isWeekend)
                            <div class="sm:col-span-2 bg-white/10 border border-white/20 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 flex items-center gap-4 shadow-inner backdrop-blur-sm opacity-80">
                                <div class="w-12 h-12 bg-white/20 text-white rounded-2xl flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                </div>
                                <div>
                                    <span class="block text-white font-black text-base uppercase tracking-wide leading-none">Akhir Pekan</span>
                                    <span class="text-[9px] text-white/70 font-bold uppercase tracking-widest mt-1">Sistem Presensi Libur</span>
                                </div>
                            </div>

                        @elseif($hariLiburIni)
                            <div class="sm:col-span-2 bg-rose-500/20 border border-rose-500/30 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 flex items-center gap-4 shadow-inner backdrop-blur-sm opacity-80">
                                <div class="w-12 h-12 bg-rose-500/30 text-rose-200 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                </div>
                                <div>
                                    <span class="block text-white font-black text-base uppercase tracking-wide leading-none">Sistem Ditutup</span>
                                    <span class="text-[9px] text-rose-200/80 font-bold uppercase tracking-widest mt-1">Hari Libur Nasional</span>
                                </div>
                            </div>

                        @elseif($belumBuka)
                            <div class="sm:col-span-2 bg-blue-500/20 border border-blue-500/30 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 flex items-center gap-4 shadow-inner backdrop-blur-sm opacity-80">
                                <div class="w-12 h-12 bg-blue-500/30 text-blue-200 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <div>
                                    <span class="block text-white font-black text-base uppercase tracking-wide leading-none">Belum Buka</span>
                                    <span class="text-[9px] text-blue-200/80 font-bold uppercase tracking-widest mt-1">Dibuka pukul 06:00 WITA</span>
                                </div>
                            </div>

                        @elseif($presensiGantung)
                            <a href="{{ route('presensi.index') }}" class="sm:col-span-2 group bg-amber-500 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 flex items-center gap-4 shadow-xl active:scale-95 transition-all">
                                <div class="w-12 h-12 bg-amber-600 text-white rounded-2xl flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                </div>
                                <div>
                                    <span class="block text-white font-black text-base uppercase tracking-wide leading-none">Isi Alasan Dulu!</span>
                                    <span class="text-[9px] text-white/80 font-bold uppercase tracking-widest mt-1">Selesaikan presensi kemarin</span>
                                </div>
                            </a>

                        @elseif($lewatJamCo || $lewatBatasMasuk)
                            <div class="sm:col-span-2 bg-rose-900/40 border border-rose-500/30 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 flex items-center gap-4 shadow-inner backdrop-blur-sm opacity-80">
                                <div class="w-12 h-12 bg-rose-500/30 text-rose-200 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                </div>
                                <div>
                                    <span class="block text-white font-black text-base uppercase tracking-wide leading-none">Waktu Habis</span>
                                    <span class="text-[9px] text-rose-200/80 font-bold uppercase tracking-widest mt-1">Sistem ditutup untuk hari ini</span>
                                </div>
                            </div>

                        @elseif(!$presensiHariIni)
                            <a href="{{ route('presensi.index') }}" class="sm:col-span-2 group bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 flex items-center gap-4 sm:gap-5 shadow-xl hover:shadow-2xl active:scale-95 transition-all duration-300">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 shrink-0 bg-emerald-50 text-emerald-600 rounded-[1rem] sm:rounded-2xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="sm:w-[28px] sm:h-[28px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                </div>
                                <div class="text-left flex-1">
                                    <span class="block text-maroon-950 font-black text-base sm:text-lg uppercase tracking-wide leading-none">Presensi Masuk</span>
                                    <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1 block">Sistem Telah Dibuka</span>
                                </div>
                                <div class="hidden sm:block text-slate-300 group-hover:text-emerald-500 group-hover:translate-x-2 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </div>
                            </a>

                        @elseif($presensiHariIni && is_null($presensiHariIni->jam_pulang))
                            <div class="bg-white/10 border border-white/20 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 flex flex-col justify-center items-center text-center shadow-inner backdrop-blur-sm">
                                <span class="text-[9px] sm:text-[10px] text-maroon-200/70 font-bold uppercase tracking-widest mb-1.5 sm:mb-2">Jam Masuk Anda</span>
                                <span class="text-2xl sm:text-3xl font-black text-white font-mono leading-none tracking-tight">{{ $presensiHariIni->jam_masuk }}</span>
                            </div>

                            <a href="{{ route('presensi.index') }}" class="group bg-maroon-800 border border-white/10 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-3 sm:gap-4 active:scale-95 transition-all duration-300 hover:bg-rose-900/40 hover:border-rose-500/30">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 shrink-0 bg-white/10 text-maroon-100 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="sm:w-[24px] sm:h-[24px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                </div>
                                <div class="text-center sm:text-left">
                                    <span class="block text-white font-black text-base sm:text-lg uppercase tracking-wide leading-none">Presensi Pulang</span>
                                    <span class="text-[9px] sm:text-[10px] text-maroon-200/50 font-bold uppercase tracking-widest mt-1 block">End Session</span>
                                </div>
                            </a>

                        @else
                            <div class="bg-white/10 border border-white/20 rounded-[1.5rem] sm:rounded-[2rem] p-4 sm:p-5 flex flex-col justify-center items-center text-center shadow-inner backdrop-blur-sm">
                                <span class="text-[9px] sm:text-[10px] text-maroon-200/70 font-bold uppercase tracking-widest mb-1 sm:mb-1.5">Jam Masuk</span>
                                <span class="text-xl sm:text-2xl font-black text-white font-mono leading-none tracking-tight">{{ $presensiHariIni->jam_masuk }}</span>
                            </div>
                            <div class="bg-white/10 border border-white/20 rounded-[1.5rem] sm:rounded-[2rem] p-4 sm:p-5 flex flex-col justify-center items-center text-center shadow-inner backdrop-blur-sm">
                                <span class="text-[9px] sm:text-[10px] text-maroon-200/70 font-bold uppercase tracking-widest mb-1 sm:mb-1.5">Jam Pulang</span>
                                <span class="text-xl sm:text-2xl font-black text-white font-mono leading-none tracking-tight">{{ $presensiHariIni->jam_pulang }}</span>
                            </div>
                            <div class="sm:col-span-2 bg-emerald-500/20 border border-emerald-500/30 rounded-xl sm:rounded-2xl p-3 sm:p-4 text-center">
                                <span class="text-[10px] sm:text-xs font-black text-emerald-300 uppercase tracking-widest flex items-center justify-center gap-1.5 sm:gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" class="sm:w-[16px] sm:h-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    Presensi Hari Ini Selesai
                                </span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>

        <section class="lg:col-span-5 xl:col-span-4 w-full order-2 animate-in" style="animation-delay: 0.2s">
            <div class="bg-white p-6 sm:p-8 rounded-[2.5rem] lg:rounded-[3rem] border border-maroon-100 shadow-sm space-y-5 sm:space-y-6">
                <div class="flex items-center justify-between gap-2">
                    <h3 class="font-extrabold text-maroon-950 tracking-tight text-base sm:text-lg">Kehadiran Bulan Ini</h3>
                    <span class="text-[9px] sm:text-[10px] font-black bg-gold-light text-gold-dark px-2 sm:px-3 py-1 rounded-full uppercase tracking-tighter shrink-0">
                        {{ \Carbon\Carbon::now('Asia/Makassar')->translatedFormat('F Y') }}
                    </span>
                </div>

                <div class="bg-emerald-50 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 border border-emerald-100">
                    <div class="flex flex-col items-center justify-center mb-5 sm:mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-5xl sm:text-6xl font-black text-emerald-700 leading-none">{{ $hadir ?? 0 }}</span>
                            <span class="text-base sm:text-lg font-bold text-emerald-600/50 uppercase tracking-tighter">/ 20</span>
                        </div>
                        <p class="text-[9px] sm:text-[10px] font-bold text-emerald-600/70 mt-1.5 sm:mt-2 uppercase tracking-[0.2em]">Total Kehadiran</p>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5 sm:gap-3">
                        <div class="bg-white p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-emerald-100/50 flex flex-col items-center shadow-sm text-center">
                            <span class="text-[8px] sm:text-[9px] font-black text-emerald-600 uppercase tracking-widest leading-none">Tepat Waktu</span>
                            <span class="text-xl sm:text-2xl font-black text-emerald-900 mt-1.5 sm:mt-2">{{ $tepatWaktu ?? 0 }}</span>
                        </div>
                        <div class="bg-white p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-emerald-100/50 flex flex-col items-center shadow-sm text-center">
                            <span class="text-[8px] sm:text-[9px] font-black text-amber-500 uppercase tracking-widest leading-none">Terlambat</span>
                            <span class="text-xl sm:text-2xl font-black text-amber-600 mt-1.5 sm:mt-2">{{ $telat ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-rose-50 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 border border-rose-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] sm:text-[12px] font-black text-rose-800 uppercase tracking-widest leading-none">Alpa</p>
                        <p class="text-[8px] sm:text-[9px] font-bold text-rose-600/70 mt-1.5 uppercase tracking-wider">Tanpa Keterangan</p>
                    </div>
                    <span class="text-3xl sm:text-4xl font-black text-rose-600">{{ $alpa ?? 0 }}</span>
                </div>
            </div>
        </section>

    </div>
</main>


@if(isset($isProfilLengkap) && !$isProfilLengkap)
<div class="fixed inset-0 z-[100] flex items-center justify-center p-3 sm:p-4">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-md"></div>

    <div class="relative w-full max-w-2xl bg-white rounded-3xl sm:rounded-[2.5rem] shadow-2xl overflow-hidden animate-in zoom-in-95 duration-300 max-h-[95vh] sm:max-h-[90vh] flex flex-col">

        <div class="bg-maroon-950 px-5 sm:px-8 py-5 sm:py-6 text-white text-center shrink-0">
            <h3 class="text-lg sm:text-xl font-black tracking-tight italic">Selamat Datang, {{ $tendik->nama_lengkap ?? Auth::user()->name }}!</h3>
            <p class="text-[10px] sm:text-xs font-bold text-maroon-300 uppercase tracking-widest mt-1.5 sm:mt-2">Lengkapi Biodata Kepegawaian Anda</p>
        </div>

        <form action="{{ route('tendik.lengkapi.profil') }}" method="POST" class="p-5 sm:p-8 space-y-5 sm:space-y-6 overflow-y-auto no-scrollbar">
            @csrf

            <div class="p-3 sm:p-4 bg-rose-50 rounded-xl sm:rounded-2xl border border-rose-100">
                <p class="text-[9px] sm:text-[11px] font-black text-rose-800 leading-relaxed uppercase tracking-wider text-center">
                    🚨 Anda wajib melengkapi data di bawah ini untuk dapat menggunakan sistem presensi.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIP / Nomor Induk</label>
                    <input type="text" name="nip" required value="{{ $tendik->nip ?? '' }}" placeholder="Masukkan NIP..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 sm:px-4 py-2.5 sm:py-3 text-[13px] sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Agama</label>
                    <select name="id_agama" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 sm:px-4 py-2.5 sm:py-3 text-[13px] sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none cursor-pointer">
                        <option value="" disabled {{ empty($tendik->id_agama) ? 'selected' : '' }}>Pilih Agama...</option>
                        @if(isset($agama))
                            @foreach($agama as $item)
                                <option value="{{ $item->id_agama }}" {{ (isset($tendik) && $tendik->id_agama == $item->id_agama) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pendidikan Terakhir</label>
                    <select name="id_pend_terakhir" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 sm:px-4 py-2.5 sm:py-3 text-[13px] sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none cursor-pointer">
                        <option value="" disabled {{ empty($tendik->id_pend_terakhir) ? 'selected' : '' }}>Pilih Pendidikan...</option>
                        @if(isset($pendidikan))
                            @foreach($pendidikan as $p)
                                <option value="{{ $p->id_pend_terakhir }}" {{ (isset($tendik) && $tendik->id_pend_terakhir == $p->id_pend_terakhir) ? 'selected' : '' }}>
                                    {{ $p->name ?? $p->nama_pendidikan ?? $p->tingkat }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                    <select name="jk" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 sm:px-4 py-2.5 sm:py-3 text-[13px] sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none cursor-pointer">
                        <option value="" disabled {{ empty($tendik->jk) ? 'selected' : '' }}>Pilih...</option>
                        <option value="L" {{ (isset($tendik) && $tendik->jk == 'L') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ (isset($tendik) && $tendik->jk == 'P') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">No. Handphone / WA</label>
                    <input type="tel" inputmode="numeric" name="no_hp" required value="{{ $tendik->no_hp ?? '' }}" placeholder="08..." oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 sm:px-4 py-2.5 sm:py-3 text-[13px] sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" required value="{{ $tendik->tempat_lahir ?? '' }}" placeholder="Kota kelahiran..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 sm:px-4 py-2.5 sm:py-3 text-[13px] sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" required value="{{ $tendik->tanggal_lahir ?? '' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 sm:px-4 py-2.5 sm:py-3 text-[13px] sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <div class="space-y-1.5 sm:space-y-2 col-span-1 sm:col-span-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Alamat Domisili Lengkap</label>
                    <textarea name="alamat" required rows="2" placeholder="Jl. Raya..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 sm:px-4 py-2.5 sm:py-3 text-[13px] sm:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none resize-none">{{ $tendik->alamat ?? '' }}</textarea>
                </div>

            </div>

            <button type="submit" class="w-full bg-maroon-950 text-white py-3.5 sm:py-4 mt-2 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800">
                Simpan & Mulai Presensi
            </button>
        </form>
    </div>
</div>

<style> body { overflow: hidden; } </style>
@endif

<script>
    function updateClock() {
        const now = new Date();
        const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('liveDate').innerText = now.toLocaleDateString('id-ID', optionsDate);
        const timeString = now.toLocaleTimeString('id-ID', { hour12: false });
        document.getElementById('liveClock').innerText = timeString.replace(/\./g, ':');
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection
