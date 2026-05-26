@extends('layouts.admin')

@section('content')
<style>
    .modal-backdrop { background: rgba(43, 11, 22, 0.4); backdrop-filter: blur(4px); }
</style>

<main id="content-area" class="p-6 lg:p-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    
    <div id="master-view" class="space-y-8 animate-in slide-in-from-left-4 duration-500">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            
            <div class="flex items-center p-1.5 bg-slate-100/80 rounded-2xl w-full lg:w-fit border border-slate-200/60">
                <button onclick="switchCategory('siswa')" id="btn-siswa" class="px-6 py-3 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest transition-all duration-300 bg-white text-maroon-900 shadow-sm w-1/2 lg:w-auto text-center">
                    Siswa Magang
                </button>
                <button onclick="switchCategory('tendik')" id="btn-tendik" class="px-6 py-3 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest transition-all duration-300 text-slate-500 hover:text-maroon-900 hover:bg-slate-200/50 w-1/2 lg:w-auto text-center">
                    Tenaga Kependidikan
                </button>
            </div>

            <button onclick="openPrintModal()" class="group bg-amber-400 text-maroon-950 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-amber-400/20 hover:bg-amber-500 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 flex items-center justify-center gap-3 w-full lg:w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-y-1 transition-transform"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                Cetak Laporan Kolektif
            </button>
        </div>

        <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white">
                <div>
                    <h3 id="list-title" class="text-xl font-black text-slate-800 tracking-tight leading-none">Daftar Siswa Magang</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Klik baris tabel untuk melihat detail riwayat</p>
                </div>
                <div class="relative group w-full max-w-sm">
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama atau ID..." class="bg-slate-50 border border-slate-200 rounded-xl px-11 py-3 text-xs font-medium w-full focus:ring-2 focus:ring-maroon-500 focus:border-maroon-500 outline-none transition-all placeholder:text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-maroon-600 transition-colors"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
            </div>

            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Personel</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">ID / Nomor Induk</th>
                            <th id="col-extra" class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Instansi Sekolah</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Efektivitas</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="list-body" class="divide-y divide-slate-100">

                        @foreach($siswa as $s)
                        <tr onclick="fetchDetail({{ $s->id_user }}, '{{ $s->nama_lengkap }}', 'Siswa Magang', '{{ $s->sekolah_asal ?? 'Tidak Diketahui' }}')" class="row-item type-siswa hover:bg-slate-50/80 transition-all cursor-pointer group">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama_lengkap) }}&background=bc5a75&color=fff" class="w-full h-full object-cover">
                                    </div>
                                    <p class="search-name text-sm font-extrabold text-slate-800 tracking-tight group-hover:text-maroon-700 transition-colors">{{ $s->nama_lengkap }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="search-id inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold font-mono border border-slate-200">{{ $s->nis ?? '-' }}</span>
                            </td>
                            <td class="px-8 py-4"><p class="text-xs font-bold text-slate-600 uppercase">{{ $s->sekolah_asal ?? '-' }}</p></td>
                            <td class="px-8 py-4 text-center">
                                @if($s->efektivitas >= 80)
                                    <span class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-lg text-[10px] font-black uppercase tracking-tight">{{ $s->efektivitas }}%</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-600 border border-amber-200 rounded-lg text-[10px] font-black uppercase tracking-tight">{{ $s->efektivitas }}%</span>
                                @endif
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="inline-flex items-center gap-2 text-maroon-600 font-black text-[10px] uppercase opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                    Lihat Detail 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @foreach($tendik as $t)
                        <tr onclick="fetchDetail({{ $t->id_user }}, '{{ $t->nama_lengkap }}', 'Tenaga Kependidikan', '{{ $t->unitKerja->nama_unit ?? 'Tidak Ada Unit' }}')" class="row-item type-tendik hover:bg-slate-50/80 transition-all cursor-pointer group" style="display: none;">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-sm flex-shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($t->nama_lengkap) }}&background=0f172a&color=fff" class="w-full h-full object-cover">
                                    </div>
                                    <p class="search-name text-sm font-extrabold text-slate-800 tracking-tight group-hover:text-maroon-700 transition-colors">{{ $t->nama_lengkap }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="search-id inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold font-mono border border-slate-200">{{ $t->nip ?? '-' }}</span>
                            </td>
                            <td class="px-8 py-4"><p class="text-xs font-bold text-slate-600 uppercase">{{ $t->unitKerja->nama_unit ?? '-' }}</p></td>
                            <td class="px-8 py-4 text-center">
                                @if($t->efektivitas >= 80)
                                    <span class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-lg text-[10px] font-black uppercase tracking-tight">{{ $t->efektivitas }}%</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-600 border border-amber-200 rounded-lg text-[10px] font-black uppercase tracking-tight">{{ $t->efektivitas }}%</span>
                                @endif
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="inline-flex items-center gap-2 text-maroon-600 font-black text-[10px] uppercase opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                    Lihat Detail 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div id="detail-view" class="hidden space-y-6 animate-in slide-in-from-right-8 duration-500">
        
        <button onclick="hideDetail()" class="flex items-center gap-3 text-xs font-black text-slate-500 uppercase tracking-widest hover:text-maroon-700 transition-colors group w-fit mb-2">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm group-hover:scale-105 group-hover:border-maroon-200 group-hover:bg-maroon-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </div>
            Kembali ke Daftar
        </button>

        <div class="bg-maroon-900 rounded-3xl p-8 lg:p-10 text-white shadow-lg shadow-maroon-900/20 overflow-hidden border border-maroon-800 relative">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-amber-400/10 rounded-full blur-[80px] pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-10">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-2xl border-2 border-amber-400/50 bg-white/10 backdrop-blur-md flex items-center justify-center text-4xl font-black text-amber-400 shadow-inner">
                        <span id="detail-initial">A</span>
                    </div>
                    <div>
                        <p id="detail-role" class="text-[10px] font-black text-amber-400 uppercase tracking-[0.2em] mb-1.5 leading-none">Role</p>
                        <h2 id="detail-name" class="text-3xl font-black tracking-tight text-white leading-tight">Nama User</h2>
                        <p id="detail-instansi" class="text-maroon-200 text-xs font-bold uppercase mt-2 tracking-widest leading-none">Instansi / Unit</p>
                    </div>
                </div>


                <div class="flex items-center gap-6 md:gap-10 bg-black/20 p-5 rounded-2xl border border-white/10 backdrop-blur-sm">
                    <div class="text-center">
                        <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Hadir</p>
                        <p id="stat-hadir" class="text-3xl font-black text-emerald-400 mt-1 leading-none">0</p>
                    </div>
                    <div class="w-[1px] h-10 bg-white/10"></div>
                    <div class="text-center">
                        <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Terlambat</p>
                        <p id="stat-telat" class="text-3xl font-black text-amber-400 mt-1 leading-none">0</p>
                    </div>
                    <div class="w-[1px] h-10 bg-white/10"></div>
                    <div class="text-center">
                        <p class="text-[9px] font-black text-maroon-300 uppercase tracking-widest">Alfa</p>
                        <p id="stat-alfa" class="text-3xl font-black text-rose-400 mt-1 leading-none">0</p>
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

        <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-black text-slate-800 tracking-tight">Data Riwayat Presensi</h3>
            </div>
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tap In</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tap Out</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="detail-table-body" class="divide-y divide-slate-100">
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

        // Definisi class untuk state aktif dan inaktif (menggunakan tema baru)
        const activeClass = "px-6 py-3 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest transition-all duration-300 bg-white text-maroon-900 shadow-sm w-1/2 lg:w-auto text-center";
        const inactiveClass = "px-6 py-3 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest transition-all duration-300 text-slate-500 hover:text-maroon-900 hover:bg-slate-200/50 w-1/2 lg:w-auto text-center";

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

    function fetchDetail(id_user, name, role, instansi) {
<<<<<<< HEAD
        // Tampilkan Loading dengan desain baru
        document.getElementById('detail-table-body').innerHTML = '<tr><td colspan="4" class="text-center py-12"><div class="inline-block animate-spin w-8 h-8 border-4 border-maroon-200 border-t-maroon-900 rounded-full mb-3"></div><p class="font-bold text-slate-400 text-xs uppercase tracking-widest">Memuat Riwayat...</p></td></tr>';
=======
        document.getElementById('detail-table-body').innerHTML = '<tr><td colspan="4" class="text-center py-10 font-bold text-slate-400">Memuat data...</td></tr>';
>>>>>>> origin/presensi

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


                // Render Tabel dengan desain Tailwind yang diperbarui
                let html = '';
                if(data.riwayat.length === 0) {
                    html = '<tr><td colspan="4" class="text-center py-10 font-bold text-slate-400 text-sm">Belum ada riwayat presensi yang tercatat.</td></tr>';
                } else {
                    data.riwayat.forEach(r => {
                        const tgl = new Date(r.tanggal).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

                        // Logika Pewarnaan Status
                        let statusBg = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                        let dotColor = 'bg-emerald-500';
                        
                        if(r.status_presensi.name === 'Terlambat') {
                            statusBg = 'bg-amber-50 text-amber-700 border-amber-200';
                            dotColor = 'bg-amber-500';
                        }
                        if(r.status_presensi.name === 'Alfa') {
                            statusBg = 'bg-rose-50 text-rose-600 border-rose-200';
                            dotColor = 'bg-rose-500';
                        }

                        html += `
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-4 text-xs font-bold text-slate-700 group-hover:text-maroon-800 transition-colors">${tgl}</td>
                                <td class="px-8 py-4 text-center text-xs font-bold text-slate-500 font-mono">${r.jam_masuk || '--:--'}</td>
                                <td class="px-8 py-4 text-center text-xs font-bold text-slate-500 font-mono">${r.jam_pulang || '--:--'}</td>
                                <td class="px-8 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 ${statusBg} border rounded-lg text-[10px] font-black uppercase tracking-widest">
                                        <span class="w-1.5 h-1.5 rounded-full ${dotColor}"></span>
                                        ${r.status_presensi.name}
                                    </span>
                                </td>
                            </tr>
                        `;
                    });
                }
                document.getElementById('detail-table-body').innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                document.getElementById('detail-table-body').innerHTML = '<tr><td colspan="4" class="text-center py-10 font-bold text-rose-500 text-sm">Gagal mengambil data dari server. Silakan coba lagi.</td></tr>';
            });
    }

    function hideDetail() {
        document.getElementById('detail-view').classList.add('hidden');
        document.getElementById('master-view').classList.remove('hidden');
        // Reset animasi agar muncul lagi dengan mulus
        document.getElementById('master-view').classList.remove('slide-in-from-left-4');
        void document.getElementById('master-view').offsetWidth; // trigger reflow
        document.getElementById('master-view').classList.add('slide-in-from-left-4');
    }
</script>
@endsection