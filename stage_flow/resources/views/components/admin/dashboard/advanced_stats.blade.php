@php
    $tauxAccept = $stats['taux_acceptation'] ?? 0;
    $dureeH     = $stats['duree_traitement_heures'] ?? 0;
    $tauxEngage = $stats['taux_engagement_etudiants'] ?? 0;
    $etActifs   = $stats['etudiants_actifs'] ?? 0;
    $topSect    = $stats['top_secteurs'] ?? collect();
    $topVilles  = $stats['top_villes'] ?? collect();

    // Couleur de la barre de taux selon valeur
    $colorAccept = $tauxAccept >= 60 ? 'bg-emerald-500' : ($tauxAccept >= 30 ? 'bg-amber-400' : 'bg-rose-500');
    $colorEngage = $tauxEngage >= 60 ? 'bg-indigo-500' : ($tauxEngage >= 30 ? 'bg-blue-400' : 'bg-gray-400');
@endphp

<div class="mt-6 space-y-6" data-aos="fade-up" data-aos-delay="200">

    {{-- Titre section --}}
    <div class="flex items-center gap-3">
        <div class="size-1.5 rounded-full bg-indigo-500"></div>
        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-widest">Statistiques Avancées</h2>
        <div class="flex-1 h-px bg-gray-100"></div>
    </div>

    {{-- KPI Cards row --}}
    <div class="grid sm:grid-cols-3 gap-4">

        {{-- Taux d'acceptation --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Taux d'acceptation</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-0.5">{{ $tauxAccept }}<span class="text-lg text-gray-400">%</span></p>
                </div>
                <div class="size-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                    </svg>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mb-2">
                <div class="{{ $colorAccept }} h-1.5 rounded-full transition-all duration-700" style="width: {{ min($tauxAccept, 100) }}%"></div>
            </div>
            <p class="text-xs text-gray-400">Candidatures acceptées / traitées</p>
        </div>

        {{-- Temps moyen de traitement --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Réactivité moyenne</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-0.5">
                        @if($dureeH >= 24)
                            {{ round($dureeH / 24) }}<span class="text-lg text-gray-400">j</span>
                        @else
                            {{ $dureeH }}<span class="text-lg text-gray-400">h</span>
                        @endif
                    </p>
                </div>
                <div class="size-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Délai moyen de réponse aux candidatures</p>
        </div>

        {{-- Engagement étudiant --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Engagement étudiant</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-0.5">{{ $tauxEngage }}<span class="text-lg text-gray-400">%</span></p>
                </div>
                <div class="size-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mb-2">
                <div class="{{ $colorEngage }} h-1.5 rounded-full transition-all duration-700" style="width: {{ min($tauxEngage, 100) }}%"></div>
            </div>
            <p class="text-xs text-gray-400">{{ $etActifs }} étudiants ont postulé au moins une fois</p>
        </div>
    </div>

    {{-- Top Secteurs & Villes --}}
    <div class="grid sm:grid-cols-2 gap-4">

        {{-- Top Secteurs --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <div class="size-8 rounded-lg bg-violet-100 flex items-center justify-center text-violet-600">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5"/>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-gray-800">Top Secteurs</h3>
                <span class="ml-auto text-xs text-gray-400">par offres</span>
            </div>
            @if($topSect->isEmpty())
                <p class="text-sm text-gray-400 text-center py-4">Aucune donnée</p>
            @else
                @php $maxSect = $topSect->max('total') ?: 1; @endphp
                <div class="space-y-3">
                    @foreach($topSect as $i => $sect)
                        @php
                            $colors = ['bg-violet-500', 'bg-violet-300', 'bg-violet-200'];
                            $pct = round(($sect->total / $maxSect) * 100);
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-gray-700 truncate max-w-[70%]">{{ $sect->secteur }}</span>
                                <span class="text-xs font-semibold text-gray-500">{{ $sect->total }} offre{{ $sect->total > 1 ? 's' : '' }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="{{ $colors[$i] ?? 'bg-gray-300' }} h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Top Villes --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <div class="size-8 rounded-lg bg-sky-100 flex items-center justify-center text-sky-600">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-gray-800">Top Villes</h3>
                <span class="ml-auto text-xs text-gray-400">par offres</span>
            </div>
            @if($topVilles->isEmpty())
                <p class="text-sm text-gray-400 text-center py-4">Aucune donnée</p>
            @else
                @php $maxVille = $topVilles->max('total') ?: 1; @endphp
                <div class="space-y-3">
                    @foreach($topVilles as $i => $ville)
                        @php
                            $colorsV = ['bg-sky-500', 'bg-sky-300', 'bg-sky-200'];
                            $pct = round(($ville->total / $maxVille) * 100);
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-gray-700">{{ $ville->ville->nom ?? 'Inconnue' }}</span>
                                <span class="text-xs font-semibold text-gray-500">{{ $ville->total }} offre{{ $ville->total > 1 ? 's' : '' }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="{{ $colorsV[$i] ?? 'bg-gray-300' }} h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
