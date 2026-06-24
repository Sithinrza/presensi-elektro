@extends('layouts.admin')
@section('page_title', 'Master Kajur')

@section('content')
<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 space-y-6 lg:space-y-8 animate-in">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 sm:px-5 sm:py-4 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-bold shadow-sm flex items-center gap-2.5 sm:gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5 shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- TAMPILAN ERROR VALIDASI (NIP / TAHUN SALAH) --}}
    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 sm:px-5 sm:py-4 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-bold shadow-sm mb-4">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">

        <section class="w-full lg:w-1/3 bg-white p-5 sm:p-6 lg:p-8 rounded-3xl lg:rounded-[2.5rem] border border-slate-100 shadow-sm shrink-0 lg:sticky lg:top-10">
            <h3 class="text-base sm:text-lg font-black text-maroon-950 uppercase italic tracking-tight mb-4 sm:mb-6">Tambah Kajur Baru</h3>
            <form action="{{ route('admin.kajur.store') }}" method="POST" class="space-y-4 sm:space-y-5">
                @csrf
                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap (Dengan Gelar)</label>
                    <input type="text" name="nama_lengkap" required placeholder="Contoh: M. Helmy Noor, S.ST., M.T." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-sm">
                </div>
                <div class="space-y-1.5 sm:space-y-2">
                    <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">NIP</label>
                    <input type="text" name="nip" required placeholder="123456789" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tahun Mulai</label>
                        <input type="number" id="tahun_mulai_add" name="tahun_mulai" required min="2000" max="2099" placeholder="2022" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 text-center transition-all shadow-sm">
                    </div>
                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tahun Selesai</label>
                        <input type="number" id="tahun_selesai_add" name="tahun_selesai" required min="2000" max="2099" placeholder="2026" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 text-center transition-all shadow-sm">
                    </div>
                </div>

                <label class="flex items-center gap-2.5 sm:gap-3 cursor-pointer group mt-2 p-2.5 sm:p-3 bg-slate-50 border border-slate-100 rounded-xl hover:border-maroon-200 transition">
                    <input type="checkbox" name="status_aktif" class="w-4 h-4 sm:w-5 sm:h-5 text-maroon-600 rounded focus:ring-maroon-500">
                    <span class="text-[10px] sm:text-xs font-black text-maroon-900 uppercase tracking-widest group-hover:text-maroon-600">Jadikan Kajur Aktif</span>
                </label>
                <button type="submit" class="w-full bg-maroon-950 text-white py-3 sm:py-3.5 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest shadow-lg hover:bg-maroon-800 transition active:scale-95 mt-3 sm:mt-4">
                    Simpan Data
                </button>
            </form>
        </section>

        <section class="w-full lg:flex-1 bg-white rounded-3xl lg:rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 sm:p-6 lg:p-8 bg-maroon-950 text-white border-b border-maroon-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg sm:text-xl font-black italic tracking-tight">Master Data Kajur</h3>
                    <p class="text-[9px] sm:text-[10px] font-bold text-maroon-200 uppercase tracking-widest mt-0.5 sm:mt-1">Riwayat Ketua Jurusan Teknik Elektro</p>
                </div>

                <form method="GET" action="{{ route('admin.kajur.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
                    <select name="filter_periode" onchange="this.form.submit()" class="flex-1 sm:flex-none bg-maroon-900 border border-maroon-800 text-white text-[10px] sm:text-xs font-bold rounded-lg sm:rounded-xl px-3 py-2 sm:px-4 sm:py-2 outline-none focus:ring-2 focus:ring-maroon-500 cursor-pointer">
                        <option value="">Semua Periode</option>
                        @foreach($listPeriode as $periode)
                            <option value="{{ $periode }}" {{ request('filter_periode') == $periode ? 'selected' : '' }}>
                                Periode {{ $periode }}
                            </option>
                        @endforeach
                    </select>
                    @if(request('filter_periode'))
                        <a href="{{ route('admin.kajur.index') }}" class="bg-white/10 hover:bg-white/20 text-white p-1.5 sm:p-2 rounded-lg sm:rounded-xl transition shrink-0" title="Reset Filter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-4 sm:h-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto custom-scroll p-0 sm:p-2">
                <table class="w-full text-left border-collapse min-w-[500px] lg:min-w-[600px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama & NIP</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Periode</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi / Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($kajurs as $k)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-4 sm:px-6 py-4 sm:py-5">
                                <p class="font-black text-xs sm:text-sm text-slate-800 group-hover:text-maroon-900 transition-colors">{{ $k->nama_lengkap }}</p>
                                <p class="text-[9px] sm:text-[10px] font-bold text-slate-500 font-mono mt-0.5 sm:mt-1">NIP. {{ $k->nip }}</p>
                            </td>
                            <td class="px-4 sm:px-6 py-4 sm:py-5 text-center">
                                <span class="bg-slate-100 text-slate-600 px-2 py-1 sm:px-3 sm:py-1 rounded-md sm:rounded-lg text-[9px] sm:text-[10px] font-black tracking-widest whitespace-nowrap">{{ $k->periode }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 sm:py-5 text-center">
                                <div class="flex flex-row items-center justify-center gap-1.5 sm:gap-2">
                                    <button onclick="openModal('modal-edit-{{ $k->id_kajur }}')" class="bg-amber-100 text-amber-700 hover:bg-amber-200 px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg sm:rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest transition-all shadow-sm active:scale-95 shrink-0">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.kajur.destroy', $k->id_kajur) }}" method="POST" class="inline-block shrink-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Kajur ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg sm:rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest transition-all shadow-sm active:scale-95">
                                            Hapus
                                        </button>
                                    </form>

                                    @if($k->status_aktif)
                                        <span class="inline-flex items-center justify-center gap-1.5 bg-emerald-100 text-emerald-700 px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg sm:rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-emerald-200 shadow-sm cursor-default w-[80px] sm:w-[90px]">
                                            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-emerald-500 rounded-full animate-pulse shrink-0"></div>
                                            Aktif
                                        </span>
                                    @else
                                        <form action="{{ route('admin.kajur.aktif', $k->id_kajur) }}" method="POST" class="inline-block shrink-0">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-white border-2 border-slate-200 text-slate-400 hover:border-maroon-500 hover:text-maroon-700 px-3 py-1 sm:px-4 sm:py-1.5 rounded-lg sm:rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest transition-all shadow-sm active:scale-95 w-[80px] sm:w-[90px]">
                                                Set Aktif
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @php
                            $periodeArr = explode(' - ', $k->periode);
                        @endphp
                        <div id="modal-edit-{{ $k->id_kajur }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity p-4">
                            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 w-full max-w-md shadow-2xl relative animate-in zoom-in-95 duration-200">
                                <button onclick="closeModal('modal-edit-{{ $k->id_kajur }}')" class="absolute top-5 right-5 sm:top-6 sm:right-6 text-slate-400 hover:text-rose-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-6 sm:h-6"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </button>

                                <h3 class="text-lg sm:text-xl font-black text-maroon-950 italic tracking-tight mb-5 sm:mb-6">Edit Data Kajur</h3>

                                <form action="{{ route('admin.kajur.update', $k->id_kajur) }}" method="POST" class="space-y-3 sm:space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-1.5 sm:space-y-2">
                                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" value="{{ $k->nama_lengkap }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-sm">
                                    </div>
                                    <div class="space-y-1.5 sm:space-y-2">
                                        <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">NIP</label>
                                        <input type="text" name="nip" value="{{ $k->nip }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 transition-all shadow-sm">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                        <div class="space-y-1.5 sm:space-y-2">
                                            <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tahun Mulai</label>
                                            <input type="number" id="tahun_mulai_edit_{{ $k->id_kajur }}" name="tahun_mulai" value="{{ $periodeArr[0] ?? '' }}" required min="2000" max="2099" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 text-center transition-all shadow-sm">
                                        </div>
                                        <div class="space-y-1.5 sm:space-y-2">
                                            <label class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tahun Selesai</label>
                                            <input type="number" id="tahun_selesai_edit_{{ $k->id_kajur }}" name="tahun_selesai" value="{{ $periodeArr[1] ?? '' }}" required min="2000" max="2099" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-[11px] sm:text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-maroon-500 text-center transition-all shadow-sm">
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full bg-amber-500 text-white py-3 sm:py-3.5 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest shadow-lg hover:bg-amber-600 transition active:scale-95 mt-4 sm:mt-6">
                                        Update Data
                                    </button>
                                </form>
                            </div>
                        </div>

                        <script>
                            document.getElementById('tahun_mulai_edit_{{ $k->id_kajur }}').addEventListener('change', function() {
                                let minVal = this.value;
                                let inputSelesai = document.getElementById('tahun_selesai_edit_{{ $k->id_kajur }}');
                                inputSelesai.min = minVal;
                                if(inputSelesai.value && inputSelesai.value < minVal) {
                                    inputSelesai.value = minVal;
                                }
                            });
                        </script>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-10 sm:px-6 sm:py-12 text-center text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest">
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

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // MENGUNCI TAHUN SELESAI AGAR TIDAK LEBIH KECIL DARI TAHUN MULAI (FORM TAMBAH)
    document.getElementById('tahun_mulai_add').addEventListener('change', function() {
        const tahunMulai = this.value;
        const inputSelesai = document.getElementById('tahun_selesai_add');

        inputSelesai.min = tahunMulai;

        if(inputSelesai.value && inputSelesai.value < tahunMulai) {
            inputSelesai.value = tahunMulai;
        }
    });
</script>
@endsection
