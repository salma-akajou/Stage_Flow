<div class="bg-white border border-gray-200 rounded-3xl p-8 shadow-sm relative z-[20]">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Registre du Commerce (RC)</label>
            <input type="text" name="registre_commerce" value="{{ $entreprise->registre_commerce }}" required class="py-3 px-4 block w-full border-gray-100 bg-gray-50/50 rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ex: 123456789">
        </div>
        <div class="relative" x-data="{ 
            open: false, 
            selected: '{{ $entreprise->taille }}',
            options: ['TPE / PME', 'Grande Entreprise', 'Multinationale']
        }" :class="{ 'z-[70]': open, 'z-[60]': !open }">
            <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Taille de l'entreprise</label>
            <div class="relative">
                <button @click="open = !open" @click.away="open = false" type="button" 
                    class="py-3 px-4 flex items-center justify-between w-full border border-gray-100 bg-gray-50/50 rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                    <span x-text="selected"></span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <input type="hidden" name="taille" :value="selected">
                <div x-show="open" x-transition.opacity class="absolute top-full left-0 w-full mt-2 z-[60] bg-white shadow-2xl rounded-2xl p-2 border border-gray-100">
                    <template x-for="opt in options">
                        <button @click="selected = opt; open = false" type="button" 
                            class="flex items-center w-full py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1"
                            :class="selected == opt ? 'bg-indigo-50 text-indigo-700' : ''"
                            x-text="opt"></button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-8">
        <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Adresse complète</label>
        <input type="text" name="adresse" value="{{ $entreprise->adresse }}" required class="py-3 px-4 block w-full border-gray-100 bg-gray-50/50 rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div>
        <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Biographie / À propos</label>
        <textarea name="bio" rows="6" class="py-3 px-4 block w-full border-gray-100 bg-gray-50/50 rounded-2xl text-sm font-medium focus:border-indigo-500 focus:ring-indigo-500" placeholder="Présentez votre entreprise, sa mission, ses valeurs...">{{ $entreprise->bio }}</textarea>
    </div>
</div>
