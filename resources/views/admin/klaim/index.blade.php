@extends('layouts.admin')

@section('content')
<main class="p-10 space-y-8 animate-in">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-maroon-950 italic tracking-tight">Verifikasi Klaim Presensi</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">Daftar pengajuan perbaikan status "Lupa Check-Out".</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl text-sm font-bold shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <section class="bg-white rounded-[3rem] border border-maroon-50 shadow-premium overflow-hidden">
        <div class="px-10 py-6 border-b border-maroon-50 bg-maroon-900">
            <h3 class="text-lg font-black text-white tracking-tight italic">Menunggu Verifikasi</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-maroon-50/30">
                        <th class="px-8 py-5 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Pengaju</th>
                        <th class="px-8 py-5 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Tgl Presensi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-maroon-900 uppercase tracking-widest">Alasan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-center">Bukti</th>
                        <th class="px-8 py-5 text-[10px] font-black text-maroon-900 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-maroon-50">
                    @forelse($klaimPending as $k)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-5">
                            @php
                                $namaPengaju = 'Unknown';
                                $userKlaim = $k->presensi->user;

                                if ($userKlaim) {
                                    // Cek apakah dia tendik atau siswa, lalu ambil nama_lengkap-nya
                                    $dataTendik = \App\Models\Tendik::where('id_user', $userKlaim->id_user)->first();
                                    $dataSiswa = \App\Models\SiswaMagang::where('id_user', $userKlaim->id_user)->first();

                                    if ($dataTendik) {
                                        $namaPengaju = $dataTendik->nama_lengkap;
                                    } elseif ($dataSiswa) {
                                        $namaPengaju = $dataSiswa->nama_lengkap;
                                    } else {
                                        $namaPengaju = $userKlaim->name ?? $userKlaim->username ?? 'User ID: ' . $userKlaim->id_user;
                                    }
                                }
                            @endphp

                            <p class="text-sm font-extrabold text-slate-800">{{ $namaPengaju }}</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase mt-1">{{ $k->presensi->user->roles->first()->name ?? 'Role' }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg border">
                                {{ \Carbon\Carbon::parse($k->presensi->tanggal)->format('d M Y') }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-xs font-medium text-slate-600 max-w-xs break-words italic">"{{ $k->alasan }}"</p>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($k->dokumen_bukti)
                                <a href="{{ asset('storage/uploads/klaim/' . $k->dokumen_bukti) }}" target="_blank" class="inline-flex items-center gap-2 text-[10px] font-black text-blue-600 bg-blue-50 px-4 py-2 rounded-xl hover:bg-blue-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    LIHAT FILE
                                </a>
                            @else
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg">Tanpa Lampiran</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                <form action="{{ route('admin.klaim.verifikasi', $k->id_klaim_presensi) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="aksi" value="terima">
                                    <button type="submit" onclick="return confirm('Terima klaim ini? Status user akan menjadi Tepat Waktu.')" class="bg-emerald-100 text-emerald-700 hover:bg-emerald-500 hover:text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">Terima</button>
                                </form>
                                <form action="{{ route('admin.klaim.verifikasi', $k->id_klaim_presensi) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="aksi" value="tolak">
                                    <button type="submit" onclick="return confirm('Tolak klaim ini? Status Lupa CO akan tetap.')" class="bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-bold uppercase text-xs tracking-widest">Belum ada pengajuan klaim baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mt-8">
        <div class="px-8 py-5 border-b border-slate-100 bg-slate-50">
            <h3 class="text-sm font-black text-slate-700 uppercase tracking-widest">Riwayat Verifikasi (50 Terakhir)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <tbody class="divide-y divide-slate-50">
                    @forelse($klaimSelesai as $ks)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-4">
                            @php
                                $namaRiwayat = 'Unknown';
                                $userRiwayat = $ks->presensi->user ?? null;

                                if ($userRiwayat) {
                                    $cekTendik = \App\Models\Tendik::where('id_user', $userRiwayat->id_user)->first();
                                    $cekSiswa = \App\Models\SiswaMagang::where('id_user', $userRiwayat->id_user)->first();

                                    if ($cekTendik) {
                                        $namaRiwayat = $cekTendik->nama_lengkap;
                                    } elseif ($cekSiswa) {
                                        $namaRiwayat = $cekSiswa->nama_lengkap;
                                    } else {
                                        $namaRiwayat = $userRiwayat->name ?? $userRiwayat->email ?? 'User ID: ' . $userRiwayat->id_user;
                                    }
                                }
                            @endphp
                            <span class="text-xs font-bold text-slate-700">{{ $namaRiwayat }}</span>
                        </td>
                        <td class="px-8 py-4">
                            <span class="text-[10px] font-bold text-slate-500">{{ \Carbon\Carbon::parse($ks->presensi->tanggal)->format('d/m/Y') }}</span>
                        </td>
                        <td class="px-8 py-4">
                            @if($ks->status_verifikasi == 'disetujui')
                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-lg text-[9px] font-black uppercase">Disetujui</span>
                            @else
                                <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-lg text-[9px] font-black uppercase">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-right">
                            <span class="text-[10px] font-bold text-slate-400">Oleh: {{ $ks->verifikator->name ?? 'Admin' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-6 text-center text-slate-400 font-bold text-xs">Belum ada riwayat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
