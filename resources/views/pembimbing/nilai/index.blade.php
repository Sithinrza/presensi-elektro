@extends('layouts.pembimbing')

@section('content')
<style>
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: slideUp 0.5s ease-out forwards;
    }
    .input-number {
        @apply w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold text-maroon-900 focus:ring-2 focus:ring-maroon-500 outline-none transition-all;
    }
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
    }
</style>

<main class="no-print max-w-6xl mx-auto p-5 lg:p-10 space-y-8 animate-in">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-2xl text-sm font-bold shadow-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl text-sm font-bold shadow-sm flex items-center justify-between">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-4 lg:hidden">
        <h1 class="text-xl font-extrabold text-maroon-950 tracking-tight leading-none uppercase">Penilaian & Sertifikat</h1>
        <div class="px-2 py-1 bg-gold text-maroon-950 rounded-full shadow-lg shadow-gold/20">
            <span class="text-[10px] font-black uppercase tracking-widest">Input Nilai</span>
        </div>
    </div>

    <div id="selection-view" class="space-y-6">
        <div class="flex items-center gap-3 px-2">
            <div class="w-1 h-6 bg-maroon-900 rounded-full"></div>
            <h3 class="text-xl font-black text-maroon-950 tracking-tight italic">Siswa Siap Dinilai</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($daftarSiswa as $siswa)
                <div class="bg-white rounded-[2.5rem] p-6 border border-maroon-50 shadow-sm hover:shadow-xl transition-all group flex flex-col md:flex-row items-center gap-6">
                    <div class="w-20 h-20 rounded-3xl bg-slate-100 overflow-hidden border-2 border-white shadow-inner">
                        @if($siswa->foto_profil)
                            <img src="/uploads/profil/{{ $siswa->foto_profil }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 text-center md:text-left overflow-hidden">
                        <h4 class="text-lg font-black text-maroon-950 leading-none truncate tracking-tight">{{ $siswa->nama_lengkap }}</h4>
                        <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest">{{ $siswa->sekolah_asal ?? 'Sekolah Tidak Diketahui' }}</p>

                        @if(\Carbon\Carbon::parse($siswa->tanggal_selesai)->isPast())
                            <div class="mt-3 inline-flex items-center px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Masa Magang Selesai</div>
                        @else
                            <div class="mt-3 inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter">Masih Magang</div>
                        @endif
                    </div>

                    <button onclick="showGradingForm(
                        '{{ addslashes($siswa->nama_lengkap) }}',
                        '{{ addslashes($siswa->sekolah_asal) }}',
                        '{{ $siswa->nis }}',
                        '{{ $siswa->id_siswa }}',
                        '{{ $siswa->foto_profil }}',
                        '{{ $siswa->presensi ? $siswa->presensi->where('id_status_presensi', 7)->count() : 0 }}',
                        '{{ $siswa->presensi ? $siswa->presensi->where('id_status_presensi', 8)->count() : 0 }}',
                        '{{ $siswa->presensi ? $siswa->presensi->where('id_status_presensi', 3)->count() : 0 }}'
                    )" class="bg-maroon-950 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-maroon-800 transition-all active:scale-95">
                        Input Nilai
                    </button>
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-sm font-bold text-slate-400">Belum ada siswa bimbingan yang terdaftar.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div id="grading-form" class="hidden space-y-8">
        <button onclick="hideGradingForm()" class="flex items-center gap-2 text-xs font-black text-maroon-950 uppercase tracking-widest hover:text-maroon-600 transition-colors group">
            <div class="w-10 h-10 rounded-xl bg-white border border-maroon-100 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </div>
            Kembali
        </button>

        <section class="bg-white rounded-[3rem] border border-maroon-100 shadow-premium overflow-hidden">
            <div class="bg-maroon-950 p-8 text-white flex flex-col md:flex-row items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-white/10 p-1">
                    <img id="student-avatar" src="https://ui-avatars.com/api/?name=Siswa" class="w-full h-full object-cover rounded-xl">
                </div>
                <div class="text-center md:text-left">
                    <h2 id="student-name" class="text-3xl font-black italic tracking-tight leading-none">Nama Siswa</h2>
                    <p id="student-info" class="text-maroon-200 text-xs font-bold uppercase mt-2 tracking-widest italic opacity-70">Sekolah • NIS: -</p>
                </div>
                <div class="ml-auto bg-white/10 px-6 py-3 rounded-2xl border border-white/10 text-center">
                    <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest leading-none mb-1">Rata-rata Nilai</p>
                    <p id="avg-display" class="text-3xl font-black text-gold leading-none">0.00</p>
                </div>
            </div>

            <form id="assessmentForm" method="POST" action="{{ route('pembimbing.nilai.store') }}" target="_blank" class="p-8 space-y-10">
                @csrf
                <input type="hidden" name="id_siswa" id="form-id-siswa" value="">

                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-maroon-50 pb-4">
                        <div class="w-10 h-10 bg-maroon-50 text-maroon-950 rounded-xl flex items-center justify-center font-black">1</div>
                        <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Aspek Sikap dan Perilaku</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kecakapan Kerja</label>
                            <input type="number" name="kecakapan_kerja" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Menerima Perintah</label>
                            <input type="number" name="menerima_perintah" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sikap / Perilaku</label>
                            <input type="number" name="sikap_perilaku" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Inisiatif & Kreatifitas</label>
                            <input type="number" name="inisiatif_kreatifitas" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Disiplin & Kehadiran</label>
                            <input type="number" name="disiplin_kehadiran" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggung Jawab</label>
                            <input type="number" name="tanggung_jawab" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-maroon-50 pb-4">
                        <div class="w-10 h-10 bg-maroon-50 text-maroon-950 rounded-xl flex items-center justify-center font-black">2</div>
                        <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Aspek Keterampilan</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 leading-none">Pemahaman Teknis</label>
                            <input type="number" name="pemahaman_teknis" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 leading-none">Persiapan Kerja</label>
                            <input type="number" name="persiapan_kerja" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 leading-none">Kerjasama Team</label>
                            <input type="number" name="kerjasama_team" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 leading-none">Mutu Hasil Kerja</label>
                            <input type="number" name="mutu_hasil_kerja" step="0.1" min="0" max="10" placeholder="0.0" class="grade-input input-number" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-maroon-50 pb-4">
                        <div class="w-10 h-10 bg-maroon-50 text-maroon-950 rounded-xl flex items-center justify-center font-black">3</div>
                        <h3 class="text-lg font-black text-maroon-950 tracking-tight uppercase italic">Data Absensi Akhir</h3>
                    </div>
                    <div class="grid grid-cols-3 gap-6 bg-slate-50 p-6 rounded-[2rem] border border-slate-100">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block text-center">Sakit</label>
                            <input type="number" id="absensi-sakit" readonly class="w-full bg-white border-none rounded-xl py-3 text-center font-black text-maroon-950">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block text-center">Izin</label>
                            <input type="number" id="absensi-izin" readonly class="w-full bg-white border-none rounded-xl py-3 text-center font-black text-maroon-950">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block text-center">Alpa</label>
                            <input type="number" id="absensi-alpa" readonly class="w-full bg-white border-none rounded-xl py-3 text-center font-black text-rose-600">
                        </div>
                    </div>
                </div>

                <div class="pt-8 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-maroon-950 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl shadow-maroon-950/20 hover:bg-maroon-900 active:scale-95 transition-all flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Nilai & Rilis Sertifikat
                    </button>
                </div>
            </form>
        </section>
    </div>
