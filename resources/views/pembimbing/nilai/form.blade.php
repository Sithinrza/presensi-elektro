@extends('layouts.pembimbing')
@section('page_title', 'Input Penilaian')

@section('content')
<main class="max-w-5xl mx-auto p-4 sm:p-5 lg:p-10 space-y-5 sm:space-y-6 animate-in">

    <a href="{{ route('pembimbing.nilai.index') }}" class="inline-flex items-center gap-2 px-4 py-2 sm:px-5 sm:py-2.5 bg-white border border-maroon-200 rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-black text-maroon-800 uppercase tracking-widest hover:bg-maroon-50 transition-colors shadow-sm active:scale-95">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><path d="m15 18-6-6 6-6"/></svg>
        Kembali
    </a>

    <section class="bg-white rounded-3xl sm:rounded-[3rem] border border-maroon-100 shadow-sm overflow-hidden">

        <div class="bg-maroon-900 p-6 sm:p-8 lg:p-10 relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-gold/20 rounded-full blur-[60px] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl p-1 shadow-md border border-gold shrink-0">
                    <div class="w-full h-full bg-slate-100 rounded-[0.8rem] flex items-center justify-center font-black text-2xl text-maroon-900 overflow-hidden">
                        @if($siswa->foto_profil)
                            <img src="{{ asset('storage/' . $siswa->foto_profil) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($siswa->nama_lengkap, 0, 1) }}
                        @endif
                    </div>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-white italic tracking-tight leading-none mb-1.5">{{ $siswa->nama_lengkap }}</h2>
                    <p class="text-[9px] sm:text-[10px] font-bold text-gold uppercase tracking-widest">{{ $siswa->sekolah_asal ?? 'Instansi Tidak Diisi' }}</p>
                </div>
            </div>
        </div>

        <form action="{{ $siswa->penilaian ? route('pembimbing.nilai.update', $siswa->id_siswa) : route('pembimbing.nilai.store') }}" method="POST" class="p-6 sm:p-8 lg:p-10 space-y-8 sm:space-y-10">
            @csrf
            @if($siswa->penilaian)
                @method('PUT')
            @endif

            <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}">

            <div class="space-y-5 sm:space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                    <div class="w-8 h-8 bg-maroon-50 text-maroon-800 rounded-lg flex items-center justify-center font-black text-sm">1</div>
                    <h3 class="text-sm sm:text-base font-black text-maroon-950 uppercase tracking-tight">Sikap dan Perilaku</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kecakapan Kerja</label>
                        <input type="text" name="kecakapan_kerja" value="{{ isset($siswa->penilaian->kecakapan_kerja) ? number_format($siswa->penilaian->kecakapan_kerja, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Menerima Perintah</label>
                        <input type="text" name="menerima_perintah" value="{{ isset($siswa->penilaian->menerima_perintah) ? number_format($siswa->penilaian->menerima_perintah, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sikap & Perilaku</label>
                        <input type="text" name="sikap_perilaku" value="{{ isset($siswa->penilaian->sikap_perilaku) ? number_format($siswa->penilaian->sikap_perilaku, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Inisiatif & Ide</label>
                        <input type="text" name="inisiatif_kreatifitas" value="{{ isset($siswa->penilaian->inisiatif_kreatifitas) ? number_format($siswa->penilaian->inisiatif_kreatifitas, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kedisiplinan</label>
                        <input type="text" name="disiplin_kehadiran" value="{{ isset($siswa->penilaian->disiplin_kehadiran) ? number_format($siswa->penilaian->disiplin_kehadiran, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggung Jawab</label>
                        <input type="text" name="tanggung_jawab" value="{{ isset($siswa->penilaian->tanggung_jawab) ? number_format($siswa->penilaian->tanggung_jawab, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                </div>
            </div>

            <div class="space-y-5 sm:space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                    <div class="w-8 h-8 bg-maroon-50 text-maroon-800 rounded-lg flex items-center justify-center font-black text-sm">2</div>
                    <h3 class="text-sm sm:text-base font-black text-maroon-950 uppercase tracking-tight">Keterampilan Teknis</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 line-clamp-1">Pemahaman Teknis</label>
                        <input type="text" name="pemahaman_teknis" value="{{ isset($siswa->penilaian->pemahaman_teknis) ? number_format($siswa->penilaian->pemahaman_teknis, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 line-clamp-1">Persiapan Kerja</label>
                        <input type="text" name="persiapan_kerja" value="{{ isset($siswa->penilaian->persiapan_kerja) ? number_format($siswa->penilaian->persiapan_kerja, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 line-clamp-1">Kerjasama Team</label>
                        <input type="text" name="kerjasama_team" value="{{ isset($siswa->penilaian->kerjasama_team) ? number_format($siswa->penilaian->kerjasama_team, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 line-clamp-1">Mutu Hasil Kerja</label>
                        <input type="text" name="mutu_hasil_kerja" value="{{ isset($siswa->penilaian->mutu_hasil_kerja) ? number_format($siswa->penilaian->mutu_hasil_kerja, 1, ',', '') : '' }}" required class="numeric-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-center text-sm font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-inner" placeholder="0,0">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6 items-stretch pt-4 border-t border-slate-50">

                <div class="col-span-1 bg-rose-50/50 p-5 sm:p-6 rounded-2xl border border-rose-100 flex flex-col justify-center items-center text-center shadow-inner">
                    <div class="bg-white p-3 sm:p-4 rounded-full shadow-sm mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                    </div>
                    <p class="text-[9px] sm:text-[10px] font-black text-rose-400 uppercase tracking-widest">Ketidakhadiran (Alpa)</p>
                    <p class="text-3xl sm:text-4xl font-black text-rose-600 mt-1">{{ $alpa }} <span class="text-sm sm:text-lg font-bold">Hari</span></p>
                </div>

                <div class="col-span-1 md:col-span-2 bg-slate-50 p-5 sm:p-6 rounded-2xl border border-slate-200">
                    <p class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 sm:mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                        Acuan Skala Penilaian
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2.5 sm:gap-x-6 sm:gap-y-3">
                        <div class="flex justify-between items-center bg-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-[11px] sm:text-xs font-black text-slate-600">8,50 - 10,0</span>
                            <span class="text-[8px] sm:text-[10px] font-black text-emerald-700 bg-emerald-100 px-2 py-1 rounded-md">A (Istimewa)</span>
                        </div>
                        <div class="flex justify-between items-center bg-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-[11px] sm:text-xs font-black text-slate-600">7,50 - 8,49</span>
                            <span class="text-[8px] sm:text-[10px] font-black text-blue-700 bg-blue-100 px-2 py-1 rounded-md">B (Baik Sekali)</span>
                        </div>
                        <div class="flex justify-between items-center bg-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-[11px] sm:text-xs font-black text-slate-600">6,00 - 7,49</span>
                            <span class="text-[8px] sm:text-[10px] font-black text-amber-700 bg-amber-100 px-2 py-1 rounded-md">C (Baik)</span>
                        </div>
                        <div class="flex justify-between items-center bg-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-[11px] sm:text-xs font-black text-slate-600">0,0 - 5,99</span>
                            <span class="text-[8px] sm:text-[10px] font-black text-rose-700 bg-rose-100 px-2 py-1 rounded-md">D (Belum Lulus)</span>
                        </div>
                    </div>
                </div>

            </div>

            <button type="submit" class="w-full bg-maroon-950 text-white py-3.5 sm:py-4 rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-black uppercase tracking-widest hover:bg-maroon-900 transition-all shadow-lg active:scale-[0.99] flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                {{ $siswa->penilaian ? 'Simpan Perubahan Nilai' : 'Simpan Penilaian Final' }}
            </button>
        </form>
    </section>
</main>

<script>
    // JS Untuk Otomatis Mengubah Angka (Ketik 95 jadi 9,5)
    document.querySelectorAll('.numeric-input').forEach(input => {
        input.addEventListener('input', function(e) {
            let val = this.value.replace(/[^0-9]/g, '');
            if (val.length > 1) {
                this.value = val.slice(0, -1) + ',' + val.slice(-1);
            } else {
                this.value = val;
            }
        });
    });
</script>
@endsection
