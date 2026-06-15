@extends('layouts.pembimbing')
@section('page_title', 'Verifikasi Logbook')

@section('content')
<style>
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: slideIn 0.5s ease-out forwards;
    }
</style>

<main class="max-w-5xl mx-auto p-4 sm:p-5 lg:p-10 space-y-6 sm:space-y-8 animate-in">

    <div class="flex items-center justify-between border-b border-maroon-100/30 pb-3 sm:pb-4">
        <a href="{{ route('pembimbing.monitoring.index') }}" class="inline-flex items-center gap-2 px-4 py-2 sm:px-5 sm:py-2.5 bg-white border border-maroon-200 rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-black text-maroon-800 uppercase tracking-widest hover:bg-maroon-50 hover:text-maroon-950 transition-colors shadow-sm active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
        <h1 class="text-base sm:text-lg font-extrabold text-maroon-950 tracking-tight leading-none uppercase italic hidden sm:block">Verifikasi Logbook</h1>
    </div>

    <section class="bg-maroon-900 rounded-3xl sm:rounded-[3rem] p-6 sm:p-8 border border-maroon-800 shadow-premium flex flex-col md:flex-row items-center gap-6 sm:gap-8 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-gold/20 rounded-full blur-[60px] pointer-events-none"></div>

        <div class="relative z-10 w-20 h-20 sm:w-24 sm:h-24 rounded-full border-4 border-gold p-1 shadow-md bg-white shrink-0">
            <div class="w-full h-full rounded-full overflow-hidden bg-slate-100 flex items-center justify-center text-3xl font-black text-maroon-900">
                @if(isset($siswa->foto_profil) && $siswa->foto_profil)
                    <img src="{{ asset('storage/' . $siswa->foto_profil) }}" class="w-full h-full object-cover">
                @else
                    {{ substr($siswa->nama_lengkap ?? 'M', 0, 1) }}
                @endif
            </div>
        </div>

        <div class="relative z-10 flex-1 text-center md:text-left space-y-1">
            <h2 class="text-2xl sm:text-3xl font-black text-white italic tracking-tight leading-none">{{ $siswa->nama_lengkap ?? 'Nama Peserta Magang' }}</h2>
            <div class="flex flex-col sm:flex-row justify-center md:justify-start items-center gap-1.5 sm:gap-3 mt-2">
                <span class="text-[10px] sm:text-xs font-bold text-gold tracking-widest uppercase">NIS: {{ $siswa->nis ?? '-' }}</span>
                <span class="hidden sm:block w-1.5 h-1.5 bg-maroon-300 rounded-full"></span>
                <span class="text-[10px] sm:text-xs font-medium text-maroon-200 uppercase tracking-widest">{{ $siswa->sekolah_asal ?? 'Instansi Tidak Diketahui' }}</span>
            </div>
        </div>

        <div class="relative z-10 bg-white/10 backdrop-blur-md w-full md:w-auto px-6 sm:px-8 py-4 rounded-2xl sm:rounded-[2rem] border border-white/20 text-center shrink-0 shadow-inner">
            <p class="text-[9px] sm:text-[10px] font-black text-maroon-200/80 uppercase tracking-widest mb-1 leading-none">Menunggu Review</p>
            <p class="text-2xl sm:text-3xl font-black text-gold leading-none drop-shadow-md">
                {{ collect($riwayatLog ?? [])->where('status', 'pending')->count() }}
            </p>
        </div>
    </section>

    <section class="space-y-5 sm:space-y-6">

        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 px-1 sm:px-2">
            <h3 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight italic">Laporan Aktivitas Harian</h3>

            <form id="filterForm" onsubmit="applyFilter(event)" class="flex flex-wrap items-center gap-2">
                <div class="relative flex-1 sm:flex-none">
                    <select id="filterStatus" name="status" class="w-full appearance-none bg-white border border-maroon-100 rounded-xl px-4 py-2.5 pr-10 text-[10px] sm:text-xs font-bold text-maroon-950 shadow-sm focus:outline-none focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                        <option value="all">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak (Revisi)</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-maroon-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

                <div class="relative flex-1 sm:flex-none">
                    <select id="filterBulan" name="bulan" class="w-full appearance-none bg-white border border-maroon-100 rounded-xl px-4 py-2.5 pr-10 text-[10px] sm:text-xs font-bold text-maroon-950 shadow-sm focus:outline-none focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                        <option value="all">Semua Bulan</option>
                        @php
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        @endphp
                        @foreach($months as $num => $name)
                            <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-maroon-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

                <div class="relative w-[30%] sm:w-auto">
                    <select id="filterTahun" name="tahun" class="w-full appearance-none bg-white border border-maroon-100 rounded-xl px-4 py-2.5 pr-10 text-[10px] sm:text-xs font-bold text-maroon-950 shadow-sm focus:outline-none focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                        <option value="all">Tahun</option>
                        @php $currentYear = date('Y'); @endphp
                        @for($y = $currentYear; $y >= $currentYear - 2; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-maroon-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

                <button type="submit" class="w-full sm:w-auto bg-maroon-950 text-white px-4 py-2.5 rounded-xl shadow-md hover:bg-maroon-800 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.3-4.3"/><circle cx="10" cy="10" r="7"/></svg>
                    <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest">Filter</span>
                </button>
            </form>
        </div>

        <div id="logbook-container" class="space-y-5 sm:space-y-6">
            @forelse($riwayatLog ?? [] as $log)
                @php
                    $isPending = $log->status == 'pending';
                    $isAccepted = $log->status == 'diterima';
                    $isRejected = $log->status == 'ditolak';

                    $borderColor = $isPending ? 'border-l-amber-400' : ($isAccepted ? 'border-l-emerald-400' : 'border-l-rose-400');
                    $badgeBg = $isPending ? 'bg-amber-50 border-amber-100 text-amber-600' : ($isAccepted ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 'bg-rose-50 border-rose-100 text-rose-600');
                    $badgeText = $isPending ? 'Menunggu Verifikasi' : ($isAccepted ? 'Diterima ✅' : 'Ditolak ❌');
                    $cardOpacity = $isPending ? 'opacity-100 shadow-md' : 'opacity-90 bg-white/60 shadow-sm';

                    $logMonth = \Carbon\Carbon::parse($log->tanggal ?? $log->created_at)->format('n');
                    $logYear = \Carbon\Carbon::parse($log->tanggal ?? $log->created_at)->format('Y');
                @endphp

                <div class="log-card bg-white rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 border border-maroon-50 relative overflow-hidden group border-l-[6px] sm:border-l-8 {{ $borderColor }} {{ $cardOpacity }} transition-all duration-300"
                     data-status="{{ $log->status }}"
                     data-bulan="{{ $logMonth }}"
                     data-tahun="{{ $logYear }}">

                    <div class="absolute top-4 sm:top-6 right-4 sm:right-6 px-3 py-1 sm:px-4 sm:py-1.5 border rounded-full text-[8px] sm:text-[9px] font-black uppercase tracking-widest {{ $badgeBg }}">
                        {{ $badgeText }}
                    </div>

                    <div class="space-y-4 sm:space-y-5 mt-6 sm:mt-0">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            @if($isPending)
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                            @elseif($isAccepted)
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                </div>
                            @else
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                </div>
                            @endif
                            <h4 class="text-xs sm:text-sm font-extrabold text-slate-800">
                                {{ \Carbon\Carbon::parse($log->tanggal ?? $log->created_at)->translatedFormat('l, d F Y') }}
                            </h4>
                        </div>

                        <div class="space-y-2">
                            <p class="text-[8px] sm:text-[9px] font-black text-maroon-900 uppercase tracking-widest ml-1 leading-none">Isi Laporan:</p>
                            <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-100 italic font-medium text-slate-600 leading-relaxed text-xs sm:text-sm shadow-inner">
                                "{{ $log->description ?? $log->uraian ?? 'Tidak ada uraian.' }}"
                            </div>
                        </div>

                        @if($isPending)
                            <form action="{{ route('pembimbing.monitoring.validasi', $log->id_log) }}" method="POST" class="space-y-3 sm:space-y-4 pt-3 sm:pt-4 border-t border-slate-50">
                                @csrf
                                <div class="space-y-2 sm:space-y-3">
                                    <textarea name="catatan_pembimbing" placeholder="Catatan" rows="2" class="w-full bg-maroon-50/30 border border-maroon-100/50 rounded-xl sm:rounded-2xl px-4 py-3 text-xs sm:text-sm font-medium text-maroon-900 placeholder:text-maroon-300 focus:ring-2 focus:ring-maroon-500 focus:bg-white transition-all outline-none resize-none shadow-inner"></textarea>
                                </div>

                                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-3">
                                    <button type="submit" name="status" value="diterima" class="w-full sm:flex-1 bg-emerald-500 text-white py-3 sm:py-3.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-500/20 active:scale-95 transition-all flex items-center justify-center gap-2 hover:bg-emerald-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        Terima Laporan
                                    </button>
                                    <button type="submit" name="status" value="ditolak" class="w-full sm:flex-1 bg-rose-50 text-rose-600 border border-rose-100 py-3 sm:py-3.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em] active:scale-95 transition-all flex items-center justify-center gap-2 hover:bg-rose-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                        Tolak / Revisi
                                    </button>
                                </div>
                            </form>
                        @else
                            @if(!empty($log->catatan_pembimbing))
                                @php
                                    $noteBg = $isAccepted ? 'bg-emerald-50/30 border-emerald-100/50 text-emerald-800' : 'bg-rose-50 border-rose-100 text-rose-800';
                                    $noteIconBg = $isAccepted ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600';
                                    $noteLabel = $isAccepted ? 'Catatan Apresiasi Anda:' : 'Alasan Penolakan Anda:';
                                @endphp
                                <div class="{{ $noteBg }} p-3 sm:p-4 rounded-xl sm:rounded-2xl border flex gap-3 sm:gap-4 items-start mt-3">
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg {{ $noteIconBg }} flex items-center justify-center shrink-0">
                                        @if($isAccepted)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m11 17 2 2 4-4"/><path d="m11 9 2 2 4-4"/><path d="M7 18a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v4"/><path d="M7 3v5"/><path d="M11 3v4"/><path d="M15 3v2"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-[8px] sm:text-[9px] font-black uppercase tracking-widest leading-none mb-1.5 opacity-70">{{ $noteLabel }}</p>
                                        <p class="text-[10px] sm:text-xs font-bold italic">"{{ $log->catatan_pembimbing }}"</p>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            @empty
                <div class="bg-white/50 backdrop-blur-sm p-10 sm:p-12 rounded-3xl sm:rounded-[3rem] border-2 border-dashed border-maroon-100 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-full shadow-sm flex items-center justify-center text-maroon-200 mb-4 sm:mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight mb-2">Belum Ada Jurnal</h3>
                    <p class="text-xs sm:text-sm font-medium text-slate-500 max-w-sm mx-auto">Peserta magang ini belum memiliki catatan aktivitas harian.</p>
                </div>
            @endforelse

            <div id="js-empty-state" style="display: none;" class="bg-white/50 backdrop-blur-sm p-10 sm:p-12 rounded-3xl sm:rounded-[3rem] border-2 border-dashed border-maroon-100 flex-col items-center justify-center text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-full shadow-sm flex items-center justify-center text-maroon-200 mb-4 sm:mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <h3 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight mb-2">Jurnal Tidak Ditemukan</h3>
                <p class="text-xs sm:text-sm font-medium text-slate-500 max-w-sm mx-auto">Tidak ada laporan yang sesuai dengan status atau bulan yang Anda cari.</p>
            </div>

        </div>
    </section>
</main>

<script>
    function applyFilter(e) {
        e.preventDefault();

        const statusVal = document.getElementById('filterStatus').value;
        const bulanVal = document.getElementById('filterBulan').value;
        const tahunVal = document.getElementById('filterTahun').value;

        const cards = document.querySelectorAll('.log-card');
        const emptyState = document.getElementById('js-empty-state');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardStatus = card.getAttribute('data-status');
            const cardBulan = card.getAttribute('data-bulan');
            const cardTahun = card.getAttribute('data-tahun');

            let matchStatus = (statusVal === 'all') || (cardStatus === statusVal);
            let matchBulan = (bulanVal === 'all') || (cardBulan === bulanVal);
            let matchTahun = (tahunVal === 'all') || (cardTahun === tahunVal);

            if(matchStatus && matchBulan && matchTahun) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if(visibleCount === 0 && cards.length > 0) {
            emptyState.style.display = 'flex';
        } else {
            emptyState.style.display = 'none';
        }
    }
</script>
@endsection
