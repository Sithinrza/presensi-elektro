@extends('layouts.admin')

@section('content')
<!-- Tambahan CSS Khusus Halaman Ini -->
<style>
    .modal-backdrop {
        background: rgba(43, 11, 22, 0.4);
        backdrop-filter: blur(4px);
    }
</style>

<main id="content-area" class="p-10 space-y-8 animate-in">
    <!-- MASTER VIEW: Kategori & List Nama -->
    <div id="master-view" class="space-y-8">
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6">
            <!-- TAB KATEGORI -->
            <div class="flex items-center gap-4 p-2 bg-maroon-50 w-fit rounded-3xl border border-maroon-100">
                <button onclick="switchCategory('siswa')" id="btn-siswa" class="px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all bg-maroon-900 text-white shadow-lg">
                    Siswa Magang
                </button>
                <button onclick="switchCategory('tendik')" id="btn-tendik" class="px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all text-maroon-400 hover:text-maroon-900">
                    Tenaga Kependidikan
                </button>
            </div>

            <!-- GLOBAL PRINT BUTTON -->
            <button onclick="openPrintModal()" class="bg-gold text-maroon-950 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-gold-dark active:scale-95 transition-all flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                Cetak Laporan Kolektif
            </button>
        </div>

        <!-- SEARCH & LIST -->
        <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
            <div class="px-10 py-8 border-b border-maroon-50 flex items-center justify-between bg-white">
                <div>
                    <h3 id="list-title" class="text-lg font-black text-maroon-950 tracking-tight italic leading-none">Daftar Siswa Magang</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Klik personil untuk melihat riwayat kehadiran mendalam</p>
                </div>
                <div class="relative">
                    <input type="text" placeholder="Cari nama atau ID..." class="bg-slate-50 border border-slate-100 rounded-xl px-10 py-2.5 text-xs font-medium w-64 focus:ring-2 focus:ring-maroon-500 outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
            </div>

            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-maroon-50/20">
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Identitas Personel</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">ID / Nomor Induk</th>
                            <th id="col-extra" class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Instansi/Unit</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Efektivitas</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="list-body" class="divide-y divide-maroon-50/50">
                        <!-- Simulated Data -->
                        <tr onclick="showDetail('Ahmad Fauzi', 'Siswa Magang', 'SMKN 5 Banjarmasin')" class="hover:bg-maroon-50/40 transition-all cursor-pointer group">
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-2xl bg-slate-100 overflow-hidden border-2 border-white group-hover:border-maroon-200 transition-all">
                                        <img src="https://i.pravatar.cc/100?img=11" class="w-full h-full object-cover">
                                    </div>
                                    <p class="text-sm font-extrabold text-slate-800 tracking-tight group-hover:text-maroon-900">Ahmad Fauzi</p>
                                </div>
                            </td>
                            <td class="px-10 py-5"><p class="text-xs font-bold text-slate-500">2021006721</p></td>
                            <td class="px-10 py-5"><p class="text-xs font-bold text-slate-600 uppercase">SMKN 5 Banjarmasin</p></td>
                            <td class="px-10 py-5 text-center"><span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase italic">92%</span></td>
                            <td class="px-10 py-5 text-right"><div class="inline-flex items-center gap-2 text-maroon-700 font-black text-[10px] uppercase opacity-0 group-hover:opacity-100 transition-opacity">Riwayat <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- DETAIL VIEW: Per Individu -->
    <div id="detail-view" class="hidden space-y-8 animate-in">
        <div class="flex items-center justify-between">
            <button onclick="hideDetail()" class="flex items-center gap-2 text-xs font-black text-maroon-950 uppercase tracking-widest hover:text-maroon-600 transition-colors group">
                <div class="w-10 h-10 rounded-xl bg-white border border-maroon-100 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </div>
                Kembali ke Daftar
            </button>
            <div class="flex gap-3">
                <button class="bg-gold text-maroon-950 px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg active:scale-95 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                    Cetak PDF
                </button>
                <button class="bg-maroon-950 text-white px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg active:scale-95 transition-all">Excel</button>
            </div>
        </div>

        <div class="bg-maroon-900 rounded-[3rem] p-10 text-white shadow-premium overflow-hidden border border-maroon-800 relative">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-gold/20 rounded-full blur-[100px]"></div>
            <div class="relative z-10 flex items-center gap-8">
                <div class="w-24 h-24 rounded-[2rem] border-2 border-gold/50 p-1 bg-white/10 backdrop-blur-md">
                    <img id="detail-photo" src="https://i.pravatar.cc/100?img=11" class="w-full h-full object-cover rounded-[1.6rem]">
                </div>
                <div>
                    <p id="detail-role" class="text-[10px] font-black text-gold uppercase tracking-[0.3em] mb-1 leading-none">Siswa Magang</p>
                    <h2 id="detail-name" class="text-4xl font-black italic tracking-tight">Ahmad Fauzi</h2>
                    <p id="detail-instansi" class="text-maroon-100/60 text-xs font-bold uppercase mt-3 tracking-widest italic leading-none">SMKN 5 Banjarmasin</p>
                </div>
                <div class="ml-auto flex gap-10 pr-4 text-center">
                    <div><p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Hadir</p><p class="text-3xl font-black text-white mt-1">22</p></div>
                    <div><p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Terlambat</p><p class="text-3xl font-black text-amber-400 mt-1">01</p></div>
                    <div><p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Alpa</p><p class="text-3xl font-black text-rose-400 mt-1">03</p></div>
                </div>
            </div>
        </div>

        <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
            <div class="px-10 py-8 border-b border-maroon-50 flex items-center justify-between">
                <h3 class="text-lg font-black text-maroon-950 tracking-tight italic">Data Riwayat Presensi</h3>
                <!-- Filter Individu -->
                <div class="flex items-center gap-3">
                    <select class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-[11px] font-black text-maroon-900 focus:ring-2 focus:ring-maroon-500 outline-none cursor-pointer">
                        <option value="4">April</option>
                        <option value="3">Maret</option>
                    </select>
                    <select class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-[11px] font-black text-maroon-900 focus:ring-2 focus:ring-maroon-500 outline-none cursor-pointer">
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>
                    <button class="bg-maroon-950 text-white p-2 rounded-lg shadow-md"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m21 21-4.3-4.3"/><circle cx="10" cy="10" r="7"/></svg></button>
                </div>
            </div>
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-maroon-50/20">
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Tanggal</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Tap In</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Tap Out</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Status</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-maroon-50/50">
                        <tr>
                            <td class="px-10 py-5 text-xs font-bold text-slate-800">Senin, 15 Apr 2024</td>
                            <td class="px-10 py-5 text-center text-xs font-bold text-slate-600 italic">07:42:01</td>
                            <td class="px-10 py-5 text-center text-xs font-bold text-slate-600 italic">16:05:32</td>
                            <td class="px-10 py-5 text-center"><span class="inline-flex px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter italic">Hadir</span></td>
                            <td class="px-10 py-5 text-right"><button class="text-slate-300 hover:text-maroon-900"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>

