<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden min-h-[400px]">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-800">Candidatures Récentes</h3>
        <a href="{{ route('student.candidatures') }}" class="text-xs font-bold text-indigo-600 hover:underline">Tout voir</a>
    </div>
    <div class="p-6 flex-grow">
        <div class="space-y-6">
            @forelse($candidatures_recentes as $candidature)
            <div class="flex items-center gap-x-4">
                <div class="size-10 bg-gray-50 flex-none flex items-center justify-center rounded-lg border border-gray-100 overflow-hidden">
                    @if($candidature->offre->entreprise->logo)
                        <img src="{{ asset('storage/'.$candidature->offre->entreprise->logo) }}" class="size-6 object-contain">
                    @else
                        <span class="text-indigo-600 font-bold text-[10px]">{{ substr($candidature->offre->entreprise->nom_entreprise, 0, 1) }}</span>
                    @endif
                </div>
                <div class="grow min-w-0">
                    <h4 class="text-sm font-bold text-gray-800 truncate">{{ $candidature->offre->titre }}</h4>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                        {{ $candidature->offre->entreprise->nom_entreprise }} - Postulé {{ $candidature->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="flex-none text-right">
                    <span class="py-1 px-2.5 inline-flex items-center gap-x-1 text-[10px] font-bold rounded-lg 
                        @if($candidature->statut == 'Acceptée' || $candidature->statut == 'Accepté') bg-emerald-100 text-emerald-800
                        @elseif($candidature->statut == 'Refusée' || $candidature->statut == 'Refusé') bg-red-100 text-red-800
                        @else bg-amber-100 text-amber-800 @endif">
                        {{ $candidature->statut }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-center py-10 text-gray-400 italic text-sm">Aucune candidature récente.</p>
            @endforelse
        </div>
    </div>
</div>
