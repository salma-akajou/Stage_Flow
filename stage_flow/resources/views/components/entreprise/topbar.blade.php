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
            <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
                <button id="hs-dropdown-enterprise" type="button"
                    class="size-9 flex justify-center items-center text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 transition"
                    aria-haspopup="menu" aria-expanded="false">
                    <div class="size-full rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs overflow-hidden">
                        @if($entreprise && $entreprise->logo)
                            <img class="size-full object-cover" src="{{ asset('storage/'.$entreprise->logo) }}" alt="Avatar">
                        @else
                            {{ substr($entreprise->nom_entreprise ?? 'MS', 0, 2) }}
                        @endif
                    </div>
                </button>
                <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-60 transition-[opacity,margin] duration opacity-0 hidden z-10 bg-white border border-gray-200 rounded-lg shadow-md p-1 mt-2" role="menu">
                    <div class="py-3 px-5 -m-1 bg-indigo-50 rounded-t-lg font-medium text-gray-800 text-sm">
                        {{ $entreprise->nom_entreprise ?? 'Microsoft Maroc' }}
                    </div>
                    <div class="p-1 space-y-0.5 mt-2 text-gray-800 text-sm">
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg hover:bg-gray-100" href="{{ route('entreprise.profile') }}">Profil Entreprise</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-red-600 hover:bg-gray-100" href="#">Déconnexion</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