<!-- MODAL CETAK LAPORAN KOLEKTIF -->
<div id="printModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" onclick="closePrintModal()"></div>
    <div class="relative w-full max-w-lg animate-in">
        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-maroon-100 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="bg-maroon-950 px-8 py-6 text-white flex items-center justify-between shrink-0">
                <div>
                    <h3 class="text-lg font-black tracking-tight italic">Cetak Laporan Kolektif</h3>
                    <p class="text-[10px] font-bold text-maroon-300 uppercase tracking-widest mt-1">Konfigurasi Berkas Ekspor</p>
                </div>
                <button onclick="closePrintModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-8 space-y-6 overflow-y-auto no-scrollbar">
                <!-- Pilihan Kategori -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Pilih Kategori Personel</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="print-cat" value="siswa" checked class="hidden peer">
                            <div class="p-4 border-2 border-slate-100 rounded-2xl text-center font-bold text-xs text-slate-400 peer-checked:border-maroon-950 peer-checked:bg-maroon-50 peer-checked:text-maroon-950 transition-all italic">Siswa Magang</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="print-cat" value="tendik" class="hidden peer">
                            <div class="p-4 border-2 border-slate-100 rounded-2xl text-center font-bold text-xs text-slate-400 peer-checked:border-maroon-950 peer-checked:bg-maroon-50 peer-checked:text-maroon-950 transition-all italic">Staf Tendik</div>
                        </label>
                    </div>
                </div>

                <!-- Pilihan Jenis Periode -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-maroon-900 uppercase tracking-widest ml-1">Jenis Laporan</label>
                    <div class="flex items-center gap-4 p-1.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <button onclick="setPrintType('bulan')" id="type-bulan" class="flex-1 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-white shadow-sm text-maroon-950 transition-all">Per Bulan</button>
                        <button onclick="setPrintType('tahun')" id="type-tahun" class="flex-1 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-400 transition-all">Per Tahun</button>
                    </div>
                </div>

                <!-- Dropdowns Periode -->
                <div class="grid grid-cols-2 gap-4 pb-4">
                    <div id="container-bulan" class="space-y-2 transition-opacity duration-300">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Bulan</label>
                        <select class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500">
                            <option value="1">Januari</option>
                            <option value="4" selected>April</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tahun</label>
                        <select class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-maroon-950 outline-none focus:ring-2 focus:ring-maroon-500">
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-8 pt-0 shrink-0">
                <button class="w-full bg-maroon-950 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl active:scale-95 transition-all flex items-center justify-center gap-2 hover:bg-maroon-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Proses Cetak Laporan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab Logika (Siswa vs Tendik)
    function switchCategory(type) {
        const btnSiswa = document.getElementById('btn-siswa');
        const btnTendik = document.getElementById('btn-tendik');
        const title = document.getElementById('list-title');
        const listBody = document.getElementById('list-body');
        const colExtra = document.getElementById('col-extra');

        if(type === 'siswa') {
            btnSiswa.className = "px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all bg-maroon-900 text-white shadow-lg";
            btnTendik.className = "px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all text-maroon-400 hover:text-maroon-900";
            title.textContent = "Daftar Siswa Magang";
            colExtra.textContent = "Instansi Sekolah";
            listBody.innerHTML = `
                <tr onclick="showDetail('Ahmad Fauzi', 'Siswa Magang', 'SMKN 5 Banjarmasin')" class="hover:bg-maroon-50/40 transition-all cursor-pointer group">
                    <td class="px-10 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 rounded-2xl bg-slate-100 overflow-hidden border-2 border-white group-hover:border-maroon-200 transition-all">
                                <img src="https://i.pravatar.cc/100?img=11" class="w-full h-full object-cover">
                            </div>
                            <p class="text-sm font-extrabold text-slate-800 tracking-tight group-hover:text-maroon-900">Ahmad Fauzi</p>
                        </div>
                    </td>
                    <td class="px-10 py-5"><p class="text-xs font-bold text-slate-500">2021006721</p></td>
                    <td class="px-10 py-5"><p class="text-xs font-bold text-slate-600 uppercase">SMKN 5 Banjarmasin</p></td>
                    <td class="px-10 py-5 text-center"><span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase italic">92%</span></td>
                    <td class="px-10 py-5 text-right"><div class="inline-flex items-center gap-2 text-maroon-700 font-black text-[10px] uppercase opacity-0 group-hover:opacity-100 transition-opacity">Riwayat <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></div></td>
                </tr>
            `;
        } else {
            btnTendik.className = "px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all bg-maroon-900 text-white shadow-lg";
            btnSiswa.className = "px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all text-maroon-400 hover:text-maroon-900";
            title.textContent = "Daftar Tenaga Kependidikan";
            colExtra.textContent = "Unit Kerja / Prodi";
            listBody.innerHTML = `
                <tr onclick="showDetail('Sri Wahyuni, M.T.', 'Tenaga Kependidikan', 'Lab Jaringan & Komputer')" class="hover:bg-maroon-50/40 transition-all cursor-pointer group">
                    <td class="px-10 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 rounded-2xl bg-slate-100 overflow-hidden border-2 border-white group-hover:border-maroon-200 transition-all">
                                <img src="https://i.pravatar.cc/100?img=5" class="w-full h-full object-cover">
                            </div>
                            <p class="text-sm font-extrabold text-slate-800 leading-none tracking-tight group-hover:text-maroon-900">Sri Wahyuni, M.T.</p>
                        </div>
                    </td>
                    <td class="px-10 py-5"><p class="text-xs font-bold text-slate-500">19880512202021</p></td>
                    <td class="px-10 py-5"><p class="text-xs font-bold text-slate-600 uppercase">Lab Jaringan & Komputer</p></td>
                    <td class="px-10 py-5 text-center"><span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase italic">98%</span></td>
                    <td class="px-10 py-5 text-right"><div class="inline-flex items-center gap-2 text-maroon-700 font-black text-[10px] uppercase opacity-0 group-hover:opacity-100 transition-opacity">Riwayat <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></div></td>
                </tr>
            `;
        }
    }

    // Navigasi Detail Personil
    function showDetail(name, role, instansi) {
        document.getElementById('master-view').classList.add('hidden');
        document.getElementById('detail-view').classList.remove('hidden');
        document.getElementById('detail-name').textContent = name;
        document.getElementById('detail-role').textContent = role;
        document.getElementById('detail-instansi').textContent = instansi;
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function hideDetail() {
        document.getElementById('master-view').classList.remove('hidden');
        document.getElementById('detail-view').classList.add('hidden');
    }

    // Modal Cetak Laporan
    function openPrintModal() { document.getElementById('printModal').classList.remove('hidden'); }
    function closePrintModal() { document.getElementById('printModal').classList.add('hidden'); }

    // Tipe Cetak (Bulan vs Tahun)
    function setPrintType(type) {
        const btnBulan = document.getElementById('type-bulan');
        const btnTahun = document.getElementById('type-tahun');
        const bulContainer = document.getElementById('container-bulan');

        if(type === 'bulan') {
            btnBulan.className = "flex-1 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-white shadow-sm text-maroon-950 transition-all";
            btnTahun.className = "flex-1 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-400 transition-all";
            bulContainer.classList.remove('opacity-30', 'pointer-events-none');
        } else {
            btnTahun.className = "flex-1 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-white shadow-sm text-maroon-950 transition-all";
            btnBulan.className = "flex-1 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-400 transition-all";
            bulContainer.classList.add('opacity-30', 'pointer-events-none');
        }
    }
</script>
@endsection
