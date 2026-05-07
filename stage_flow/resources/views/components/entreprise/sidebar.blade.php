<aside id="application-sidebar"
    class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 flex flex-col pt-7 pb-10 overflow-hidden lg:block lg:translate-x-0 lg:end-auto lg:bottom-0">
    <div class="px-6 pb-6">
        <a class="flex-none text-xl font-bold inline-flex items-center gap-x-2" href="{{ route('landing') }}"
            aria-label="Brand">
            <img src="{{ asset('logo_app.png') }}" alt="Logo StageFlow" class="size-8 object-contain">
            <div>
                <span class="text-gray-900 leading-none block font-heading">StageFlow</span>
            </div>
        </a>
    </div>

    <div class="px-4 mb-6">
        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-100 rounded-xl p-3 flex items-center gap-3">
            <div class="shrink-0 size-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                @if($entreprise && $entreprise->logo)
                    <img class="size-10 rounded-full object-cover" src="{{ asset('storage/'.$entreprise->logo) }}" alt="Logo">
                @else
                    {{ substr($entreprise->nom_entreprise ?? 'EN', 0, 2) }}
                @endif
            </div>
            <div class="min-w-0">
                <p class="text-sm font-bold text-gray-800 truncate">{{ $entreprise->nom_entreprise ?? 'Entreprise' }}</p>
                <p class="text-[11px] text-indigo-600 font-medium">Compte Entreprise</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-4 w-full flex flex-col flex-wrap overflow-y-auto">
        <ul class="space-y-1.5">
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('entreprise.dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }} text-sm rounded-lg"
                    href="{{ route('entreprise.dashboard') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><rect width="7" height="9" x="3" y="3" rx="1" /><rect width="7" height="5" x="14" y="3" rx="1" /><rect width="7" height="9" x="14" y="12" rx="1" /><rect width="7" height="5" x="3" y="16" rx="1" /></svg>
                    Tableau de bord
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('entreprise.offres.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }} text-sm rounded-lg"
                    href="{{ route('entreprise.offres.index') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" /><polyline points="14 2 14 8 20 8" /></svg>
                    Mes Offres
                </a>
            </li>
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('entreprise.candidatures.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }} text-sm rounded-lg"
                    href="{{ route('entreprise.candidatures.index') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg>
                    Candidatures Reçues
                </a>
            </li>
            
            <li class="pt-5 pb-2 px-2.5">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Compte</span>
            </li>
            
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('entreprise.profile') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }} text-sm rounded-lg"
                    href="{{ route('entreprise.profile') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" /><circle cx="12" cy="7" r="4" /></svg>
                    Profil Entreprise
                </a>
            </li>
        </ul>
    </nav>

    <div class="px-4 mt-auto">
        <div class="h-px bg-gray-100 mb-4 px-2"></div>
        <a class="flex items-center gap-x-3.5 py-3 px-3 text-sm font-bold text-rose-600 rounded-xl hover:bg-rose-50 transition"
            href="#">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path d="m16 17 5-5-5-5" /><path d="M21 12H9" /><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" /></svg>
            Déconnexion
        </a>
    </div>
</aside>
