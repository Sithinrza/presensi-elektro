<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SIPETANG</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-100 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-green-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="text-center mb-8 relative z-10">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-green-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Cek Email Anda</h2>
            <p class="text-slate-500 text-sm mt-2 font-medium">Kami telah mengirimkan 6 digit kode OTP ke email <br><b class="text-slate-800">{{ session('reset_email') }}</b></p>
        </div>

        @if (session('success'))
            <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm font-bold mb-6 border border-green-100 text-center shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->has('otp'))
            <div class="bg-rose-50 text-rose-600 p-4 rounded-xl text-sm font-bold mb-6 border border-rose-100 text-center shadow-sm">
                {{ $errors->first('otp') }}
            </div>
        @endif

        <form action="{{ route('password.otp.submit') }}" method="POST" class="relative z-10">
            @csrf
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 text-center">Masukkan 6 Digit OTP</label>
                <input type="text" name="otp" required maxlength="6" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-4 text-center text-3xl font-black tracking-[0.5em] rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] transition bg-slate-50 shadow-inner" placeholder="••••••">
            </div>

            <div class="flex flex-col items-center justify-center gap-2 mb-6">
                <p class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                    Sisa waktu: <span id="timer" class="text-rose-600 font-black font-mono">15:00</span>
                </p>
            </div>

            <button type="submit" class="w-full bg-[#5B1D2A] text-white font-black uppercase tracking-widest py-3.5 rounded-xl hover:bg-[#6D2433] active:scale-95 transition-all shadow-lg shadow-[#5B1D2A]/30">
                Verifikasi OTP
            </button>
        </form>

        <div class="mt-6 text-center text-xs font-medium text-slate-500 relative z-10 border-t border-slate-100 pt-5">
            Tidak menerima email?
            <form action="{{ route('password.otp.resend') }}" method="POST" class="inline m-0">
                @csrf
                <button type="submit" class="text-[#5B1D2A] font-bold hover:underline ml-1">Kirim Ulang</button>
            </form>
        </div>
    </div>

    <script>
        // Tanggal OTP dibuat dari Controller (di-parsing via Carbon)
        const createdAt = new Date("{{ $createdAt->format('Y-m-d H:i:s') }}").getTime();
        // Waktu expired = Waktu Dibuat + 15 Menit (900.000 ms)
        const expireTime = createdAt + (15 * 60 * 1000);

        const timerElement = document.getElementById("timer");

        const countdown = setInterval(function() {
            // Kita pakai Date.now() browser, asumsi jam server dan client kurang lebih sama
            const now = new Date().getTime();
            const distance = expireTime - now;

            if (distance < 0) {
                clearInterval(countdown);
                timerElement.innerHTML = "KEDALUWARSA";
                timerElement.classList.replace("text-rose-600", "text-slate-400");
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Format ke 00:00
            const mText = minutes < 10 ? "0" + minutes : minutes;
            const sText = seconds < 10 ? "0" + seconds : seconds;

            timerElement.innerHTML = mText + ":" + sText;
        }, 1000);
    </script>
</body>
</html>
