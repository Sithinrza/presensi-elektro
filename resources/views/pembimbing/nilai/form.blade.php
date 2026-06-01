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
                        <input type="number" step="0.1" max="10" name="kecakapan_kerja" value="{{ $siswa->penilaian->kecakapan_kerja ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Menerima Perintah</label>
                        <input type="number" step="0.1" max="10" name="menerima_perintah" value="{{ $siswa->penilaian->menerima_perintah ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Sikap / Perilaku</label>
                        <input type="number" step="0.1" max="10" name="sikap_perilaku" value="{{ $siswa->penilaian->sikap_perilaku ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Inisiatif & Kreatifitas</label>
                        <input type="number" step="0.1" max="10" name="inisiatif_kreatifitas" value="{{ $siswa->penilaian->inisiatif_kreatifitas ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Disiplin & Kehadiran</label>
                        <input type="number" step="0.1" max="10" name="disiplin_kehadiran" value="{{ $siswa->penilaian->disiplin_kehadiran ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Tanggung Jawab</label>
                        <input type="number" step="0.1" max="10" name="tanggung_jawab" value="{{ $siswa->penilaian->tanggung_jawab ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-lg font-black text-maroon-950 uppercase italic border-b border-maroon-50 pb-2">2. Keterampilan</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Pemahaman Teknis</label>
                        <input type="number" step="0.1" max="10" name="pemahaman_teknis" value="{{ $siswa->penilaian->pemahaman_teknis ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Persiapan Kerja</label>
                        <input type="number" step="0.1" max="10" name="persiapan_kerja" value="{{ $siswa->penilaian->persiapan_kerja ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Kerjasama Team</label>
                        <input type="number" step="0.1" max="10" name="kerjasama_team" value="{{ $siswa->penilaian->kerjasama_team ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Mutu Hasil Kerja</label>
                        <input type="number" step="0.1" max="10" name="mutu_hasil_kerja" value="{{ $siswa->penilaian->mutu_hasil_kerja ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-center font-bold outline-none focus:ring-2 focus:ring-maroon-500">
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 grid grid-cols-3 gap-6 text-center">
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase">Sakit</p>
                    <p class="text-xl font-bold text-maroon-950">{{ $sakit }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase">Izin</p>
                    <p class="text-xl font-bold text-maroon-950">{{ $izin }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase">Alpa</p>
                    <p class="text-xl font-bold text-rose-600">{{ $alpa }}</p>
                </div>
            </div>

            <button type="submit" class="w-full bg-maroon-950 text-white py-4 rounded-xl font-black uppercase tracking-widest hover:bg-maroon-900 transition-all shadow-lg">
                {{ $siswa->penilaian ? 'Update Penilaian' : 'Simpan Penilaian' }}
            </button>
        </form>
    </section>
</main>
@endsection
