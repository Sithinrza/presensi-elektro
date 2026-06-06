@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto p-5 lg:p-10 space-y-8 animate-in">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-5 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <!-- FORM TAMBAH KAJUR BARU -->
        <section class="w-full lg:w-1/3 bg-white p-6 sm:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm shrink-0 sticky top-10">
            <h3 class="text-lg font-black text-maroon-950 uppercase italic tracking-tight mb-6">Tambah Kajur Baru</h3>
            <form action="{{ route('admin.kajur.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap (Beserta Gelar)</label>
                    <input type="text" name="nama_lengkap" required placeholder="M. HELMY NOOR, S.ST., M.T." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">NIP</label>
                    <input type="text" name="nip" required placeholder="19750507 200012 1 001" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500">
                </div>

                <!-- INPUT PERIODE DIBUAT 2 KOLOM -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" required min="2000" max="2099" placeholder="2022" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 text-center">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" required min="2000" max="2099" placeholder="2026" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 text-center">
                    </div>
                </div>

                <label class="flex items-center gap-3 cursor-pointer group mt-2 p-3 bg-slate-50 border border-slate-100 rounded-xl hover:border-maroon-200 transition">
                    <input type="checkbox" name="status_aktif" class="w-5 h-5 text-maroon-600 rounded focus:ring-maroon-500">
                    <span class="text-xs font-black text-maroon-900 uppercase tracking-widest group-hover:text-maroon-600">Jadikan Kajur Aktif</span>
                </label>
                <button type="submit" class="w-full bg-maroon-950 text-white py-3.5 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg hover:bg-maroon-800 transition active:scale-95 mt-4">
                    Simpan Data
                </button>
            </form>
        </section>

        <!-- TABEL DAFTAR KAJUR & FILTER -->
        <section class="w-full lg:flex-1 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8 bg-maroon-950 text-white border-b border-maroon-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-black italic tracking-tight">Master Data Kajur</h3>
                    <p class="text-[10px] font-bold text-maroon-200 uppercase tracking-widest mt-1">Riwayat Ketua Jurusan Teknik Elektro</p>
                </div>

                <!-- FILTER PERIODE -->
                <form method="GET" action="{{ route('admin.kajur.index') }}" class="flex items-center gap-2">
                    <select name="filter_periode" onchange="this.form.submit()" class="bg-maroon-900 border border-maroon-800 text-white text-xs font-bold rounded-xl px-4 py-2 outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer">
                        <option value="">Semua Periode</option>
                        @foreach($listPeriode as $periode)
                            <option value="{{ $periode }}" {{ request('filter_periode') == $periode ? 'selected' : '' }}>
                                Periode {{ $periode }}
                            </option>
                        @endforeach
                    </select>
                    @if(request('filter_periode'))
                        <a href="{{ route('admin.kajur.index') }}" class="bg-white/10 hover:bg-white/20 text-white p-2 rounded-xl transition" title="Reset Filter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto custom-scroll p-2">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama & NIP</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Periode</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi / Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($kajurs as $k)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-5">
                                <p class="font-black text-sm text-slate-800 group-hover:text-maroon-900 transition-colors">{{ $k->nama_lengkap }}</p>
                                <p class="text-[10px] font-bold text-slate-500 font-mono mt-1">NIP. {{ $k->nip }}</p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-lg text-[10px] font-black tracking-widest">{{ $k->periode }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- TOMBOL EDIT -->
                                    <button onclick="openModal('modal-edit-{{ $k->id_kajur }}')" class="bg-amber-100 text-amber-700 hover:bg-amber-200 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm active:scale-95">
                                        Edit
                                    </button>

                                    <!-- TOMBOL STATUS AKTIF -->
                                    @if($k->status_aktif)
                                        <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-700 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200 shadow-sm cursor-default">
                                            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                            Aktif
                                        </span>
                                    @else
                                        <form action="{{ route('admin.kajur.aktif', $k->id_kajur) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-white border-2 border-slate-200 text-slate-400 hover:border-maroon-500 hover:text-maroon-700 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm active:scale-95">
                                                Set Aktif
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- MODAL EDIT KHUSUS KAJUR INI -->
                        @php
                            // Pecah string "2022 - 2026" kembali menjadi array untuk form edit
                            $periodeArr = explode(' - ', $k->periode);
                        @endphp
                        <div id="modal-edit-{{ $k->id_kajur }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity">
                            <div class="bg-white rounded-[2.5rem] p-8 w-full max-w-md shadow-2xl relative animate-in zoom-in-95 duration-200">
                                <button onclick="closeModal('modal-edit-{{ $k->id_kajur }}')" class="absolute top-6 right-6 text-slate-400 hover:text-rose-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </button>

                                <h3 class="text-xl font-black text-maroon-950 italic tracking-tight mb-6">Edit Data Kajur</h3>

                                <form action="{{ route('admin.kajur.update', $k->id_kajur) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" value="{{ $k->nama_lengkap }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">NIP</label>
                                        <input type="text" name="nip" value="{{ $k->nip }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun Mulai</label>
                                            <input type="number" name="tahun_mulai" value="{{ $periodeArr[0] ?? '' }}" required min="2000" max="2099" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 text-center">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun Selesai</label>
                                            <input type="number" name="tahun_selesai" value="{{ $periodeArr[1] ?? '' }}" required min="2000" max="2099" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 text-center">
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full bg-amber-500 text-white py-3.5 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg hover:bg-amber-600 transition active:scale-95 mt-6">
                                        Update Data
                                    </button>
                                </form>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                Belum ada data Ketua Jurusan yang ditambahkan atau cocok dengan filter.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</main>

<!-- SCRIPT UNTUK BUKA/TUTUP MODAL -->
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Kunci scroll background
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
