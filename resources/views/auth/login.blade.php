<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>Login Sistem E-Presensi Elektro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            maroon: {
              50: '#fdf6f7', 100: '#f9e8eb', 200: '#f2cfd6', 300: '#e5a8b7',
              400: '#d27b91', 500: '#bc5a75', 600: '#9f3f5d', 700: '#7f2b46',
              800: '#652037', 900: '#4d182b', 950: '#2b0b16'
            },
            gold: {
              light: '#f7f1e7', DEFAULT: '#d8b98b', dark: '#b89a6d'
            }
          },
          fontFamily: {
            sans: ['Plus Jakarta Sans', 'sans-serif'],
            display: ['Playfair Display', 'serif']
          },
          boxShadow: {
            'premium': '0 25px 50px -12px rgba(77, 24, 43, 0.25)',
            'inner-soft': 'inset 0 2px 4px 0 rgba(255, 255, 255, 0.06)',
          }
        }
      }
    }
  </script>

  <style>
    body {
      background-color: #fcfaf8;
      background-image:
        radial-gradient(at 0% 0%, rgba(188, 90, 117, 0.08) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(216, 185, 139, 0.1) 0px, transparent 50%);
    }

    .glass-effect {
      backdrop-filter: blur(16px);
      background: rgba(255, 255, 255, 0.85);
      border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .circuit-pattern {
      background-image: radial-gradient(#d8b98b 0.5px, transparent 0.5px);
      background-size: 24px 24px;
      opacity: 0.2;
    }

    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }

    .animate-float {
      animation: float 4s ease-in-out infinite;
    }

    .input-focus {
      transition: all 0.3s ease;
    }
    .input-focus:focus {
      box-shadow: 0 0 0 4px rgba(188, 90, 117, 0.1);
      transform: translateY(-1px);
    }

    ::-webkit-scrollbar {
      width: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #fcfaf8;
    }
    ::-webkit-scrollbar-thumb {
      background: #bc5a75;
      border-radius: 10px;
    }
  </style>
</head>
<body class="font-sans text-slate-900 min-h-screen flex items-center justify-center p-4 sm:p-8">

  <!-- Background Decorative Elements -->
  <div class="fixed inset-0 circuit-pattern pointer-events-none"></div>
  <div class="fixed top-[-10%] right-[-5%] w-[40%] h-[40%] bg-maroon-100/30 rounded-full blur-[120px] pointer-events-none"></div>
  <div class="fixed bottom-[-10%] left-[-5%] w-[40%] h-[40%] bg-gold-light/40 rounded-full blur-[120px] pointer-events-none"></div>

  <main class="relative w-full max-w-5xl grid lg:grid-cols-10 glass-effect rounded-[3rem] overflow-hidden shadow-premium border border-white my-auto">

    <!-- LEFT SIDE: BRANDING & INFO (Hidden on Mobile) -->
    <div class="hidden lg:flex lg:col-span-4 relative bg-maroon-950 p-12 flex-col justify-between overflow-hidden min-h-[600px]">
        <!-- Overlay Decorative -->
        <div class="absolute top-0 right-0 w-full h-full opacity-10 circuit-pattern"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-gold/20 rounded-full blur-3xl"></div>

        <div class="relative z-10">
            <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png"
                 alt="Logo Elektro"
                 class="w-20 h-20 object-contain animate-float">

            <div class="mt-12 space-y-4">
                <h2 class="font-display text-4xl text-white leading-tight">Presensi<br><span class="text-gold italic">Elektro Poliban.</span></h2>
                <div class="w-16 h-1 bg-gold rounded-full"></div>
            </div>
        </div>

        <div class="relative z-10 space-y-6">
            <div class="flex items-center gap-4 text-white/70">
                <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <p class="text-sm font-medium">Teknologi Face Match & Liveness</p>
            </div>
            <div class="flex items-center gap-4 text-white/70">
                <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <p class="text-sm font-medium">Validasi Geo-Location Presisi</p>
            </div>
        </div>

        <p class="relative z-10 text-white/30 text-[10px] font-bold uppercase tracking-widest leading-none">
            &copy; 2026 Jurusan Teknik Elektro • Poliban
        </p>
    </div>

    <!-- RIGHT SIDE: LOGIN FORM -->
    <div class="lg:col-span-6 p-8 md:p-16 flex flex-col justify-center bg-white/50 min-h-[500px]">

        <div class="max-w-md mx-auto w-full">
            <!-- Mobile Header Logo -->
            <div class="lg:hidden flex justify-center mb-8">
                <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png"
                     alt="Logo Elektro"
                     class="w-16 h-16 object-contain">
            </div>

            <div class="mb-10 text-center lg:text-left">
                <h1 class="text-3xl md:text-4xl font-black text-maroon-950 tracking-tight leading-none mb-4">Selamat Datang</h1>
                <p class="text-slate-400 font-medium">Silakan masuk untuk mengakses sistem presensi digital.</p>
            </div>

            <!-- FORM LARAVEL START -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Alert Error Login -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-2xl relative text-sm font-medium mb-4 flex items-center gap-3 shadow-sm" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Username/Email -->
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-maroon-900 uppercase tracking-[0.2em] ml-1">Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-maroon-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="Masukkan Email Anda"
                               class="w-full bg-white border border-slate-200 rounded-2xl py-4 pl-12 pr-4 text-sm font-bold text-maroon-950 outline-none focus:border-maroon-500 input-focus shadow-sm">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-maroon-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <input id="password-input" type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full bg-white border border-slate-200 rounded-2xl py-4 pl-12 pr-12 text-sm font-bold text-maroon-950 outline-none focus:border-maroon-500 input-focus shadow-sm">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-300 hover:text-maroon-500 transition-colors">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between ml-1">
                        <label class="block text-[10px] font-black text-maroon-900 uppercase tracking-[0.2em]">Kata Sandi</label>
                        <a href="{{ route('password.request') }}" class="text-[10px] font-black text-gold-dark hover:text-maroon-700 uppercase tracking-widest transition-colors">Lupa Password?</a>
                    </div>
                </div>



                <!-- Login Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-maroon-950 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl shadow-maroon-950/20 hover:bg-maroon-800 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                        Masuk Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </div>
            </form>
            <!-- FORM LARAVEL END -->

            <div class="mt-12 pt-8 border-t border-slate-100 text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ada Masalah Akses?</p>
                <a href="#" class="inline-block mt-2 text-xs font-black text-maroon-700 hover:text-maroon-900 underline transition-colors">Hubungi Admin IT Jurusan</a>
            </div>
        </div>

    </div>
  </main>

  <script>
    function togglePassword() {
        const input = document.getElementById('password-input');
        const icon = document.getElementById('eye-icon');

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
