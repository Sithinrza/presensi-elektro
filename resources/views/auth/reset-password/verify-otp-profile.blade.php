<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keamanan Profil - Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-100 relative">

        <a href="{{ url()->previous() }}" class="absolute top-6 left-6 w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-600 rounded-full transition-colors active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>

        <div class="text-center mb-8 mt-2">
            <div class="w-16 h-16 bg-[#5B1D2A]/10 text-[#5B1D2A] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Verifikasi Keamanan</h2>
            <p class="text-slate-500 text-sm mt-2">Untuk memastikan ini benar Anda, kami telah mengirimkan OTP ke email <b class="text-slate-700">{{ Auth::user()->email }}</b>.</p>
        </div>

        @if (session('success'))
            <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl text-sm font-bold mb-6 border border-emerald-100 text-center shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.password.verify.submit') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2 text-center">Masukkan 6 Digit OTP</label>
                <input type="text" name="otp" required maxlength="6" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-4 text-center text-3xl font-black tracking-[0.5em] rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] outline-none transition" placeholder="••••••">
                @error('otp')
                    <p class="text-rose-500 text-xs font-bold mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-3">
                <button type="submit" class="w-full bg-[#5B1D2A] text-white font-bold tracking-widest uppercase text-xs py-4 rounded-xl hover:bg-[#4d182b] transition shadow-lg shadow-[#5B1D2A]/20 active:scale-95">
                    Verifikasi Identitas
                </button>

                <a href="{{ url()->previous() }}" class="block w-full text-center text-slate-400 hover:text-slate-600 text-xs font-bold tracking-widest uppercase py-2 transition-colors">
                    Batal & Kembali
                </a>
            </div>
        </form>
    </div>
</body>
</html>
