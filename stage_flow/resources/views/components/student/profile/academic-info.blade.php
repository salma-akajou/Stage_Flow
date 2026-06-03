<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8 relative z-[10]" data-aos="fade-up" data-aos-delay="100">
    <h3 class="text-lg font-black text-gray-800 mb-8 flex items-center gap-2 font-heading">
        <svg class="size-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
        Parcours Académique
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- École / Université (Dynamic Dropdown) -->
        <div class="space-y-2 relative" x-data="{
            open: false,
            value: '{{ old('etablissement_id', $etudiant->etablissement_id) }}',
            label: '{{ old('etablissement_id') && $etablissements->find(old('etablissement_id')) ? $etablissements->find(old('etablissement_id'))->nom : ($etudiant->etablissement->nom ?? 'Choisir une école') }}'
        }" :class="{ 'z-[70]': open, 'z-[10]': !open }">
            <label class="block text-sm font-bold text-gray-700">École / Université</label>
            <div class="relative">
                <button @click="open = !open" @click.away="open = false" type="button" 
                    class="py-2.5 px-4 flex items-center justify-between w-full border border-gray-200 bg-white rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
                    <span x-text="label"></span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <input type="hidden" name="etablissement_id" :value="value">
                <div x-show="open" x-transition.opacity class="absolute top-full left-0 w-full mt-2 z-[80] bg-white shadow-2xl rounded-2xl p-2 border border-gray-100 max-h-60 overflow-y-auto scrollbar-none">
                    @foreach($etablissements as $etab)
                        <button @click="value = '{{ $etab->id }}'; label = '{{ $etab->nom }}'; open = false" type="button" 
                            class="flex items-center w-full py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1"
                            :class="value == '{{ $etab->id }}' ? 'bg-indigo-50 text-indigo-700' : ''">
                            {{ $etab->nom }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Niveau d'études (Corrected values: Bac+2, Bac+3, Bac+5, Doctorat) -->
        <div class="space-y-2 relative" x-data="customSelect('{{ old('niveau_etudes', $etudiant->niveau_etudes) }}', ['Bac+2', 'Bac+3', 'Bac+5', 'Doctorat'])" :class="{ 'z-[70]': open, 'z-[10]': !open }">
            <label class="block text-sm font-bold text-gray-700">Niveau d'études</label>
            <div class="relative">
                <button @click="open = !open" @click.away="open = false" type="button" 
                    class="py-2.5 px-4 flex items-center justify-between w-full border border-gray-200 bg-white rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
                    <span x-text="selected"></span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <input type="hidden" name="niveau_etudes" :value="selected">
                <div x-show="open" x-transition.opacity class="absolute top-full left-0 w-full mt-2 z-[80] bg-white shadow-2xl rounded-2xl p-2 border border-gray-100 max-h-60 overflow-y-auto scrollbar-none">
                    <template x-for="opt in options">
                        <button @click="select(opt)" type="button" 
                            class="flex items-center w-full py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1"
                            :class="selected == opt ? 'bg-indigo-50 text-indigo-700' : ''"
                            x-text="opt"></button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Filière (Dynamic Dropdown) -->
        <div class="space-y-2 sm:col-span-2 relative" x-data="{
            open: false,
            value: '{{ old('filiere_id', $etudiant->filiere_id) }}',
            label: '{{ old('filiere_id') && $filieres->find(old('filiere_id')) ? $filieres->find(old('filiere_id'))->nom : ($etudiant->filiere->nom ?? 'Choisir une filière') }}'
        }" :class="{ 'z-[70]': open, 'z-[10]': !open }">
            <label class="block text-sm font-bold text-gray-700">Filière</label>
            <div class="relative">
                <button @click="open = !open" @click.away="open = false" type="button" 
                    class="py-2.5 px-4 flex items-center justify-between w-full border border-gray-200 bg-white rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
                    <span x-text="label"></span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <input type="hidden" name="filiere_id" :value="value">
                <div x-show="open" x-transition.opacity class="absolute top-full left-0 w-full mt-2 z-[80] bg-white shadow-2xl rounded-2xl p-2 border border-gray-100 max-h-60 overflow-y-auto scrollbar-none">
                    @foreach($filieres as $fil)
                        <button @click="value = '{{ $fil->id }}'; label = '{{ $fil->nom }}'; open = false" type="button" 
                            class="flex items-center w-full py-2.5 px-4 rounded-xl text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1"
                            :class="value == '{{ $fil->id }}' ? 'bg-indigo-50 text-indigo-700' : ''">
                            {{ $fil->nom }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
