<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keamanan Profil - Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-100 relative overflow-hidden">

        <!-- Background glow -->
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#5B1D2A]/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="absolute top-6 left-6 w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-600 rounded-full transition-colors active:scale-95 z-20">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>

        <!-- Header -->
        <div class="text-center mb-8 mt-6 relative z-10">
            <div class="w-16 h-16 bg-[#5B1D2A]/10 text-[#5B1D2A] rounded-full flex items-center justify-center mx-auto mb-4 border border-[#5B1D2A]/20 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Verifikasi Keamanan</h2>
            <p class="text-slate-500 text-sm mt-2 font-medium">Kami telah mengirimkan 6 digit OTP ke email <br><b class="text-slate-700">{{ Auth::user()->email }}</b></p>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl text-sm font-bold mb-6 border border-emerald-100 text-center shadow-sm relative z-10">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->has('otp'))
            <div class="bg-rose-50 text-rose-600 p-4 rounded-xl text-sm font-bold mb-6 border border-rose-100 text-center shadow-sm relative z-10">
                {{ $errors->first('otp') }}
            </div>
        @endif

        <!-- Form Verifikasi -->
        <form action="{{ route('profile.password.verify.submit') }}" method="POST" class="relative z-10" id="otp_form">
            @csrf
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 text-center">Masukkan 6 Digit OTP</label>
                <input type="text" name="otp" id="otp_input" required maxlength="6" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-4 text-center text-3xl font-black tracking-[0.5em] rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] outline-none transition bg-slate-50 shadow-inner" placeholder="••••••">
            </div>

            <div class="flex flex-col items-center justify-center gap-2 mb-6">
                <p class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                    Sisa waktu: <span id="timer" class="text-rose-600 font-black font-mono">15:00</span>
                </p>
            </div>

            <button type="submit" id="btn_verify" class="w-full bg-[#5B1D2A] text-white font-black uppercase tracking-widest py-3.5 rounded-xl hover:bg-[#6D2433] active:scale-95 transition-all shadow-lg shadow-[#5B1D2A]/30">
                Verifikasi OTP
            </button>
        </form>

        <!-- Form Kirim Ulang -->
        <div class="mt-6 text-center text-xs font-medium text-slate-500 relative z-10 border-t border-slate-100 pt-5">
            Tidak menerima email atau kode kedaluwarsa?
            <form action="{{ route('profile.password.resend') }}" method="POST" class="inline m-0">
                @csrf
                <button type="submit" id="btn_resend" class="text-[#5B1D2A] font-bold hover:underline ml-1 transition-colors">Kirim Ulang</button>
            </form>
        </div>
    </div>

<script>
    const expireTime = ({{ $createdAt->timestamp }} * 1000) + (15 * 60 * 1000);
    const timerElement = document.getElementById("timer");
    const otpInput = document.getElementById("otp_input");
    const btnVerify = document.getElementById("btn_verify");
    const btnResend = document.getElementById("btn_resend");
    const otpForm = document.getElementById("otp_form");

    let isExpired = false;

    otpForm.addEventListener("submit", function(e) {
        if (isExpired) {
            e.preventDefault();
            alert("Waktu habis! Silakan klik tombol Kirim Ulang.");
        }
    });

    const countdown = setInterval(function() {
        const now = new Date().getTime();
        const distance = expireTime - now;

        if (distance < 0) {
            clearInterval(countdown);
            isExpired = true;

            timerElement.innerHTML = "KEDALUWARSA";
            timerElement.classList.replace("text-rose-600", "text-slate-400");

            otpInput.disabled = true;
            otpInput.classList.add("opacity-50", "cursor-not-allowed");

            btnVerify.disabled = true;
            btnVerify.classList.replace("bg-[#5B1D2A]", "bg-slate-400");
            btnVerify.classList.replace("hover:bg-[#6D2433]", "hover:bg-slate-400");
            btnVerify.classList.add("cursor-not-allowed", "shadow-none");
            btnVerify.innerHTML = "KODE KEDALUWARSA";

            // Highlight tombol kirim ulang
            btnResend.classList.add("text-rose-600", "underline");

            return;
        }

        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const mText = minutes < 10 ? "0" + minutes : minutes;
        const sText = seconds < 10 ? "0" + seconds : seconds;

        timerElement.innerHTML = mText + ":" + sText;
    }, 1000);
</script>
</body>
</html>
