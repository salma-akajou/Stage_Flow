<header class="sticky top-0 inset-x-0 z-50 w-full bg-white/70 backdrop-blur-lg border-b border-slate-100 py-3">
    <nav class="max-w-[85rem] w-full mx-auto px-4 flex items-center justify-between" aria-label="Global">
        <a class="flex items-center gap-x-2 text-xl font-black font-heading tracking-tight flex-none" href="{{ route('landing') }}" @click="activeLink = 'accueil'">
            <img src="{{ asset('logo_app.png') }}" alt="Logo" class="size-8 object-contain" onerror="this.onerror=null; this.src='https://raw.githubusercontent.com/salma-akajou/php_native/main/logo_app.png';">
            <span class="text-slate-900">StageFlow</span>
        </a>

        <div class="flex items-center gap-x-8">
            <div class="hidden lg:flex items-center gap-x-8 mr-4 border-r border-slate-100 pr-8">
                <a href="{{ route('landing') }}" 
                   @click="activeLink = 'accueil'"
                   :class="activeLink === 'accueil' ? 'text-indigo-600 font-bold' : 'text-slate-500 font-semibold'"
                   class="text-sm transition">Accueil</a>

                <a href="#experience" 
                   @click.prevent="activeLink = 'propos'; document.getElementById('experience').scrollIntoView({ behavior: 'smooth' })"
                   :class="activeLink === 'propos' ? 'text-indigo-600 font-bold' : 'text-slate-500 font-semibold'"
                   class="text-sm transition">À propos</a>

                @auth
                    @php
                        $role = auth()->user()->getRoleNames()->first();
                        $offresRoute = $role === 'entreprise' ? route('entreprise.offres.index') : route('student.offres.index');
                        $candidaturesRoute = match($role) {
                            'entreprise' => route('entreprise.candidatures.index'),
                            'etudiant' => route('student.candidatures'),
                            default => '#'
                        };
                    @endphp
                    <a href="{{ $offresRoute }}" 
                       class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition">Offres</a>

                    <a href="{{ $candidaturesRoute }}" 
                       class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition">Candidatures</a>
                @else
                    <a href="{{ route('register') }}" 
                       class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition">Offres</a>

                    <a href="{{ route('register') }}" 
                       class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition">Candidatures</a>
                @endauth
            </div>

            <div class="flex items-center gap-x-6">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition">Connexion</a>
                    <a href="{{ route('register') }}" class="py-2.5 px-8 text-sm font-bold bg-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition active:scale-95 leading-none">
                        S'inscrire
                    </a>
                @else
                    <div class="relative inline-flex" x-data="navbarPublic">
                        <button @click="open = !open" @click.away="open = false" type="button" class="size-10 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-2xl border border-slate-200 bg-white text-slate-800 shadow-sm hover:bg-slate-50 transition-all overflow-hidden">
                            @if(auth()->user()->avatar_url)
                                <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}" class="size-full object-cover">
                            @else
                                <div class="size-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xs">
                                    {{ substr(auth()->user()->prenom, 0, 1) }}{{ substr(auth()->user()->nom, 0, 1) }}
                                </div>
                            @endif
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 top-full mt-2 min-w-60 bg-white shadow-2xl rounded-2xl p-2 border border-slate-100 z-[100]" 
                             x-cloak>
                            <div class="py-3 px-5 -m-2 bg-slate-50 rounded-t-2xl border-b border-slate-100">
                                <p class="text-sm font-black text-slate-800 tracking-tight">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
                                <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">{{ auth()->user()->getRoleNames()->first() }}</p>
                            </div>
                            <div class="mt-2 py-2">
                                @php
                                    $dashboardRoute = match(auth()->user()->getRoleNames()->first()) {
                                        'admin' => route('admin.dashboard'),
                                        'etudiant' => '/student/dashboard',
                                        'entreprise' => route('entreprise.dashboard'),
                                        default => '/home'
                                    };
                                @endphp
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition" href="{{ $dashboardRoute }}">
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1" /><rect width="7" height="5" x="14" y="3" rx="1" /><rect width="7" height="9" x="14" y="12" rx="1" /><rect width="7" height="5" x="3" y="16" rx="1" /></svg>
                                    Tableau de bord
                                </a>
                                
                                <div class="h-px bg-slate-100 my-2"></div>

                                <form action="{{ route('logout') }}" method="POST" id="logout-form-public">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-xl text-sm font-bold text-rose-600 hover:bg-rose-50 transition">
                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</header>
