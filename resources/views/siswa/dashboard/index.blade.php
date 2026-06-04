@extends('layouts.siswa')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT COLUMN -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-8">

            <!-- GREETING & CLOCK -->
            <section class="animate-in flex flex-col md:flex-row md:items-end justify-between gap-4" style="animation-delay: 0.1s">
                <div>
                    <!-- Greeting dinamis berdasarkan waktu bisa diatur di controller, ini contoh static -->
                    <h2 id="liveDate" class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-wider italic">Memuat Tanggal...</h2>
                </div>
                <div class="md:text-right text-left">
                    <div id="liveClock" class="text-4xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-none mb-1">00:00:00</div>
                    <span class="text-[10px] md:text-xs font-bold text-maroon-500 uppercase tracking-widest">Waktu Indonesia Tengah</span>
                </div>
            </section>

            <!-- PRESENSI CARD -->
            <section class="animate-in" style="animation-delay: 0.2s">
                <div class="relative bg-maroon-900 rounded-[3rem] p-8 md:p-10 text-white shadow-premium overflow-hidden border border-maroon-800">
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-gold/20 rounded-full blur-[80px]"></div>
                    <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-white/10 rounded-full blur-[60px]"></div>

                    <div class="relative z-10 space-y-8">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="space-y-2">
                                <p class="text-maroon-200/60 text-xs font-bold uppercase tracking-[0.3em]">Status Presensi</p>
                                <h3 class="text-2xl md:text-3xl font-black italic tracking-tight leading-tight">Pastikan Lokasi & Wajah <br><span class="text-gold">Terverifikasi</span></h3>
                            </div>
                            <div class="bg-emerald-500/20 text-emerald-300 px-4 py-2 rounded-2xl text-xs font-extrabold border border-emerald-500/30 backdrop-blur-md flex items-center gap-3">
                                <span class="w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_12px_rgba(52,211,153,0.8)]"></span>
                                SIAP PRESENSI
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- TOMBOL MENUJU PRESENSI GLOBAL -->
                            <a href="{{ route('presensi.index') }}" class="group bg-white rounded-[2rem] p-6 flex items-center gap-5 shadow-xl hover:shadow-2xl active:scale-95 transition-all duration-300">
                                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-maroon-950 font-black text-lg uppercase tracking-wide leading-none">Presensi Masuk</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Start Working</span>
                                </div>
                            </a>
                            <!-- TOMBOL MENUJU PRESENSI GLOBAL JUGA (Sistem di Controller yang menentukan ini masuk/pulang) -->
                            <a href="{{ route('presensi.index') }}" class="group bg-maroon-800 border border-white/10 rounded-[2rem] p-6 flex items-center gap-5 active:scale-95 transition-all duration-300 hover:bg-rose-900/40">
                                <div class="w-14 h-14 bg-white/10 text-maroon-100 rounded-2xl flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-white font-black text-lg uppercase tracking-wide leading-none">Presensi Pulang</span>
                                    <span class="text-[10px] text-maroon-200/50 font-bold uppercase tracking-widest mt-1">End Session</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- LOG HARIAN QUICK ACCESS -->
            <section class="animate-in" style="animation-delay: 0.3s">
                <div class="bg-white rounded-[2.5rem] p-8 border border-maroon-100 shadow-sm flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                    <div class="w-20 h-20 bg-gold-light text-gold-dark rounded-3xl flex items-center justify-center shrink-0 shadow-inner mx-auto md:mx-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-black text-maroon-950 tracking-tight">Log Harian Siswa</h3>
                        <p class="text-sm text-slate-500 font-medium mt-1 leading-relaxed">
                            Jangan lupa isi laporan kegiatan magang kamu hari ini agar terekap oleh pembimbing.
                        </p>
                    </div>
                    <!-- Arahkan ke URL form tambah logbook -->
                    <a href="{{ route('siswa.log') }}" class="bg-maroon-950 text-white px-8 py-4 rounded-2xl font-bold hover:bg-maroon-800 transition-all shadow-lg active:scale-95 whitespace-nowrap w-full md:w-auto inline-block text-center">
                        Isi Log Hari Ini
                    </a>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="lg:col-span-5 xl:col-span-4 space-y-8">

            <section class="animate-in" style="animation-delay: 0.4s">
                <div class="bg-white p-8 rounded-[3rem] border border-maroon-100 shadow-sm space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-extrabold text-maroon-950 tracking-tight text-lg">Kehadiran Bulan Ini</h3>
                        <span class="text-[10px] font-black bg-gold-light text-gold-dark px-3 py-1 rounded-full uppercase tracking-tighter">
                            {{ \Carbon\Carbon::now('Asia/Makassar')->translatedFormat('F Y') }}
                        </span>
                    </div>

                    <div class="bg-emerald-50 rounded-[2rem] p-6 border border-emerald-100">
                        <div class="flex flex-col items-center justify-center mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-6xl font-black text-emerald-700 leading-none">{{ $hadir ?? 0 }}</span>
                                <span class="text-lg font-bold text-emerald-600/50 uppercase tracking-tighter">/ {{ $total_hari_kerja ?? 20 }}</span>
                            </div>
                            <p class="text-[10px] font-bold text-emerald-600/70 mt-2 uppercase tracking-[0.2em]">Total Kehadiran</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-white p-4 rounded-2xl border border-emerald-100/50 flex flex-col items-center shadow-sm">
                                <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest leading-none">Tepat Waktu</span>
                                <span class="text-2xl font-black text-emerald-900 mt-2">{{ $tepatWaktu ?? 0 }}</span>
                            </div>
                            <div class="bg-white p-4 rounded-2xl border border-emerald-100/50 flex flex-col items-center shadow-sm">
                                <span class="text-[9px] font-black text-amber-500 uppercase tracking-widest leading-none">Terlambat</span>
                                <span class="text-2xl font-black text-amber-600 mt-2">{{ $telat ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-rose-50 rounded-[2rem] p-6 border border-rose-100 flex items-center justify-between">
                        <div>
                            <p class="text-[12px] font-black text-rose-800 uppercase tracking-widest leading-none">Alfa</p>
                            <p class="text-[9px] font-bold text-rose-600/70 mt-1.5 uppercase tracking-wider">Tanpa Keterangan</p>
                        </div>
                        <span class="text-4xl font-black text-rose-600">{{ $alpa ?? 0 }}</span>
                    </div>
                </div>
            </section>

            <!-- INFO BANNER -->
            <section class="animate-in" style="animation-delay: 0.5s">
                <div class="bg-gradient-to-br from-gold/20 to-maroon-50 border border-gold/30 rounded-[2.5rem] p-6 flex items-start gap-5 backdrop-blur-sm">
                    <div class="w-12 h-12 bg-gold rounded-2xl shrink-0 flex items-center justify-center text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-gold-dark uppercase tracking-wider">Tips Keamanan</h4>
                        <p class="text-[11px] text-gold-dark/70 mt-1.5 leading-relaxed font-medium">
                            Pastikan kamu berada di area Jurusan saat melakukan presensi untuk menghindari kegagalan sistem lokasi.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<!-- ============================================================== -->
<!-- POPUP WAJIB ISI PROFIL (Muncul jika isProfilLengkap = false) -->
<!-- ============================================================== -->
@if(isset($isProfilLengkap) && !$isProfilLengkap)
<div class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    <!-- Background Blur -->
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-md"></div>

    <!-- Modal Container -->
    <div class="relative w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden animate-in zoom-in-95 duration-300 max-h-[90vh] flex flex-col">

        <!-- Header Popup -->
        <div class="bg-maroon-950 px-8 py-6 text-white text-center shrink-0">
            <h3 class="text-xl font-black tracking-tight italic">Selamat Datang, {{ $siswa->nama_lengkap ?? Auth::user()->name }}!</h3>
            <p class="text-xs font-bold text-maroon-300 uppercase tracking-widest mt-2">Lengkapi Data Biodata Diri Anda</p>
        </div>

        <!-- Body Form -->
        <form action="{{ route('siswa.lengkapi.profil') }}" method="POST" class="p-8 space-y-6 overflow-y-auto no-scrollbar">
            @csrf

            <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100">
                <p class="text-[11px] font-black text-rose-800 leading-relaxed uppercase tracking-wider text-center">
                    🚨 Anda wajib melengkapi data di bawah ini untuk mengaktifkan fitur Liveness Detection Anda.
                </p>
            </div>

            <!-- GRID FORM -->
            <div class="grid grid-cols-2 gap-5">

                <!-- NIS -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIS / Nomor Induk</label>
                    <input type="text" name="nis" required value="{{ $siswa->nis ?? '' }}" placeholder="Masukkan NIS..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Sekolah Asal -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Sekolah Asal</label>
                    <input type="text" name="sekolah_asal" required value="{{ $siswa->sekolah_asal ?? '' }}" placeholder="Nama sekolah..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Jurusan -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jurusan / Kelas</label>
                    <input type="text" name="jurusan" required value="{{ $siswa->jurusan ?? '' }}" placeholder="Contoh: TKJ / XII" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Agama -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Agama</label>
                    <select name="id_agama" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        <option value="">Pilih...</option>
                        @if(isset($agama))
                            @foreach($agama as $item)
                                <option value="{{ $item->id_agama }}" {{ (isset($siswa) && $siswa->id_agama == $item->id_agama) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Jenis Kelamin -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                    <select name="jk" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        <option value="">Pilih...</option>
                        <option value="L" {{ (isset($siswa) && $siswa->jk == 'L') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ (isset($siswa) && $siswa->jk == 'P') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- No Handphone -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">No. Handphone / WA</label>
                    <input type="text" name="no_hp" required value="{{ $siswa->no_hp ?? '' }}" placeholder="08..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Tempat Lahir -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" required value="{{ $siswa->tempat_lahir ?? '' }}" placeholder="Kota kelahiran..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Tanggal Lahir -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" required value="{{ $siswa->tanggal_lahir ?? '' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Alamat -->
                <div class="space-y-2 col-span-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Alamat Domisili Lengkap</label>
                    <textarea name="alamat" required rows="2" placeholder="Jl. Raya..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">{{ $siswa->alamat ?? '' }}</textarea>
                </div>

            </div>

            <button type="submit" class="w-full bg-maroon-950 text-white py-4 mt-2 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800">
                Simpan & Lanjutkan
            </button>
        </form>
    </div>
</div>

<!-- Mencegah scroll di background jika popup muncul -->
<style>
    body { overflow: hidden; }
</style>
@endif

<!-- JAVASCRIPT UNTUK JAM REALTIME -->
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
