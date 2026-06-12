<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Dashboard Tendik - E-Presensi Elektro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                        'premium': '0 20px 50px rgba(77, 24, 43, 0.12)',
                        'inner-light': 'inset 0 2px 4px rgba(255, 255, 255, 0.2)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #fcfaf8;
            background-image:
                radial-gradient(at 0% 0%, rgba(188, 90, 117, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(216, 185, 139, 0.1) 0px, transparent 50%);
            -webkit-tap-highlight-color: transparent;
        }

        .glass-effect {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>

<body class="font-sans text-slate-900 {{ View::hasSection('hide_nav') ? '' : 'pb-24 lg:pb-0 lg:pl-24' }}">

    @if(!View::hasSection('hide_nav'))
        @include('layouts.tendik.sidebar')
    @endif

    @if(!View::hasSection('hide_nav'))
        @include('layouts.tendik.navbar')
    @endif

    @yield('content')

    @if(!View::hasSection('hide_nav'))
        @include('layouts.tendik.bottomnav')
    @endif

    <script>
        function updateClock() {
            const clockElement = document.getElementById("liveClock");
            const dateElement = document.getElementById("liveDate");
            if(!clockElement || !dateElement) return;

            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            clockElement.textContent = `${hours}:${minutes}:${seconds}`;

            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            dateElement.textContent = now.toLocaleDateString('id-ID', options);
        }

        setInterval(updateClock, 1000);
        updateClock();

        // Efek sentuhan untuk mobile
        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('touchstart', () => { btn.classList.add('scale-95'); });
            btn.addEventListener('touchend', () => { btn.classList.remove('scale-95'); });
        });
    </script>
</body>
</html>
