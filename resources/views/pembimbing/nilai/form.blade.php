@extends('layouts.pembimbing')

@section('content')
<main class="max-w-6xl mx-auto p-5 lg:p-10 space-y-6">
    <a href="{{ route('pembimbing.nilai.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-maroon-950 uppercase tracking-widest hover:text-maroon-600 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m15 18-6-6 6-6"/></svg>
        Kembali ke Daftar
    </a>

    <section class="bg-white rounded-[3rem] border border-maroon-100 shadow-sm overflow-hidden">
        <div class="bg-maroon-950 p-8 text-white flex items-center gap-6">
            <h2 class="text-3xl font-black italic tracking-tight">Form Penilaian: {{ $siswa->nama_lengkap }}</h2>
        </div>

        <form action="{{ $siswa->penilaian ? route('pembimbing.nilai.update', $siswa->id_siswa) : route('pembimbing.nilai.store') }}" method="POST" class="p-8 space-y-10">
            @csrf
            @if($siswa->penilaian)
                @method('PUT')
            @endif

            <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}">

            <div class="space-y-6">
                <h3 class="text-lg font-black text-maroon-950 uppercase italic border-b border-maroon-50 pb-2">1. Sikap dan Perilaku</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Kecakapan Kerja</label>
                        <input type="text" name="kecakapan_kerja" value="{{ isset($siswa->penilaian->kecakapan_kerja) ? number_format($siswa->penilaian->kecakapan_kerja, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Menerima Perintah</label>
                        <input type="text" name="menerima_perintah" value="{{ isset($siswa->penilaian->menerima_perintah) ? number_format($siswa->penilaian->menerima_perintah, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Sikap / Perilaku</label>
                        <input type="text" name="sikap_perilaku" value="{{ isset($siswa->penilaian->sikap_perilaku) ? number_format($siswa->penilaian->sikap_perilaku, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Inisiatif & Kreatifitas</label>
                        <input type="text" name="inisiatif_kreatifitas" value="{{ isset($siswa->penilaian->inisiatif_kreatifitas) ? number_format($siswa->penilaian->inisiatif_kreatifitas, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Disiplin & Kehadiran</label>
                        <input type="text" name="disiplin_kehadiran" value="{{ isset($siswa->penilaian->disiplin_kehadiran) ? number_format($siswa->penilaian->disiplin_kehadiran, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Tanggung Jawab</label>
                        <input type="text" name="tanggung_jawab" value="{{ isset($siswa->penilaian->tanggung_jawab) ? number_format($siswa->penilaian->tanggung_jawab, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-lg font-black text-maroon-950 uppercase italic border-b border-maroon-50 pb-2">2. Keterampilan</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Pemahaman Teknis</label>
                        <input type="text" name="pemahaman_teknis" value="{{ isset($siswa->penilaian->pemahaman_teknis) ? number_format($siswa->penilaian->pemahaman_teknis, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Persiapan Kerja</label>
                        <input type="text" name="persiapan_kerja" value="{{ isset($siswa->penilaian->persiapan_kerja) ? number_format($siswa->penilaian->persiapan_kerja, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Kerjasama Team</label>
                        <input type="text" name="kerjasama_team" value="{{ isset($siswa->penilaian->kerjasama_team) ? number_format($siswa->penilaian->kerjasama_team, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Mutu Hasil Kerja</label>
                        <input type="text" name="mutu_hasil_kerja" value="{{ isset($siswa->penilaian->mutu_hasil_kerja) ? number_format($siswa->penilaian->mutu_hasil_kerja, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500" placeholder="0,0">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">

                <div class="col-span-1 bg-rose-50 p-6 rounded-2xl border border-rose-100 flex flex-col justify-center items-center text-center shadow-inner">
                    <div class="bg-white p-4 rounded-full shadow-sm mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                    </div>
                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest">Ketidakhadiran (Alfa)</p>
                    <p class="text-4xl font-black text-rose-600 mt-1">{{ $alpa }} <span class="text-lg font-bold">Hari</span></p>
                </div>

                <div class="col-span-1 md:col-span-2 bg-slate-50 p-6 rounded-2xl border border-slate-200">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                        Acuan Skala Penilaian
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">
                        <div class="flex justify-between items-center bg-white px-4 py-2.5 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-xs font-black text-slate-600">8,50 - 10,0</span>
                            <span class="text-[10px] font-black text-emerald-700 bg-emerald-100 px-2 py-1 rounded-md">A (Lulus Istimewa)</span>
                        </div>
                        <div class="flex justify-between items-center bg-white px-4 py-2.5 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-xs font-black text-slate-600">7,50 - 8,49</span>
                            <span class="text-[10px] font-black text-blue-700 bg-blue-100 px-2 py-1 rounded-md">B (Lulus Baik Sekali)</span>
                        </div>
                        <div class="flex justify-between items-center bg-white px-4 py-2.5 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-xs font-black text-slate-600">6,00 - 7,49</span>
                            <span class="text-[10px] font-black text-amber-700 bg-amber-100 px-2 py-1 rounded-md">C (Lulus Baik)</span>
                        </div>
                        <div class="flex justify-between items-center bg-white px-4 py-2.5 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-xs font-black text-slate-600">0,0 - 5,99</span>
                            <span class="text-[10px] font-black text-rose-700 bg-rose-100 px-2 py-1 rounded-md">D (Belum Lulus)</span>
                        </div>
                    </div>
                </div>

            </div>

            <button type="submit" class="w-full bg-maroon-950 text-white py-4 rounded-xl font-black uppercase tracking-widest hover:bg-maroon-900 transition-all shadow-lg active:scale-[0.99]">
                {{ $siswa->penilaian ? 'Update Penilaian' : 'Simpan Penilaian' }}
            </button>
        </form>
    </section>
</main>

<script>
    // JS Untuk Otomatis Mengubah Angka (Ketik 95 jadi 9,5)
    document.querySelectorAll('.numeric-input').forEach(input => {
        input.addEventListener('input', function(e) {
            // Hilangkan semua karakter kecuali angka
            let val = this.value.replace(/[^0-9]/g, '');

            // Sisipkan koma jika angka lebih dari 1 digit
            if (val.length > 1) {
                this.value = val.slice(0, -1) + ',' + val.slice(-1);
            } else {
                this.value = val;
            }
        });
    });
</script>
@endsection
