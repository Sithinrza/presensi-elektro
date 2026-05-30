@extends($layout)

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

    @if($presensiSelesai)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/xl" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Status Presensi</h2>
            </div>
            <div class="p-6 bg-green-50 border border-green-200 rounded-xl mb-6">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/xl" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
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
                    <span class="font-black {{ $presensiHariIni->statusCo->name == 'Tepat Waktu' ? 'text-emerald-600' : 'text-rose-600' }} bg-white px-3 py-1 rounded-lg border shadow-sm uppercase tracking-wider text-xs">
                        {{ $presensiHariIni->statusCo->name ?? 'Belum CO' }}
                    </span>
                </div>
            </div>
            <a href="{{ $url_dashboard }}" class="block w-full py-3.5 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-900 transition shadow-lg">Kembali ke Dashboard</a>
        </div>

    @elseif($belumWaktunyaPulang)
        <div class="card-presensi animate-in">
            <div class="flex items-center gap-4 mb-5">
                <a href="{{ $url_dashboard }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-maroon-100 active:scale-90 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/xl" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">Menunggu Waktu</h2>
            </div>
            <div class="p-6 bg-blue-50 border border-blue-200 rounded-xl mb-6">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/xl" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
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
                    <svg xmlns="http://www.w3.org/2000/xl" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h2 style="margin: 0; color: #1e293b; font-size: 1.5rem; font-weight: bold;">
                    {{ $presensiHariIni ? 'Presensi Pulang' : 'Presensi Masuk' }}
                </h2>
            </div>
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

@if(!$presensiSelesai && !$belumWaktunyaPulang)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script type="module">
    import { FaceLandmarker, ObjectDetector, FilesetResolver, DrawingUtils } from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3";

    const KORDINAT_TARGET = [-3.2760497, 114.5935089];
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

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((pos) => {
            userLat = pos.coords.latitude; userLng = pos.coords.longitude;
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
            const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user", width: 640, height: 480 } });
            video.srcObject = stream; video.play();

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
            let adaHP = false; const bendaTerlarang = ["cell phone", "laptop", "tv", "monitor"];

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
                                modeSistem = "ABSEN";
                            }
                        } else if (modeSistem === "ABSEN") {
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

            // PERBAIKAN UTAMA: Menggunakan Relative Path & Header Ngrok khusus
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
