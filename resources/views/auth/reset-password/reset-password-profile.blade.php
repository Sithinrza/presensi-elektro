<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-xl border border-slate-100">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-black text-slate-800">Ubah Password Keamanan</h2>
            <p class="text-slate-500 text-sm mt-2">Identitas terverifikasi. Silakan masukkan password baru Anda.</p>
        </div>

        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                <div class="relative">
                    <input id="password-input" type="password" name="password" required class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] transition outline-none" placeholder="Minimal 6 karakter">

                    <button type="button" onclick="togglePassword('password-input', 'eye-icon')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#5B1D2A] transition-colors focus:outline-none">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-[18px] h-[18px]"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>

                @error('password')
                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input id="password-confirm-input" type="password" name="password_confirmation" required class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] transition outline-none" placeholder="Ketik ulang password baru">

                    <button type="button" onclick="togglePassword('password-confirm-input', 'eye-icon-confirm')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#5B1D2A] transition-colors focus:outline-none">
                        <svg id="eye-icon-confirm" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-[18px] h-[18px]"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#5B1D2A] text-white font-bold py-3.5 rounded-xl tracking-widest uppercase text-xs hover:bg-[#6D2433] transition shadow-lg shadow-[#5B1D2A]/20 active:scale-95">
                Simpan & Kembali ke Dashboard
            </button>
        </form>
    </div>

    <script>
        // Fungsi diubah dengan menambahkan parameter agar bisa dipakai di kedua kolom
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>
</body>
</html>
