@extends('layouts.pembimbing')

@section('content')
<main class="max-w-5xl mx-auto p-5 lg:p-10 space-y-8 animate-in">

    <!-- TOMBOL KEMBALI & HEADER -->
    <div class="flex items-center justify-between">
        <a href="{{ route('pembimbing.monitoring.index') }}" class="inline-flex items-center gap-2 px-4 py-2 sm:px-5 sm:py-2.5 bg-white border border-maroon-200 rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-black text-maroon-800 uppercase tracking-widest hover:bg-maroon-50 hover:text-maroon-950 transition-colors shadow-sm active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
        <h1 class="text-lg font-extrabold text-maroon-950 tracking-tight leading-none uppercase hidden sm:block">Verifikasi Jurnal</h1>
    </div>

    <!-- KARTU RINGKASAN PROFIL SISWA -->
    <section class="bg-white rounded-[3rem] p-8 border border-maroon-50 shadow-sm flex flex-col md:flex-row items-center gap-8">
        <div class="w-24 h-24 rounded-3xl bg-slate-100 overflow-hidden border-4 border-maroon-50 shadow-inner shrink-0 flex items-center justify-center text-3xl font-black text-maroon-900">
            <!-- Menampilkan Inisial Nama (Atau Foto) -->
            {{ substr($siswa->nama_lengkap ?? 'Siswa', 0, 1) }}
        </div>
        <div class="flex-1 text-center md:text-left">
            <p class="text-[10px] font-black text-gold uppercase tracking-[0.3em] mb-1">Anak Bimbingan</p>
            <h2 class="text-3xl font-black text-maroon-950 italic tracking-tight">{{ $siswa->nama_lengkap ?? 'Nama Siswa' }}</h2>
            <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 mt-3">
                <span class="text-sm font-bold text-slate-400">NIS: {{ $siswa->nis ?? '-' }}</span>
                <span class="w-1.5 h-1.5 bg-maroon-100 rounded-full"></span>
                <span class="text-sm font-bold text-slate-400 uppercase tracking-tighter">{{ $siswa->sekolah_asal ?? 'Instansi Tidak Diketahui' }}</span>
            </div>
        </div>
        <div class="bg-maroon-50 px-8 py-4 rounded-[2rem] border border-maroon-100 text-center shrink-0 shadow-sm">
            <p class="text-[10px] font-black text-maroon-400 uppercase tracking-widest mb-1 leading-none">Menunggu Review</p>
            <p class="text-3xl font-black text-amber-500 leading-none">
                {{ collect($riwayatLog)->where('status', 'pending')->count() }}
            </p>
        </div>
    </section>

    <!-- DAFTAR LOGBOOK -->
    <section class="space-y-6">
        <div class="flex items-center justify-between px-2">
            <h3 class="text-xl font-black text-maroon-950 tracking-tight italic">Laporan Aktivitas Harian</h3>
        </div>

        <div class="space-y-8">
            @forelse($riwayatLog as $log)
                @php
                    // Logika pewarnaan otomatis berdasarkan status laporan
                    $isPending = $log->status == 'pending';
                    $isAccepted = $log->status == 'diterima';
                    $isRejected = $log->status == 'ditolak';

                    $borderColor = $isPending ? 'border-l-amber-400' : ($isAccepted ? 'border-l-emerald-400' : 'border-l-rose-400');
                    $badgeBg = $isPending ? 'bg-amber-50 border-amber-100 text-amber-600' : ($isAccepted ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 'bg-rose-50 border-rose-100 text-rose-600');
                    $badgeText = $isPending ? 'Menunggu Verifikasi' : ($isAccepted ? 'Diterima ✅' : 'Ditolak ❌');
                    $cardOpacity = $isPending ? 'opacity-100 shadow-md' : 'opacity-90 bg-white/60 shadow-sm';
                @endphp

                <div class="bg-white rounded-[2.5rem] p-8 border border-maroon-50 relative overflow-hidden group border-l-8 {{ $borderColor }} {{ $cardOpacity }} transition-all duration-300">
                    
                    <!-- Label Status di Pojok Kanan Atas -->
                    <div class="absolute top-8 right-8 px-4 py-1.5 border rounded-full text-[9px] font-black uppercase tracking-widest {{ $badgeBg }}">
                        {{ $badgeText }}
                    </div>

                    <div class="space-y-6">
                        <!-- Tanggal / Header Log -->
                        <div class="flex items-center gap-3">
                            @if($isPending)
                                <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                            @elseif($isAccepted)
                                <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                </div>
                            @endif
                            <h4 class="text-sm font-extrabold text-slate-800">
                                {{ \Carbon\Carbon::parse($log->tanggal ?? $log->created_at)->translatedFormat('l, d F Y') }}
                            </h4>
                        </div>

                        <!-- Uraian Pekerjaan Siswa -->
                        <div class="space-y-2">
                            <p class="text-[9px] font-black text-maroon-900 uppercase tracking-widest ml-1 leading-none">Isi Laporan Siswa:</p>
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 italic font-medium text-slate-600 leading-relaxed text-sm shadow-inner">
                                "{{ $log->description ?? $log->uraian ?? 'Tidak ada uraian.' }}"
                            </div>
                        </div>

                        <!-- Form Validasi (Hanya muncul jika statusnya 'pending') -->
                        @if($isPending)
                            <form action="{{ route('pembimbing.monitoring.validasi', $log->id_log) }}" method="POST" class="space-y-4 pt-4 border-t border-slate-50">
                                @csrf
                                
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black text-maroon-900 uppercase tracking-widest ml-1 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                        Catatan / Masukan (Opsional)
                                    </label>
                                    <textarea name="catatan_pembimbing" placeholder="Berikan catatan perbaikan atau apresiasi kepada siswa..." rows="3" class="w-full bg-maroon-50/30 border border-maroon-100/50 rounded-2xl px-5 py-4 text-sm font-medium text-maroon-900 placeholder:text-maroon-300 focus:ring-2 focus:ring-maroon-500 focus:bg-white transition-all outline-none resize-none shadow-inner"></textarea>
                                </div>

                                <div class="flex flex-col sm:flex-row items-center gap-3">
                                    <!-- Tombol Terima -->
                                    <button type="submit" name="status" value="diterima" class="w-full sm:flex-1 bg-emerald-500 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-500/20 active:scale-95 transition-all flex items-center justify-center gap-2 hover:bg-emerald-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        Terima & Simpan
                                    </button>
                                    <!-- Tombol Tolak -->
                                    <button type="submit" name="status" value="ditolak" class="w-full sm:flex-1 bg-rose-50 text-rose-600 border border-rose-100 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] active:scale-95 transition-all flex items-center justify-center gap-2 hover:bg-rose-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                        Tolak Laporan
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Menampilkan Catatan yang sudah tersimpan jika status Diterima / Ditolak -->
                            @if(!empty($log->catatan_pembimbing))
                                @php
                                    $noteBg = $isAccepted ? 'bg-emerald-50/30 border-emerald-100/50 text-emerald-800' : 'bg-rose-50 border-rose-100 text-rose-800';
                                    $noteIconBg = $isAccepted ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600';
                                    $noteLabel = $isAccepted ? 'Catatan Apresiasi Anda:' : 'Alasan Penolakan Anda:';
                                @endphp
                                <div class="{{ $noteBg }} p-4 rounded-2xl border flex gap-4 items-start mt-4">
                                    <div class="w-8 h-8 rounded-lg {{ $noteIconBg }} flex items-center justify-center shrink-0">
                                        @if($isAccepted)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m11 17 2 2 4-4"/><path d="m11 9 2 2 4-4"/><path d="M7 18a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v4"/><path d="M7 3v5"/><path d="M11 3v4"/><path d="M15 3v2"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black uppercase tracking-widest leading-none mb-1.5 opacity-70">{{ $noteLabel }}</p>
                                        <p class="text-xs font-bold italic">"{{ $log->catatan_pembimbing }}"</p>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            @empty
                <!-- Tampilan Apabila Jurnal Kosong -->
                <div class="bg-white/50 backdrop-blur-sm p-12 rounded-[3rem] border-2 border-dashed border-maroon-100 flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-white rounded-full shadow-sm flex items-center justify-center text-maroon-200 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-maroon-950 tracking-tight mb-2">Belum Ada Jurnal</h3>
                    <p class="text-sm font-medium text-slate-500 max-w-md mx-auto">Siswa ini belum memiliki catatan aktivitas logbook harian untuk ditampilkan.</p>
                </div>
            @endforelse
        </div>
    </section>
</main>
@endsection