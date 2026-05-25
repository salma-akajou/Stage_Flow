<div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5 shadow-sm relative z-50" data-aos="fade-up" data-aos-delay="200">
    <form x-data="candidaturesFilter('{{ request('statut') }}')" action="{{ route('student.candidatures') }}" method="GET" class="flex flex-col lg:flex-row items-center gap-4">
        <div class="relative w-full lg:flex-1">
            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                <svg class="size-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                class="py-2.5 ps-11 pe-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Rechercher une entreprise ou un poste...">
        </div>

        <div x-data="dropdownFilter" class="relative inline-flex w-full lg:w-56 z-20">
            <input type="hidden" name="statut" id="statut-input" value="{{ request('statut') }}">
            <button @click="open = !open" @click.away="open = false" type="button" class="py-2.5 px-4 w-full inline-flex items-center justify-between gap-x-2 text-sm font-medium rounded-xl border border-gray-200 bg-gray-50 text-gray-700 focus:outline-none hover:bg-gray-100 transition">
                <span class="truncate">{{ request('statut') ?: 'Tous les statuts' }}</span>
                <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-500 shrink-0 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <div x-show="open" style="display: none;" x-transition.opacity.duration.200ms class="absolute top-full left-0 mt-2 z-[50] w-full min-w-[14rem] bg-white shadow-xl rounded-xl p-2 border border-gray-100 max-h-64 overflow-y-auto">
                <a @click.prevent="document.getElementById('statut-input').value = ''; $event.target.closest('form').submit()" href="#" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 font-bold mb-1">
                    Tous les statuts
                </a>
                <a @click.prevent="document.getElementById('statut-input').value = 'En attente'; $event.target.closest('form').submit()" href="#" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm {{ request('statut') == 'En attente' ? 'bg-amber-50 text-amber-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }} mb-0.5">
                    <span class="size-2 bg-amber-500 rounded-full"></span> En attente
                </a>
                <a @click.prevent="document.getElementById('statut-input').value = 'Accepté'; $event.target.closest('form').submit()" href="#" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm {{ request('statut') == 'Accepté' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }} mb-0.5">
                    <span class="size-2 bg-emerald-500 rounded-full"></span> Accepté
                </a>
                <a @click.prevent="document.getElementById('statut-input').value = 'Refusé'; $event.target.closest('form').submit()" href="#" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm {{ request('statut') == 'Refusé' ? 'bg-rose-50 text-rose-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="size-2 bg-rose-500 rounded-full"></span> Refusé
                </a>
            </div>
        </div>
        <button type="submit" class="hidden">Filtrer</button>
    </form>
</div>
