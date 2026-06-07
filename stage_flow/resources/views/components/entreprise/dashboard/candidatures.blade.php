
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="100">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-base font-bold text-gray-800">Candidatures récentes</h2>
        <a href="{{ route('entreprise.candidatures.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">Voir tout →</a>
    </div>
    <div class="divide-y divide-gray-50">
        @forelse($candidatures_recentes as $cand)
            <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50/60 transition">
                <div onclick="openStudentProfile({{ $cand->etudiant_id }})" class="size-10 rounded-full border border-gray-100 flex items-center justify-center font-bold text-xs shrink-0 ring-2 ring-white shadow-sm cursor-pointer hover:scale-110 transition overflow-hidden bg-gray-50">
                    @if($cand->etudiant->photo)
                        <img src="{{ asset('storage/'.$cand->etudiant->photo) }}" class="size-full object-cover">
                    @else
                        {{ substr($cand->etudiant->user->prenom, 0, 1) }}{{ substr($cand->etudiant->user->nom, 0, 1) }}
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $cand->etudiant->user->prenom }} {{ $cand->etudiant->user->nom }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $cand->etudiant->filiere?->nom ?? '' }}</p>
                </div>
                <span class="text-[10px] font-black px-2.5 py-1 rounded-full shrink-0 uppercase tracking-widest
                    @if($cand->statut === 'En attente') bg-orange-50 text-orange-600 border border-orange-100 @elseif($cand->statut === 'Accepté') bg-emerald-50 text-emerald-600 border border-emerald-100 @else bg-rose-50 text-rose-600 border border-rose-100 @endif">
                    {{ $cand->statut }}
                </span>
                <button onclick="openDetailModal({{ $cand->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Voir les détails">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>
        @empty
            <p class="p-8 text-center text-xs text-gray-400 font-bold uppercase tracking-widest italic">Aucune candidature</p>
        @endforelse
    </div>
</div>
