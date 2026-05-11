<div class="p-4 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-wrap gap-4 items-center relative z-50" data-aos="fade-up" data-aos-delay="50">
    <form action="{{ route('entreprise.offres.index') }}" method="GET" id="search-form" class="flex flex-col lg:flex-row items-center gap-4 w-full m-0" @submit.prevent="fetchOffers()">
        <div class="relative w-full lg:flex-1">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="size-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </div>
            <input type="text" name="titre" value="{{ request('titre') }}" id="search-offers" placeholder="Rechercher par titre de poste..."
                class="py-2.5 px-3 ps-10 block w-full border-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 border shadow-sm transition"
                @input.debounce.500ms="fetchOffers()">
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <input type="hidden" id="status-input" name="status" value="{{ request('status') }}">
            <input type="hidden" id="type-input" name="type_stage" value="{{ request('type_stage') }}">

            <div x-data="{ open: false, selected: '{{ request('status') ?: 'Tous les statuts' }}' }" class="relative inline-flex w-full sm:w-48">
                <button @click="open = !open" @click.away="open = false" type="button" 
                    class="py-2.5 px-4 w-full inline-flex items-center justify-between gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none transition-all">
                    <span class="truncate" x-text="selected"></span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-500 shrink-0 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-transition.opacity style="display: none;" class="absolute top-full left-0 mt-2 z-[60] w-full bg-white shadow-xl rounded-2xl p-2 border border-gray-100">
                    <a @click.prevent="document.getElementById('status-input').value = ''; selected = 'Tous les statuts'; open = false; fetchOffers()" href="#" class="flex items-center py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 font-bold mb-1">Tous les statuts</a>
                    <template x-for="s in ['Active', 'Expirée']">
                        <a @click.prevent="document.getElementById('status-input').value = s; selected = s; open = false; fetchOffers()" href="#" 
                            class="flex items-center py-2 px-3 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition"
                            :class="selected == s ? 'bg-indigo-50 text-indigo-700 font-bold' : ''"
                            x-text="s"></a>
                    </template>
                </div>
            </div>

            <div x-data="{ open: false, selected: '{{ request('type_stage') ?: 'Tous les types' }}' }" class="relative inline-flex w-full sm:w-48">
                <button @click="open = !open" @click.away="open = false" type="button" 
                    class="py-2.5 px-4 w-full inline-flex items-center justify-between gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none transition-all">
                    <span class="truncate" x-text="selected"></span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-500 shrink-0 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-transition.opacity style="display: none;" class="absolute top-full left-0 mt-2 z-[60] w-full bg-white shadow-xl rounded-2xl p-2 border border-gray-100">
                    <a @click.prevent="document.getElementById('type-input').value = ''; selected = 'Tous les types'; open = false; fetchOffers()" href="#" class="flex items-center py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 font-bold mb-1">Tous les types</a>
                    <template x-for="t in ['PFE', 'Technique', 'Observation']">
                        <a @click.prevent="document.getElementById('type-input').value = t; selected = t; open = false; fetchOffers()" href="#" 
                            class="flex items-center py-2 px-3 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition"
                            :class="selected == t ? 'bg-indigo-50 text-indigo-700 font-bold' : ''"
                            x-text="t"></a>
                    </template>
                </div>
            </div>
        </div>
    </form>
</div>
