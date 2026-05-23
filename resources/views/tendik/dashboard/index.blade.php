@extends('layouts.tendik')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10">
    <!-- Notifikasi Sukses/Error (Opsional, jika ada) -->
    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- KIRI: SAMBUTAN & TOMBOL ABSEN -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-8">
            <section class="animate-in flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 id="liveDate" class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-wider italic">Memuat Tanggal...</h2>
                </div>
                <div class="md:text-right text-left">
                    <div id="liveClock" class="text-4xl md:text-5xl font-black text-maroon-950 tracking-tighter leading-none mb-1">00:00:00</div>
                    <span class="text-[10px] md:text-xs font-bold text-maroon-500 uppercase tracking-widest">Waktu Indonesia Tengah</span>
                </div>
            </section>

            <section class="animate-in">
                <div class="relative bg-maroon-900 rounded-[3rem] p-8 md:p-10 text-white shadow-premium overflow-hidden border border-maroon-800">
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-gold/20 rounded-full blur-[80px]"></div>
                    <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-white/10 rounded-full blur-[60px]"></div>

                    <div class="relative z-10 space-y-8">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="space-y-2">
                                <p class="text-maroon-200/60 text-xs font-bold uppercase tracking-[0.3em]">Status Presensi</p>
                                <h3 class="text-2xl md:text-3xl font-black italic tracking-tight leading-tight">Presensi Liveness <br><span class="text-gold">Detection</span></h3>
                            </div>
                            <div class="bg-emerald-500/20 text-emerald-300 px-4 py-2 rounded-2xl text-xs font-extrabold border border-emerald-500/30 backdrop-blur-md flex items-center gap-3">
                                <span class="w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_12px_rgba(52,211,153,0.8)]"></span>
                                SIAP PRESENSI
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <a href="{{ route('presensi.index') }}" class="group bg-white rounded-[2rem] p-6 flex items-center gap-5 shadow-xl hover:shadow-2xl active:scale-95 transition-all duration-300">
                                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-maroon-950 font-black text-lg uppercase tracking-wide leading-none">Presensi Masuk</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Check-In Pagi</span>
                                </div>
                            </a>
                            <a href="{{ route('presensi.index') }}" class="group bg-maroon-800 border border-white/10 rounded-[2rem] p-6 flex items-center gap-5 active:scale-95 transition-all duration-300 hover:bg-rose-900/40">
                                <div class="w-14 h-14 bg-white/10 text-maroon-100 rounded-2xl flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-white font-black text-lg uppercase tracking-wide leading-none">Presensi Pulang</span>
                                    <span class="text-[10px] text-maroon-200/50 font-bold uppercase tracking-widest mt-1">Check-Out Sore</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- KANAN: STATISTIK & INFO -->
        <div class="lg:col-span-5 xl:col-span-4 space-y-8">
            <section class="animate-in">
                <div class="bg-white p-8 rounded-[3rem] border border-maroon-100 shadow-sm space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-extrabold text-maroon-950 tracking-tight text-lg">Kehadiran Bulan Ini</h3>
                        <span class="text-[10px] font-black bg-gold-light text-gold-dark px-3 py-1 rounded-full uppercase tracking-tighter">
                            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                        </span>
                    </div>

                    <div class="flex flex-col items-center justify-center py-6 bg-maroon-50 rounded-[2rem] border border-maroon-100/50">
                        <div class="flex items-baseline gap-1">
                            <span class="text-6xl font-black text-maroon-950 leading-none">{{ $hadir ?? 0 }}</span>
                            <span class="text-lg font-bold text-maroon-500/60 uppercase tracking-tighter">/ {{ $total_hari_kerja ?? 22 }}</span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-[0.2em]">Total Kehadiran</p>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-maroon-50/50 p-3 rounded-2xl border border-maroon-100/30 flex flex-col items-center">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Hadir</span>
                            <span class="text-xl font-black text-maroon-900 mt-1">{{ $hadir ?? 0 }}</span>
                        </div>
                        <div class="bg-amber-50 p-3 rounded-2xl border border-amber-100 flex flex-col items-center">
                            <span class="text-[9px] font-bold text-amber-600/60 uppercase tracking-widest leading-none">Telat</span>
                            <span class="text-xl font-black text-amber-600 mt-1">{{ $telat ?? 0 }}</span>
                        </div>
                        <div class="bg-rose-50 p-3 rounded-2xl border border-rose-100 flex flex-col items-center">
                            <span class="text-[9px] font-bold text-rose-400 uppercase tracking-widest leading-none">Alpa</span>
                            <span class="text-xl font-black text-rose-600 mt-1">{{ $alpa ?? 0 }}</span>
                        </div>
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
            <h3 class="text-xl font-black tracking-tight italic">Selamat Datang, {{ $tendik->nama_lengkap ?? Auth::user()->name }}!</h3>
            <p class="text-xs font-bold text-maroon-300 uppercase tracking-widest mt-2">Lengkapi Biodata Kepegawaian Anda</p>
        </div>

        <!-- Body Form -->
        <form action="{{ route('tendik.lengkapi.profil') }}" method="POST" class="p-8 space-y-6 overflow-y-auto no-scrollbar">
            @csrf

            <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100">
                <p class="text-[11px] font-black text-rose-800 leading-relaxed uppercase tracking-wider text-center">
                    🚨 Anda wajib melengkapi data di bawah ini untuk dapat menggunakan sistem presensi.
                </p>
            </div>

            <!-- GRID FORM TENDIK -->
            <div class="grid grid-cols-2 gap-5">

                <!-- NIP -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">NIP / Nomor Induk</label>
                    <input type="text" name="nip" required value="{{ $tendik->nip ?? '' }}" placeholder="Masukkan NIP..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Agama -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Agama</label>
                    <select name="id_agama" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        <option value="">Pilih Agama...</option>
                        @if(isset($agama))
                            @foreach($agama as $item)
                                <option value="{{ $item->id_agama }}" {{ (isset($tendik) && $tendik->id_agama == $item->id_agama) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <!-- Pendidikan Terakhir -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Pendidikan Terakhir</label>
                    <select name="id_pend_terakhir" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                        <option value="">Pilih Pendidikan...</option>
                        @if(isset($pendidikan))
                            @foreach($pendidikan as $p)
                                <!-- Sesuaikan $p->name dengan nama kolom di tabel pendidikan_terakhir milikmu -->
                                <option value="{{ $p->id_pend_terakhir }}" {{ (isset($tendik) && $tendik->id_pend_terakhir == $p->id_pend_terakhir) ? 'selected' : '' }}>
                                    {{ $p->name ?? $p->nama_pendidikan ?? $p->tingkat }}
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
                        <option value="L" {{ (isset($tendik) && $tendik->jk == 'L') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ (isset($tendik) && $tendik->jk == 'P') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- No Handphone -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">No. Handphone / WA</label>
                    <input type="text" name="no_hp" required value="{{ $tendik->no_hp ?? '' }}" placeholder="08..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Tempat Lahir -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" required value="{{ $tendik->tempat_lahir ?? '' }}" placeholder="Kota kelahiran..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Tanggal Lahir -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" required value="{{ $tendik->tanggal_lahir ?? '' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">
                </div>

                <!-- Alamat -->
                <div class="space-y-2 col-span-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Alamat Domisili Lengkap</label>
                    <textarea name="alamat" required rows="2" placeholder="Jl. Raya..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none">{{ $tendik->alamat ?? '' }}</textarea>
                </div>

            </div>

            <button type="submit" class="w-full bg-maroon-950 text-white py-4 mt-2 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all hover:bg-maroon-800">
                Simpan & Mulai Presensi
            </button>
        </form>
    </div>
</div>

<style> body { overflow: hidden; } </style>
@endif

<!-- JAVASCRIPT JAM REALTIME -->
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
