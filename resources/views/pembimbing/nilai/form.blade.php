@extends('layouts.pembimbing')
@section('page_title', 'Form Penilaian Siswa')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 space-y-6 sm:space-y-8 animate-in">

    <!-- Wadah putih pembungkus form -->
    <div class="bg-white/80 backdrop-blur-md rounded-3xl sm:rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

        <form action="{{ $siswa->penilaian ? route('pembimbing.nilai.update', $siswa->id_siswa) : route('pembimbing.nilai.store') }}" method="POST" class="p-6 sm:p-8 lg:p-10 space-y-8 sm:space-y-10">
            @csrf
            @if($siswa->penilaian)
                @method('PUT')
            @endif

            <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}">

            <!-- ALERT GLOBAL JIKA ADA ERROR VALIDASI -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-bold shadow-sm flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>Gagal menyimpan! Periksa kembali nilai yang Anda masukkan (Maksimal 10):</span>
                    </div>
                    <ul class="list-disc pl-7 font-medium text-[11px] sm:text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- BAGIAN INFORMASI ATAS (ALPA, RATA-RATA & ACUAN SKALA) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5">

                <!-- KOLOM KIRI -->
                <div class="col-span-1 flex flex-col gap-3 justify-between">
                    <div class="bg-rose-50/50 py-3.5 px-4 rounded-2xl border border-rose-100 flex flex-col justify-center items-center text-center shadow-sm flex-1">
                        <p class="text-[9px] sm:text-[10px] font-black text-rose-500 uppercase tracking-widest">Ketidakhadiran (Alpa)</p>
                        <p class="text-3xl font-black text-rose-600 mt-1">{{ $alpa }} <span class="text-xs font-bold">Hari</span></p>
                    </div>

                    <div id="box-rata-rata" class="bg-slate-50/50 py-3.5 px-4 rounded-2xl border border-slate-200 flex flex-col justify-center items-center text-center shadow-sm transition-colors duration-300 flex-1">
                        <p id="label-rata-rata" class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest">Rata-Rata Nilai Akhir</p>
                        <p id="nilai-rata-rata" class="text-3xl font-black text-slate-400 mt-1">0,00</p>
                        <span id="predikat-rata-rata" class="text-[9px] font-bold px-3 py-1 rounded-md mt-1.5 bg-slate-200 text-slate-600 uppercase tracking-widest">Menunggu Input</span>
                    </div>
                </div>

                <!-- KOLOM KANAN: Acuan Skala Penilaian -->
                <div class="col-span-1 lg:col-span-2 bg-slate-50/30 p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                        Acuan Skala Penilaian
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 h-full">
                        <div class="flex justify-between items-center bg-white px-3.5 py-3 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-[11px] sm:text-xs font-black text-slate-700">8,50 - 10,0</span>
                            <span class="text-[9px] sm:text-[10px] font-black text-emerald-700 bg-emerald-100 px-2 py-1.5 rounded-md">A (Istimewa)</span>
                        </div>
                        <div class="flex justify-between items-center bg-white px-3.5 py-3 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-[11px] sm:text-xs font-black text-slate-700">7,50 - 8,49</span>
                            <span class="text-[9px] sm:text-[10px] font-black text-blue-700 bg-blue-100 px-2 py-1.5 rounded-md">B (Baik Sekali)</span>
                        </div>
                        <div class="flex justify-between items-center bg-white px-3.5 py-3 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-[11px] sm:text-xs font-black text-slate-700">6,00 - 7,49</span>
                            <span class="text-[9px] sm:text-[10px] font-black text-amber-700 bg-amber-100 px-2 py-1.5 rounded-md">C (Baik)</span>
                        </div>
                        <div class="flex justify-between items-center bg-white px-3.5 py-3 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-[11px] sm:text-xs font-black text-slate-700">0,0 - 5,99</span>
                            <span class="text-[9px] sm:text-[10px] font-black text-rose-700 bg-rose-100 px-2 py-1.5 rounded-md">D (Belum Lulus)</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- BAGIAN 1: SIKAP DAN PERILAKU -->
            <div class="space-y-4 sm:space-y-5">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-3 mt-4">
                    <div class="w-7 h-7 bg-maroon-50 text-maroon-800 rounded-lg flex items-center justify-center font-black text-xs">1</div>
                    <h3 class="text-sm sm:text-base font-black text-maroon-950 uppercase tracking-tight">Sikap dan Perilaku</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5">
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kecakapan Kerja</label>
                        <input type="text" name="kecakapan_kerja" maxlength="5" value="{{ old('kecakapan_kerja', isset($siswa->penilaian->kecakapan_kerja) ? str_replace('.', ',', $siswa->penilaian->kecakapan_kerja) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('kecakapan_kerja') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('kecakapan_kerja')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Menerima Perintah</label>
                        <input type="text" name="menerima_perintah" maxlength="5" value="{{ old('menerima_perintah', isset($siswa->penilaian->menerima_perintah) ? str_replace('.', ',', $siswa->penilaian->menerima_perintah) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('menerima_perintah') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('menerima_perintah')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sikap & Perilaku</label>
                        <input type="text" name="sikap_perilaku" maxlength="5" value="{{ old('sikap_perilaku', isset($siswa->penilaian->sikap_perilaku) ? str_replace('.', ',', $siswa->penilaian->sikap_perilaku) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('sikap_perilaku') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('sikap_perilaku')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Inisiatif & Ide</label>
                        <input type="text" name="inisiatif_kreatifitas" maxlength="5" value="{{ old('inisiatif_kreatifitas', isset($siswa->penilaian->inisiatif_kreatifitas) ? str_replace('.', ',', $siswa->penilaian->inisiatif_kreatifitas) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('inisiatif_kreatifitas') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('inisiatif_kreatifitas')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kedisiplinan</label>
                        <input type="text" name="disiplin_kehadiran" maxlength="5" value="{{ old('disiplin_kehadiran', isset($siswa->penilaian->disiplin_kehadiran) ? str_replace('.', ',', $siswa->penilaian->disiplin_kehadiran) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('disiplin_kehadiran') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('disiplin_kehadiran')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggung Jawab</label>
                        <input type="text" name="tanggung_jawab" maxlength="5" value="{{ old('tanggung_jawab', isset($siswa->penilaian->tanggung_jawab) ? str_replace('.', ',', $siswa->penilaian->tanggung_jawab) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('tanggung_jawab') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('tanggung_jawab')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: KETERAMPILAN TEKNIS -->
            <div class="space-y-4 sm:space-y-5">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                    <div class="w-7 h-7 bg-maroon-50 text-maroon-800 rounded-lg flex items-center justify-center font-black text-xs">2</div>
                    <h3 class="text-sm sm:text-base font-black text-maroon-950 uppercase tracking-tight">Keterampilan Teknis</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-5">
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 line-clamp-1">Pemahaman Teknis</label>
                        <input type="text" name="pemahaman_teknis" maxlength="5" value="{{ old('pemahaman_teknis', isset($siswa->penilaian->pemahaman_teknis) ? str_replace('.', ',', $siswa->penilaian->pemahaman_teknis) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('pemahaman_teknis') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('pemahaman_teknis')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 line-clamp-1">Persiapan Kerja</label>
                        <input type="text" name="persiapan_kerja" maxlength="5" value="{{ old('persiapan_kerja', isset($siswa->penilaian->persiapan_kerja) ? str_replace('.', ',', $siswa->penilaian->persiapan_kerja) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('persiapan_kerja') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('persiapan_kerja')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 line-clamp-1">Kerjasama Team</label>
                        <input type="text" name="kerjasama_team" maxlength="5" value="{{ old('kerjasama_team', isset($siswa->penilaian->kerjasama_team) ? str_replace('.', ',', $siswa->penilaian->kerjasama_team) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('kerjasama_team') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('kerjasama_team')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 line-clamp-1">Mutu Hasil Kerja</label>
                        <input type="text" name="mutu_hasil_kerja" maxlength="5" value="{{ old('mutu_hasil_kerja', isset($siswa->penilaian->mutu_hasil_kerja) ? str_replace('.', ',', $siswa->penilaian->mutu_hasil_kerja) : '') }}" required class="input-nilai numeric-input w-full bg-slate-50 border {{ $errors->has('mutu_hasil_kerja') ? 'border-red-400 focus:ring-red-500' : 'border-slate-200 focus:ring-maroon-500' }} rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 transition-all shadow-inner" placeholder="0,0">
                        @error('mutu_hasil_kerja')
                            <p class="text-red-500 text-[9px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- TOMBOL SIMPAN -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-maroon-950 text-white py-3 sm:py-3.5 rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-black uppercase tracking-widest hover:bg-maroon-900 transition-all shadow-lg active:scale-[0.99] flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    {{ $siswa->penilaian ? 'Simpan Perubahan Nilai' : 'Simpan Penilaian Final' }}
                </button>
            </div>
        </form>

    </div>
