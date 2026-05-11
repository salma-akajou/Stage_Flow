<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="100">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <p class="text-sm text-gray-500">Affichage de <span class="font-semibold text-gray-800">{{ $offres->count() }}</span> sur <span class="font-semibold text-gray-800">{{ $offres->total() }}</span> offres</p>
        <span class="text-xs text-gray-400">Mis à jour aujourd'hui</span>
    </div>

    <div class="overflow-x-auto overflow-y-hidden">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead>
                <tr class="bg-gray-50/80">
                    <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre du Poste</th>
                    <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                    <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Candidatures</th>
                    <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                    <th scope="col" class="px-6 py-3.5 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Date d'expiration</th>
                    <th scope="col" class="px-6 py-3.5 text-end text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @if($offres->isEmpty())
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100 shadow-sm">
                                <svg class="size-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Aucun résultat trouvé</h3>
                            <p class="text-sm text-gray-500 max-w-sm mx-auto">Nous n'avons trouvé aucune offre correspondant à vos critères de recherche. Essayez d'ajuster vos filtres ou d'ajouter une nouvelle offre.</p>
                            <button type="button" onclick="document.getElementById('search-offers').value=''; document.getElementById('status-input').value=''; document.getElementById('type-input').value=''; fetchOffers();" class="mt-6 inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-wider transition">
                                Réinitialiser les filtres
                            </button>
                        </div>
                    </td>
                </tr>
                @else
                @php
                    $icons = [
                        ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-500', 'svg' => '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" /><circle cx="12" cy="12" r="3" />'],
                        ['bg' => 'bg-blue-50', 'text' => 'text-blue-500', 'svg' => '<path d="M18 20V10" /><path d="M12 20V4" /><path d="M6 20v-6" />'],
                        ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-500', 'svg' => '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5"/><path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3"/>']
                    ];
                @endphp
                @foreach($offres as $index => $offre)
                @php $icon = $icons[$index % 3]; @endphp
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="shrink-0 size-9 rounded-lg {{ $icon['bg'] }} flex items-center justify-center">
                                <svg class="size-4 {{ $icon['text'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    {!! $icon['svg'] !!}
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $offre->titre }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">Publiée le {{ $offre->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $offre->type_stage }}</td>
                    <td class="px-6 py-4 max-w-[200px]">
                        <p class="text-sm text-gray-500 truncate" title="{{ $offre->description }}">{{ $offre->description }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 font-semibold text-indigo-700">
                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                            </svg>
                            {{ $offre->candidatures_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($offre->status === 'Active')
                            <span class="inline-flex items-center py-1 px-2.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                ● Active
                            </span>
                        @else
                            <span class="inline-flex items-center py-1 px-2.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                ● Expirée
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $offre->date_fin->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-end">
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" onclick="openEditModal({{ $offre->id }})" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Modifier">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </button>
                            <form action="{{ route('entreprise.offres.destroy', $offre->id) }}" method="POST" class="inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cette offre ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        @if($offres->hasPages())
            <div class="px-6 py-4 bg-white border-t border-gray-100 flex justify-center sticky left-0 min-w-[max-content]" data-aos="fade-up">
                {{ $offres->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
