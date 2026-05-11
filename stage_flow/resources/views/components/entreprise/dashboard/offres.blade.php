
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="100">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-base font-bold text-gray-800">Offres actives</h2>
        <a href="{{ route('entreprise.offres.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">Gérer →</a>
    </div>
    <div class="p-4 space-y-3">
        @forelse($offres_actives as $offre)
            <div class="p-3 rounded-xl bg-gray-50 hover:bg-indigo-50/50 transition border border-gray-50 cursor-pointer group">
                <div class="flex items-start justify-between gap-2 mb-1">
                    <p class="text-sm font-semibold text-gray-800 leading-tight group-hover:text-indigo-600 transition">{{ $offre->titre }}</p>
                    <span class="shrink-0 text-[10px] font-bold bg-emerald-500 text-white px-2 py-0.5 rounded-full uppercase scale-75 origin-right">Active</span>
                </div>
                <div class="flex items-center gap-x-2 text-[10px] text-gray-500">
                    <span>{{ $offre->candidatures_count }} candidatures</span><span>·</span><span>Expirée le {{ $offre->date_fin->format('d/m') }}</span>
                </div>
            </div>
        @empty
            <p class="p-6 text-center text-[10px] font-bold text-gray-300 uppercase italic">Aucune offre active.</p>
        @endforelse
    </div>
</div>
