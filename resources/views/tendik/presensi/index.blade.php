@extends('layouts.tendik')

@section('content')
<!-- CSS KHUSUS HALAMAN PRESENSI KAMERA -->
<style>
    .camera-container {
        position: relative;
        overflow: hidden;
        aspect-ratio: 3/4;
        background: #000;
        border-radius: 2rem;
    }

    /* Face Guide Overlay */
    .face-guide {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70%;
        height: 65%;
        border: 3px solid rgba(216, 185, 139, 0.5);
        border-radius: 50% / 50%;
        box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.6);
        pointer-events: none;
        z-index: 10;
    }

    .face-guide.active {
        border-color: #34d399; /* emerald-400 */
        box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.4);
    }

    .scanning-line {
        position: absolute;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, transparent, #d8b98b, transparent);
        box-shadow: 0 0 15px #d8b98b;
        top: 0;
        z-index: 11;
        animation: scan 3s linear infinite;
    }

    @keyframes scan {
        0% { top: 20%; }
        50% { top: 80%; }
        100% { top: 20%; }
    }

    .glass-dark {
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
    }
</style>

<!-- KONTEN UTAMA PRESENSI -->
<main class="max-w-md mx-auto p-5 space-y-6 animate-in">

    <!-- Judul Halaman (Opsional karena sudah ada Topbar, tapi bagus untuk navigasi mobile) -->
    <div class="flex items-center gap-4 mb-4 lg:hidden">
        <a href="{{ url('/siswa/dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-maroon-50 text-maroon-900 active:scale-90 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <h1 class="text-lg font-extrabold text-maroon-950 tracking-tight">Presensi Masuk</h1>
    </div>

    <!-- CAMERA SECTION -->
    <section class="space-y-4">
        <div class="camera-container shadow-2xl border border-white/20">
            <!-- Mock Video Feed -->
            <div class="absolute inset-0 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-white/10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <p class="absolute bottom-10 text-white/30 text-[10px] font-bold uppercase tracking-widest">Initializing Camera...</p>
            </div>

            <!-- Overlay Elements -->
            <div id="guide" class="face-guide"></div>
            <div id="scanLine" class="scanning-line hidden"></div>

            <!-- Floating Badge -->
            <div class="absolute top-6 left-6 z-20">
                <div class="glass-dark px-3 py-1.5 rounded-xl border border-white/10 flex items-center gap-2">
                    <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
                    <span class="text-white text-[10px] font-black uppercase tracking-widest">Live Detection</span>
                </div>
            </div>

            <!-- Instruction Overlay -->
            <div class="absolute bottom-8 left-0 right-0 z-20 flex justify-center px-6">
                <div id="instructionBox" class="glass-dark w-full p-4 rounded-3xl border border-white/20 text-center shadow-2xl">
                    <p id="instructionText" class="text-white font-bold text-sm tracking-wide transition-all duration-300">Posisikan wajah di dalam area panduan</p>
                    <div id="progressContainer" class="mt-3 w-full h-1.5 bg-white/10 rounded-full overflow-hidden hidden">
                        <div id="progressBar" class="h-full bg-gold transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <button id="startBtn" onclick="startDetection()" class="w-full bg-maroon-900 text-white py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-xl shadow-maroon-900/20 active:scale-95 transition-all flex items-center justify-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/><circle cx="12" cy="12" r="3"/></svg>
            Mulai Verifikasi
        </button>
    </section>

    <!-- LOCATION STATUS SECTION -->
    <section class="bg-white rounded-[2.5rem] p-6 border border-maroon-100 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-maroon-50 text-maroon-700 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-maroon-950">Validasi Lokasi</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">GPS Status</p>
                </div>
            </div>
            <div id="locationBadge" class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-xl text-[10px] font-black border border-emerald-100 uppercase tracking-widest">
                Valid
            </div>
        </div>

        <!-- Mock Coordinate / Address -->
        <div class="bg-maroon-50 rounded-2xl p-4 space-y-2">
            <p class="text-[10px] font-bold text-maroon-400 uppercase tracking-widest">Lokasi Terdeteksi</p>
            <p class="text-xs font-bold text-maroon-900 leading-relaxed">Jurusan Teknik Elektro, Politeknik Negeri Banjarmasin</p>
            <div class="flex items-center gap-2 mt-2">
                <span class="text-[9px] font-mono font-bold text-slate-400">-3.296541, 114.582641</span>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span class="text-[9px] font-bold text-emerald-600 uppercase">Akurasi: Tinggi (3m)</span>
            </div>
        </div>

        <!-- Map Mockup -->
        <div class="w-full h-32 bg-slate-100 rounded-3xl border border-maroon-100 overflow-hidden relative grayscale opacity-70">
            <!-- Simulated map background -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-8 h-8 bg-emerald-500/20 rounded-full flex items-center justify-center animate-ping"></div>
                <div class="absolute w-3 h-3 bg-emerald-500 rounded-full border-2 border-white shadow-lg"></div>
            </div>
            <p class="absolute top-2 right-2 text-[8px] font-bold bg-white/80 px-2 py-1 rounded text-slate-500">Google Maps Interface</p>
        </div>
    </section>

    <!-- INFO CARD -->
    <section class="bg-maroon-950 rounded-[2.5rem] p-6 text-white overflow-hidden relative mb-8">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gold/10 rounded-full blur-2xl"></div>
        <div class="flex gap-4 relative z-10">
            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-gold">Petunjuk Presensi</h4>
                <ul class="mt-2 space-y-1 text-[10px] text-white/70 leading-relaxed">
                    <li>• Pastikan wajah terlihat jelas tanpa masker.</li>
                    <li>• Ikuti instruksi gerakan yang muncul di layar.</li>
                    <li>• Jangan meninggalkan halaman sebelum proses selesai.</li>
                </ul>
            </div>
        </div>
    </section>
</main>

<!-- SCRIPT LOGIKA KAMERA -->
<script>
    let step = 0;
    const instructions = [
        "Posisikan wajah di dalam oval",
        "Silakan Berkedip 2 kali",
        "Silakan Menoleh ke Kanan",
        "Silakan Tersenyum",
        "Memproses Verifikasi..."
    ];

    function startDetection() {
        const startBtn = document.getElementById('startBtn');
        const guide = document.getElementById('guide');
        const scanLine = document.getElementById('scanLine');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const instructionText = document.getElementById('instructionText');

        startBtn.disabled = true;
        startBtn.innerHTML = "Memproses...";
        startBtn.classList.add('opacity-50');

        scanLine.classList.remove('hidden');
        progressContainer.classList.remove('hidden');
        guide.classList.add('active');

        let currentProgress = 0;
        const interval = setInterval(() => {
            currentProgress += 1;
            progressBar.style.width = currentProgress + '%';

            if (currentProgress === 20) {
                instructionText.textContent = instructions[1];
            } else if (currentProgress === 45) {
                instructionText.textContent = instructions[2];
            } else if (currentProgress === 70) {
                instructionText.textContent = instructions[3];
            } else if (currentProgress === 90) {
                instructionText.textContent = instructions[4];
                guide.classList.remove('active');
                scanLine.classList.add('hidden');
            } else if (currentProgress >= 100) {
                clearInterval(interval);
                alert("Presensi Berhasil Terkirim!");
                // Arahkan kembali ke Dashboard Siswa
                window.location.href = "{{ url('/siswa/dashboard') }}";
            }
        }, 50);
    }
</script>
@endsection
