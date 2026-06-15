<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SIPETANG</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-100">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Cek Email Anda</h2>
            <p class="text-slate-500 text-sm mt-2">Kami telah mengirimkan 6 digit kode OTP ke email <b class="text-slate-700">{{ session('reset_email') }}</b>.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm font-semibold mb-6 border border-green-100 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('password.otp.submit') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2 text-center">Masukkan 6 Digit OTP</label>
                <input type="text" name="otp" required maxlength="6" class="w-full px-4 py-4 text-center text-3xl font-black tracking-[0.5em] rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] transition" placeholder="••••••">
                @error('otp')
                    <p class="text-red-500 text-xs font-bold mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#5B1D2A] text-white font-bold py-3.5 rounded-xl hover:bg-[#6D2433] transition shadow-lg">
                Verifikasi OTP
            </button>
        </form>
    </div>

</body>
</html>
