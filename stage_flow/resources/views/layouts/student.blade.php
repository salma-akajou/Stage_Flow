<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                @if($etudiant)
                
                <!-- Notifications Dropdown -->
                @php
                    $unreadNotifications = auth()->user()->notifications()->whereNull('read_at')->latest()->get();
                    $unreadCount = $unreadNotifications->count();
                @endphp
                <div x-data="{ showNotif: false }" class="relative inline-flex">
                    <button @click="showNotif = !showNotif" type="button" class="size-9 flex justify-center items-center text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none relative">
                        <svg class="shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                        </svg>
                        @if($unreadCount > 0)
                            <span class="absolute top-0 right-0 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                            </span>
                        @endif
                    </button>

                    <div x-show="showNotif" @click.away="showNotif = false" x-cloak class="absolute right-0 mt-12 w-[350px] bg-white border border-gray-200 rounded-xl shadow-lg p-2 z-[150]">
                        <div class="flex items-center justify-between px-3 py-2 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-800 text-sm">Notifications</h3>
                            @if($unreadCount > 0)
                                <form action="{{ route('student.notifications.markAllRead') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition">Tout lire</button>
                                </form>
                            @endif
                        </div>
                        
                        <div class="mt-2 max-h-80 overflow-y-auto space-y-1">
                            @forelse($unreadNotifications as $notification)
                                <form action="{{ route('student.notifications.markRead', $notification->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-start gap-x-3 p-3 rounded-lg hover:bg-gray-50 transition duration-150">
                                        <div class="shrink-0 mt-0.5">
                                            @if($notification->type === 'candidature_status')
                                                @if(($notification->data['status'] ?? '') === 'Accepté')
                                                    <span class="flex justify-center items-center size-8 rounded-full bg-emerald-50 text-emerald-600">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                    </span>
                                                @else
                                                    <span class="flex justify-center items-center size-8 rounded-full bg-rose-50 text-rose-600">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    </span>
                                                @endif
                                            @elseif($notification->type === 'new_offre')
                                                <span class="flex justify-center items-center size-8 rounded-full bg-indigo-50 text-indigo-600">
                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18V6a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 6v3.75m-9.75-3h1.5" /></svg>
                                                </span>
                                            @else
                                                <span class="flex justify-center items-center size-8 rounded-full bg-gray-100 text-gray-600">
                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="grow">
                                            <p class="font-medium text-gray-800 text-xs flex justify-between items-center">
                                                <span>{{ $notification->title }}</span>
                                                <span class="text-[10px] text-gray-400 font-normal shrink-0">{{ $notification->created_at->diffForHumans(null, true) }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $notification->message }}</p>
                                        </div>
                                    </button>
                                </form>
                            @empty
                                <div class="py-8 px-4 text-center">
                                    <svg class="mx-auto size-8 text-gray-300 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>
                                    <p class="text-xs text-gray-400 font-medium">Aucune nouvelle notification</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div x-data="{ showAccount: false }" class="relative inline-flex">
                    <button @click="showAccount = !showAccount" type="button" class="size-9 flex justify-center items-center text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none">
                        @if($etudiant->photo)
                            <img class="shrink-0 size-9 rounded-full object-cover" src="{{ asset('storage/'.$etudiant->photo) }}" alt="Avatar">
                        @else
                            <span class="flex shrink-0 justify-center items-center size-full rounded-full bg-indigo-100 text-indigo-600 font-bold uppercase text-xs">
                                {{ substr($etudiant->user->prenom, 0, 1) }}{{ substr($etudiant->user->nom, 0, 1) }}
                            </span>
                        @endif
                    </button>

                    <div x-show="showAccount" @click.away="showAccount = false" x-cloak class="absolute right-0 mt-12 w-60 bg-white border border-gray-200 rounded-lg shadow-md p-1 z-[150]">
                        <div class="py-3 px-5 -m-1 bg-gray-100 rounded-t-lg font-medium text-gray-800 text-sm">
                            {{ $etudiant->user->email }}
                        </div>
                        <div class="p-1 space-y-0.5 mt-2 text-gray-800 text-sm">
                            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg hover:bg-gray-100" href="{{ route('student.profile') }}">Mon profil</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-red-600 hover:bg-gray-100">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 transition">Connexion</a>
                @endif
            </div>
        </nav>
    </header>

    @include('components.student.sidebar')

    <main class="w-full h-full lg:ps-64 relative z-0">
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
    <x-chatbot />
    @stack('scripts')
</body>
</html>
