@extends('layouts.siswa')

@section('content')
<!-- CSS KHUSUS HALAMAN LOGBOOK -->
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
    
    /* Styling input date agar senada dengan tema */
    input[type="date"]::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="%23bc5a75" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>');
        cursor: pointer;
    }
</style>

<!-- KONTEN UTAMA LOGBOOK -->
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10">

    <!-- Judul Halaman (Untuk Mobile) -->
    <div class="flex items-center gap-4 mb-4 lg:hidden">
        <h1 class="text-xl font-extrabold text-maroon-950 tracking-tight">E-Logbook Siswa</h1>
    </div>

    @if(session('success'))
        <div class="mb-6 p-3 sm:p-4 bg-emerald-50 text-emerald-700 text-xs sm:text-sm font-bold rounded-xl sm:rounded-2xl border border-emerald-100 animate-in">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-3 sm:p-4 bg-rose-50 text-rose-700 text-xs sm:text-sm font-bold rounded-xl sm:rounded-2xl border border-rose-100 animate-in">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-10 items-start">
        
        <!-- BAGIAN FORM INPUT (COL 5) -->
        <div class="lg:col-span-5 space-y-6 sm:space-y-8 animate-in" style="animation-delay: 0.1s">
            <div class="bg-white rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-8 border border-maroon-100 shadow-premium">
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl font-black text-maroon-950 tracking-tight leading-none">Form Kegiatan</h2>
                    <p class="text-xs sm:text-sm text-slate-400 font-medium mt-1 sm:mt-2">Input rincian tugas yang Anda kerjakan hari ini.</p>
                </div>

                @if(!$sudahAbsen)
                    <div class="bg-rose-50 border border-rose-100 rounded-2xl p-5 sm:p-6 text-center">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-8 sm:h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h3 class="font-bold text-rose-800 mb-1 sm:mb-2 text-sm sm:text-base">Form Terkunci</h3>
                        <p class="text-[10px] sm:text-xs text-rose-600 font-medium">Anda belum melakukan presensi masuk hari ini. Silakan melakukan presensi terlebih dahulu untuk membuka akses e-logbook.</p>
                        <a href="{{ route('presensi.index') }}" class="inline-block mt-4 bg-rose-600 text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-[10px] sm:text-xs font-bold uppercase tracking-wider shadow-md hover:bg-rose-700 transition-all">Lakukan Presensi</a>
                    </div>

                @elseif($sudahIsiLogHariIni)
                    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-5 sm:p-6 text-center">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-8 sm:h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <h3 class="font-bold text-emerald-800 mb-1 text-sm sm:text-base">Log Terkirim!</h3>
                        <p class="text-[10px] sm:text-xs text-emerald-600 font-medium">Anda telah berhasil mengisi rekaman logbook harian untuk hari ini. Sampai jumpa besok!</p>
                    </div>

                @else
                    @if ($errors->any())
                        <div class="p-3 sm:p-4 bg-rose-50 text-rose-700 font-bold rounded-xl sm:rounded-2xl border border-rose-100 text-[10px] sm:text-xs mb-4">
                            <ul class="list-disc pl-4 sm:pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('siswa.log.store') }}" method="POST" class="space-y-4 sm:space-y-6">
                        @csrf
                        <!-- TANGGAL (Kalender Aktif & Dibatasi) -->
                        <div class="space-y-1.5 sm:space-y-2">
                            <label for="log_date" class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Pilih Tanggal Kegiatan</label>
                            <div class="relative">
                                <input 
                                    type="date" 
                                    id="log_date"
                                    name="tanggal"
                                    max="{{ date('Y-m-d') }}"
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full bg-maroon-50/50 border border-maroon-100/50 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-xs sm:text-sm font-bold text-maroon-950 focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:bg-white transition-all cursor-pointer"
                                    required
                                >
                            </div>
                            <p class="text-[8px] sm:text-[9px] text-slate-400 font-bold uppercase tracking-wider ml-1 italic">* Pengisian logbook masa depan dinonaktifkan</p>
                        </div>

                        <!-- DESKRIPSI KEGIATAN -->
                        <div class="space-y-1.5 sm:space-y-2">
                            <label for="description" class="text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Uraian Pekerjaan</label>
                            <textarea 
                                id="description"
                                name="uraian"
                                placeholder="Contoh: Maintenance jaringan di Gedung Elektro lantai 2..." 
                                rows="6" 
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-xs sm:text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:ring-2 focus:ring-maroon-500 focus:bg-white transition-all outline-none resize-none"
                                required
                            ></textarea>
                        </div>

                        <!-- SUBMIT BUTTON -->
                        <button type="submit" class="w-full bg-maroon-950 text-white py-4 sm:py-5 rounded-xl sm:rounded-2xl font-black text-xs sm:text-sm uppercase tracking-[0.2em] shadow-xl shadow-maroon-950/20 active:scale-95 transition-all flex items-center justify-center gap-2 sm:gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
                            Simpan Logbook
                        </button>
                    </form>
                @endif
            </div>

            <!-- INFO CARD -->
            <div class="bg-gold-light border border-gold/30 rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-6 flex items-start gap-4 sm:gap-5">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gold rounded-xl sm:rounded-2xl shrink-0 flex items-center justify-center text-white shadow-lg shadow-gold/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-extrabold text-gold-dark uppercase tracking-wider leading-none mb-1">Petunjuk Logbook</h4>
                    <p class="text-[10px] sm:text-[11px] text-gold-dark/80 mt-1 leading-relaxed font-semibold italic">
                        Pengisian diperbolehkan untuk hari ini dan hari-hari sebelumnya. Anda tidak diperkenankan melakukan pengisian mendahului tanggal hari ini.
                    </p>
                </div>
            </div>
        </div>

        <!-- BAGIAN RIWAYAT (COL 7) -->
        <div class="lg:col-span-7 space-y-4 sm:space-y-6 animate-in" style="animation-delay: 0.2s">
            
            <!-- HEADER & FILTER -->
            <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-3 sm:gap-4">
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight leading-none">Riwayat Jurnal</h2>
                    <p class="text-[10px] sm:text-xs text-slate-400 font-bold uppercase tracking-widest mt-1 sm:mt-2">Daftar Aktivitas & Status Validasi</p>
                </div>
                
                <!-- FILTER BAR (Diubah menjadi div agar menghindari reload halaman) -->
                <div class="flex flex-wrap items-center gap-2 mt-2 xl:mt-0">
                    <!-- Dropdown Status -->
                    <div class="relative w-[48%] sm:w-auto flex-1 sm:flex-none">
                        <select id="filterStatus" onchange="applyFilter()" class="w-full appearance-none bg-white border border-maroon-100 rounded-xl px-3 py-2.5 pr-8 text-[9px] sm:text-[10px] font-bold text-maroon-950 shadow-sm focus:outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer transition-all">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="diterima">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                        <div class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 pointer-events-none text-maroon-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>

                    <!-- Dropdown Bulan -->
                    <div class="relative w-[48%] sm:w-auto flex-1 sm:flex-none">
                        <select id="filterBulan" onchange="applyFilter()" class="w-full appearance-none bg-white border border-maroon-100 rounded-xl px-3 py-2.5 pr-8 text-[9px] sm:text-[10px] font-bold text-maroon-950 shadow-sm focus:outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer transition-all">
                            <option value="all">Bulan</option>
                            @php
                                $months = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ];
                            @endphp
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 pointer-events-none text-maroon-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>

                    <!-- Dropdown Tahun -->
                    <div class="relative flex-1 sm:w-auto sm:flex-none hidden sm:block">
                        <select id="filterTahun" onchange="applyFilter()" class="w-full appearance-none bg-white border border-maroon-100 rounded-xl px-3 py-2.5 pr-8 text-[9px] sm:text-[10px] font-bold text-maroon-950 shadow-sm focus:outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer transition-all">
                            <option value="all">Tahun</option>
                            @php $currentYear = date('Y'); @endphp
                            @for($y = $currentYear; $y >= $currentYear - 2; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-maroon-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>

                    <!-- Tombol Cari -->
                    <button type="button" onclick="applyFilter()" class="w-full sm:w-auto bg-maroon-950 text-white p-2.5 rounded-xl shadow-md hover:bg-maroon-800 active:scale-95 transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="hidden sm:block"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <span class="text-[10px] font-black uppercase tracking-widest sm:hidden">Terapkan Filter</span>
                    </button>
                </div>
            </div>

            <!-- LOG LIST WITH DYNAMIC STATUS -->
            <div id="logbook-container" class="space-y-4 sm:space-y-6 max-h-[700px] overflow-y-auto no-scrollbar pr-1 custom-scrollbar">
                
                @forelse($riwayatLog as $log)
                    @php
                        // Persiapan data untuk JS Filter (Menggunakan tanggal atau created_at sebagai default fallback)
                        $logDate = \Carbon\Carbon::parse($log->report_date ?? $log->tanggal ?? $log->created_at);
                        $logMonth = $logDate->format('n');
                        $logYear = $logDate->format('Y');
                    @endphp

                    <!-- CARD LOGBOOK DENGAN DATA ATRIBUT -->
                    <div class="log-card group bg-white p-5 sm:p-6 rounded-3xl sm:rounded-[2.5rem] border border-maroon-50 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden"
                         data-status="{{ strtolower($log->status ?? 'pending') }}" 
                         data-bulan="{{ $logMonth }}" 
                         data-tahun="{{ $logYear }}">

                        <!-- Side Border Indicator -->
                        @if(strtolower($log->status) == 'diterima')
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 sm:w-2 bg-emerald-500"></div>
                        @elseif(strtolower($log->status) == 'ditolak')
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 sm:w-2 bg-rose-500"></div>
                        @else
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 sm:w-2 bg-amber-400"></div>
                        @endif

                        <div class="flex items-start justify-between mb-3 sm:mb-4 pl-1 sm:pl-2">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 {{ strtolower($log->status) == 'diterima' ? 'bg-emerald-500' : (strtolower($log->status) == 'ditolak' ? 'bg-rose-500' : 'bg-amber-500') }} text-white rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                                    @if(strtolower($log->status) == 'diterima')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-[22px] sm:h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                    @elseif(strtolower($log->status) == 'ditolak')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-[22px] sm:h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-[22px] sm:h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-extrabold text-slate-800 tracking-tight">
                                        {{ $logDate->translatedFormat('l, d F Y') }}
                                    </h4>
                                    <div class="flex items-center gap-1.5 sm:gap-2 mt-0.5 sm:mt-1">
                                        <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-widest {{ strtolower($log->status) == 'diterima' ? 'text-emerald-600' : (strtolower($log->status) == 'ditolak' ? 'text-rose-600' : 'text-amber-600') }}">
                                            {{ strtolower($log->status) == 'pending' ? 'Menunggu Validasi' : $log->status }}
                                        </span>
                                        <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                        <span class="text-[8px] sm:text-[9px] font-bold text-slate-400">{{ $logDate->format('H:i') }} WITA</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl sm:rounded-2xl p-4 sm:p-5 border border-slate-100 ml-1 sm:ml-2">
                            <p class="text-[11px] sm:text-xs font-medium text-slate-600 leading-relaxed italic">
                                "{{ $log->description ?? $log->uraian }}"
                            </p>
                        </div>

                        @if($log->catatan_pembimbing)
                        <div class="mt-3 sm:mt-4 ml-1 sm:ml-2 pl-3 sm:pl-4 border-l-2 border-gold/50">
                            <p class="text-[9px] sm:text-[10px] font-black text-gold-dark uppercase tracking-widest mb-0.5 sm:mb-1">Catatan Pembimbing:</p>
                            <p class="text-[11px] sm:text-xs font-medium text-slate-500">"{{ $log->catatan_pembimbing }}"</p>
                        </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white p-8 sm:p-10 rounded-3xl sm:rounded-[2.5rem] border border-maroon-50 shadow-sm text-center">
                        <p class="text-xs sm:text-sm font-bold text-slate-400 uppercase tracking-widest">Belum ada catatan aktivitas jurnal.</p>
                    </div>
                @endforelse

                <!-- EMPTY STATE JS (Tampil saat filter tidak ada hasil) -->
                <div id="js-empty-state" style="display: none;" class="bg-white p-8 sm:p-10 rounded-3xl sm:rounded-[2.5rem] border border-dashed border-maroon-100 shadow-sm text-center flex-col items-center justify-center">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-maroon-50 rounded-full flex items-center justify-center text-maroon-300 mx-auto mb-3 sm:mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <p class="text-sm sm:text-base font-black text-maroon-900 tracking-tight">Tidak Ditemukan</p>
                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Data dengan filter tersebut tidak ada.</p>
                </div>

            </div>
        </div>
    </div>
</main>

<script>
    // SCRIPT VALIDASI KALENDER
    document.addEventListener("DOMContentLoaded", function() {
        const dateInput = document.getElementById("log_date");
        if(dateInput) {
            // Ambil tanggal hari ini dalam format YYYY-MM-DD
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const localToday = `${year}-${month}-${day}`;
            
            // Set max date pada input kalender
            dateInput.max = localToday;
            
            dateInput.addEventListener("change", function() {
                if(this.value > localToday) {
                    alert("Maaf, Anda tidak dapat mengisi logbook untuk tanggal masa depan!");
                    this.value = localToday;
                }
            });
        }
    });

    // SCRIPT FILTER CLIENT-SIDE
    function applyFilter() {
        const statusVal = document.getElementById('filterStatus').value.toLowerCase();
        const bulanVal = document.getElementById('filterBulan').value;
        const tahunVal = document.getElementById('filterTahun').value;
        
        const cards = document.querySelectorAll('.log-card');
        const emptyState = document.getElementById('js-empty-state');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const cardStatus = (card.getAttribute('data-status') || '').toLowerCase();
            const cardBulan = card.getAttribute('data-bulan') || '';
            const cardTahun = card.getAttribute('data-tahun') || '';
            
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
        
        // Menampilkan UI kosong jika tidak ada yang cocok
        if(visibleCount === 0 && cards.length > 0) {
            emptyState.style.display = 'flex';
        } else {
            emptyState.style.display = 'none';
        }
    }
</script>
@endsection