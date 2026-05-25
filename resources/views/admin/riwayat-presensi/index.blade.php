@extends('layouts.admin')

@section('content')
<style>
    .modal-backdrop { background: rgba(43, 11, 22, 0.4); backdrop-filter: blur(4px); }
</style>

<main id="content-area" class="p-10 space-y-8 animate-in">
    <div id="master-view" class="space-y-8">
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6">
            <div class="flex items-center gap-4 p-2 bg-maroon-50 w-fit rounded-3xl border border-maroon-100">
                <button onclick="switchCategory('siswa')" id="btn-siswa" class="px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all bg-maroon-900 text-white shadow-lg">
                    Siswa Magang
                </button>
                <button onclick="switchCategory('tendik')" id="btn-tendik" class="px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all text-maroon-400 hover:text-maroon-900">
                    Tenaga Kependidikan
                </button>
            </div>

            <button onclick="openPrintModal()" class="bg-gold text-maroon-950 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-gold-dark active:scale-95 transition-all flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                Cetak Laporan Kolektif
            </button>
        </div>

        <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
            <div class="px-10 py-8 border-b border-maroon-50 flex items-center justify-between bg-white">
                <div>
                    <h3 id="list-title" class="text-lg font-black text-maroon-950 tracking-tight italic leading-none">Daftar Siswa Magang</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Klik personil untuk melihat riwayat kehadiran mendalam</p>
                </div>
                <div class="relative">
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama atau ID..." class="bg-slate-50 border border-slate-100 rounded-xl px-10 py-2.5 text-xs font-medium w-64 focus:ring-2 focus:ring-maroon-500 outline-none">
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

                        @foreach($siswa as $s)
                        <tr onclick="fetchDetail({{ $s->id_user }}, '{{ $s->nama_lengkap }}', 'Siswa Magang', '{{ $s->sekolah_asal ?? 'Tidak Diketahui' }}')" class="row-item type-siswa hover:bg-maroon-50/40 transition-all cursor-pointer group">
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-2xl bg-slate-100 flex items-center justify-center text-maroon-900 font-bold border-2 border-white group-hover:border-maroon-200 transition-all">
                                        {{ substr($s->nama_lengkap, 0, 1) }}
                                    </div>
                                    <p class="search-name text-sm font-extrabold text-slate-800 tracking-tight group-hover:text-maroon-900">{{ $s->nama_lengkap }}</p>
                                </div>
                            </td>
                            <td class="px-10 py-5"><p class="search-id text-xs font-bold text-slate-500">{{ $s->nis ?? '-' }}</p></td>
                            <td class="px-10 py-5"><p class="text-xs font-bold text-slate-600 uppercase">{{ $s->sekolah_asal ?? '-' }}</p></td>
                            <td class="px-10 py-5 text-center">
                                <span class="px-3 py-1 {{ $s->efektivitas >= 80 ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }} rounded-lg text-[9px] font-black uppercase italic">{{ $s->efektivitas }}%</span>
                            </td>
                            <td class="px-10 py-5 text-right"><div class="inline-flex items-center gap-2 text-maroon-700 font-black text-[10px] uppercase opacity-0 group-hover:opacity-100 transition-opacity">Riwayat <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></div></td>
                        </tr>
                        @endforeach

                        @foreach($tendik as $t)
                        <tr onclick="fetchDetail({{ $t->id_user }}, '{{ $t->nama_lengkap }}', 'Tenaga Kependidikan', '{{ $t->unitKerja->nama_unit ?? 'Tidak Ada Unit' }}')" class="row-item type-tendik hover:bg-maroon-50/40 transition-all cursor-pointer group" style="display: none;">
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-2xl bg-slate-100 flex items-center justify-center text-maroon-900 font-bold border-2 border-white group-hover:border-maroon-200 transition-all">
                                        {{ substr($t->nama_lengkap, 0, 1) }}
                                    </div>
                                    <p class="search-name text-sm font-extrabold text-slate-800 tracking-tight group-hover:text-maroon-900">{{ $t->nama_lengkap }}</p>
                                </div>
                            </td>
                            <td class="px-10 py-5"><p class="search-id text-xs font-bold text-slate-500">{{ $t->nip ?? '-' }}</p></td>
                            <td class="px-10 py-5"><p class="text-xs font-bold text-slate-600 uppercase">{{ $t->unitKerja->nama_unit ?? '-' }}</p></td>
                            <td class="px-10 py-5 text-center">
                                <span class="px-3 py-1 {{ $t->efektivitas >= 80 ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }} rounded-lg text-[9px] font-black uppercase italic">{{ $t->efektivitas }}%</span>
                            </td>
                            <td class="px-10 py-5 text-right"><div class="inline-flex items-center gap-2 text-maroon-700 font-black text-[10px] uppercase opacity-0 group-hover:opacity-100 transition-opacity">Riwayat <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></div></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div id="detail-view" class="hidden space-y-8 animate-in">
        <div class="flex items-center justify-between">
            <button onclick="hideDetail()" class="flex items-center gap-2 text-xs font-black text-maroon-950 uppercase tracking-widest hover:text-maroon-600 transition-colors group">
                <div class="w-10 h-10 rounded-xl bg-white border border-maroon-100 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </div>
                Kembali ke Daftar
            </button>
            </div>

        <div class="bg-maroon-900 rounded-[3rem] p-10 text-white shadow-premium overflow-hidden border border-maroon-800 relative">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-gold/20 rounded-full blur-[100px]"></div>
            <div class="relative z-10 flex items-center gap-8">
                <div class="w-24 h-24 rounded-[2rem] border-2 border-gold/50 p-1 bg-white/10 backdrop-blur-md flex items-center justify-center text-4xl font-black text-gold">
                    <span id="detail-initial">A</span>
                </div>
                <div>
                    <p id="detail-role" class="text-[10px] font-black text-gold uppercase tracking-[0.3em] mb-1 leading-none">Role</p>
                    <h2 id="detail-name" class="text-4xl font-black italic tracking-tight">Nama</h2>
                    <p id="detail-instansi" class="text-maroon-100/60 text-xs font-bold uppercase mt-3 tracking-widest italic leading-none">Instansi</p>
                </div>
                <div class="ml-auto flex gap-10 pr-4 text-center">
                    <div><p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Tepat Waktu</p><p id="stat-hadir" class="text-3xl font-black text-white mt-1">0</p></div>
                    <div><p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Terlambat</p><p id="stat-telat" class="text-3xl font-black text-amber-400 mt-1">0</p></div>
                    <div><p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Alfa</p><p id="stat-alfa" class="text-3xl font-black text-rose-400 mt-1">0</p></div>
                </div>
            </div>
        </div>

        <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
            <div class="px-10 py-8 border-b border-maroon-50 flex items-center justify-between">
                <h3 class="text-lg font-black text-maroon-950 tracking-tight italic">Data Riwayat Presensi</h3>
            </div>
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-maroon-50/20">
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Tanggal</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Tap In</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Tap Out</th>
                            <th class="px-10 py-6 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="detail-table-body" class="divide-y divide-maroon-50/50">
                        </tbody>
                </table>
            </div>
        </section>
    </div>
