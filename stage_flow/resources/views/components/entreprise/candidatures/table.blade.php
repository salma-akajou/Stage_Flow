<div id="table-container">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <p class="text-sm text-gray-500">Affichage de <span class="font-semibold text-gray-800">{{ $candidatures->count() }}</span> sur <span class="font-semibold text-gray-800">{{ $candidatures->total() }}</span> candidatures</p>
            <span class="text-xs text-gray-400">Mis à jour aujourd'hui</span>
        </div>
        <div class="overflow-x-auto overflow-y-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Candidat</th>
                        <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Offre</th>
                        <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($candidatures as $c)
                        <tr class="row-hover transition group" id="candidature-row-{{ $c->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3 cursor-pointer" onclick="openStudentProfile({{ $c->etudiant_id }})">
                                    <div class="size-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs shrink-0 overflow-hidden ring-2 ring-white shadow-sm transition group-hover:ring-indigo-100">
                                        @if($c->etudiant->photo)
                                            <img src="{{ asset('storage/'.$c->etudiant->photo) }}" class="size-full object-cover">
                                        @else
                                            <span class="flex items-center justify-center size-full text-indigo-600 font-bold">
                                                {{ substr($c->etudiant->user->prenom, 0, 1) }}{{ substr($c->etudiant->user->nom, 0, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover:text-indigo-600 transition">{{ $c->etudiant->user->prenom }} {{ $c->etudiant->user->nom }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $c->etudiant->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 font-medium">{{ $c->offre->titre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ \Carbon\Carbon::parse($c->created_at)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span id="status-badge-{{ $c->id }}" class="inline-flex items-center py-1 px-2.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider
                                    @if($c->statut == 'En attente') bg-amber-100 text-amber-700
                                    @elseif($c->statut == 'Accepté') bg-emerald-100 text-emerald-700
                                    @else bg-rose-100 text-rose-700 @endif">
                                    {{ $c->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2" id="actions-{{ $c->id }}">
                                    <button onclick="openCandidatureDetails(this, {{ $c->id }})" class="btn-action p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all hover:scale-110" title="Voir les détails">
                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                    
                                    <div class="flex items-center gap-2">
                                        <button onclick="updateStatus({{ $c->id }}, 'Accepté')" 
                                            class="btn-action p-2 rounded-lg transition-all hover:scale-110 {{ $c->statut == 'Accepté' ? 'text-emerald-600 bg-emerald-50 shadow-inner' : 'text-gray-400 hover:text-emerald-600 hover:bg-emerald-50' }}" 
                                            title="Accepter">
                                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path d="M20 6 9 17l-5-5" />
                                            </svg>
                                        </button>
                                        <button onclick="updateStatus({{ $c->id }}, 'Refusé')" 
                                            class="btn-action p-2 rounded-lg transition-all hover:scale-110 {{ $c->statut == 'Refusé' ? 'text-rose-600 bg-rose-50 shadow-inner' : 'text-gray-400 hover:text-rose-600 hover:bg-rose-50' }}" 
                                            title="Refuser">
                                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="size-16 bg-gray-50 rounded-full flex items-center justify-center">
                                        <svg class="size-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                                    </div>
                                    <p class="text-gray-400 font-medium italic">Aucune candidature ne correspond à votre recherche.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($candidatures->hasPages())
            <div class="px-6 py-4 bg-white border-t border-gray-100 flex justify-center sticky left-0 min-w-[max-content]" data-aos="fade-up">
                {{ $candidatures->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
