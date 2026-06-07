<div id="recommended-offers" class="space-y-4" data-aos="fade-up">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold text-gray-800">Dernières offres de stage</h3>
        <a class="text-xs font-bold text-indigo-600 hover:text-indigo-700 hover:underline" href="{{ route('student.offres.index') }}">Tout voir</a>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 text-gray-800">
        @foreach($recommandations as $offre)
        <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-2xl p-6 hover:shadow-md transition">
            <div class="flex items-center gap-x-4 mb-4">
                <div class="size-12 bg-gray-50 flex items-center justify-center rounded-xl border border-gray-100 shrink-0 overflow-hidden">
                    @if($offre->entreprise->logo)
                        <img src="{{ asset('storage/'.$offre->entreprise->logo) }}" class="size-8 object-contain">
                    @else
                        <span class="text-indigo-600 font-bold text-xs">{{ substr($offre->entreprise->nom_entreprise, 0, 1) }}</span>
                    @endif
                </div>
                <div class="min-w-0">
                    <h4 class="text-base font-bold text-gray-800 truncate group-hover:text-indigo-600 transition">{{ $offre->titre }}</h4>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $offre->entreprise->nom_entreprise }} • {{ $offre->ville->nom }}</p>
                </div>
            </div>
            <p class="text-xs text-gray-600 line-clamp-2 mb-4 leading-relaxed lowercase">{{ $offre->description }}</p>
            <div class="flex flex-wrap gap-2 mb-6">
                <span class="py-1 px-2.5 rounded-lg text-[10px] font-bold bg-indigo-50 text-indigo-700">{{ $offre->secteur?->nom ?? '' }}</span>
                <span class="py-1 px-2.5 rounded-lg text-[10px] font-bold bg-gray-100 text-gray-600">{{ $offre->duree }}</span>
                @if ($offre->remuneration === 'Payé')
                    <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-[10px] font-bold bg-green-100 text-green-800">
                        Payé
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                        Non-payé
                    </span>
                @endif
            </div>
            <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
                <span class="text-[10px] font-bold text-gray-400 italic">{{ $offre->created_at->diffForHumans() }}</span>
                <a href="{{ route('student.offres.show', $offre->id) }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-xs font-bold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">Voir Détails</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
