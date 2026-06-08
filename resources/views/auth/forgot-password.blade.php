<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIPETANG</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-[#5B1D2A] mb-2">SIPETANG</h1>
            <h2 class="text-xl font-bold text-slate-800">Ubah Password</h2>
            <p class="text-slate-500 text-sm mt-2">Masukkan email Anda yang terdaftar. Kami akan mengirimkan 6 digit kode OTP untuk mereset password Anda.</p>
        </div>

        @if (session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-semibold mb-6 border border-red-100">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] transition" placeholder="contoh: email@domain.com">
                @error('email')
                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#5B1D2A] text-white font-bold py-3.5 rounded-xl hover:bg-[#6D2433] transition shadow-lg">
                Kirim Kode OTP
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/login" class="text-sm font-bold text-slate-500 hover:text-[#5B1D2A] transition">Kembali ke halaman Login</a>
        </div>
    </div>

</body>
</html>
