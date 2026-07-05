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

            {{-- KOLOM PASSWORD BARU --}}
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] transition" placeholder="Minimal 6 karakter">

                    <button type="button" onclick="togglePassword('password', 'eye-open-1', 'eye-closed-1')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#5B1D2A] transition-colors focus:outline-none">
                        <svg id="eye-open-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg id="eye-closed-1" class="hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m2 2 20 20"></path><path d="M6.71 6.71A10 10 0 0 0 2 12s3 7 10 7a9.9 9.9 0 0 0 5.29-1.54"></path><path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path><path d="M17.85 17.85A10 10 0 0 0 22 12s-3-7-10-7a9.9 9.9 0 0 0-3.15.52"></path>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- KOLOM KONFIRMASI PASSWORD --}}
            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#5B1D2A] focus:border-[#5B1D2A] transition" placeholder="Ketik ulang password baru">

                    <button type="button" onclick="togglePassword('password_confirmation', 'eye-open-2', 'eye-closed-2')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#5B1D2A] transition-colors focus:outline-none">
                        <svg id="eye-open-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg id="eye-closed-2" class="hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m2 2 20 20"></path><path d="M6.71 6.71A10 10 0 0 0 2 12s3 7 10 7a9.9 9.9 0 0 0 5.29-1.54"></path><path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path><path d="M17.85 17.85A10 10 0 0 0 22 12s-3-7-10-7a9.9 9.9 0 0 0-3.15.52"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#5B1D2A] text-white font-bold py-3.5 rounded-xl hover:bg-[#6D2433] transition shadow-lg">
                Simpan Password Baru
            </button>
        </form>
    </div>

    {{-- SCRIPT UNTUK TOGGLE MATA --}}
    <script>
        function togglePassword(inputId, eyeOpenId, eyeClosedId) {
            const input = document.getElementById(inputId);
            const eyeOpen = document.getElementById(eyeOpenId);
            const eyeClosed = document.getElementById(eyeClosedId);

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
