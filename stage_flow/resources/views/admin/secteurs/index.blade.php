@extends('layouts.admin')
@section('title', 'Gestion des Secteurs - StageFlow')
@section('breadcrumb', 'Secteurs')

@section('content')

<div x-data="{
    openModal: {{ $errors->has('nom') ? 'true' : 'false' }},
    editMode: {{ old('_method') === 'PUT' ? 'true' : 'false' }},
    itemId: {{ old('itemId') ?? 'null' }},
    itemNom: '{{ old('nom') ?? '' }}',
    search: '',
    
    openAdd() {
        this.editMode = false;
        this.itemId = null;
        this.itemNom = '';
        this.openModal = true;
    },
    openEdit(id, nom) {
        this.editMode = true;
        this.itemId = id;
        this.itemNom = nom;
        this.openModal = true;
    },
    submitSearch() {
        fetch('{{ route('admin.secteurs.index') }}?search=' + this.search, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('secteurs-table-container').innerHTML = html;
        });
    }
}">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 font-heading">Gestion des <span class="text-indigo-600">Secteurs</span></h1>
            <p class="text-sm text-gray-500 mt-1">Gerez les secteurs d'activité de la plateforme.</p>
        </div>
        @can('gerer-utilisateurs')
        <div>
            <button @click="openAdd()" type="button" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-indigo-600 text-white shadow-md hover:bg-indigo-700 transition active:scale-95">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Ajouter un secteur
            </button>
        </div>
        @endcan
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl p-4 mb-8 flex items-center gap-3 text-sm font-bold shadow-sm" role="alert" data-aos="fade-left">
            <div class="size-8 rounded-full bg-emerald-100 flex items-center justify-center">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filtre Recherche -->
    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm mb-6" data-aos="fade-up">
        <div class="relative w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" x-model="search" @input.debounce.300ms="submitSearch()"
                class="py-3 ps-11 pe-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                placeholder="Rechercher un secteur par nom...">
        </div>
    </div>

    <!-- Conteneur Tableau -->
    <div id="secteurs-table-container" class="relative z-10" data-aos="fade-up">
        @include('components.admin.secteurs.table', ['secteurs' => $secteurs])
    </div>

    <!-- Modal Ajout/Modification -->
    <div x-show="openModal" class="fixed inset-0 z-[110] transition-opacity duration-300" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="openModal = false"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center p-4 z-10 pointer-events-none">
            <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl flex flex-col pointer-events-auto transform transition-all duration-300 border border-gray-100 overflow-hidden relative p-8">
                
                <div class="absolute top-5 right-5">
                    <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-900 transition-all bg-white rounded-full p-2 border border-gray-100 shadow-sm">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="mb-6">
                    <h3 class="text-2xl font-black text-gray-900 font-heading tracking-tight" x-text="editMode ? 'Modifier le secteur' : 'Ajouter un secteur'">...</h3>
                    <p class="text-sm text-gray-500 mt-1" x-text="editMode ? 'Modifiez le nom du secteur existant.' : 'Remplissez les informations pour ajouter un nouveau secteur.'">...</p>
                </div>

                <form :action="editMode ? '{{ url('admin/secteurs') }}/' + itemId : '{{ route('admin.secteurs.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="hidden" name="itemId" :value="itemId">

                    <div class="space-y-4">
                        <div>
                            <label for="nom" class="block text-sm font-bold text-gray-700 mb-2">Nom du secteur</label>
                            <input type="text" name="nom" id="nom" x-model="itemNom"
                                class="py-3 px-4 block w-full @error('nom') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @else border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 @enderror rounded-xl text-sm shadow-sm"
                                placeholder="Entrer le nom de secteur">
                            @error('nom')
                                <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-x-2 pt-4">
                            <button type="button" @click="openModal = false" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 transition">
                                Annuler
                            </button>
                            <button type="submit" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-indigo-600 text-white shadow-md hover:bg-indigo-700 transition">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

