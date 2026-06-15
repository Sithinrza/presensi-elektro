@extends('layouts.pembimbing')
@section('page_title', 'Nilai')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 space-y-6 sm:space-y-8 animate-in">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-bold shadow-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/60 backdrop-blur-md p-4 sm:p-6 rounded-3xl sm:rounded-[2.5rem] border border-maroon-100/50 shadow-sm">
        <div class="flex items-center gap-3 sm:gap-4 pl-1 sm:pl-2">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-xl sm:rounded-2xl flex items-center justify-center text-maroon-900 shadow-sm border border-maroon-50 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-[22px] sm:h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
            </div>
            <div>
                <h2 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight leading-none">Penilaian Siswa</h2>
                <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 line-clamp-1">Kelola Nilai & Cetak Sertifikat Magang</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
        @forelse($daftarSiswa as $siswa)
            <div class="bg-white rounded-3xl sm:rounded-[2.5rem] p-5 sm:p-6 lg:p-8 border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6 group">

                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl sm:rounded-3xl bg-slate-50 overflow-hidden border border-slate-200 shadow-inner shrink-0 group-hover:border-maroon-200 transition-colors flex items-center justify-center text-maroon-900 font-black text-2xl">
                    @if($siswa->foto_profil)
                        <img src="{{ asset('storage/' . $siswa->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($siswa->nama_lengkap, 0, 1) }}
                    @endif
                </div>

                <div class="flex-1 text-center sm:text-left w-full">
                    <h4 class="text-base sm:text-lg font-black text-maroon-950 truncate tracking-tight">{{ $siswa->nama_lengkap }}</h4>
                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest truncate">{{ $siswa->sekolah_asal ?? 'Instansi Tidak Diisi' }}</p>

                    <div class="mt-3 mb-4">
                        @if($siswa->penilaian)
                            <span class="inline-flex px-2 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-md text-[8px] font-black uppercase tracking-widest">
                                Sudah Dinilai
                            </span>
                        @else
                            <span class="inline-flex px-2 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded-md text-[8px] font-black uppercase tracking-widest">
                                Belum Dinilai
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row flex-wrap gap-2 justify-center sm:justify-start">
                        @if($siswa->penilaian)
                            <a href="{{ route('pembimbing.nilai.edit', $siswa->id_siswa) }}" class="bg-amber-100 text-amber-700 px-4 py-2.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest hover:bg-amber-200 transition-colors flex-1 sm:flex-none text-center">
                                Edit Nilai
                            </a>

                            @if($siswa->penilaian->nomor_sertifikat)
                                <a href="{{ route('pembimbing.nilai.cetak', $siswa->id_siswa) }}" target="_blank" class="bg-emerald-500 text-white px-4 py-2.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 shadow-md shadow-emerald-500/20 active:scale-95 transition-all flex-1 sm:flex-none text-center flex items-center justify-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                    Cetak Sertifikat
                                </a>
                            @else
                                <button disabled class="bg-slate-50 text-slate-400 border border-slate-200 px-4 py-2.5 rounded-xl text-[8px] sm:text-[9px] font-black uppercase tracking-widest cursor-not-allowed transition-colors flex-1 sm:flex-none text-center" title="Sertifikat bisa dicetak setelah Admin IT menerbitkan Nomor Surat.">
                                    Menunggu No. Surat Admin
                                </button>
                            @endif

                        @else
                            <a href="{{ route('pembimbing.nilai.create', $siswa->id_siswa) }}" class="w-full bg-maroon-950 text-white px-6 py-3 rounded-xl sm:rounded-2xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest shadow-md hover:bg-maroon-800 active:scale-95 transition-all flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                                Input Nilai Baru
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white/50 backdrop-blur-sm p-8 sm:p-12 rounded-3xl sm:rounded-[3rem] border-2 border-dashed border-maroon-100 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white shadow-sm text-maroon-200 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15l-2 5l9-9l-7 0l2-5l-9 9l7 0"/></svg>
                </div>
                <h3 class="text-lg sm:text-xl font-black text-maroon-950 tracking-tight mb-2">Belum Ada Peserta Magang</h3>
                <p class="text-xs sm:text-sm font-medium text-slate-500 max-w-md mx-auto">Anda belum memiliki peserta magang untuk diberikan penilaian akhir.</p>
            </div>
        @endforelse
    </div>
</main>
@endsection