</main>

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

        if(type === 'siswa') {
            btnSiswa.className = "px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all bg-maroon-900 text-white shadow-lg";
            btnTendik.className = "px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all text-maroon-400 hover:text-maroon-900";
            title.textContent = "Daftar Siswa Magang";
            colExtra.textContent = "Instansi Sekolah";

            rowsSiswa.forEach(row => row.style.display = '');
            rowsTendik.forEach(row => row.style.display = 'none');
        } else {
            btnTendik.className = "px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all bg-maroon-900 text-white shadow-lg";
            btnSiswa.className = "px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all text-maroon-400 hover:text-maroon-900";
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

    function fetchDetail(id_user, name, role, instansi) {
        document.getElementById('detail-table-body').innerHTML = '<tr><td colspan="4" class="text-center py-10 font-bold text-slate-400">Memuat data...</td></tr>';

        document.getElementById('master-view').classList.add('hidden');
        document.getElementById('detail-view').classList.remove('hidden');
        document.getElementById('detail-name').textContent = name;
        document.getElementById('detail-role').textContent = role;
        document.getElementById('detail-instansi').textContent = instansi;
        document.getElementById('detail-initial').textContent = name.charAt(0);
        window.scrollTo({top: 0, behavior: 'smooth'});

        fetch(`/admin/riwayat-presensi/detail/${id_user}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('stat-hadir').textContent = data.statistik.hadir;
                document.getElementById('stat-telat').textContent = data.statistik.telat;
                document.getElementById('stat-alfa').textContent = data.statistik.alfa;

                let html = '';
                if(data.riwayat.length === 0) {
                    html = '<tr><td colspan="4" class="text-center py-10 font-bold text-slate-400">Belum ada riwayat presensi.</td></tr>';
                } else {
                    data.riwayat.forEach(r => {
                        const tgl = new Date(r.tanggal).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

                        // Badge untuk CI
                        let statusCiName = r.status_ci ? r.status_ci.name : 'Alfa';
                        let colorCi = statusCiName === 'Tepat Waktu' ? 'bg-emerald-100 text-emerald-600' : (statusCiName === 'Terlambat' ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600');

                        // Badge untuk CO
                        let statusCoName = r.status_co ? r.status_co.name : 'Belum CO';
                        let colorCo = statusCoName === 'Tepat Waktu' ? 'bg-emerald-100 text-emerald-600' : (statusCoName === 'Belum CO' ? 'bg-slate-100 text-slate-500' : 'bg-rose-100 text-rose-600');

                        html += `
                            <tr>
                                <td class="px-10 py-5 text-xs font-bold text-slate-800">${tgl}</td>
                                <td class="px-10 py-5 text-center text-xs font-bold text-slate-600 italic">${r.jam_masuk || '--:--'}</td>
                                <td class="px-10 py-5 text-center text-xs font-bold text-slate-600 italic">${r.jam_pulang || '--:--'}</td>
                                <td class="px-10 py-5 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="inline-flex px-3 py-1 ${colorCi} rounded-lg text-[9px] font-black uppercase tracking-tighter italic">
                                            CI: ${statusCiName}
                                        </span>
                                        <span class="inline-flex px-3 py-1 ${colorCo} rounded-lg text-[9px] font-black uppercase tracking-tighter italic">
                                            CO: ${statusCoName}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }
                document.getElementById('detail-table-body').innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                document.getElementById('detail-table-body').innerHTML = '<tr><td colspan="4" class="text-center py-10 font-bold text-red-500">Gagal mengambil data.</td></tr>';
            });
    }

    function hideDetail() {
        document.getElementById('master-view').classList.remove('hidden');
        document.getElementById('detail-view').classList.add('hidden');
    }
</script>
@endsection
