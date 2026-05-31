@extends($layout)

@section('content')

{{-- RIWAYAT PRESENSI TENDIK DAN SISWA --}}
<main class="max-w-7xl mx-auto p-5 lg:p-10 space-y-8">
    <section class="bg-white rounded-[2.5rem] p-6 lg:p-8 border border-maroon-100 shadow-sm">
        <form action="{{ route('presensi.riwayat-presensi') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-xl font-black text-maroon-950 tracking-tight italic">Filter Periode</h2>
                <p class="text-sm text-slate-500 font-medium">Lihat data kehadiran bulan ini.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <select name="bulan" class="bg-maroon-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-maroon-900 focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                <select name="tahun" class="bg-maroon-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-maroon-900 focus:ring-2 focus:ring-maroon-500 transition-all cursor-pointer">
                    @for ($y = date('Y'); $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <button type="submit" class="bg-maroon-900 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg hover:bg-maroon-800 transition-all">
                    <span>Cari</span>
                </button>
            </div>
        </form>
    </section>

    <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
            <span class="text-3xl font-black text-emerald-600 leading-none">{{ $hadir ?? 0 }}</span>
            <span class="text-[10px] text-emerald-700/60 font-bold mt-2 uppercase tracking-widest">Tepat Waktu</span>
        </div>

        <div class="bg-amber-50 border border-amber-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
            <span class="text-3xl font-black text-amber-600 leading-none">{{ $telat ?? 0 }}</span>
            <span class="text-[10px] text-amber-700/60 font-bold mt-2 uppercase tracking-widest">Terlambat</span>
        </div>

        <div class="bg-maroon-50 border border-maroon-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
            <span class="text-3xl font-black text-maroon-900 leading-none">{{ $alfa ?? 0 }}</span>
            <span class="text-[10px] text-maroon-700/60 font-bold mt-2 uppercase tracking-widest">Alfa</span>
        </div>

        <div class="bg-blue-50 border border-blue-100 p-6 rounded-[2rem] flex flex-col items-center shadow-sm">
            <span class="text-3xl font-black text-blue-600 leading-none">{{ $libur ?? 0 }}</span>
            <span class="text-[10px] text-blue-700/60 font-bold mt-2 uppercase tracking-widest">Libur</span>
        </div>
    </section>

    <section class="bg-white rounded-[2.5rem] border border-maroon-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-maroon-900 text-white">
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-center">Masuk</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-center">Pulang</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest">Status Harian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50">
                    @forelse($riwayat as $r)
                    <tr class="hover:bg-maroon-50/40 transition-colors">
                        <td class="px-8 py-5">
                            @if($r->id_presensi)
                                <a href="{{ route('presensi.detail', $r->id_presensi) }}" class="text-sm font-extrabold text-maroon-900 hover:text-maroon-600 underline decoration-maroon-200 underline-offset-4 transition-colors">
                                    {{ Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                                </a>
                            @else
                                <span class="text-sm font-extrabold text-slate-400">
                                    {{ Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-sm font-bold text-slate-600">{{ $r->jam_masuk ?? '--:--' }}</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-sm font-bold text-slate-600">{{ $r->jam_pulang ?? '--:--' }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1 items-start">

                                @if($r->statusCi && $r->statusCi->name == 'Tepat Waktu')
                                    <span class="w-fit px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[9px] font-black uppercase">CI: {{ $r->statusCi->name }}</span>
                                @elseif($r->statusCi && $r->statusCi->name == 'Terlambat')
                                    <span class="w-fit px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[9px] font-black uppercase">CI: {{ $r->statusCi->name }}</span>
                                @elseif($r->statusCi && $r->statusCi->name == 'Libur')
                                    <span class="w-fit px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-[9px] font-black uppercase">CI: {{ $r->statusCi->name }}</span>
                                @else
                                    <span class="w-fit px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-[9px] font-black uppercase">CI: {{ $r->statusCi->name ?? 'Alfa' }}</span>
                                @endif

                                @if($r->statusCo)
                                    @if($r->statusCo->name == 'Tepat Waktu')
                                        <span class="w-fit px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[9px] font-black uppercase">CO: {{ $r->statusCo->name }}</span>
                                    @elseif($r->statusCo->name == 'Lupa Check-Out')
                                        <span class="w-fit px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-[9px] font-black uppercase mb-1">CO: {{ $r->statusCo->name }}</span>

                                        @if(!$r->klaim)
                                            @if($r->id_presensi)
                                                <button onclick="bukaModalKlaim({{ $r->id_presensi }}, '{{ Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}')" class="bg-maroon-900 text-white px-3 py-1.5 rounded-lg text-[10px] font-bold hover:bg-maroon-800 transition shadow-sm">
                                                    Ajukan Klaim
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-[9px] font-bold italic {{ $r->klaim->status_verifikasi == 'pending' ? 'text-amber-600' : ($r->klaim->status_verifikasi == 'disetujui' ? 'text-emerald-600' : 'text-rose-600') }}">
                                                Klaim: {{ ucfirst($r->klaim->status_verifikasi) }}
                                            </span>
                                        @endif
                                    @elseif($r->statusCo->name == 'Libur')
                                        <span class="w-fit px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-[9px] font-black uppercase">CO: {{ $r->statusCo->name }}</span>
                                    @else
                                        <span class="w-fit px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-[9px] font-black uppercase">CO: {{ $r->statusCo->name }}</span>
                                    @endif
                                @else
                                    <span class="w-fit px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[9px] font-black uppercase">CO: Belum</span>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-10 text-center text-slate-400 font-bold uppercase text-xs tracking-widest">Belum ada data presensi bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

<div id="modal-klaim" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl transform scale-95 transition-transform duration-300" id="modal-content">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-black text-maroon-950 italic">Ajukan Klaim Presensi</h3>
            <button onclick="tutupModalKlaim()" class="text-slate-400 hover:text-rose-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <p class="text-sm text-slate-500 mb-6 font-medium">Tanggal Presensi: <span id="modal-tanggal" class="font-bold text-slate-800"></span></p>

        <form action="{{ route('presensi.ajukan-klaim') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <input type="hidden" name="id_presensi" id="id_presensi_input">

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Alasan / Keterangan</label>
                <textarea name="alasan" required rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-maroon-500 outline-none transition-all" placeholder="Contoh: Rapat dinas luar / Lupa buka PWA"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Dokumen Bukti (Opsional)</label>
                <input type="file" name="dokumen_bukti" accept="image/*,.pdf" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-50 file:text-maroon-900 hover:file:bg-maroon-100 cursor-pointer">
                <p class="text-[10px] text-slate-400 mt-2 font-medium">Format: JPG, PNG, atau PDF. Maksimal 2MB.</p>
            </div>

            <button type="submit" class="w-full bg-maroon-900 text-white font-bold py-3.5 rounded-xl hover:bg-maroon-800 active:scale-95 transition-all shadow-lg mt-4">
                Kirim Pengajuan
            </button>
        </form>
    </div>
</div>

<script>
    function bukaModalKlaim(id_presensi, tanggal) {
        document.getElementById('id_presensi_input').value = id_presensi;
        document.getElementById('modal-tanggal').textContent = tanggal;

        const modal = document.getElementById('modal-klaim');
        const content = document.getElementById('modal-content');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    }

    function tutupModalKlaim() {
        const modal = document.getElementById('modal-klaim');
        const content = document.getElementById('modal-content');

        modal.classList.add('opacity-0');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
