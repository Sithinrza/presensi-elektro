@extends('layouts.siswa')

@section('content')
<style>
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: slideUp 0.5s ease-out forwards;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #bc5a75;
        border-radius: 10px;
    }
</style>

<main class="max-w-7xl mx-auto p-5 lg:p-10">

    <div class="flex items-center gap-4 mb-4 lg:hidden">
        <h1 class="text-xl font-extrabold text-maroon-950 tracking-tight">E-Logbook Siswa</h1>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 font-bold rounded-2xl border border-emerald-100 animate-in">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 text-rose-700 font-bold rounded-2xl border border-rose-100 animate-in">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

        <div class="lg:col-span-5 space-y-8 animate-in" style="animation-delay: 0.1s">
            <div class="bg-white rounded-[2.5rem] p-8 border border-maroon-100 shadow-premium">
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-maroon-950 tracking-tight">Form Kegiatan</h2>
                    <p class="text-sm text-slate-400 font-medium mt-1">Input rincian tugas yang Anda kerjakan hari ini.</p>
                </div>

                @if(!$sudahAbsen)
                    <div class="bg-rose-50 border border-rose-100 rounded-2xl p-6 text-center">
                        <div class="w-16 h-16 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h3 class="font-bold text-rose-800 mb-2">Form Terkunci</h3>
                        <p class="text-xs text-rose-600 font-medium">Anda belum melakukan presensi masuk hari ini. Silakan melakukan presensi terlebih dahulu untuk membuka akses e-logbook.</p>
                        <a href="{{ route('presensi.index') }}" class="inline-block mt-4 bg-rose-600 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider shadow-md hover:bg-rose-700 transition-all">Lakukan Presensi</a>
                    </div>

                @elseif($sudahIsiLogHariIni)
                    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 text-center">
                        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <h3 class="font-bold text-emerald-800 mb-1">Log Terkirim!</h3>
                        <p class="text-xs text-emerald-600 font-medium">Anda telah berhasil mengisi rekaman logbook harian untuk hari ini. Sampai jumpa besok!</p>
                    </div>

                @else
                    @if ($errors->any())
                        <div class="p-4 bg-rose-50 text-rose-700 font-bold rounded-2xl border border-rose-100 text-xs">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('siswa.log.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Tanggal</label>
                            <div class="relative">
                                <input type="text" value="{{ \Carbon\Carbon::parse($tanggalHariIni)->translatedFormat('d F Y') }}" readonly class="w-full bg-maroon-50 border-none rounded-2xl px-5 py-4 text-sm font-bold text-maroon-900 focus:ring-0 cursor-default">
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 text-maroon-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Uraian Pekerjaan</label>
                            <textarea name="kegiatan" required placeholder="Contoh: Maintenance jaringan di Gedung Elektro lantai 2..." rows="8" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:ring-2 focus:ring-maroon-500 focus:bg-white transition-all outline-none resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-maroon-950 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl shadow-maroon-950/20 active:scale-95 transition-all flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
                            Simpan Log
                        </button>
                    </form>
                @endif
            </div>

            <div class="bg-gold-light border border-gold/30 rounded-[2.5rem] p-6 flex items-start gap-5">
                <div class="w-12 h-12 bg-gold rounded-2xl shrink-0 flex items-center justify-center text-white shadow-lg shadow-gold/20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-extrabold text-gold-dark">Petunjuk Log</h4>
                    <p class="text-[11px] text-gold-dark/70 mt-1 leading-relaxed font-medium">
                        Log harian wajib diisi setiap hari kerja sebagai syarat penilaian magang oleh koordinator.
                    </p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 space-y-6 animate-in" style="animation-delay: 0.2s">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-maroon-950 tracking-tight">Riwayat Log</h2>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Daftar Kegiatan Terbaru</p>
                </div>
            </div>

            <div class="space-y-4 max-h-[700px] overflow-y-auto no-scrollbar pr-1 custom-scrollbar">
                @forelse($riwayatLog as $log)
                <div class="group bg-white p-6 rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden">

                    @if($log->status == 'diterima')
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-emerald-500"></div>
                    @elseif($log->status == 'ditolak')
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-rose-500"></div>
                    @else
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-amber-400"></div>
                    @endif

                    <div class="flex items-start justify-between mb-4 pl-2">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 {{ $log->status == 'diterima' ? 'bg-emerald-500' : ($log->status == 'ditolak' ? 'bg-rose-500' : 'bg-amber-500') }} text-white rounded-2xl flex items-center justify-center shadow-lg">
                                @if($log->status == 'diterima')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                @elseif($log->status == 'ditolak')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-extrabold text-slate-800 tracking-tight">
                                    {{ \Carbon\Carbon::parse($log->report_date)->translatedFormat('l, d F Y') }}
                                </h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[9px] font-black uppercase tracking-widest {{ $log->status == 'diterima' ? 'text-emerald-600' : ($log->status == 'ditolak' ? 'text-rose-600' : 'text-amber-600') }}">
                                        {{ $log->status == 'pending' ? 'Menunggu Validasi' : $log->status }}
                                    </span>
                                    <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                    <span class="text-[9px] font-bold text-slate-400">{{ \Carbon\Carbon::parse($log->report_date)->format('H:i') }} WITA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 ml-2">
                        <p class="text-xs font-semibold text-slate-600 leading-relaxed italic">
                            "{{ $log->description }}"
                        </p>
                    </div>

                    @if($log->catatan_pembimbing)
                    <div class="mt-4 ml-2 pl-4 border-l-2 border-gold/50">
                        <p class="text-[10px] font-black text-gold-dark uppercase tracking-widest mb-1">Catatan Pembimbing:</p>
                        <p class="text-xs font-medium text-slate-500">"{{ $log->catatan_pembimbing }}"</p>
                    </div>
                    @endif
                </div>
                @empty
                <div class="bg-white p-10 rounded-[2.5rem] border border-maroon-50 shadow-sm text-center">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Belum ada catatan aktivitas jurnal.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection
