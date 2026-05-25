<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8 relative z-[20]" data-aos="fade-up">
    <h3 class="text-lg font-black text-gray-800 mb-8 flex items-center gap-2 font-heading">
        <svg class="size-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        Informations personnelles
    </h3>

    @include('components.student.profile.photo-upload')

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-700">Prénom</label>
            <input type="text" name="prenom" value="{{ $etudiant->user->prenom }}"
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-700">Nom</label>
            <input type="text" name="nom" value="{{ $etudiant->user->nom }}"
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
        </div>
        <div class="space-y-2 relative sm:col-span-2" x-data="selectVille('{{ $etudiant->ville_id }}', '{{ $etudiant->ville->nom ?? 'Choisir une ville' }}', @js($villes))" :class="{ 'z-[70]': open, 'z-[10]': !open }">
            <label class="block text-sm font-bold text-gray-700">Ville</label>
            <div class="relative">
                <button @click="open = !open" @click.away="open = false" type="button" 
                    class="py-2.5 px-4 flex items-center justify-between w-full border border-gray-200 bg-white rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
                    <span x-text="selectedNom"></span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <input type="hidden" name="ville_id" :value="selectedId">
                <div x-show="open" x-transition.opacity class="absolute top-full left-0 w-full mt-2 z-[80] bg-white shadow-2xl rounded-2xl p-2 border border-gray-100 max-h-60 overflow-y-auto scrollbar-none">
                    <template x-for="v in villes">
                        <button @click="select(v.id, v.nom)" type="button" 
                            class="flex items-center w-full py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1"
                            :class="selectedId == v.id ? 'bg-indigo-50 text-indigo-700' : ''"
                            x-text="v.nom"></button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