</main>

<script>
    // JS disesuaikan untuk menerima data sakit, izin, alpa secara dinamis
    function showGradingForm(name, school, nis, id_siswa, foto_profil, sakit, izin, alpa) {
        document.getElementById('selection-view').classList.add('hidden');
        document.getElementById('grading-form').classList.remove('hidden');

        document.getElementById('student-name').textContent = name;
        document.getElementById('student-info').textContent = `${school} • NIS: ${nis}`;
        document.getElementById('form-id-siswa').value = id_siswa;

        // Set Data Absensi Akhir secara otomatis ke input readonly
        document.getElementById('absensi-sakit').value = sakit;
        document.getElementById('absensi-izin').value = izin;
        document.getElementById('absensi-alpa').value = alpa;

        let avatarSrc = foto_profil ? `/uploads/profil/${foto_profil}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=bc5a75&color=fff`;
        document.getElementById('student-avatar').src = avatarSrc;

        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function hideGradingForm() {
        document.getElementById('selection-view').classList.remove('hidden');
        document.getElementById('grading-form').classList.add('hidden');
        document.getElementById('assessmentForm').reset();
        document.getElementById('avg-display').textContent = "0.00";
    }

    // Auto-calculate Average
    const inputs = document.querySelectorAll('.grade-input');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            let total = 0;
            let count = 0;
            inputs.forEach(i => {
                if(i.value) {
                    total += parseFloat(i.value);
                    count++;
                }
            });
            const avg = count > 0 ? (total / 10).toFixed(2) : "0.00";
            document.getElementById('avg-display').textContent = avg;
        });
    });
</script>
@endsection
