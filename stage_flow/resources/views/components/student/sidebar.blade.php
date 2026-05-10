<aside id="application-sidebar" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 flex flex-col pt-7 pb-10 overflow-hidden lg:block lg:translate-x-0 lg:end-auto lg:bottom-0">
    <div class="px-6 pb-8">
        <a class="flex-none text-xl font-bold inline-flex items-center gap-x-2" href="{{ route('landing') }}" aria-label="Brand">
            <img src="{{ asset('logo_app.png') }}" alt="Logo" class="size-8 object-contain">
            <span class="text-gray-900 leading-none font-heading">StageFlow</span>
        </a>
    </div>

    <div class="px-4 mb-6">
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-50 border border-indigo-100 rounded-xl p-3 flex items-center gap-3">
            <div class="shrink-0 size-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm overflow-hidden">
                @if(auth()->user()->avatar_url)
                    <img class="size-full object-cover" src="{{ asset('storage/' . auth()->user()->avatar_url) }}" alt="Avatar">
                @else
                    {{ strtoupper(substr(auth()->user()->prenom, 0, 1) . substr(auth()->user()->nom, 0, 1)) }}
                @endif
            </div>
            <div class="min-w-0">
                <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
                <p class="text-[11px] text-indigo-600 font-medium capitalize">Étudiant</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-4 w-full flex flex-col flex-wrap overflow-y-auto">
        <ul class="space-y-1.5 font-medium text-gray-700">
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('student.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-100' }} text-sm rounded-lg" href="{{ route('student.dashboard') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Tableau de bord
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('student.offres.*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-100' }} text-sm rounded-lg" href="{{ route('student.offres.index') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    Catalogue des Offres
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('student.candidatures') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-100' }} text-sm rounded-lg" href="{{ route('student.candidatures') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Candidatures
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('student.favoris') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-100' }} text-sm rounded-lg" href="{{ route('student.favoris') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    Favoris
                </a>
            </li>

            <li class="pt-5 pb-2 px-2.5">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Compte</span>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('student.profile') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-100' }} text-sm rounded-lg" href="{{ route('student.profile') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Mon Profil
                </a>
            </li>
        </ul>
    </nav>
    <div class="px-4 mt-auto">
        <div class="h-px bg-gray-100 mb-4 mx-2"></div>
        <a class="flex items-center gap-x-3.5 py-3 px-3 text-sm font-semibold text-red-600 rounded-lg hover:bg-red-50 focus:outline-none transition" 
           href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
            Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</aside>
