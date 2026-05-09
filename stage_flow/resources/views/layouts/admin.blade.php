<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Admin - StageFlow')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc', 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 900: '#312e81', 950: '#1e1b4b' },
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'], heading: ['Outfit', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }

        .sticker-float {
            animation: float 12s ease-in-out infinite;
        }
        .sticker-float-slow {
            animation: float 18s ease-in-out infinite;
        }
        .sticker-float-fast {
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(5deg); }
            66% { transform: translateY(10px) rotate(-3deg); }
        }

        .bg-mesh {
            background-color: #fafafa;
            background-image:
                radial-gradient(at 0% 0%, hsla(235, 80%, 65%, 0.06) 0, transparent 60%),
                radial-gradient(at 100% 0%, hsla(250, 90%, 68%, 0.05) 0, transparent 60%),
                radial-gradient(at 50% 100%, hsla(220, 80%, 70%, 0.04) 0, transparent 60%);
        }
    </style>
</head>
<body class="bg-mesh h-full overflow-x-hidden">
    
    <div id="admin-layout-wrapper" class="transition-all duration-500">
        @include('components.admin.navbar')
        @include('components.admin.sidebar')

        <main class="w-full h-full lg:ps-64 relative z-0">
            <div class="absolute inset-0 pointer-events-none overflow-hidden z-[-1] opacity-[0.03]">
                <div class="absolute top-20 left-10 sticker-float"><svg class="size-44 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" /></svg></div>
                <div class="absolute top-[35%] right-10 sticker-float-slow" style="animation-delay:-4s"><svg class="size-32 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /></svg></div>
                <div class="absolute bottom-20 left-[40%] sticker-float-fast" style="animation-delay:-8s"><svg class="size-24 text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z" /><path d="M2 17l10 5 10-5" /><path d="M2 12l10 5 10-5" /></svg></div>
            </div>
            <div class="fixed top-0 right-0 w-96 h-96 bg-indigo-300/10 rounded-full blur-3xl pointer-events-none z-[-1]"></div>
            <div class="fixed bottom-0 left-64 w-96 h-96 bg-indigo-200/10 rounded-full blur-3xl pointer-events-none z-[-1]"></div>

            <div class="p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-10">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Modale global (hors de l'enveloppe de flou) -->
    @include('components.admin.users.user-detail-modal')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 800, once: true });
        });
    </script>
    @stack('scripts')
</body>
</html>
