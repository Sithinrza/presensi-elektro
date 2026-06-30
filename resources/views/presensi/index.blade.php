@extends($layout)
@section('page_title', 'Presensi')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    .card-presensi { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 480px; text-align: center; margin: 0 auto; }
    #map { height: 180px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #ddd; z-index: 1;}
    #kamera-container { position: relative; display: none; border-radius: 12px; overflow: hidden; background: #000; aspect-ratio: 4/3; box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
    video, canvas { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transform: scaleX(-1); }
    canvas { z-index: 5; pointer-events: none; }
    #oval-guide { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 110px; height: 150px; border: 3px solid yellow; border-radius: 50%; z-index: 10; pointer-events: none; transition: border-color 0.2s;}
    .instruksi { position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); color: white; background: rgba(0,0,0,0.8); padding: 8px 20px; border-radius: 25px; font-size: 14px; font-weight: 600; z-index: 15; width: 85%; transition: background-color 0.3s; }
    #debug-info { position: absolute; top: 10px; left: 10px; background: rgba(255,255,255,0.9); padding: 8px; border-radius: 5px; font-size: 11px; z-index: 10; font-weight: bold; text-align: left; box-shadow: 0 2px 4px rgba(0,0,0,0.1);}
    .status-badge { padding: 12px; margin-bottom: 20px; border-radius: 8px; font-weight: 600; font-size: 14px; }
    .bg-warning { background: #fffbeb; color: #92400e; border: 1px solid #fef3c7; }
    .bg-success { background: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
    .bg-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }
</style>

<div class="p-4 lg:p-8 w-full flex justify-center items-start min-h-screen">

    {{-- KONDISI BLOKIR PRIORITAS 1: AKUN NONAKTIF --}}
    @if($isNonaktif)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                </div>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Akun Nonaktif</h2>
            </div>

            <div class="p-8 bg-slate-50 border border-slate-200 rounded-xl mb-6 text-center">
                <div class="w-20 h-20 bg-white text-slate-400 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 tracking-tight leading-none mb-3">Akses Presensi Ditutup</h3>
                <p class="text-slate-600 text-sm">Status akun Anda saat ini adalah <b class="text-red-600">Nonaktif</b>. Anda sudah tidak dapat melakukan presensi lagi.</p>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    {{-- KONDISI BLOKIR PRIORITAS UPA CO --}}
    @elseif($presensiGantung)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-amber-100 text-amber-700 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Peringatan Sistem</h2>
            </div>

            <div class="p-6 bg-amber-50 border border-amber-200 rounded-xl mb-6 text-left">
                <h3 class="text-lg font-bold text-amber-800 mb-2">Alasan Lupa Check-Out</h3>
                <p class="text-amber-700 text-sm mb-4 leading-relaxed">
                    Sistem mendeteksi Anda tidak melakukan presensi pulang pada tanggal
                    <b class="font-black bg-amber-200 px-2 py-0.5 rounded">{{ \Carbon\Carbon::parse($presensiGantung->tanggal)->translatedFormat('d F Y') }}</b>.
                    Anda wajib mengisi alasan sebelum dapat melakukan presensi hari ini.
                </p>

                <form action="{{ route('presensi.simpan_alasan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_presensi" value="{{ $presensiGantung->id_presensi }}">

                    <label class="block text-sm font-bold text-slate-700 mb-2">Tulis Alasan Anda:</label>
                    <textarea name="alasan" rows="3" required class="w-full p-3 border border-slate-300 rounded-lg focus:ring-maroon-900 focus:border-maroon-900" placeholder="Misal: Lupa klik check-out karena buru-buru ada perbaikan mendadak..."></textarea>

                    @error('alasan')
                        <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="mt-4 w-full py-3 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 active:scale-95 transition shadow-lg">
                        Simpan Alasan & Lanjutkan
                    </button>
                </form>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    {{-- 🚨 KONDISI BLOKIR PRIORITAS 3: LEWAT JAM PULANG TAPI BELUM CHECK IN --}}
    @elseif($lewatBatasMasuk)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Sistem Ditutup</h2>
            </div>
            <div class="p-8 bg-rose-50 border border-rose-200 rounded-xl mb-6">
                <div class="w-20 h-20 bg-white text-rose-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm border border-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <h3 class="text-xl font-black text-rose-800 tracking-tight leading-none mb-3">Waktu Presensi Habis</h3>
                <p class="text-rose-700 text-sm">Anda melewatkan jam kerja. Batas waktu untuk melakukan presensi masuk telah habis karena saat ini sudah memasuki jadwal Check-Out. Anda tercatat <span class="font-bold text-rose-900">Alpa</span>.</p>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    @elseif($presensiSelesai)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Status Presensi</h2>
            </div>
            <div class="p-6 bg-green-50 border border-green-200 rounded-xl mb-6">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <h3 class="text-xl font-bold text-green-800 mb-1">Presensi Selesai!</h3>
                <p class="text-green-700 text-sm">Anda telah menyelesaikan presensi masuk dan pulang untuk hari ini.</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-5 text-left border border-slate-200 mb-5">
                <h4 class="font-semibold text-slate-700 mb-4 border-b pb-2">Detail Riwayat Hari Ini</h4>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-slate-500 text-sm">Jam Masuk</span>
                    <span class="font-bold text-slate-800 bg-white px-3 py-1 rounded border shadow-sm">{{ $presensiHariIni->jam_masuk }} WITA</span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-slate-500 text-sm">Jam Pulang</span>
                    <span class="font-bold text-slate-800 bg-white px-3 py-1 rounded border shadow-sm">{{ $presensiHariIni->jam_pulang }} WITA</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t mb-2">
                    <span class="text-slate-500 text-sm font-bold">Status Masuk</span>
                    <span class="font-black {{ $presensiHariIni->statusCi->name == 'Tepat Waktu' ? 'text-emerald-600' : ($presensiHariIni->statusCi->name == 'Terlambat' ? 'text-amber-500' : 'text-rose-600') }} bg-white px-3 py-1 rounded-lg border shadow-sm uppercase tracking-wider text-xs">
                        {{ $presensiHariIni->statusCi->name ?? 'Tidak Diketahui' }}
                    </span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t">
                    <span class="text-slate-500 text-sm font-bold">Status Pulang</span>
                    <span class="font-black {{ in_array($presensiHariIni->statusCo->name ?? '', ['Check Out', 'Tepat Waktu']) ? 'text-emerald-600' : 'text-rose-600' }} bg-white px-3 py-1 rounded-lg border shadow-sm uppercase tracking-wider text-xs">
                        {{ $presensiHariIni->statusCo->name ?? 'Belum CO' }}
                    </span>
                </div>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    @elseif($isWeekend)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Akhir Pekan</h2>
            </div>
            <div class="p-8 bg-slate-50 border border-slate-200 rounded-xl mb-6">
                <div class="w-20 h-20 bg-white text-slate-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none mb-3">Selamat Beristirahat</h3>
                <p class="text-slate-600 text-sm">Sistem presensi tidak diaktifkan pada hari Sabtu dan Minggu.</p>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    @elseif($belumBuka)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Belum Buka</h2>
            </div>
            <div class="p-8 bg-blue-50 border border-blue-200 rounded-xl mb-6">
                <div class="w-20 h-20 bg-white text-blue-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm border border-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3 class="text-xl font-black text-blue-800 tracking-tight leading-none mb-3">Sistem Belum Aktif</h3>
                <p class="text-blue-700 text-sm">Sistem presensi masuk baru akan dibuka pada pukul <b class="px-2 py-1 bg-white rounded shadow-sm text-blue-900">06:00 WITA</b>. Silakan kembali lagi nanti.</p>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    @elseif($hariLiburIni)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Libur Nasional</h2>
            </div>
            <div class="p-8 bg-rose-50 border border-rose-200 rounded-xl mb-6">
                <div class="w-20 h-20 bg-white text-rose-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm border border-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line><line x1="10" y1="14" x2="14" y2="18"></line><line x1="14" y1="14" x2="10" y2="18"></line></svg>
                </div>
                <h3 class="text-2xl font-black text-rose-800 tracking-tight leading-none mb-3">Sistem Ditutup</h3>
                <p class="text-rose-700 text-sm">Hari ini sistem presensi tidak diaktifkan karena sedang libur:</p>
                <div class="mt-4 px-4 py-2 bg-white rounded-lg border border-rose-100 shadow-sm inline-block">
                    <span class="text-rose-900 font-extrabold uppercase tracking-widest text-xs">{{ $hariLiburIni->nama_libur }}</span>
                </div>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    @elseif($lewatJamCo)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Sistem Ditutup</h2>
            </div>
            <div class="p-8 bg-rose-50 border border-rose-200 rounded-xl mb-6">
                <div class="w-20 h-20 bg-white text-rose-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm border border-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <h3 class="text-xl font-black text-rose-800 tracking-tight leading-none mb-3">Waktu Presensi Habis</h3>
                <p class="text-rose-700 text-sm">Waktu kerja hari ini telah berakhir dan Anda tidak melakukan presensi masuk dari pagi. Status Anda tercatat sebagai <span class="font-bold text-rose-900">Alpa</span>.</p>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    @elseif($belumWaktunyaPulang)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Menunggu Waktu</h2>
            </div>
            <div class="p-6 bg-blue-50 border border-blue-200 rounded-xl mb-6">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3 class="text-xl font-bold text-blue-800 mb-2">Belum Waktunya Pulang</h3>
                <p class="text-blue-700 text-sm">Anda sudah melakukan presensi masuk. Silakan kembali lagi pada pukul <b class="px-2 py-1 bg-white rounded shadow-sm text-blue-900">{{ $jadwalPulang }} WITA</b> untuk melakukan presensi pulang.</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-5 text-left border border-slate-200 mb-5 space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-slate-500 text-sm">Jam Masuk Anda:</span>
                    <span class="font-bold text-slate-800 bg-white px-3 py-1 rounded border shadow-sm">{{ $presensiHariIni->jam_masuk }} WITA</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500 text-sm">Status Masuk:</span>
                    <span class="font-black {{ $presensiHariIni->statusCi->name == 'Tepat Waktu' ? 'text-emerald-600' : ($presensiHariIni->statusCi->name == 'Terlambat' ? 'text-amber-500' : 'text-rose-600') }} bg-white px-3 py-1 rounded border shadow-sm uppercase tracking-wider text-xs">
                        {{ $presensiHariIni->statusCi->name ?? 'Tidak Diketahui' }}
                    </span>
                </div>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    @else
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">
                    {{ $presensiHariIni ? 'Presensi Pulang' : 'Presensi Masuk' }}
                </h2>

            </div>
            <div class="bg-maroon-950 p-5 rounded-3xl flex items-start gap-4 shadow-xl border border-white/5">

                <!-- Icon -->
                <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center shrink-0 border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-white">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>

                <!-- Content -->
                <div>
                    <h3 class="text-[#e8b57d] font-semibold text-sm mb-2">
                        Petunjuk Presensi
                    </h3>

                    <ul class="text-slate-300 text-xs space-y-2">
                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 bg-slate-400 rounded-full shrink-0"></span>
                            <span>Izinkan akses kamera dan lokasi (GPS).</span>
                        </li>

                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 bg-slate-400 rounded-full shrink-0"></span>
                            <span class="text-left leading-relaxed">
                                Pastikan jarak anda pada Gedung Jurusan Teknik Elektro masih dalam radius 50 meter.
                            </span>
                        </li>

                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 bg-slate-400 rounded-full shrink-0"></span>
                            <span>Pastikan wajah terlihat jelas tanpa masker.</span>
                        </li>

                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 bg-slate-400 rounded-full shrink-0"></span>
                            <span>Ikuti instruksi gerakan yang muncul di layar.</span>
                        </li>

                        <li class="flex items-start gap-2">
                            <span class="mt-1.5 w-1.5 h-1.5 bg-rose-400 rounded-full shrink-0"></span>
                            <span class="text-rose-200">Jangan menutup halaman sebelum proses selesai.</span>
                        </li>
                    </ul>
                </div>

            </div> <br>
            <div id="status-global" class="status-badge bg-warning">Menginisialisasi GPS...</div>
            <div id="map"></div>
            <div id="kamera-container">
                <video id="video" autoplay playsinline muted></video>
                <canvas id="canvas"></canvas>
                <div id="oval-guide"></div>
                <div id="debug-info">Memuat Keamanan...</div>
                <div id="teks-panduan" class="instruksi">Menyiapkan Kamera...</div>
            </div>
            <div id="notif-berhasil" class="status-badge bg-success" style="display: none; margin-top: 20px;">
                🎉 Presensi Berhasil Disimpan!
            </div>


        </div>
    @endif
</div>


{{-- PASTIKAN SCRIPT AI DIBLOKIR JIKA ADA SALAH SATU KONDISI DI BAWAH INI --}}
@if(!$isNonaktif && !$presensiGantung && !$presensiSelesai && !$belumWaktunyaPulang && !$hariLiburIni && !$isWeekend && !$belumBuka && !$lewatJamCo && !($lewatBatasMasuk ?? false))
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script type="module">
    import { FaceLandmarker, ObjectDetector, FilesetResolver, DrawingUtils } from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3";

    const KORDINAT_TARGET = [-3.296868, 114.581400];
    const RADIUS_AMAN = 2000;

    let userLat = 0; let userLng = 0;
    let faceLandmarker, objectDetector, drawingUtils;
    const video = document.getElementById("video");
    const canvasElement = document.getElementById("canvas");
    const canvasCtx = canvasElement.getContext("2d");
    const panduan = document.getElementById("teks-panduan");
    const ovalGuide = document.getElementById("oval-guide");
    const debugInfo = document.getElementById("debug-info");

    const map = L.map('map').setView(KORDINAT_TARGET, 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    const areaKantor = L.circle(KORDINAT_TARGET, { radius: RADIUS_AMAN, color: '#10b981', fillColor: '#10b981', fillOpacity: 0.2 }).addTo(map);

    // ini kalau mau ad titiknya
    const markerKantor = L.marker(KORDINAT_TARGET).addTo(map);
    markerKantor.bindPopup("🏢 <b>Titik Pusat Kantor</b>");

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((pos) => {
            userLat = pos.coords.latitude;
            userLng = pos.coords.longitude;
            const userPos = L.latLng(userLat, userLng);

            const markerUser = L.marker(userPos).addTo(map);
            markerUser.bindPopup("📍 <b>Posisi Kamu</b>").openPopup();
            const group = new L.featureGroup([areaKantor, markerUser]);
            map.fitBounds(group.getBounds(), { padding: [20, 20] });

            if (L.latLng(KORDINAT_TARGET).distanceTo(userPos) <= RADIUS_AMAN) {
                document.getElementById('status-global').innerText = "Lokasi Sesuai. Memuat AI...";
                document.getElementById('status-global').className = "status-badge bg-success";
                mulaiSistemAI();
            } else {
                document.getElementById('status-global').innerText = "Di Luar Jangkauan Kantor!";
                document.getElementById('status-global').className = "status-badge bg-danger";
            }
        }, () => {
            alert("Izinkan akses lokasi GPS.");
            document.getElementById('status-global').innerText = "Gagal Mendapatkan GPS!";
            document.getElementById('status-global').className = "status-badge bg-danger";
        }, { enableHighAccuracy: true });
    } else {
        alert("Browser kamu tidak mendukung fitur GPS.");
    }

    async function mulaiSistemAI() {
        document.getElementById('kamera-container').style.display = "block";
        try {
            panduan.innerText = "Meminta izin kamera...";
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: "user", width: 640, height: 480 } });
            video.srcObject = stream;
            video.play();

            panduan.innerText = "Kamera aktif. Memuat file AI...";
            const vision = await FilesetResolver.forVisionTasks("https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3/wasm");

            objectDetector = await ObjectDetector.createFromOptions(vision, {
                baseOptions: { modelAssetPath: "https://storage.googleapis.com/mediapipe-models/object_detector/efficientdet_lite0/float16/1/efficientdet_lite0.tflite", delegate: "CPU" },
                scoreThreshold: 0.3, runningMode: "VIDEO"
            });

            faceLandmarker = await FaceLandmarker.createFromOptions(vision, {
                baseOptions: { modelAssetPath: "https://storage.googleapis.com/mediapipe-models/face_landmarker/face_landmarker/float16/1/face_landmarker.task", delegate: "CPU" },
                runningMode: "VIDEO", numFaces: 1
            });

            drawingUtils = new DrawingUtils(canvasCtx);
            if (video.readyState >= 2) jalankanLoopDeteksi();
            else video.addEventListener("loadeddata", jalankanLoopDeteksi);
        } catch (error) {
            panduan.innerText = "❌ Gagal memuat AI."; panduan.style.background = "red";
        }
    }

    let isDone = false; let lastTime = -1; let lastCheckTime = 0;
    let modeSistem = "KALIBRASI"; let sampelMata = [];
    let batasKedipPersonal = 0; let masaHukumanSampai = 0;

    async function jalankanLoopDeteksi() {
        if (isDone) return;
        const now = performance.now();
        if (now - lastCheckTime < 150) { requestAnimationFrame(jalankanLoopDeteksi); return; }
        lastCheckTime = now;

        if (lastTime !== video.currentTime) {
            lastTime = video.currentTime;
            canvasElement.width = video.videoWidth; canvasElement.height = video.videoHeight;
            canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);

            const objRes = objectDetector.detectForVideo(video, now);
            let adaHP = false; const bendaTerlarang = ["cell phone"];

            for (const deteksi of objRes.detections) {
                if (bendaTerlarang.includes(deteksi.categories[0].categoryName)) {
                    adaHP = true; const b = deteksi.boundingBox;
                    canvasCtx.strokeStyle = "#ff0000"; canvasCtx.lineWidth = 3;
                    canvasCtx.strokeRect(b.originX, b.originY, b.width, b.height);
                }
            }

            if (adaHP) masaHukumanSampai = now + 3000;

            if (now < masaHukumanSampai) {
                panduan.innerText = "🚫 OBJEK TERLARANG!"; panduan.style.background = "rgba(220, 38, 38, 0.9)";
                ovalGuide.style.borderColor = "red"; modeSistem = "KALIBRASI"; sampelMata = [];
                debugInfo.innerHTML = `<span style="color:red; font-weight:bold;">SISTEM TERKUNCI</span>`;
            } else {
                const faceRes = faceLandmarker.detectForVideo(video, now);
                if (faceRes.faceLandmarks && faceRes.faceLandmarks.length > 0) {
                    const landmarks = faceRes.faceLandmarks[0];
                    drawingUtils.drawConnectors(landmarks, FaceLandmarker.FACE_LANDMARKS_TESSELATION, { color: "rgba(110, 231, 183, 0.15)", lineWidth: 0.5 });
                    drawingUtils.drawConnectors(landmarks, FaceLandmarker.FACE_LANDMARKS_LEFT_EYE, { color: "rgba(16, 185, 129, 0.8)", lineWidth: 1.5 });
                    drawingUtils.drawConnectors(landmarks, FaceLandmarker.FACE_LANDMARKS_RIGHT_EYE, { color: "rgba(16, 185, 129, 0.8)", lineWidth: 1.5 });

                    const faceWidth = Math.abs(landmarks[454].x - landmarks[234].x);
                    if (faceWidth > 0.35) {
                        panduan.innerText = "MUNDUR! Wajah terlalu dekat"; panduan.style.background = "#ef4444";
                        modeSistem = "KALIBRASI"; sampelMata = [];
                    } else if (faceWidth < 0.15) {
                        panduan.innerText = "Terlalu jauh, maju sedikit"; panduan.style.background = "#eab308";
                        modeSistem = "KALIBRASI"; sampelMata = [];
                    } else {
                        ovalGuide.style.borderColor = "green";
                        const curEAR = (Math.abs(landmarks[159].y - landmarks[145].y) + Math.abs(landmarks[386].y - landmarks[374].y)) / 2;
                        debugInfo.innerHTML = `Keamanan: <span style="color:green">Aman</span><br>Mode: <b>${modeSistem}</b><br>Mata: ${curEAR.toFixed(4)}`;

                        if (modeSistem === "KALIBRASI") {
                            panduan.innerText = "Tatap layar... (Kalibrasi)"; panduan.style.background = "#3b82f6";
                            sampelMata.push(curEAR);
                            if (sampelMata.length >= 8) {
                                batasKedipPersonal = (sampelMata.reduce((a, b) => a + b, 0) / sampelMata.length) * 0.55;
                                modeSistem = "PRESENSI";
                            }
                        } else if (modeSistem === "PRESENSI") {
                            panduan.innerText = "✅ Siap! Silakan Berkedip"; panduan.style.background = "#22c55e";
                            if (curEAR < batasKedipPersonal) {
                                isDone = true; verifikasiSukses();
                            }
                        }
                    }
                } else {
                    panduan.innerText = "Wajah tidak terlihat"; panduan.style.background = "rgba(0,0,0,0.8)";
                    modeSistem = "KALIBRASI"; sampelMata = []; ovalGuide.style.borderColor = "yellow";
                }
            }
        }
        requestAnimationFrame(jalankanLoopDeteksi);
    }

    function verifikasiSukses() {
        setTimeout(() => {
            const snapCanvas = document.createElement('canvas');
            snapCanvas.width = video.videoWidth; snapCanvas.height = video.videoHeight;
            const snapCtx = snapCanvas.getContext('2d');
            snapCtx.translate(snapCanvas.width, 0); snapCtx.scale(-1, 1);
            snapCtx.drawImage(video, 0, 0, snapCanvas.width, snapCanvas.height);
            const fotoBase64 = snapCanvas.toDataURL('image/jpeg', 0.8);

            video.srcObject.getTracks().forEach(t => t.stop());
            document.getElementById('kamera-container').style.display = "none";
            document.getElementById('status-global').innerText = "Menyimpan ke Database...";
            document.getElementById('status-global').style.display = "block";

            fetch('/presensi-submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'ngrok-skip-browser-warning': 'true'
                },
                body: JSON.stringify({ image_base64: fotoBase64, latitude: userLat, longitude: userLng })
            })
            .then(async response => {
                if (!response.ok) {
                    const errText = await response.text();
                    console.error("SERVER ERROR:", errText);
                    throw new Error("Server Laravel mengalami error.");
                }
                return response.json();
            })
            .then(data => {
                if(data.status === 'success') {
                    document.getElementById('status-global').style.display = "none";
                    const notif = document.getElementById('notif-berhasil');
                    notif.innerText = "🎉 " + data.message; notif.style.display = "block";
                    setTimeout(() => { window.location.href = data.redirect; }, 1500);
                } else {
                    alert("Gagal: " + data.message); location.reload();
                }
            })
            .catch(error => {
                alert("GAGAL MENGIRIM: " + error.message);
                document.getElementById('status-global').innerText = "Gagal memproses data.";
            });
        }, 500);
    }
</script>
@endif
@endsection
