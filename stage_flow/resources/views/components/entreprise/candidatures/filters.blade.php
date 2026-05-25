<div class="mt-6 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-wrap gap-4 items-center relative z-50" data-aos="fade-up" data-aos-delay="50">
    <form @submit.prevent="fetchCandidatures()" class="flex flex-col lg:flex-row items-center gap-4 w-full m-0">
        <div class="relative flex-1 min-w-[200px]">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="size-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" />
                </svg>
            </div>
            <input type="text" x-model="search" @input.debounce.500ms="fetchCandidatures()" placeholder="Rechercher un candidat..."
                class="py-2 px-3 ps-10 block w-full border-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 border bg-white shadow-none transition">
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto ml-auto">
            <div x-data="dropdownFilter" class="relative inline-flex">
                <button @click="toggle()" @click.away="close()" type="button" 
                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-slate-200 bg-white text-gray-700 shadow-none hover:bg-gray-50 focus:outline-none transition-all">
                    <span x-text="statusLabel()"></span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-transition.opacity style="display: none;" class="absolute top-full right-0 mt-2 z-[60] bg-white shadow-xl rounded-xl p-2 border border-gray-100 min-w-[160px]">
                    <a @click.prevent="status = ''; close(); fetchCandidatures()" href="#" class="flex items-center py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 font-bold mb-1">Tous les statuts</a>
                    @foreach(['En attente', 'Accepté', 'Refusé'] as $s)
                        <a @click.prevent="status = '{{ $s }}'; close(); fetchCandidatures()" href="#" 
                            class="flex items-center py-2 px-3 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition"
                            :class="status == '{{ $s }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : ''">{{ $s }}</a>
                    @endforeach
                </div>
            </div>

            <div x-data="dropdownFilter" class="relative inline-flex">
                <button @click="toggle()" @click.away="close()" type="button" 
                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-slate-200 bg-white text-gray-700 shadow-none hover:bg-gray-50 focus:outline-none transition-all">
                    <span x-text="offreLabel()"></span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-transition.opacity style="display: none;" class="absolute top-full right-0 mt-2 z-[60] bg-white shadow-xl rounded-xl p-2 border border-gray-100 min-w-[200px]">
                    <a @click.prevent="offreId = ''; close(); fetchCandidatures()" href="#" class="flex items-center py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 font-bold mb-1">Toutes les offres</a>
                    @foreach($offres as $o)
                        <a @click.prevent="offreId = '{{ $o->id }}'; offreTitre = '{{ $o->titre }}'; close(); fetchCandidatures()" href="#" 
                            class="flex items-center py-2 px-3 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition"
                            :class="offreId == '{{ $o->id }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : ''">{{ $o->titre }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div>
