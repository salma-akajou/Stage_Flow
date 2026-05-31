<header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white/90 backdrop-blur-md border-b border-gray-200 text-sm py-2.5 sm:py-4 lg:ps-64">
    <nav class="max-w-[85rem] mx-auto w-full px-4 sm:px-6 lg:px-8 flex items-center justify-between" aria-label="Global">
        <div class="flex items-center gap-x-3">
            <button type="button"
                class="lg:hidden py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-white border border-gray-200 text-gray-800 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none"
                data-hs-overlay="#application-sidebar">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" x2="21" y1="6" y2="6" /><line x1="3" x2="21" y1="12" y2="12" /><line x1="3" x2="21" y1="18" y2="18" />
                </svg>
            </button>
            <ol class="flex items-center whitespace-nowrap min-w-0" aria-label="Breadcrumb">
                <li class="inline-flex items-center text-sm text-gray-400 hover:text-indigo-600 transition">
                    <a href="{{ route('landing') }}">StageFlow</a>
                    <svg class="shrink-0 mx-2 overflow-visible size-4 text-gray-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6" /></svg>
                </li>
                <li class="inline-flex items-center text-sm text-gray-400">
                    Espace Entreprise
                    <svg class="shrink-0 mx-2 overflow-visible size-4 text-gray-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6" /></svg>
                </li>
                <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate" aria-current="page">
                    @yield('breadcrumb', 'Tableau de bord')
                </li>
            </ol>
        </div>
        
        <div class="flex flex-row items-center justify-end gap-x-2 sm:gap-x-4">
            @php
                $unreadNotifications = auth()->user()->notifications()->whereNull('read_at')->latest()->get();
                $unreadCount = $unreadNotifications->count();
            @endphp
            <!-- Notifications Dropdown -->
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
                            <form action="{{ route('entreprise.notifications.markAllRead') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition">Tout lire</button>
                            </form>
                        @endif
                    </div>
                    
                    <div class="mt-2 max-h-80 overflow-y-auto space-y-1">
                        @forelse($unreadNotifications as $notification)
                            <form action="{{ route('entreprise.notifications.markRead', $notification->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-start gap-x-3 p-3 rounded-lg hover:bg-gray-50 transition duration-150">
                                    <div class="shrink-0 mt-0.5">
                                        <span class="flex justify-center items-center size-8 rounded-full bg-indigo-50 text-indigo-600">
                                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                                        </span>
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

            <!-- Profile Dropdown -->
            <div x-data="{ showProfile: false }" class="relative inline-flex">
                <button @click="showProfile = !showProfile" type="button" class="size-9 flex justify-center items-center text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none">
                    <div class="size-full rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs overflow-hidden">
                        @if($entreprise && $entreprise->logo)
                            <img class="size-full object-cover" src="{{ asset('storage/'.$entreprise->logo) }}" alt="Avatar">
                        @else
                            {{ substr($entreprise->nom_entreprise ?? 'MS', 0, 2) }}
                        @endif
                    </div>
                </button>
                <div x-show="showProfile" @click.away="showProfile = false" x-cloak class="absolute right-0 mt-12 w-60 bg-white border border-gray-200 rounded-lg shadow-md p-1 z-[150]" role="menu">
                    <div class="py-3 px-5 -m-1 bg-indigo-50 rounded-t-lg font-medium text-gray-800 text-sm">
                        {{ $entreprise->nom_entreprise ?? 'Microsoft Maroc' }}
                    </div>
                    <div class="p-1 space-y-0.5 mt-2 text-gray-800 text-sm">
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg hover:bg-gray-100" href="{{ route('entreprise.profile') }}">Profil Entreprise</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-red-600 hover:bg-gray-100 text-left">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
