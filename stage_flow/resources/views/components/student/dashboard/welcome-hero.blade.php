<div class="bg-indigo-950 rounded-2xl p-8 sm:p-12 relative overflow-hidden shadow-lg" data-aos="zoom-in">
    <div class="relative z-10 max-w-2xl text-white">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Bonjour, {{ $etudiant->user->prenom }} 👋</h1>
            <p class="text-indigo-300 text-sm font-medium mt-1">{{ $etudiant->filiere }} - {{ $etudiant->etablissement }}</p>
        </div>
        <h2 class="text-4xl font-black mb-6 leading-tight">Propulse ton potentiel avec StageFlow.</h2>
        <p class="text-indigo-200 text-lg mb-8 leading-relaxed">Trouve le stage de tes rêves parmi des centaines d'opportunités exclusives et adaptées à ton profil.</p>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('offres.index') }}"
                class="py-3 px-8 inline-flex items-center gap-x-2 text-sm font-bold rounded-lg bg-white text-indigo-950 hover:bg-indigo-50 transition">
                Explorer les offres
            </a>
            <a href="#recommended-offers"
                class="py-3 px-8 inline-flex items-center gap-x-2 text-sm font-bold rounded-lg border border-white/20 text-white hover:bg-white/10 transition">
                Voir les recommandations
            </a>
        </div>
    </div>
    <div class="absolute -bottom-10 -right-10 opacity-10">
        <svg class="size-64 text-white" fill="none" stroke="currentColor" stroke-width="1"
            viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
        </svg>
    </div>
</div>
