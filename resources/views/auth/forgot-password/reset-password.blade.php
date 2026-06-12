<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - SIPETANG</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-100">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-black text-slate-800">Buat Password Baru</h2>
            <p class="text-slate-500 text-sm mt-2">Kode OTP tervalidasi! Silakan masukkan password baru Anda yang kuat dan mudah diingat.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] transition" placeholder="Minimal 6 karakter">
                @error('password')
                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] transition" placeholder="Ketik ulang password baru">
            </div>

            <button type="submit" class="w-full bg-[#5B1D2A] text-white font-bold py-3.5 rounded-xl hover:bg-[#6D2433] transition shadow-lg">
                Simpan Password Baru
            </button>
        </form>
    </div>

</body>
</html>
