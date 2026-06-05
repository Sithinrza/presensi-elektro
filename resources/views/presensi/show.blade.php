@extends($layout)

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

<main class="max-w-7xl mx-auto p-5 lg:p-10 space-y-8 animate-in">

    <div class="flex items-center justify-between border-b border-maroon-100/30 pb-4">
        <div class="flex items-center gap-4">
            <a href="{{ $backUrl }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-maroon-50 text-maroon-950 hover:bg-maroon-100 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <h1 class="text-lg font-extrabold text-maroon-950 tracking-tight leading-none uppercase italic hidden sm:block">Detail Aktivitas</h1>
        </div>
    </div>

    <section class="text-center md:text-left space-y-2">
        <p class="text-slate-400 font-bold uppercase tracking-[0.3em] text-[10px]">Laporan Presensi Tanggal</p>
        <h2 class="text-4xl font-black text-maroon-950 italic tracking-tight">{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('l, d F Y') }}</h2>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <section class="space-y-6 bg-white p-8 rounded-[3rem] border border-maroon-50 shadow-sm flex flex-col">
            <div class="flex items-start justify-between border-b border-slate-50 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-maroon-950 italic uppercase leading-none">Sesi Masuk</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Check-in: {{ $presensi->jam_masuk ?? '--:--:--' }} WITA</p>
                    </div>
                </div>
                @php
                    $ciName = $presensi->statusCi ? $presensi->statusCi->name : 'Alfa';
                    $colorCi = $ciName === 'Tepat Waktu' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($ciName === 'Terlambat' ? 'bg-amber-50 text-amber-600 border-amber-200' : 'bg-rose-50 text-rose-600 border-rose-200');
                @endphp
                <span class="inline-flex items-center px-3 py-1.5 {{ $colorCi }} border rounded-lg text-[9px] font-black uppercase tracking-widest text-center">
                    {{ $ciName }}
                </span>
            </div>

            <div class="flex flex-col md:flex-row gap-6 items-start h-full w-full">
                <div class="w-full md:w-44 shrink-0">
                    <div class="group relative aspect-[3/4] rounded-[2rem] overflow-hidden border-4 border-white shadow-lg bg-slate-100">
                        @if($presensi->foto_masuk)
                            <img src="{{ asset('storage/presensi/' . $presensi->foto_masuk) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex-1 space-y-3 w-full h-full flex flex-col justify-between">
                    <div class="space-y-3 flex-1 flex flex-col">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-maroon-7700 shrink-0"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span class="text-[10px] font-black text-maroon-950 uppercase tracking-widest">Peta Lokasi Tap-In</span>
                        </div>
                        @if($presensi->latitude_masuk && $presensi->longitude_masuk)
                            <div id="mapMasuk" class="w-full h-44 bg-slate-100 rounded-2xl border border-slate-200 overflow-hidden shadow-inner"></div>
                        @else
                            <div class="w-full h-44 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><line x1="4" y1="4" x2="20" y2="20"/></svg>
                                <span class="text-[9px] font-bold uppercase tracking-widest">Lokasi Tidak Terekam</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col gap-1 text-[9px] font-mono font-bold text-slate-400 uppercase tracking-widest bg-slate-50 p-4 rounded-2xl border border-slate-100 w-full mt-2">
                        <span>LAT: {{ $presensi->latitude_masuk ?? '-' }}</span>
                        <span>LNG: {{ $presensi->longitude_masuk ?? '-' }}</span>
                        <span class="{{ $presensi->latitude_masuk ? 'text-emerald-500' : 'text-slate-400' }} mt-1">STATUS: {{ $presensi->latitude_masuk ? 'VALID (INSIDE GEOFENCE)' : '-' }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-6 bg-white p-8 rounded-[3rem] border border-maroon-50 shadow-sm flex flex-col">
            <div class="flex items-start justify-between border-b border-slate-50 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-maroon-950 italic uppercase leading-none">Sesi Pulang</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                            Check-out: {{ $presensi->jam_pulang ? $presensi->jam_pulang . ' WITA' : '--:--:--' }}
                        </p>
                    </div>
                </div>
                @php
                    $coName = $presensi->statusCo ? $presensi->statusCo->name : 'Belum CO';
                    $colorCo = $coName === 'Tepat Waktu' || $coName === 'Check Out' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($coName === 'Belum CO' ? 'bg-slate-50 text-slate-500 border-slate-200' : 'bg-rose-50 text-rose-600 border-rose-200');
                @endphp
                <span class="inline-flex items-center px-3 py-1.5 {{ $colorCo }} border rounded-lg text-[9px] font-black uppercase tracking-widest text-center">
                    {{ $coName }}
                </span>
            </div>

            @if($presensi->jam_pulang)
                <div class="flex flex-col md:flex-row gap-6 items-start h-full w-full">
                    <div class="w-full md:w-44 shrink-0">
                        <div class="group relative aspect-[3/4] rounded-[2rem] overflow-hidden border-4 border-white shadow-lg bg-slate-100">
                            @if($presensi->foto_pulang)
                                <img src="{{ asset('storage/presensi/' . $presensi->foto_pulang) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 space-y-3 w-full h-full flex flex-col justify-between">
                        <div class="space-y-3 flex-1 flex flex-col">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-maroon-700 shrink-0"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span class="text-[10px] font-black text-maroon-950 uppercase tracking-widest">Peta Lokasi Tap-Out</span>
                            </div>
                            @if($presensi->latitude_pulang && $presensi->longitude_pulang)
                                <div id="mapPulang" class="w-full h-44 bg-slate-100 rounded-2xl border border-slate-200 overflow-hidden shadow-inner"></div>
                            @else
                                <div class="w-full h-44 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><line x1="4" y1="4" x2="20" y2="20"/></svg>
                                    <span class="text-[9px] font-bold uppercase tracking-widest">Lokasi Tidak Terekam</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-1 text-[9px] font-mono font-bold text-slate-400 uppercase tracking-widest bg-slate-50 p-4 rounded-2xl border border-slate-100 w-full mt-2">
                            <span>LAT: {{ $presensi->latitude_pulang ?? '-' }}</span>
                            <span>LNG: {{ $presensi->longitude_pulang ?? '-' }}</span>
                            <span class="text-emerald-500 mt-1">STATUS: VALID (INSIDE GEOFENCE)</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="h-full min-h-[14rem] flex flex-col items-center justify-center text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200 p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300 mb-3"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <p class="text-sm font-black text-slate-500">Belum Presensi Pulang</p>
                    <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Data checkout akan muncul di sini</p>
                </div>
            @endif
        </section>
    </div>

</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // --- PENGATURAN KANTOR PUSAT ---
        const officeLat = -3.2759542;
        const officeLng = 114.5969156;
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
