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

                <a href="{{ route('offres.index') }}" 
                   @click="activeLink = 'offres'"
                   :class="activeLink === 'offres' ? 'text-indigo-600 font-bold' : 'text-slate-500 font-semibold'"
                   class="text-sm transition">Offres</a>

                <a href="{{ route('entreprise.candidatures.index') }}" 
                   @click="activeLink = 'candidatures'"
                   :class="activeLink === 'candidatures' ? 'text-indigo-600 font-bold' : 'text-slate-500 font-semibold'"
                   class="text-sm transition">Candidatures</a>
            </div>

            <div class="flex items-center gap-x-6">
                <a href="#" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition">Connexion</a>
                <a href="#" class="py-2.5 px-8 text-sm font-bold bg-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition active:scale-95 leading-none">
                    S'inscrire
                </a>
            </div>
        </div>
    </nav>
</header>
