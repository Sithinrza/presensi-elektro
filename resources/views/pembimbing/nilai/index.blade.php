@extends('layouts.pembimbing')

@section('content')
<main class="max-w-6xl mx-auto p-5 lg:p-10 space-y-8">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-2xl text-sm font-bold shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-6 bg-maroon-900 rounded-full"></div>
        <h3 class="text-xl font-black text-maroon-950 tracking-tight italic">Daftar Siswa Bimbingan</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($daftarSiswa as $siswa)
            <div class="bg-white rounded-[2.5rem] p-6 border border-maroon-50 shadow-sm flex flex-col md:flex-row items-center gap-6">
                <div class="w-20 h-20 rounded-3xl bg-slate-100 overflow-hidden border-2 border-white shadow-inner">
                    @if($siswa->foto_profil)
                        <img src="/uploads/profil/{{ $siswa->foto_profil }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                    @endif
                </div>

                <div class="flex-1 text-center md:text-left overflow-hidden">
                    <h4 class="text-lg font-black text-maroon-950 truncate">{{ $siswa->nama_lengkap }}</h4>
                    <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">{{ $siswa->sekolah_asal ?? '-' }}</p>

                    <div class="mt-4 flex flex-wrap gap-2 justify-center md:justify-start">
                        @if($siswa->penilaian)
                            <a href="{{ route('pembimbing.nilai.edit', $siswa->id_siswa) }}" class="bg-amber-100 text-amber-700 px-4 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-amber-200 transition">
                                Edit Nilai
                            </a>
                            <a href="{{ route('pembimbing.nilai.cetak', $siswa->id_siswa) }}" target="_blank" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-emerald-700 transition">
                                Cetak PDF
                            </a>
                        @else
                            <a href="{{ route('pembimbing.nilai.create', $siswa->id_siswa) }}" class="bg-maroon-950 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase shadow-lg hover:bg-maroon-800 transition">
                                Input Nilai
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-sm font-bold text-slate-400">Belum ada siswa bimbingan.</p>
            </div>
        @endforelse
    </div>
</main>
@endsection
