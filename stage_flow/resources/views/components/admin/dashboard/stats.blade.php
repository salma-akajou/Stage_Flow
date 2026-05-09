<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4" data-aos="fade-up" data-aos-delay="50">
    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="size-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </div>
            <span class="text-sm text-gray-500">Utilisateurs</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_utilisateurs']) }}</p>
        <p class="text-xs text-indigo-600 mt-1 flex items-center gap-1">
            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" /></svg>
            +{{ number_format($stats['nouveaux_users_mois']) }} ce mois
        </p>
    </div>
    
    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="size-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                </svg>
            </div>
            <span class="text-sm text-gray-500">Offres</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_offres']) }}</p>
        <p class="text-xs text-blue-600 mt-1 flex items-center gap-1">
            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" /></svg>
            +{{ number_format($stats['nouvelles_offres_mois']) }} ce mois
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="size-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
            </div>
            <span class="text-sm text-gray-500">Feedbacks</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_commentaires']) }}</p>
        @if($stats['feedbacks_a_moderer'] > 0)
        <p class="text-xs text-amber-600 mt-1 flex items-center gap-1 font-medium">
            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            {{ number_format($stats['feedbacks_a_moderer']) }} à modérer
        </p>
        @else
        <p class="text-xs text-emerald-600 mt-1 flex items-center gap-1">
            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
            Tout est géré
        </p>
        @endif
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="size-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <span class="text-sm text-gray-500">Candidatures</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_candidatures']) }}</p>
        <p class="text-xs text-emerald-600 mt-1 flex items-center gap-1">
            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" /></svg>
            {{ number_format($stats['candidatures_semaine']) }} cette semaine
        </p>
    </div>
</div>
