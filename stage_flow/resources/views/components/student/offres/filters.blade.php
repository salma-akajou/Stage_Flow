<div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6 shadow-sm relative z-50" data-aos="fade-up">
    <form action="{{ route('student.offres.index') }}" method="GET" class="flex flex-col lg:flex-row items-center gap-4">
        <div class="relative w-full lg:flex-1">
            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" name="titre" x-model="search" @input.debounce.500ms="$el.form.submit()"
                class="py-3 ps-11 pe-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500" 
                placeholder="Rechercher...">
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto z-20">
            <input type="hidden" id="ville-input" name="ville_id" value="{{ request('ville_id') }}">
            <input type="hidden" id="secteur-input" name="secteur" value="{{ request('secteur') }}">

            <div x-data="dropdownFilter" class="relative inline-flex w-full sm:w-48">
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

            <div x-data="dropdownFilter" class="relative inline-flex w-full sm:w-56">
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
