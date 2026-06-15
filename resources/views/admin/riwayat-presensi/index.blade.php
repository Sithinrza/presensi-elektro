@extends('layouts.admin')
@section('page_title', 'Riwayat Presensi')
@section('content')
<style>
    .modal-backdrop { background: rgba(43, 11, 22, 0.4); backdrop-filter: blur(4px); }
</style>

<main id="content-area" class=" mx-auto w-full p-4 sm:p-6 lg:p-10 space-y-6 lg:space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    <div id="master-view" class="space-y-6 lg:space-y-8">

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-6">
            <div class="flex items-center p-1.5 bg-slate-100/80 rounded-[1rem] lg:rounded-2xl w-full lg:w-fit border border-slate-200/60">
                <button onclick="switchCategory('siswa')" id="btn-siswa" class="px-2 py-2.5 lg:px-6 lg:py-3 rounded-xl text-[9px] sm:text-[10px] lg:text-xs font-black uppercase tracking-widest transition-all duration-300 bg-white text-maroon-900 shadow-sm w-1/2 lg:w-auto text-center leading-tight">
                    Siswa Magang
                </button>
                <button onclick="switchCategory('tendik')" id="btn-tendik" class="px-2 py-2.5 lg:px-6 lg:py-3 rounded-xl text-[9px] sm:text-[10px] lg:text-xs font-black uppercase tracking-widest transition-all duration-300 text-slate-500 hover:text-maroon-900 hover:bg-slate-200/50 w-1/2 lg:w-auto text-center leading-tight">
                    Tenaga Kependidikan
                </button>
            </div>

            <button onclick="openPrintModal()" class="group bg-amber-400 text-maroon-950 px-5 py-3.5 lg:px-8 lg:py-4 rounded-xl lg:rounded-2xl font-black text-[10px] lg:text-xs uppercase tracking-widest shadow-lg shadow-amber-400/20 hover:bg-amber-500 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 flex items-center justify-center gap-2 lg:gap-3 w-full lg:w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-y-1 transition-transform lg:w-[18px] lg:h-[18px]"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                Cetak Laporan
            </button>
        </div>

        <section class="bg-white rounded-[1.5rem] lg:rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-4 lg:px-8 py-4 lg:py-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white">
                <div>
                    <h3 id="list-title" class="text-lg lg:text-xl font-black text-slate-800 tracking-tight leading-none">Daftar Siswa Magang</h3>
                    <p class="text-[9px] lg:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 lg:mt-2">Klik baris tabel untuk detail</p>
                </div>
                <div class="relative group w-full md:max-w-sm">
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama atau ID..." class="bg-slate-50 border border-slate-200 rounded-xl px-10 py-2.5 lg:py-3 text-[11px] lg:text-xs font-medium w-full focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all placeholder:text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-maroon-600 transition-colors lg:w-4 lg:h-4"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
            </div>

            <div class="overflow-x-auto custom-scroll pb-2">
                <table class="w-full text-left border-collapse min-w-[650px] lg:min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-4 lg:px-8 py-3 lg:py-5 text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Personel</th>
                            <th class="px-4 lg:px-8 py-3 lg:py-5 text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest">ID / Induk</th>
                            <th id="col-extra" class="px-4 lg:px-8 py-3 lg:py-5 text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest">Instansi Sekolah</th>
                            <th class="px-4 lg:px-8 py-3 lg:py-5 text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status Hari Ini</th>
                            <th class="px-4 lg:px-8 py-3 lg:py-5 text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="list-body" class="divide-y divide-slate-100">

                        @foreach($siswa as $s)
                        <tr onclick="window.location.href='{{ url('/admin/riwayat-presensi/detail/' . $s->id_user) }}'" class="row-item type-siswa hover:bg-slate-50/80 transition-all cursor-pointer group">
                            <td class="px-4 lg:px-8 py-3 lg:py-4">
                                <div class="flex items-center gap-3 lg:gap-4">
                                    <div class="w-8 h-8 lg:w-11 lg:h-11 rounded-lg lg:rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0">
                                        @if($s->foto_profil)
                                            <img src="{{ asset('storage/' . $s->foto_profil) }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <p class="search-name text-xs lg:text-sm font-extrabold text-slate-800 tracking-tight group-hover:text-maroon-700 transition-colors">{{ $s->nama_lengkap }}</p>
                                </div>
                            </td>
                            <td class="px-4 lg:px-8 py-3 lg:py-4">
                                <span class="search-id inline-flex items-center px-2 py-1 lg:px-2.5 rounded-md bg-slate-100 text-slate-600 text-[10px] lg:text-xs font-bold font-mono border border-slate-200">{{ $s->nis ?? '-' }}</span>
                            </td>
                            <td class="px-4 lg:px-8 py-3 lg:py-4"><p class="text-[10px] lg:text-xs font-bold text-slate-600 uppercase">{{ $s->sekolah_asal ?? '-' }}</p></td>
                            <td class="px-4 lg:px-8 py-3 lg:py-4 text-center">
                                @php
                                    $status = $s->status_hari_ini;
                                    $badgeColor = match($status) {
                                        'Tepat Waktu', 'Check Out' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Terlambat', 'Terlambat CO' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'Alpa', 'Lupa Check-Out' => 'bg-rose-50 text-rose-600 border-rose-200',
                                        default => 'bg-slate-50 text-slate-500 border-slate-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-1.5 {{ $badgeColor }} border rounded-md lg:rounded-lg text-[8px] lg:text-[10px] font-black uppercase tracking-tight">{{ $status }}</span>
                            </td>
                            <td class="px-4 lg:px-8 py-3 lg:py-4 text-right">
                                <div class="inline-flex items-center gap-1.5 lg:gap-2 text-maroon-600 font-black text-[9px] lg:text-[10px] uppercase opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lg:w-[14px] lg:h-[14px]"><path d="m9 18 6-6-6-6"/></svg>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @foreach($tendik as $t)
                        <tr onclick="window.location.href='{{ url('/admin/riwayat-presensi/detail/' . $t->id_user) }}'" class="row-item type-tendik hover:bg-slate-50/80 transition-all cursor-pointer group" style="display: none;">
                            <td class="px-4 lg:px-8 py-3 lg:py-4">
                                <div class="flex items-center gap-3 lg:gap-4">
                                    <div class="w-8 h-8 lg:w-11 lg:h-11 rounded-lg lg:rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0">
                                        @if($t->foto_profil)
                                            <!-- PERBAIKAN: Menghilangkan teks 'profil/' agar image bisa dimuat dengan benar -->
                                            <img src="{{ asset('storage/' . $t->foto_profil) }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($t->nama_lengkap) }}&background=0f172a&color=fff" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <p class="search-name text-xs lg:text-sm font-extrabold text-slate-800 tracking-tight group-hover:text-maroon-700 transition-colors">{{ $t->nama_lengkap }}</p>
                                </div>
                            </td>
                            <td class="px-4 lg:px-8 py-3 lg:py-4">
                                <span class="search-id inline-flex items-center px-2 py-1 lg:px-2.5 rounded-md bg-slate-100 text-slate-600 text-[10px] lg:text-xs font-bold font-mono border border-slate-200">{{ $t->nip ?? '-' }}</span>
                            </td>
                            <td class="px-4 lg:px-8 py-3 lg:py-4"><p class="text-[10px] lg:text-xs font-bold text-slate-600 uppercase">{{ $t->unitKerja->nama_unit ?? '-' }}</p></td>
                            <td class="px-4 lg:px-8 py-3 lg:py-4 text-center">
                                @php
                                    $status = $t->status_hari_ini;
                                    $badgeColor = match($status) {
                                        'Tepat Waktu', 'Check Out' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Terlambat', 'Terlambat CO' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Libur' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'Alpa', 'Lupa Check-Out' => 'bg-rose-50 text-rose-600 border-rose-200',
                                        default => 'bg-slate-50 text-slate-500 border-slate-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-1.5 {{ $badgeColor }} border rounded-md lg:rounded-lg text-[8px] lg:text-[10px] font-black uppercase tracking-tight">{{ $status }}</span>
                            </td>
                            <td class="px-4 lg:px-8 py-3 lg:py-4 text-right">
                                <div class="inline-flex items-center gap-1.5 lg:gap-2 text-maroon-600 font-black text-[9px] lg:text-[10px] uppercase opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lg:w-[14px] lg:h-[14px]"><path d="m9 18 6-6-6-6"/></svg>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </section>
    </div>

</main>

<!-- MODAL CETAK DIKEMBALIKAN -->
<div id="modal-cetak" class="fixed inset-0 modal-backdrop z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-6 lg:p-8 w-full max-w-md shadow-2xl transform scale-95 transition-transform duration-300" id="modal-cetak-content">
        <div class="flex justify-between items-center mb-5 lg:mb-6">
            <h3 class="text-lg lg:text-xl font-black text-maroon-950 italic">Cetak Rekap Bulanan</h3>
            <button onclick="closePrintModal()" class="text-slate-400 hover:text-rose-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lg:w-6 lg:h-6"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.riwayat.excel') }}" method="GET" class="space-y-4 lg:space-y-5">
            <div>
                <label class="block text-[10px] lg:text-xs font-bold text-slate-700 mb-1.5 lg:mb-2 uppercase tracking-wide">Pilih Kategori</label>
                <select name="kategori" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 lg:p-3 text-xs lg:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all">
                    <option value="siswa">Siswa Magang</option>
                    <option value="tendik">Tenaga Kependidikan</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3 lg:gap-4">
                <div>
                    <label class="block text-[10px] lg:text-xs font-bold text-slate-700 mb-1.5 lg:mb-2 uppercase tracking-wide">Bulan</label>
                    <select name="bulan" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 lg:p-3 text-xs lg:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] lg:text-xs font-bold text-slate-700 mb-1.5 lg:mb-2 uppercase tracking-wide">Tahun</label>
                    <select name="tahun" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 lg:p-3 text-xs lg:text-sm font-bold text-slate-800 focus:ring-2 focus:ring-maroon-500 outline-none transition-all">
                        @for ($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <button type="submit" onclick="closePrintModal()" class="w-full flex items-center justify-center gap-2 bg-emerald-600 text-white font-bold py-3 lg:py-3.5 rounded-xl hover:bg-emerald-700 active:scale-95 transition-all shadow-lg mt-3 lg:mt-4 text-xs lg:text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lg:w-[18px] lg:h-[18px]"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M8 13h2"/><path d="M8 17h2"/><path d="M14 13h2"/><path d="M14 17h2"/></svg>
                Download Excel
            </button>
        </form>
    </div>
</div>

<script>
    let currentCategory = 'siswa';

    function switchCategory(type) {
        currentCategory = type;
        const btnSiswa = document.getElementById('btn-siswa');
        const btnTendik = document.getElementById('btn-tendik');
        const title = document.getElementById('list-title');
        const colExtra = document.getElementById('col-extra');

        const rowsSiswa = document.querySelectorAll('.type-siswa');
        const rowsTendik = document.querySelectorAll('.type-tendik');

        const activeClass = "px-2 py-2.5 lg:px-6 lg:py-3 rounded-xl text-[9px] sm:text-[10px] lg:text-xs font-black uppercase tracking-widest transition-all duration-300 bg-white text-maroon-900 shadow-sm w-1/2 lg:w-auto text-center leading-tight";
        const inactiveClass = "px-2 py-2.5 lg:px-6 lg:py-3 rounded-xl text-[9px] sm:text-[10px] lg:text-xs font-black uppercase tracking-widest transition-all duration-300 text-slate-500 hover:text-maroon-900 hover:bg-slate-200/50 w-1/2 lg:w-auto text-center leading-tight";

        if(type === 'siswa') {
            btnSiswa.className = activeClass;
            btnTendik.className = inactiveClass;
            title.textContent = "Daftar Siswa Magang";
            colExtra.textContent = "Instansi Sekolah";

            rowsSiswa.forEach(row => row.style.display = '');
            rowsTendik.forEach(row => row.style.display = 'none');
        } else {
            btnTendik.className = activeClass;
            btnSiswa.className = inactiveClass;
            title.textContent = "Daftar Tenaga Kependidikan";
            colExtra.textContent = "Unit Kerja / Prodi";

            rowsSiswa.forEach(row => row.style.display = 'none');
            rowsTendik.forEach(row => row.style.display = '');
        }
    }

    function filterTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.row-item');

        rows.forEach(row => {
            if(row.classList.contains('type-' + currentCategory)) {
                const name = row.querySelector('.search-name').textContent.toLowerCase();
                const id = row.querySelector('.search-id').textContent.toLowerCase();

                if (name.includes(input) || id.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }

    function openPrintModal() {
        const modal = document.getElementById('modal-cetak');
        const content = document.getElementById('modal-cetak-content');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    }

    function closePrintModal() {
        const modal = document.getElementById('modal-cetak');
        const content = document.getElementById('modal-cetak-content');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection