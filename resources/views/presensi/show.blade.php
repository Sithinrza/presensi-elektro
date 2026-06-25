@extends($layout)
@section('page_title', 'Detail Presensi')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    .animate-in { animation: fadeIn 0.6s ease-out forwards; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .leaflet-container { z-index: 10 !important; font-family: inherit; }
</style>

<main class="max-w-7xl mx-auto p-4 sm:p-5 lg:p-10 space-y-6 lg:space-y-8 animate-in">

    <div class="flex items-center justify-between border-b border-maroon-100/30 pb-3 sm:pb-4">
        <div class="flex items-center gap-3 sm:gap-4">
            <a href="{{ $backUrl }}" class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-lg sm:rounded-xl bg-maroon-50 text-maroon-950 hover:bg-maroon-100 transition-colors shadow-sm shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <h1 class="text-base sm:text-lg font-extrabold text-maroon-950 tracking-tight leading-none uppercase italic">Detail Presensi</h1>
        </div>
    </div>

    <section class="text-left space-y-1 sm:space-y-2">
        <p class="text-slate-400 font-bold uppercase tracking-[0.2em] sm:tracking-[0.3em] text-[9px] sm:text-[10px]">Laporan Presensi Tanggal</p>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-maroon-950 italic tracking-tight">{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('l, d F Y') }}</h2>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-8">

        <section class="space-y-4 sm:space-y-6 bg-white p-5 sm:p-6 lg:p-8 rounded-3xl lg:rounded-[3rem] border border-maroon-50 shadow-sm flex flex-col">
            <div class="flex items-start justify-between border-b border-slate-50 pb-3 sm:pb-4">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-100 text-emerald-600 rounded-lg sm:rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><path d="m9 18 6-6-6-6"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-black text-maroon-950 italic uppercase leading-none">Sesi Masuk</h3>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5 sm:mt-1">Check-in: {{ $presensi->jam_masuk ?? '--:--:--' }} WITA</p>
                    </div>
                </div>
                @php
                    $ciName = $presensi->statusCi ? $presensi->statusCi->name : 'Alpa';
                    $colorCi = $ciName === 'Tepat Waktu' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($ciName === 'Terlambat' ? 'bg-amber-50 text-amber-600 border-amber-200' : 'bg-rose-50 text-rose-600 border-rose-200');
                @endphp
                <span class="inline-flex items-center px-2.5 py-1 sm:px-3 sm:py-1.5 {{ $colorCi }} border rounded-md sm:rounded-lg text-[8px] sm:text-[9px] font-black uppercase tracking-widest text-center">
                    {{ $ciName }}
                </span>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start h-full w-full">
                <div class="w-1/2 sm:w-32 md:w-44 shrink-0 mx-auto sm:mx-0">
                    <div class="group relative aspect-[3/4] rounded-2xl sm:rounded-[2rem] overflow-hidden border-4 border-white shadow-lg bg-slate-100">
                        @if($presensi->foto_masuk)
                            <img src="{{ asset('storage/presensi/' . $presensi->foto_masuk) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="sm:w-10 sm:h-10"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex-1 space-y-2.5 sm:space-y-3 w-full h-full flex flex-col justify-between">
                    <div class="space-y-2 sm:space-y-3 flex-1 flex flex-col">
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-maroon-700 shrink-0 sm:w-3.5 sm:h-3.5"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span class="text-[9px] sm:text-[10px] font-black text-maroon-950 uppercase tracking-widest">Peta Lokasi Tap-In</span>
                        </div>
                        @if($presensi->latitude_masuk && $presensi->longitude_masuk)
                            <div id="mapMasuk" class="w-full h-32 sm:h-40 md:h-44 bg-slate-100 rounded-xl sm:rounded-2xl border border-slate-200 overflow-hidden shadow-inner"></div>
                        @else
                            <div class="w-full h-32 sm:h-40 md:h-44 bg-slate-50 border border-dashed border-slate-200 rounded-xl sm:rounded-2xl flex flex-col items-center justify-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1.5 sm:mb-2 sm:w-6 sm:h-6"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><line x1="4" y1="4" x2="20" y2="20"/></svg>
                                <span class="text-[8px] sm:text-[9px] font-bold uppercase tracking-widest">Lokasi Tidak Terekam</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col gap-0.5 sm:gap-1 text-[8px] sm:text-[9px] font-mono font-bold text-slate-400 uppercase tracking-widest bg-slate-50 p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-slate-100 w-full mt-2">
                        <span>LAT: {{ $presensi->latitude_masuk ?? '-' }}</span>
                        <span>LNG: {{ $presensi->longitude_masuk ?? '-' }}</span>
                        <span class="{{ $presensi->latitude_masuk ? 'text-emerald-500' : 'text-slate-400' }} mt-0.5 sm:mt-1">STATUS: {{ $presensi->latitude_masuk ? 'VALID (INSIDE GEOFENCE)' : '-' }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-4 sm:space-y-6 bg-white p-5 sm:p-6 lg:p-8 rounded-3xl lg:rounded-[3rem] border border-maroon-50 shadow-sm flex flex-col">
            <div class="flex items-start justify-between border-b border-slate-50 pb-3 sm:pb-4">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-rose-100 text-rose-600 rounded-lg sm:rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-5 sm:h-5"><path d="m15 18-6-6 6-6"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-black text-maroon-950 italic uppercase leading-none">Sesi Pulang</h3>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5 sm:mt-1">
                            Check-out: {{ $presensi->jam_pulang ? $presensi->jam_pulang . ' WITA' : '--:--:--' }}
                        </p>
                    </div>
                </div>
                @php
                    $coName = $presensi->statusCo ? $presensi->statusCo->name : 'Belum CO';
                    $colorCo = $coName === 'Tepat Waktu' || $coName === 'Check Out' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($coName === 'Belum CO' ? 'bg-slate-50 text-slate-500 border-slate-200' : 'bg-rose-50 text-rose-600 border-rose-200');
                @endphp
                <span class="inline-flex items-center px-2.5 py-1 sm:px-3 sm:py-1.5 {{ $colorCo }} border rounded-md sm:rounded-lg text-[8px] sm:text-[9px] font-black uppercase tracking-widest text-center whitespace-nowrap">
                    {{ $coName }}
                </span>
            </div>

            @if($presensi->jam_pulang)
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start h-full w-full">
                    <div class="w-1/2 sm:w-32 md:w-44 shrink-0 mx-auto sm:mx-0">
                        <div class="group relative aspect-[3/4] rounded-2xl sm:rounded-[2rem] overflow-hidden border-4 border-white shadow-lg bg-slate-100">
                            @if($presensi->foto_pulang)
                                <img src="{{ asset('storage/presensi/' . $presensi->foto_pulang) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="sm:w-10 sm:h-10"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 space-y-2.5 sm:space-y-3 w-full h-full flex flex-col justify-between">
                        <div class="space-y-2 sm:space-y-3 flex-1 flex flex-col">
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-maroon-700 shrink-0 sm:w-3.5 sm:h-3.5"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span class="text-[9px] sm:text-[10px] font-black text-maroon-950 uppercase tracking-widest">Peta Lokasi Tap-Out</span>
                            </div>
                            @if($presensi->latitude_pulang && $presensi->longitude_pulang)
                                <div id="mapPulang" class="w-full h-32 sm:h-40 md:h-44 bg-slate-100 rounded-xl sm:rounded-2xl border border-slate-200 overflow-hidden shadow-inner"></div>
                            @else
                                <div class="w-full h-32 sm:h-40 md:h-44 bg-slate-50 border border-dashed border-slate-200 rounded-xl sm:rounded-2xl flex flex-col items-center justify-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1.5 sm:mb-2 sm:w-6 sm:h-6"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><line x1="4" y1="4" x2="20" y2="20"/></svg>
                                    <span class="text-[8px] sm:text-[9px] font-bold uppercase tracking-widest">Lokasi Tidak Terekam</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-0.5 sm:gap-1 text-[8px] sm:text-[9px] font-mono font-bold text-slate-400 uppercase tracking-widest bg-slate-50 p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-slate-100 w-full mt-2">
                            <span>LAT: {{ $presensi->latitude_pulang ?? '-' }}</span>
                            <span>LNG: {{ $presensi->longitude_pulang ?? '-' }}</span>
                            <span class="{{ $presensi->latitude_pulang ? 'text-emerald-500' : 'text-slate-400' }} mt-0.5 sm:mt-1">STATUS: {{ $presensi->latitude_pulang ? 'VALID (INSIDE GEOFENCE)' : '-' }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="h-full min-h-[12rem] sm:min-h-[14rem] flex flex-col items-center justify-center text-center bg-slate-50 rounded-2xl sm:rounded-3xl border border-dashed border-slate-200 p-5 sm:p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300 mb-2 sm:mb-3 sm:w-8 sm:h-8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <p class="text-xs sm:text-sm font-black text-slate-500">Belum Presensi Pulang</p>
                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Data checkout akan muncul di sini</p>
                </div>
            @endif
        </section>
    </div>
        @if(isset($presensi->alasan) && $presensi->alasan)
            <section class="mt-6 lg:mt-8 bg-amber-50 border border-amber-200 p-5 sm:p-6 lg:p-8 rounded-3xl lg:rounded-[3rem] shadow-sm flex flex-col sm:flex-row gap-4 sm:gap-5 items-start animate-in">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-amber-200 text-amber-700 rounded-xl sm:rounded-2xl flex items-center justify-center shrink-0 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-7 sm:h-7"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/></svg>
                </div>
                <div>
                    <h3 class="text-[10px] sm:text-xs font-black text-amber-900 uppercase tracking-widest mb-1.5 sm:mb-2">Keterangan / Alasan Lupa Check-Out</h3>
                    <p class="text-sm sm:text-base font-bold text-amber-800 leading-relaxed italic border-l-4 border-amber-400 pl-3 sm:pl-4">
                        "{{ $presensi->alasan }}"
                    </p>
                </div>
            </section>
            @endif

</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // --- PENGATURAN KANTOR PUSAT ---
        const officeLat = -3.296867;
        const officeLng = 114.5813285;
        const radiusAman = 50; // Radius batas aman dalam meter

        // Ikon Custom Titik Kantor & User
        const officeIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

        const userIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

        // 1. RENDER MAP MASUK
        const latMasuk = {{ $presensi->latitude_masuk ?? 'null' }};
        const lngMasuk = {{ $presensi->longitude_masuk ?? 'null' }};

        if (latMasuk !== null && lngMasuk !== null) {
            const mapMasuk = L.map('mapMasuk').setView([latMasuk, lngMasuk], 17);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapMasuk);

            // Lingkaran Bulat Geofence Area Kantor
            L.circle([officeLat, officeLng], {
                color: '#10b981', fillColor: '#10b981', fillOpacity: 0.15, radius: radiusAman
            }).addTo(mapMasuk);
            L.marker([officeLat, officeLng], {icon: officeIcon}).addTo(mapMasuk).bindPopup('Titik Pusat Kantor');

            // Titik Koordinat Tempat User Klik Presensi Masuk (CI)
            L.marker([latMasuk, lngMasuk], {icon: userIcon}).addTo(mapMasuk).bindPopup('Lokasi Kamu Tap-In').openPopup();
        }

        // 2. RENDER MAP PULANG
        const latPulang = {{ $presensi->latitude_pulang ?? 'null' }};
        const lngPulang = {{ $presensi->longitude_pulang ?? 'null' }};

        if (latPulang !== null && lngPulang !== null) {
            const mapPulang = L.map('mapPulang').setView([latPulang, lngPulang], 17);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapPulang);

            // Lingkaran Bulat Geofence Area Kantor
            L.circle([officeLat, officeLng], {
                color: '#10b981', fillColor: '#10b981', fillOpacity: 0.15, radius: radiusAman
            }).addTo(mapPulang);
            L.marker([officeLat, officeLng], {icon: officeIcon}).addTo(mapPulang).bindPopup('Titik Pusat Kantor');

            // Titik Koordinat Tempat User Klik Presensi Pulang (CO)
            L.marker([latPulang, lngPulang], {icon: userIcon}).addTo(mapPulang).bindPopup('Lokasi Kamu Tap-Out').openPopup();
        }

    });
</script>
@endsection
