<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Étudiant - StageFlow')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
            animation: float 10s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .bg-mesh {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 16%, 15%, 0.03) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(225, 39%, 30%, 0.03) 0, transparent 50%),
                radial-gradient(at 50% 100%, hsla(217, 91%, 60%, 0.02) 0, transparent 50%);
        }
    </style>
</head>
<body class="bg-mesh h-full overflow-x-hidden">
    <header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white border-b border-gray-200 text-sm py-2.5 sm:py-4 lg:ps-64">
        <nav class="max-w-[85rem] mx-auto w-full px-4 sm:px-6 lg:px-8 flex items-center justify-between" aria-label="Global">
            <div class="flex items-center gap-x-3">
                <button type="button" class="lg:hidden py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-white border border-gray-200 text-gray-800 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none" data-hs-overlay="#application-sidebar" aria-controls="application-sidebar">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                </button>
                <ol class="flex items-center whitespace-nowrap min-w-0" aria-label="Breadcrumb">
                    <li class="inline-flex items-center text-sm text-gray-400">
                        Étudiant
                        <svg class="shrink-0 mx-2 overflow-visible size-4 text-gray-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </li>
                    <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate" aria-current="page">
                        @yield('breadcrumb', 'Tableau de bord')
                    </li>
                </ol>
            </div>

            <div class="flex flex-row items-center justify-end gap-x-2 sm:gap-x-4">
                <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
                    <button id="hs-dropdown-account" type="button" class="size-9 flex justify-center items-center text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none">
                        @if($etudiant->user->photo)
                            <img class="shrink-0 size-9 rounded-full object-cover" src="{{ asset('storage/'.$etudiant->user->photo) }}" alt="Avatar">
                        @else
                            <span class="flex shrink-0 justify-center items-center size-full rounded-full bg-indigo-100 text-indigo-600 font-bold uppercase text-xs">
                                {{ substr($etudiant->user->prenom, 0, 1) }}{{ substr($etudiant->user->nom, 0, 1) }}
                            </span>
                        @endif
                    </button>

                    <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-60 transition-[opacity,margin] duration opacity-0 hidden z-[60] bg-white border border-gray-200 rounded-lg shadow-md p-1 mt-2">
                        <div class="py-3 px-5 -m-1 bg-gray-100 rounded-t-lg font-medium text-gray-800 text-sm">
                            {{ $etudiant->user->email }}
                        </div>
                        <div class="p-1 space-y-0.5 mt-2 text-gray-800 text-sm">
                            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg hover:bg-gray-100" href="{{ route('student.profile') }}">Mon profil</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-red-600 hover:bg-gray-100" href="#">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    @include('partials.student-sidebar')

    <main class="w-full h-full lg:ps-64 relative z-0">
        <!-- Animated Stickers Background Decor -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden z-[-1] opacity-[0.05]">
            <div class="absolute top-10 left-10 sticker-float"><svg class="size-48 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg></div>
            <div class="absolute top-[50%] right-10 sticker-float" style="animation-delay: -2s"><svg class="size-32 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg></div>
            <div class="absolute bottom-20 left-[20%] sticker-float" style="animation-delay: -4s"><svg class="size-60 text-indigo-400 rotate-12" fill="currentColor" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"/></svg></div>
        </div>

        <div class="p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-10">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 800, once: true });
        });
    </script>
</body>
</html>
