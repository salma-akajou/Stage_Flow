<div class="bg-white border border-gray-200 rounded-3xl p-8 shadow-sm relative z-[30]">
    <div class="absolute -top-24 -right-24 size-48 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
    
    <div class="flex flex-col md:flex-row gap-10 items-start relative z-10">
        <div class="flex flex-col items-center gap-4">
            <div class="relative group" x-data="logoUpload('{{ $entreprise->logo ? asset('storage/'.$entreprise->logo) : '' }}')">
                <div class="size-32 rounded-3xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-2xl overflow-hidden border-4 border-white shadow-xl group-hover:shadow-indigo-100 transition duration-300">
                    <template x-if="logoUrl">
                        <img :src="logoUrl" class="size-full object-cover">
                    </template>
                    <template x-if="!logoUrl">
                        <span class="text-4xl uppercase">{{ substr($entreprise->nom_entreprise, 0, 1) }}</span>
                    </template>
                </div>
                <label for="logo-input" class="absolute -bottom-2 -right-2 size-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center cursor-pointer hover:bg-indigo-700 transition shadow-lg ring-4 ring-white">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 9a2 2 0 0 1 2-2h.93a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 10.07 4h3.86a2 2 0 0 1 1.664.89l.812 1.22A2 2 0 0 0 18.07 7H19a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/><circle cx="12" cy="13" r="3"/></svg>
                    <input type="file" id="logo-input" name="logo" class="hidden" accept="image/*" @change="previewLogo($event)">
                </label>
            </div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Logo Entreprise (PNG/JPG)</p>
        </div>

        <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informations du Responsable -->
            <div class="md:col-span-2 flex items-center gap-2 mb-2">
                <span class="size-2 rounded-full bg-indigo-600"></span>
                <h4 class="text-sm font-black uppercase text-gray-800 tracking-wider">Informations du responsable</h4>
            </div>
            <div>
                <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Prénom du responsable</label>
                <input type="text" name="prenom" value="{{ $entreprise->user->prenom }}" required class="py-3 px-4 block w-full border-gray-100 bg-gray-50/50 rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Nom du responsable</label>
                <input type="text" name="nom" value="{{ $entreprise->user->nom }}" required class="py-3 px-4 block w-full border-gray-100 bg-gray-50/50 rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Informations de l'Entreprise -->
            <div class="md:col-span-2 flex items-center gap-2 mt-4 mb-2 border-t border-gray-100 pt-6">
                <span class="size-2 rounded-full bg-indigo-600"></span>
                <h4 class="text-sm font-black uppercase text-gray-800 tracking-wider">Informations de l'entreprise</h4>
            </div>
            <div>
                <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Nom de l'entreprise</label>
                <input type="text" name="nom_entreprise" value="{{ $entreprise->nom_entreprise }}" required class="py-3 px-4 block w-full border-gray-100 bg-gray-50/50 rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="relative" x-data="customSelect('{{ $entreprise->secteur }}', ['Informatique', 'Design', 'Marketing', 'Commerce', 'Industrie', 'Autre'])" :class="{ 'z-[70]': open, 'z-[60]': !open }">
                <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Secteur d'activité</label>
                <div class="relative">
                    <button @click="open = !open" @click.away="open = false" type="button" 
                        class="py-3 px-4 flex items-center justify-between w-full border border-gray-100 bg-gray-50/50 rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                        <span x-text="selected"></span>
                        <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <input type="hidden" name="secteur" :value="selected">
                    <div x-show="open" x-transition.opacity class="absolute top-full left-0 w-full mt-2 z-[60] bg-white shadow-2xl rounded-2xl p-2 border border-gray-100 max-h-60 overflow-y-auto scrollbar-none">
                        <template x-for="opt in options">
                            <button @click="select(opt)" type="button" 
                                class="flex items-center w-full py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1"
                                :class="selected == opt ? 'bg-indigo-50 text-indigo-700' : ''"
                                x-text="opt"></button>
                        </template>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Adresse E-mail Contact</label>
                <input type="email" name="email_contact" value="{{ $entreprise->email_contact }}" required class="py-3 px-4 block w-full border-gray-100 bg-gray-50/50 rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="relative" x-data="selectVille('{{ $entreprise->ville_id }}', '{{ $entreprise->ville->nom ?? 'Choisir une ville' }}', @js($villes))" :class="{ 'z-[70]': open, 'z-[60]': !open }">
                <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Ville</label>
                <div class="relative">
                    <button @click="open = !open" @click.away="open = false" type="button" 
                        class="py-3 px-4 flex items-center justify-between w-full border border-gray-100 bg-gray-50/50 rounded-xl text-sm font-bold focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                        <span x-text="selectedNom"></span>
                        <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <input type="hidden" name="ville_id" :value="selectedId">
                    <div x-show="open" x-transition.opacity class="absolute top-full left-0 w-full mt-2 z-[60] bg-white shadow-2xl rounded-2xl p-2 border border-gray-100 max-h-60 overflow-y-auto scrollbar-none">
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
</div>
