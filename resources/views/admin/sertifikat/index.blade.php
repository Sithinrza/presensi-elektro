@extends('layouts.admin')

@section('content')
<main class="p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-5 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error') || $errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-5 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') ?? $errors->first() }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-black text-maroon-950 tracking-tight italic">Penerbitan Sertifikat</h2>
            <p class="text-sm font-bold text-slate-500 mt-1">Kelola dan terbitkan nomor sertifikat resmi untuk siswa magang.</p>
        </div>
    </div>

    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">

        <div class="px-8 py-6 border-b border-maroon-50 bg-white">
            <h3 class="text-lg font-black text-maroon-950 tracking-tight italic leading-none">Daftar Penilaian Akhir</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Input nomor surat resmi dan klik cetak</p>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-maroon-50/30">
                        <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center w-16">No</th>
                        <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Siswa & Instansi Asal</th>
                        <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Nilai Akhir</th>
                        <th class="px-8 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Input & Cetak Sertifikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50">

                    @forelse($penilaian as $index => $p)
                    <tr class="hover:bg-maroon-50/20 transition-colors group">
                        <td class="px-8 py-5 text-center font-bold text-slate-400 text-xs">{{ $index + 1 }}</td>

                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shadow-sm border-2 border-white group-hover:border-maroon-100 transition-all flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($p->siswa->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-sm tracking-tight group-hover:text-maroon-900 transition-colors">{{ $p->siswa->nama_lengkap }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 line-clamp-1">{{ $p->siswa->sekolah_asal }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-5 text-center">
                            @php
                                $nilaiAvg = number_format($p->rata_rata, 2, ',', '');
                                $isLulus = $p->rata_rata >= 6.00;
                            @endphp
                            <div class="inline-flex flex-col items-center justify-center">
                                <span class="inline-flex items-center justify-center bg-white text-maroon-900 font-black text-sm w-12 h-12 rounded-[1rem] border-2 border-maroon-100 shadow-sm {{ $isLulus ? 'border-emerald-200 text-emerald-700 bg-emerald-50' : 'border-rose-200 text-rose-700 bg-rose-50' }}">
                                    {{ $nilaiAvg }}
                                </span>
                            </div>
                        </td>

                        <td class="px-8 py-5">
                            <form action="{{ route('admin.sertifikat.update', $p->id_penilaian) }}" method="POST" class="flex items-center gap-2 w-max" id="formSertifikat_{{ $p->id_penilaian }}" onsubmit="gabungSertifikat('{{ $p->id_penilaian }}')">
                                @csrf @method('PUT')

                                @php
                                    $nomor_db = $p->nomor_sertifikat ?? '';

                                    // Setelan Default jika masih kosong
                                    $noUrut = '';
                                    $tahunSertif = date('Y');
                                    $middlePart = '/DST/PL18.3/DV.01.10/';

                                    if (!empty($nomor_db)) {
                                        // Cari posisi garis miring pertama dan terakhir
                                        $firstSlash = strpos($nomor_db, '/');
                                        $lastSlash = strrpos($nomor_db, '/');

                                        // Jika formatnya valid (punya minimal 2 garis miring)
                                        if ($firstSlash !== false && $lastSlash !== false && $firstSlash !== $lastSlash) {
                                            $noUrut = substr($nomor_db, 0, $firstSlash);
                                            $tahunSertif = substr($nomor_db, $lastSlash + 1);
                                            $middlePart = substr($nomor_db, $firstSlash, $lastSlash - $firstSlash + 1);
                                        } else {
                                            // Fallback kalau nomor di DB aneh / tidak ada garis miringnya
                                            $noUrut = $nomor_db;
                                            $middlePart = '';
                                            $tahunSertif = '';
                                        }
                                    }
                                @endphp

                                <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-maroon-500 shadow-sm group-hover:bg-white transition-all h-11">

                                    <input type="text" id="prefix_{{ $p->id_penilaian }}" value="{{ $noUrut }}" required placeholder="001" class="w-14 bg-transparent px-3 py-3 text-xs font-black text-slate-800 outline-none text-center placeholder:text-slate-300">

                                    <input type="text" id="middle_{{ $p->id_penilaian }}" value="{{ $middlePart }}" readonly class="w-48 bg-transparent px-0 py-3 text-[11px] font-bold text-slate-400 outline-none text-center cursor-not-allowed select-none">

                                    <button type="button" onclick="toggleLock('{{ $p->id_penilaian }}')" title="Buka Kunci / Edit Format" class="px-2 text-slate-300 hover:text-amber-500 transition-colors">
                                        <svg id="iconLock_{{ $p->id_penilaian }}" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0"></path></svg>
                                    </button>

                                    <input type="text" id="suffix_{{ $p->id_penilaian }}" value="{{ $tahunSertif }}" required class="w-16 bg-transparent px-2 py-3 text-xs font-black text-slate-800 outline-none text-center border-l border-slate-200/60">
                                </div>

                                <input type="hidden" name="nomor_sertifikat" id="hasil_gabung_{{ $p->id_penilaian }}">

                                <button type="submit" title="Simpan Nomor Sertifikat" class="h-11 px-4 bg-maroon-950 text-white rounded-xl flex items-center justify-center gap-2 shadow-lg hover:bg-maroon-800 active:scale-95 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Simpan</span>
                                </button>

                                @if($p->nomor_sertifikat)
                                    <div class="w-px h-6 bg-slate-200 mx-1"></div> <a href="{{ route('admin.sertifikat.cetak', $p->id_penilaian) }}" target="_blank" title="Cetak Sertifikat (PDF)" class="h-11 px-4 bg-emerald-500 text-white rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 active:scale-95 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Cetak</span>
                                    </a>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @empty

                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-maroon-50 text-maroon-200 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                            </div>
                            <p class="text-lg font-black text-maroon-900 tracking-tight">Belum Ada Penilaian</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Belum ada data nilai akhir yang disubmit oleh pembimbing lapangan.</p>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </section>
</main>

<script>
    // Fungsi untuk membuka kunci (unlock) inputan tengah
    function toggleLock(id) {
        let inputMiddle = document.getElementById('middle_' + id);
        let iconLock = document.getElementById('iconLock_' + id);

        if (inputMiddle.readOnly) {
            // BUKA KUNCI
            inputMiddle.readOnly = false;
            inputMiddle.classList.remove('text-slate-400', 'cursor-not-allowed', 'select-none');
            inputMiddle.classList.add('text-maroon-600');
            // Ganti icon ke Unlock
            iconLock.innerHTML = '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path>';
            iconLock.parentElement.classList.add('text-amber-500');
        } else {
            // KUNCI KEMBALI
            inputMiddle.readOnly = true;
            inputMiddle.classList.add('text-slate-400', 'cursor-not-allowed', 'select-none');
            inputMiddle.classList.remove('text-maroon-600');
            // Ganti icon ke Lock
            iconLock.innerHTML = '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0"></path>';
            iconLock.parentElement.classList.remove('text-amber-500');
        }
    }

    // Fungsi untuk menggabungkan text sesaat sebelum form disubmit
    function gabungSertifikat(id) {
        let prefix = document.getElementById('prefix_' + id).value;
        let middle = document.getElementById('middle_' + id).value;
        let suffix = document.getElementById('suffix_' + id).value;

        let hasilAkhir = prefix + middle + suffix;

        document.getElementById('hasil_gabung_' + id).value = hasilAkhir;
    }
</script>
@endsection
