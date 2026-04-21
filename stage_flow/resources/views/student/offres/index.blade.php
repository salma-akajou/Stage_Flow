@extends('layouts.student')

@section('title', 'Catalogue des Offres - StageFlow')
@section('breadcrumb', 'Catalogue des Offres')

@section('content')
<div class="space-y-10" x-data="{ 
    search: '{{ addslashes(request('titre')) }}',
    ville: '{{ request('ville_id') }}',
    secteur: '{{ addslashes(request('secteur')) }}'
}">
    <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6 shadow-sm relative z-50" data-aos="fade-up">
        <form action="{{ route('offres.index') }}" method="GET" class="flex flex-col lg:flex-row items-center gap-4">
            <!-- Search -->
            <div class="relative w-full lg:flex-1">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <input type="text" name="titre" x-model="search" @input.debounce.500ms="$el.form.submit()"
                    class="py-3 ps-11 pe-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500" 
                    placeholder="Rechercher...">
            </div>

            <!-- Selects -->
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto z-20">
                <input type="hidden" id="ville-input" name="ville_id" value="{{ request('ville_id') }}">
                <input type="hidden" id="secteur-input" name="secteur" value="{{ request('secteur') }}">

                <!-- Dropdown Ville -->
                <div x-data="{ open: false }" class="relative inline-flex w-full sm:w-48">
                    @php $activeVille = $villes->firstWhere('id', request('ville_id')); @endphp
                    <button @click="open = !open" @click.away="open = false" type="button" class="py-3 px-4 w-full inline-flex items-center justify-between gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                        <span class="truncate">{{ $activeVille ? $activeVille->nom : 'Toutes les villes' }}</span>
                        <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-500 shrink-0 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="open" x-transition.opacity.duration.200ms style="display: none;" class="absolute top-full left-0 mt-2 z-[50] w-full min-w-[12rem] bg-white shadow-xl rounded-xl p-2 border border-gray-100 max-h-64 overflow-y-auto">
                        <a @click.prevent="document.getElementById('ville-input').value = ''; $event.target.closest('form').submit()" href="#" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 font-bold mb-1">
                            Toutes les villes
                        </a>
                        @foreach($villes as $v)
                            <a @click.prevent="document.getElementById('ville-input').value = '{{ $v->id }}'; $event.target.closest('form').submit()" href="#" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm {{ request('ville_id') == $v->id ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                {{ $v->nom }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Dropdown Secteur -->
                <div x-data="{ open: false }" class="relative inline-flex w-full sm:w-56">
                    <button @click="open = !open" @click.away="open = false" type="button" class="py-3 px-4 w-full inline-flex items-center justify-between gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                        <span class="truncate">{{ request('secteur') ?: 'Tous les secteurs' }}</span>
                        <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-500 shrink-0 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="open" x-transition.opacity.duration.200ms style="display: none;" class="absolute top-full left-0 mt-2 z-[50] w-full min-w-[14rem] bg-white shadow-xl rounded-xl p-2 border border-gray-100 max-h-64 overflow-y-auto">
                        <a @click.prevent="document.getElementById('secteur-input').value = ''; $event.target.closest('form').submit()" href="#" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 font-bold mb-1">
                            Tous les secteurs
                        </a>
                        @foreach($secteurs as $s)
                            <a @click.prevent="document.getElementById('secteur-input').value = '{{ addslashes($s) }}'; $event.target.closest('form').submit()" href="#" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm {{ request('secteur') == $s ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                {{ $s }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Offers Grid -->
    @if($offres->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up">
            @foreach($offres as $offre)
                <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl p-6 hover:shadow-md transition relative">
                    <form action="{{ route('student.favoris.toggle', $offre->id) }}" method="POST" class="absolute top-4 right-4 z-10">
                        @csrf
                        <button type="submit" class="p-2 rounded-full bg-white/80 backdrop-blur-sm shadow-sm hover:bg-rose-50 transition border border-gray-100 group/fav">
                            <svg class="size-4 {{ $etudiant->favoris->contains($offre->id) ? 'fill-rose-500 text-rose-500' : 'text-gray-400 group-hover/fav:text-rose-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </form>

                    <div class="flex items-center gap-x-4 mb-4 text-sm">
                        <div class="size-12 bg-gray-50 flex items-center justify-center rounded-lg border border-gray-100 overflow-hidden shrink-0">
                            @if($offre->entreprise->logo)
                                <img src="{{ asset('storage/'.$offre->entreprise->logo) }}" class="size-7 object-contain" alt="Logo">
                            @else
                                <span class="text-indigo-600 font-bold text-lg uppercase">{{ substr($offre->entreprise->nom_entreprise, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800 truncate group-hover:text-indigo-600 transition">{{ $offre->titre }}</h4>
                            <p class="text-xs text-gray-500">{{ $offre->entreprise->nom_entreprise }} • {{ $offre->ville->nom }}</p>
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-600 line-clamp-2 mb-4 leading-relaxed lowercase">
                        {{ $offre->description }}
                    </p>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="py-1 px-2.5 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700">{{ $offre->secteur }}</span>
                        <span class="py-1 px-2.5 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600">{{ $offre->duree }}</span>
                        @if ($offre->remuneration === 'Payé')
                            <span class="py-1 px-2.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700">Payé</span>
                        @else
                            <span class="py-1 px-2.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700">Non payé</span>
                        @endif
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-xs text-gray-400 italic">Publié {{ $offre->created_at->diffForHumans() }}</span>
                        <a href="{{ route('offres.show', $offre->id) }}" 
                           class="py-2 px-4 inline-flex items-center gap-x-2 text-xs font-bold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                            Voir Détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10" data-aos="fade-up">
            {{ $offres->links('components.pagination') }}
        </div>
    @else
        <div class="bg-white border border-gray-200 rounded-xl p-12 text-center" data-aos="fade-up">
            <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                <svg class="size-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Aucune offre trouvée</h3>
            <p class="text-gray-500">Essayez d'ajuster vos filtres pour trouver plus de résultats.</p>
            <a href="{{ route('offres.index') }}" class="mt-6 inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-wider">
                Réinitialiser les filtres
            </a>
        </div>
    @endif
</div>
@endsection
