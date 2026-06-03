<div class="divide-y divide-gray-100">
    @forelse($feedbacks as $feedback)
        @php
            // Logique de badge selon la note
            $badgeColor = 'emerald';
            $badgeText = 'Commentaire positif';
            $badgeIcon = '<svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5" /></svg>';
            
            
            if($feedback->note == 3) {
                $badgeColor = 'amber';
                $badgeText = 'Suggestion d\'amélioration';
                $badgeIcon = '<svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 9v4M12 17h.01" /></svg>';
            } elseif($feedback->note <= 2) {
                $badgeColor = 'rose';
                $badgeText = 'Bug signalé';
                $badgeIcon = '<svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 9v4M12 17h.01" /></svg>';
            }


            $sujet = 'Expérience Utilisateur';
            $textLower = strtolower($feedback->texte);
            if(str_contains($textLower, 'critères') || str_contains($textLower, 'tri') || str_contains($textLower, 'candidature')) $sujet = 'Gestion Candidatures';
            elseif(str_contains($textLower, 'cv') || str_contains($textLower, 'pdf') || str_contains($textLower, 'télécharger')) $sujet = 'Dépôt de CV';
            elseif(str_contains($textLower, 'équipe') || str_contains($textLower, 'bravo')) $sujet = 'Service Client';
            elseif(str_contains($textLower, 'recherche') || str_contains($textLower, 'filtre')) $sujet = 'Moteur de Recherche';
            
            // Avatar
            $initials = substr($feedback->auteur->prenom, 0, 1) . substr($feedback->auteur->nom, 0, 1);
            $bgColor = $feedback->auteur->role === 'etudiant' ? 'bg-blue-100' : 'bg-indigo-100';
            $textColor = $feedback->auteur->role === 'etudiant' ? 'text-blue-600' : 'text-indigo-600';
            $avatar = $feedback->auteur->avatar_url;
        @endphp

        <div class="p-6 hover:bg-gray-50 transition-all group">
            <div class="flex items-start gap-4">
                <!-- Avatar Cercle Initials ou Photo -->
                <div class="size-10 rounded-full {{ $bgColor }} flex items-center justify-center {{ $textColor }} font-bold text-sm shrink-0 shadow-sm overflow-hidden">
                    @if($avatar)
                        <img src="{{ asset('storage/' . $avatar) }}" class="size-full object-cover">
                    @else
                        <span>{{ $initials }}</span>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <p class="font-semibold text-gray-900">{{ $feedback->auteur->prenom }} {{ $feedback->auteur->nom }}</p>
                        <span class="py-0.5 px-2 {{ $feedback->auteur->role === 'etudiant' ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700' }} text-[10px] font-medium rounded-full">
                            {{ $feedback->auteur->role === 'etudiant' ? 'Étudiant' : 'Entreprise' }}
                        </span>
                        <span class="text-gray-400 text-sm">·</span>
                        <span class="text-sm text-gray-400">{{ $feedback->created_at->diffForHumans() }}</span>
                    </div>

                    <p class="text-gray-700 mb-3 text-sm leading-relaxed">
                        {{ $feedback->texte }}
                    </p>

                    <div class="flex items-center gap-4">
                        <span class="text-sm text-{{ $badgeColor }}-600 font-medium flex items-center gap-1.5">
                            {!! $badgeIcon !!}
                            {{ $badgeText }}
                        </span>
                        <span class="text-sm text-gray-400">
                            Sujet : <span class="text-indigo-600 font-medium">{{ $sujet }}</span>
                        </span>
                    </div>
                </div>

                <!-- Actions Mockup Style -->
                <div class="flex items-center gap-2 shrink-0">
                    @if(!$feedback->valide)
                        <form action="{{ route('admin.feedbacks.approve', $feedback->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Approuver">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6 9 17l-5-5"/></svg>
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="p-20 text-center flex flex-col items-center gap-4">
            <div class="size-16 rounded-3xl bg-gray-50 flex items-center justify-center text-gray-200">
                <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
            </div>
            <p class="text-sm font-bold text-gray-400">Aucun commentaire trouvé.</p>
        </div>
    @endforelse

    <!-- Pagination Mockup Style -->
    <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
        <p class="text-sm text-gray-500">
            Affichage de <span class="font-semibold text-gray-800">{{ $feedbacks->firstItem() ?? 0 }}-{{ $feedbacks->lastItem() ?? 0 }}</span> sur {{ $feedbacks->total() }} signalés
        </p>
        <div class="flex items-center gap-x-1">
            {{ $feedbacks->links('components.pagination') }}
        </div>
    </div>
</div>
