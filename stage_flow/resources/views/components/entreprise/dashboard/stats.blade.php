
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4" data-aos="fade-up" data-aos-delay="50">
    <div class="stat-card bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="size-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                <svg class="size-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                </svg>
            </div>
            <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase border border-emerald-50">Actives</span>
        </div>
        <p class="text-3xl font-extrabold text-gray-900">{{ $stats['offres'] }}</p>
        <p class="text-xs text-gray-500 mt-1 font-medium">Offres publiées</p>
    </div>
    <div class="stat-card bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="size-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                <svg class="size-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full uppercase border border-indigo-50">Récents</span>
        </div>
        <p class="text-3xl font-extrabold text-gray-900">{{ $stats['candidatures_recues'] }}</p>
        <p class="text-xs text-gray-500 mt-1 font-medium">Candidatures reçues</p>
    </div>
    <div class="stat-card bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="size-10 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="size-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4l3 3" />
                </svg>
            </div>
            <span class="text-[10px] font-black text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full uppercase border border-amber-50">À traiter</span>
        </div>
        <p class="text-3xl font-extrabold text-gray-900">{{ $stats['en_attente'] }}</p>
        <p class="text-xs text-gray-500 mt-1 font-medium">En attente de réponse</p>
    </div>
    <div class="stat-card bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="size-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg class="size-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
            </div>
            <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase border border-emerald-50">Visibilité</span>
        </div>
        <p class="text-3xl font-extrabold text-gray-900">
            @if($stats['vues_offres'] >= 1000)
                {{ number_format($stats['vues_offres'] / 1000, 1) }}k
            @else
                {{ $stats['vues_offres'] }}
            @endif
        </p>
        <p class="text-xs text-gray-500 mt-1 font-medium">Vues de vos offres</p>
    </div>
</div>
