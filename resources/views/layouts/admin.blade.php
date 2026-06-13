<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin Dashboard - E-Presensi Elektro</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                },
                boxShadow: {
                    'premium': '0 20px 50px rgba(77, 24, 43, 0.08)',
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
                overflow-x: hidden;
            }

            /* Transisi dasar */
            #sidebar { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
            #main-container { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); width: 100%; }

            /* LOGIKA RESPONSIVE DESKTOP */
            @media (min-width: 768px) {
                #sidebar { width: 260px; }
                #main-container { margin-left: 260px; width: calc(100% - 260px); }

                /* Efek Collapse Desktop */
                .collapsed #sidebar { width: 85px; }
                .collapsed #main-container { margin-left: 85px; width: calc(100% - 85px); }
                .collapsed .sidebar-text,
                .collapsed .sidebar-header-text,
                .collapsed .sidebar-section-label { display: none; }
                .collapsed .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
            }

            .glass-effect {
                backdrop-filter: blur(12px);
                background: rgba(255, 255, 255, 0.8);
                border-bottom: 1px solid rgba(77, 24, 43, 0.05);
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-in { animation: fadeIn 0.4s ease-out forwards; }
            .no-scrollbar::-webkit-scrollbar { display: none; }
        </style>
    </head>
    <body class="font-sans text-slate-900 relative">

        @if(!View::hasSection('hide_nav'))
            <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-maroon-950/40 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300 md:hidden"></div>
            @include('layouts.admin.sidebar')
        @endif

        <div id="{{ View::hasSection('hide_nav') ? 'fullscreen-container' : 'main-container' }}" class="main-content {{ View::hasSection('hide_nav') ? 'w-full min-h-screen' : '' }}">

            @if(!View::hasSection('hide_nav'))
                @include('layouts.admin.navbar')
            @endif

            @yield('content')
        </div>

        <script>
            // Fungsi Pintar Toggle Responsif
            function toggleSidebar() {
                if (window.innerWidth >= 768) {
                    // Desktop: Perkecil (Collapse)
                    document.body.classList.toggle('collapsed');
                } else {
                    // Mobile: Munculkan/Sembunyikan dari kiri
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebarOverlay');

                    if (sidebar && overlay) {
                        const isHidden = sidebar.classList.contains('-translate-x-full');
                        if (isHidden) {
                            sidebar.classList.remove('-translate-x-full');
                            overlay.classList.remove('hidden');
                            setTimeout(() => { overlay.classList.remove('opacity-0'); }, 10);
                        } else {
                            sidebar.classList.add('-translate-x-full');
                            overlay.classList.add('opacity-0');
                            setTimeout(() => { overlay.classList.add('hidden'); }, 300);
                        }
                    }
                }
            }
        </script>
    </body>
</html>
