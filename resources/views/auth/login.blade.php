<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>Login SIPETANG</title>
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
<body class="font-sans text-slate-900 h-screen w-screen overflow-hidden flex items-center justify-center p-4 sm:p-8 relative">

  <div class="fixed inset-0 circuit-pattern pointer-events-none"></div>
  <div class="fixed top-[-10%] right-[-5%] w-[40%] h-[40%] bg-maroon-100/30 rounded-full blur-[120px] pointer-events-none"></div>
  <div class="fixed bottom-[-10%] left-[-5%] w-[40%] h-[40%] bg-gold-light/40 rounded-full blur-[120px] pointer-events-none"></div>

  <div class="w-full max-w-5xl relative z-10 max-h-full flex flex-col">

    <div class="flex items-center gap-3 mb-4 shrink-0">
        <a href="{{ url('/') }}"
        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white/80 backdrop-blur-sm border border-white/50 text-maroon-950 hover:bg-white transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
        </a>
        <span class="text-sm font-bold text-maroon-950">
            Kembali ke Landing Page
        </span>
    </div>

    <main class="w-full grid lg:grid-cols-10 glass-effect rounded-3xl lg:rounded-[3rem] overflow-hidden shadow-premium border border-white">

      <div class="hidden lg:flex lg:col-span-4 relative bg-maroon-950 p-10 lg:p-12 flex-col justify-center overflow-hidden">

          <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=800"
               class="absolute inset-0 w-full h-full object-cover mix-blend-luminosity opacity-10" alt="Tech Background">

          <div class="absolute inset-0 bg-gradient-to-br from-maroon-950/80 via-maroon-950/95 to-maroon-950"></div>

          <div class="absolute top-0 right-0 w-full h-full opacity-10 circuit-pattern"></div>
          <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-gold/20 rounded-full blur-3xl pointer-events-none"></div>

          <div class="relative z-10 text-left space-y-6 my-auto">
              <div class="inline-flex items-center justify-center p-4 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md shadow-lg">
                  <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png"
                       alt="Logo Elektro"
                       class="w-14 h-14 lg:w-16 lg:h-16 object-contain drop-shadow-lg">
              </div>

              <div class="space-y-4">
                  <h2 class="font-display text-4xl lg:text-5xl text-white leading-none font-black tracking-wide">
                      SIPETANG<span class="text-gold">.</span>
                  </h2>
                  <p class="text-white/75 text-xs lg:text-sm font-medium leading-relaxed max-w-[280px]">
                      Sistem Presensi Elektro Tendik dan Anak Magang.
                  </p>
                  <div class="w-12 h-1 bg-gold rounded-full"></div>
              </div>
          </div>

          <p class="relative z-10 text-white/40 text-[9px] lg:text-[10px] font-bold uppercase tracking-widest leading-none mt-auto">
              &copy; 2026 Jurusan Teknik Elektro • Poliban
          </p>
      </div>

      <div class="lg:col-span-6 p-6 sm:p-10 md:p-12 xl:p-16 flex flex-col justify-center bg-white/60">

          <div class="max-w-md mx-auto w-full">
              <div class="lg:hidden flex flex-col items-center justify-center mb-6">
                  <div class="inline-flex items-center justify-center p-3 bg-maroon-950 rounded-2xl shadow-lg mb-3">
                      <img src="https://poliban.ac.id/wp-content/uploads/elementor/thumbs/logo-poliban-jurusan-elektro-qk7viq77pvg3pdria0wjpmdjnb0p1myetqdr356ck4.png"
                           alt="Logo Elektro"
                           class="w-11 h-12 object-contain drop-shadow-md">
                  </div>
                  <h2 class="font-display text-3xl font-black text-maroon-950 leading-none mb-1">SIPETANG</h2>
                  <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest text-center leading-relaxed">
                      Sistem Presensi Elektro<br>Tendik dan Anak Magang
                  </p>
              </div>

              <div class="mb-6 sm:mb-8 text-center lg:text-left">
                  <h1 class="text-2xl sm:text-3xl font-black text-maroon-950 tracking-tight leading-none mb-2">Selamat Datang</h1>
                  <p class="text-xs sm:text-sm text-slate-500 font-medium">Silakan masuk menggunakan akun Anda.</p>
              </div>

              <form action="{{ route('login.post') }}" method="POST" class="space-y-4 sm:space-y-5">
                  @csrf

                  @if($errors->any())
                      <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-xl sm:rounded-2xl relative text-xs sm:text-sm font-bold mb-4 flex items-center gap-3 shadow-sm" role="alert">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                          <span>{{ $errors->first() }}</span>
                      </div>
                  @endif

                  <div class="space-y-1.5">
                      <label class="block text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-[0.2em] ml-1">Email</label>
                      <div class="relative group">
                          <div class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-maroon-500 transition-colors">
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[18px] sm:h-[18px] w-4 h-4"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                          </div>
                          <input type="email" name="email" value="{{ old('email') }}" required
                                 placeholder="Masukkan Email Anda"
                                 class="w-full bg-white border border-slate-200 rounded-xl sm:rounded-2xl py-3 sm:py-3.5 pl-10 sm:pl-12 pr-4 text-xs sm:text-sm font-bold text-maroon-950 outline-none focus:border-maroon-500 input-focus shadow-sm">
                      </div>
                  </div>

                  <div class="space-y-1.5">
                      <label class="block text-[9px] sm:text-[10px] font-black text-maroon-900 uppercase tracking-[0.2em] ml-1">Kata Sandi</label>

                      <div class="relative group">
                          <div class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-maroon-500 transition-colors">
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[18px] sm:h-[18px] w-4 h-4"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                          </div>
                          <input id="password-input" type="password" name="password" required
                                 placeholder="••••••••"
                                 class="w-full bg-white border border-slate-200 rounded-xl sm:rounded-2xl py-3 sm:py-3.5 pl-10 sm:pl-12 pr-12 text-xs sm:text-sm font-bold text-maroon-950 outline-none focus:border-maroon-500 input-focus shadow-sm">
                          <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 sm:pr-5 flex items-center text-slate-400 hover:text-maroon-600 transition-colors focus:outline-none">
                              <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[18px] sm:h-[18px] w-4 h-4"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                          </button>
                      </div>

                      <div class="flex justify-end pt-0.5">
                          <a href="{{ route('password.request') }}" class="text-[9px] sm:text-[10px] font-black text-maroon-600 hover:text-maroon-900 uppercase tracking-widest transition-colors mr-1">Lupa Sandi?</a>
                      </div>
                  </div>

                  <div class="pt-2 sm:pt-3">
                      <button type="submit" class="w-full bg-maroon-950 text-white py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-black text-xs sm:text-sm uppercase tracking-[0.2em] shadow-lg shadow-maroon-950/20 hover:bg-maroon-800 active:scale-[0.98] transition-all flex items-center justify-center gap-2 sm:gap-3">
                          Login
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[18px] sm:h-[18px]"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                      </button>
                  </div>
              </form>
              <div class="mt-6 sm:mt-8 pt-4 sm:pt-5 border-t border-slate-200 text-center">
                  <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ada Masalah Akses?</p>
                  <a href="https://wa.me/62812345678?text=Halo%20Admin%20Jurusan,%20saya%20butuh%20bantuan%20terkait%20sistem%20presensi." target="_blank" class="inline-block mt-1 text-[10px] sm:text-xs font-black text-maroon-700 hover:text-maroon-900 underline transition-colors">Hubungi Admin Jurusan</a>
              </div>
          </div>

      </div>
    </main>
  </div>

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