</main>

<!-- JAVASCRIPT UNTUK FORMAT ANGKA & HITUNG RATA-RATA REAL-TIME -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // 1. SCRIPT OTOMATIS KOMA SUPER PINTAR
        document.querySelectorAll('.numeric-input').forEach(input => {
            input.addEventListener('input', function(e) {
                let val = this.value.replace(/[^0-9]/g, '');

                if (val === '') {
                    this.value = '';
                } else if (val.startsWith('10')) {
                    if (val.length <= 2) {
                        this.value = val;
                    } else {
                        this.value = '10,' + val.substring(2, 4);
                    }
                } else {
                    let angkaDepan = val.substring(0, 1);
                    let angkaBelakang = val.substring(1, 3);

                    if (val.length === 1) {
                        this.value = angkaDepan;
                    } else {
                        this.value = angkaDepan + ',' + angkaBelakang;
                    }
                }

                updateRataRata();
            });
        });

        // 2. SCRIPT HITUNG RATA-RATA REAL-TIME
        const inputFields = document.querySelectorAll('.input-nilai');
        const textNilai = document.getElementById('nilai-rata-rata');
        const textPredikat = document.getElementById('predikat-rata-rata');
        const boxContainer = document.getElementById('box-rata-rata');
        const labelText = document.getElementById('label-rata-rata');

        function updateRataRata() {
            let total = 0;
            let countFilled = 0;

            inputFields.forEach(input => {
                let val = input.value.replace(',', '.');
                let num = parseFloat(val);

                if (!isNaN(num)) {
                    total += num;
                    countFilled++;
                }
            });

            if (countFilled === 10) {
                let rataRata = total / 10;
                textNilai.textContent = rataRata.toFixed(2).replace('.', ',');

                if (rataRata >= 8.5) {
                    textPredikat.textContent = 'A (Istimewa)';
                    setTheme('emerald');
                } else if (rataRata >= 7.5) {
                    textPredikat.textContent = 'B (Baik Sekali)';
                    setTheme('blue');
                } else if (rataRata >= 6.0) {
                    textPredikat.textContent = 'C (Baik)';
                    setTheme('amber');
                } else {
                    textPredikat.textContent = 'D (Belum Lulus)';
                    setTheme('rose');
                }
            } else {
                textNilai.textContent = '-';
                textPredikat.textContent = 'Belum Lengkap (' + countFilled + '/10)';
                setTheme('slate');
            }
        }

        function setTheme(color) {
            boxContainer.className = `bg-${color}-50/50 py-3.5 px-4 rounded-2xl border border-${color}-200 flex flex-col justify-center items-center text-center shadow-sm transition-colors duration-300 flex-1`;
            textNilai.className = `text-3xl font-black text-${color}-700 mt-1`;
            textPredikat.className = `text-[9px] font-bold px-3 py-1 rounded-md mt-1.5 uppercase tracking-widest bg-${color}-200 text-${color}-800`;
            labelText.className = `text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-${color}-600`;
        }

        updateRataRata();
    });
</script>
@endsection
